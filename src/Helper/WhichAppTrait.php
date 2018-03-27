<?php
namespace App\Helper;


trait WhichAppTrait
{
    public function isAdmin():bool{
        if (strpos(HTTP_SERVER, '/admin_it/') !== false) {
            return true;
        }
        return false;
    }
}