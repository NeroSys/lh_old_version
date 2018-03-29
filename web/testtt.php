<?php

$loader = require_once dirname(__DIR__, 1).'/vendor/autoload.php';

require_once(dirname(__DIR__,1) . '/config/config.php');

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$hostname = DB_HOSTNAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$database = DB_DATABASE;
$port = DB_PORT;
\ActiveRecord\Config::initialize(function($cfg) use ($hostname, $username, $password, $database, $port)
{
    $cfg->set_model_directory(LOCAL_DIR_OPENCART.'/src/Entity');
    $cfg->set_connections(
        array(
            'development' => 'mysql://'.$username.':'.$password.'@'.$hostname.'/'.$database
        )
    );
});


    // connect your database here first
    //

    // Actual code starts here
$ar_adapter = ActiveRecord\ConnectionManager::get_connection();
    $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = '".DB_DATABASE."'
        AND ENGINE = 'MyISAM'";

    $rs = $ar_adapter->query($sql);

    foreach ($rs as $row)
    {
        $tbl = $row['table_name'];
        echo "ALTER TABLE `$tbl` ENGINE=INNODB";
        echo '<br>';

    }


$product = \App\Entity\Product::find(50);
var_dump($product->categories);