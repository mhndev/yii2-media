<?php

return [
    'mediaClass' => \mhndev\yii2Media\Models\Media::class,

    'formats' => [


        'image'=>[
            'avatar'=>[
                'storagePath'=> 'avatar',
                'uploadSizeLimit' => 2,
            ],

            'post-cover' => [
                'storagePath' => 'post/cover',
                'uploadSizeLimit' => 3
            ],


            'post-list-view' => [
                'storagePath' => 'post/list',
                'uploadSizeLimit' => 4
            ]
        ],

        'audio'=>[
            'music'=>[
                'storagePath'=> 'music',
                'uploadSizeLimit' => 10

            ],
            'english-learning'=>[
                'storagePath'=> 'english-learning',
                'uploadSizeLimit' => 4

            ]
        ],

        'video'=>[
            'storagePath'=> 'video',
            'uploadSizeLimit' => 10
        ],


        'text'=>[

            'document'=>[
                'storagePath'=> 'text',
                'uploadSizeLimit' => 1
            ]
        ]
    ]


];
