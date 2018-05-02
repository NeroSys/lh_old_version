<?php

namespace App\Overrides\Admin\Controller\Catalog;


use App\Entity\ProductOptionGroup;

require_once(DIR_OPENCART . 'admin/controller/catalog/product.php');


class ProductController extends \ControllerCatalogProduct
{
    protected function getForm()
    {
        // OCFilter start
        $this->document->addStyle('view/stylesheet/ocfilter/ocfilter.css');
        $this->document->addScript('view/javascript/ocfilter/ocfilter.js');
        // OCFilter end

        parent::getForm();
        $data = $this->load->data;

        // OCFilter start
        $data['tab_ocfilter'] = $this->language->get('tab_ocfilter');
        $data['entry_values'] = $this->language->get('entry_values');
        $data['ocfilter_select_category'] = $this->language->get('ocfilter_select_category');
        // OCFilter end

        $data['product_option_groups'] = $this->getProductSpecifications();
        foreach ($this->getProductOptions() as $key => $product_option) {
            $product_option_value_data = array();

            if (isset($product_option['product_option_value'])) {
                foreach ($product_option['product_option_value'] as $product_option_value) {
                    $product_option_value_data[] = $product_option_value;
                }
            }

            $data['product_options'][$key] = $product_option;
            $data['product_options'][$key]['product_option_value'] = $product_option_value_data;
        }

        $this->response->setOutput($this->load->view('catalog/product_form', $data));
    }

    protected function getProductSpecifications(): ?array
    {
        if(isset($this->request->get['product_id'])){
            return $this->model_catalog_product->getAviableProductSpecifications((int)$this->request->get['product_id']);
        }
        return null;
    }

    protected function getProductOptions(): array
    {
        if (isset($this->request->post['product_option'])) {
            $product_options = $this->request->post['product_option'];
        } elseif (isset($this->request->get['product_id'])) {
            $product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
        } else {
            $product_options = array();
        }
        return $product_options;
    }
}