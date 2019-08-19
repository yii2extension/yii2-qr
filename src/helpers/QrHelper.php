<?php

namespace yii2extension\qr\helpers;

use yii\helpers\ArrayHelper;
use chillerlan\QRCode\{QRCode, QROptions};
use yii2rails\extension\yii\helpers\FileHelper;

class QrHelper
{

    public static function encodeToFile($data, $file, $options = []) {
        $options['outputType'] = FileHelper::fileExt($file);
        $binaryData = QrHelper::encode($data, $options);
        FileHelper::save($file, $binaryData);
    }

    public static function encode($data, $options) {
        $qrcode = self::getInstance($options);
        $binaryData = $qrcode->render($data);
        return $binaryData;
    }

    public static function prepareOptoins($options) {
        $defaultOptions = [
            'version'    => QRCode::VERSION_AUTO,
            'eccLevel'   => QRCode::ECC_L,
            'addQuietzone' => false,
            'imageTransparent' => false,
            //'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'imageBase64' => false,
        ];
        return ArrayHelper::merge($defaultOptions, $options);
    }

    public static function getInstance($options) {
        $options = self::prepareOptoins($options);
        $optionsObject = new QROptions($options);
        $qrcode = new QRCode($optionsObject);
        return $qrcode;
    }

}
