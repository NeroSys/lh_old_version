<?php

namespace App\Overrides\Catalog\Model\Tool;

require_once DIR_OPENCART . 'catalog/model/tool/image.php';

class ImageModel extends \ModelToolImage
{
    public function resize($filename, $width, $height)
    {
        //если файла с изображением продукта нет проверить его на медиасервере и перенести в файловое хранилище сайта
        if (!is_file(DIR_IMAGE . $filename) && (strpos($filename, 'catalog/', 0) !== false)) {
            $this->checkMediaserverForFile($filename);
        }
        return parent::resize($filename, $width, $height);
    }

    public function checkMediaserverForFile(string $filename){
        $fileInTheServer = str_replace("catalog/", "", $filename);
        if($productImage = file_get_contents(MEDIASERVER_ADDRESS.'/'.$fileInTheServer)){
            file_put_contents(DIR_IMAGE . $filename, $productImage);
        }
    }

    public function imageLocation($filename)
    {
        if (!is_file(DIR_IMAGE . $filename)) {
            return;
        }
        if ($this->request->server['HTTPS']) {
            return $this->config->get('config_ssl') . 'image/' . $filename;
        }
        return $this->config->get('config_url') . 'image/' . $filename;

    }
}
