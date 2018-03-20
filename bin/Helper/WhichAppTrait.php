<?php
namespace App\Helper;


trait WhichAppTrait
{
    public function isAdmin():bool{
        if (strpos(DIR_APPLICATION, '/admin') !== false) {
            return true;
        }
        return false;
    }
}