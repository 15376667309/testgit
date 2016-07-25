<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'utils' => [//生成缩略图文件
            'class' => 'common\components\Utils'
        ]
    ],
];
