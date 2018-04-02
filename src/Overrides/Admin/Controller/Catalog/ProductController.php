<?php

namespace App\Overrides\Admin\Controller\Catalog;


use App\Entity\ProductOptionGroup;

require_once(DIR_OPENCART . 'admin/controller/catalog/product.php');


class ProductController extends \ControllerCatalogProduct
{
    protected function getForm()
    {
        parent::getForm();
        $data = $this->load->data;

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
        return $this->model_catalog_product->getAviableProductSpecifications((int)$this->request->get['product_id']);
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