<?php

namespace App\Helper;

class ActiveRecord
{
    static function initializeActiveRecord(string $hostname, string $username, string $password, string $database, string $port)
    {
        \ActiveRecord\Config::initialize(function (\ActiveRecord\Config $cfg) use ($hostname, $username, $password, $database, $port) {
            $cfg->set_model_directory(LOCAL_DIR_OPENCART . '/src/Entity');
            $cfg->set_connections(
                array(
                    'development' => 'mysql://' . $username . ':' . $password . '@' . $hostname . '/' . $database.';charset=utf8'
               )
            );
        });
    }

    static function currentDatetimeCreate(){
        return date ("Y-m-d H:i:s", time());
    }

}