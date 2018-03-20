<?php
namespace App\Helper;


trait FilesTrait
{
    /**
     * @param string $pattern
     * @return null|string
     */
    protected function findMatchesPathForOverwriting(string $filePath)
    {
        if (strpos($filePath, DIR_APPLICATION) !== false) {
            return str_replace(DIR_APPLICATION, LOCAL_DIR_APPLICATION, $filePath);
        }
        elseif (strpos($filePath, DIR_TEMPLATE) !== false) {
            return str_replace(DIR_TEMPLATE, LOCAL_DIR_TEMPLATE, $filePath);
        }
    }
}