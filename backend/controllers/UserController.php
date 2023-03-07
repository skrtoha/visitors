<?php

namespace backend\controllers;

use common\models\User;
use common\models\Visit;
use frontend\models\PasswordResetRequestForm;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends CommonController
{
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin')){
            $query = User::find();
            $view = 'index';
            $sort = [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ];
        }
        if (Yii::$app->user->can('manager')){
            $query = Visit::find()
                ->from(['v' => Visit::tableName()])
                ->select([
                    'user_id' => 'u.id',
                    'count_visits' => 'COUNT(u.id)',
                    'sum' => 'SUM(v.sum - v.discount)'
                ])
                ->leftJoin(['u' => User::tableName()], "v.user_id = u.id")
                ->where(['u.type' => User::TYPE_USER])
                ->groupBy('v.user_id');
            $view = 'index-group';
            $sort = [];
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => $sort,
        ]);

        return $this->render($view, [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $this->checkRole('admin');

        $model = new User();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->status = User::STATUS_ACTIVE;

            $orWhere = ['OR', ['username' => $model->username]];
            if ($model->phone) {
                $orWhere[] = ['phone' => $model->phone];
            }
            if ($model->email){
                $orWhere[] = ['email' => $model->email];
            }
            $count = User::find()->where($orWhere)->count();
            if ($count){
                Yii::$app->session->setFlash('error', 'Такой пользователь, номер телефона или почта уже присутствуют в базе');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

            $model->setPassword(Yii::$app->request->post('password'));
            $model->generateAuthKey();
            $model->generateEmailVerificationToken();
            if ($model->save()) {
                if (in_array($model->type, [User::TYPE_ADMINISTRATOR, User::TYPE_MANAGER])){
                    $form = new PasswordResetRequestForm();
                    $form->sendEmail($model);

                    $auth = Yii::$app->authManager;
                    if ($model->type == User::TYPE_MANAGER) $role = $auth->getRole('manager');
                    if ($model->type == User::TYPE_ADMINISTRATOR) $role = $auth->getRole('admin');
                    $auth->assign($role, $model->id);
                }

                if ($model->type == User::TYPE_USER){
                    User::sendQRCode($model);
                }

                Yii::$app->session->setFlash('success', 'Пользователь успешно сохранен');

                return $this->response->redirect(['/user/update', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Exception
     */
    public function actionUpdate()
    {
        $this->checkRole('admin');

        $model = $this->findModel(Yii::$app->request->get('id'));

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()){
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Exception
     */
    public function actionDelete($id)
    {
        $this->checkRole('admin');
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
