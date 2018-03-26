<?php

namespace App\Overrides\Catalog\Model\Tool;

require_once DIR_OPENCART . 'catalog/model/tool/image.php';

class ImageModel extends \ModelToolImage
{
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
