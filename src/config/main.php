<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'agency',
    'basePath' => dirname(__DIR__),
    'params' => $params,

    'mediaClass' => \mhndev\yii2Media\Models\Media::class,


    'userClass' => \mhndev\yii2Media\Models\Media::class,
];


return $config;
