<?php

$connection = getenv('DB_CONNECTION');
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$database = getenv('DB_DATABASE');

return [
    'class' => 'yii\db\Connection',
    'dsn' => $connection.':host='.$host.';port='.$port.';dbname='.$database,
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
