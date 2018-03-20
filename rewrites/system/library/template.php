<?php

class Template
{

    private $data = array();

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function render($template)
    {
        if ($file = \App\Helper\FileExiststRewriter::fileExists(DIR_TEMPLATE . $template)) {
            return $this->renderTemplateFile($file);
        }

        trigger_error('Error: Could not load template ' . $file . '!');
        exit();
    }

    protected function renderTemplateFile(string $file)
    {
        extract($this->data);

        ob_start();

        require($file);

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

}
