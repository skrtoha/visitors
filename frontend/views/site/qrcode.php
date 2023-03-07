<?php
/** @var string $text */
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;


?>
<div class="mt-5 offset-lg-3 col-lg-6">
    <?=Text::widget([
        'outputDir' => '@webroot/upload/qrcode',
        'outputDirWeb' => '@web/upload/qrcode',
        'ecLevel' => QRcode::QR_ECLEVEL_L,
        'text' => $text,
        'size' => 6,
    ]);?>
</div>
