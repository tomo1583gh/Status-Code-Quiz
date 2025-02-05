<?php
$status_codes = [
    [
        'id' => 0,
        'code' => '102',
        'meaning' => 'Processing',
        'description' => '処理中である'
    ],
    [
        'id' => 1,
        'code' => '200',
        'meaning' => 'OK',
        'description' => 'リクエストが正常に成功できた'
    ],
    [
        'id' => 2,
        'code' => '301',
        'meaning' => 'Moved Permanently',
        'description' => 'リクエストしたリソースが恒久的に移動されている'
    ],
    [
        'id' => 3,
        'code' => '304',
        'meaning' => 'Not Modified',
        'description' => 'リクエストしたリソースは更新されていない'
    ],
    [
        'id' => 4,
        'code' => '400',
        'meaning' => 'Bad Request',
        'description' => 'クライアントのリクエストに異常がある'
    ],
    [
        'id' => 5,
        'code' => '401',
        'meaning' => 'Unauthorized',
        'description' => 'アクセストークンが無効なときや、認証がされていない'
    ],
    [
        'id' => 6,
        'code' => '403',
        'meaning' => 'Forbidden',
        'description' => '閲覧権限が無いファイルやフォルダである'
    ],
    [
        'id' => 7,
        'code' => '404',
        'meaning' => 'Not found',
        'description' => 'Webページが見つからない'
    ],
    [
        'id' => 8,
        'code' => '500',
        'meaning' => 'Internal Server Error',
        'description' => '何らかのサーバ内でエラーが起きた'
    ],
    [
        'id' => 9,
        'code' => '502',
        'meaning' => 'Bad Gateway',
        'description' => 'サーバーがリクエストに満たすのに必要な機能をサポートしていない'
    ],
    [
        'id' => 10,
        'code' => '503',
        'meaning' => 'Service Unavailable',
        'description' => '一時的にサーバにアクセスが出来ない'
    ]
];
