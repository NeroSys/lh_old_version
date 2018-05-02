<?php
namespace App\Overrides\Admin\Model\Catalog;
use App\Entity\ProductOptionGroup;

require_once(DIR_OPENCART . 'admin/model/catalog/product.php');

class ProductModel extends \ModelCatalogProduct
{
    public function addProduct($data){

        $product_id = parent::addProduct($data);

        // OCFilter start
        $this->db->query("DELETE FROM " . DB_PREFIX . "ocfilter_option_value_to_product WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ocfilter_option_value_to_product_description WHERE product_id = '" . (int)$product_id . "'");

        if (isset($data['ocfilter_product_option'])) {
            foreach ($data['ocfilter_product_option'] as $option_id => $values) {
                foreach ($values['values'] as $value_id => $value) {
                    if (isset($value['selected'])) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ocfilter_option_value_to_product SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', value_id = '" . (string)$value_id . "', slide_value_min = '" . (isset($value['slide_value_min']) ? (float)$value['slide_value_min'] : 0) . "', slide_value_max = '" . (isset($value['slide_value_max']) ? (float)$value['slide_value_max'] : 0) . "'");

                        foreach ($value['description'] as $language_id => $description) {
                            if (trim($description['description'])) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "ocfilter_option_value_to_product_description SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', value_id = '" . (string)$value_id . "', language_id = '" . (int)$language_id . "', description = '" . $this->db->escape($description['description']) . "'");
                            }
                        }
                    }
                }
            }
        }
        // OCFilter end
      return $product_id;
    }

    public function editProduct($product_id, $data) {
        parent::editProduct($product_id, $data);
        // OCFilter start
        $this->db->query("DELETE FROM " . DB_PREFIX . "ocfilter_option_value_to_product WHERE product_id = '" . (int)$product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ocfilter_option_value_to_product_description WHERE product_id = '" . (int)$product_id . "'");

        if (isset($data['ocfilter_product_option'])) {
            foreach ($data['ocfilter_product_option'] as $option_id => $values) {
                foreach ($values['values'] as $value_id => $value) {
                    if (isset($value['selected'])) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ocfilter_option_value_to_product SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', value_id = '" . (string)$value_id . "', slide_value_min = '" . (isset($value['slide_value_min']) ? (float)$value['slide_value_min'] : 0) . "', slide_value_max = '" . (isset($value['slide_value_max']) ? (float)$value['slide_value_max'] : 0) . "'");

                        foreach ($value['description'] as $language_id => $description) {
                            if (trim($description['description'])) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "ocfilter_option_value_to_product_description SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', value_id = '" . (string)$value_id . "', language_id = '" . (int)$language_id . "', description = '" . $this->db->escape($description['description']) . "'");
                            }
                        }
                    }
                }
            }
        }
        // OCFilter end
    }


    public function deleteProduct($product_id) {
        parent::deleteProduct($product_id);
        // OCFilter start
        $this->db->query("DELETE FROM " . DB_PREFIX . "ocfilter_option_value_to_product WHERE product_id = '" . (int)$product_id . "'");
        // OCFilter end

    }

    public function getAviableProductSpecifications(int $productId):?array{
        return ProductOptionGroup::find('all',array('conditions' => array('product_id=?', $productId)));
    }

    public function getProductOptions($product_id) {
        $product_option_data = array();

        $product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        foreach ($product_option_query->rows as $product_option) {
            $product_option_value_data = array();

            $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");

            foreach ($product_option_value_query->rows as $product_option_value) {
                $product_option_value_data[] = array(
                    'product_option_value_id' => $product_option_value['product_option_value_id'],
                    'option_value_id'         => $product_option_value['option_value_id'],
                    'quantity'                => $product_option_value['quantity'],
                    'subtract'                => $product_option_value['subtract'],
                    'price'                   => $product_option_value['price'],
                    'price_prefix'            => $product_option_value['price_prefix'],
                    'points'                  => $product_option_value['points'],
                    'points_prefix'           => $product_option_value['points_prefix'],
                    'weight'                  => $product_option_value['weight'],
                    'weight_prefix'           => $product_option_value['weight_prefix'],
                    'product_option_group'           => $product_option_value['product_option_group']
                );
            }

            $product_option_data[] = array(
                'product_option_id'    => $product_option['product_option_id'],
                'product_option_value' => $product_option_value_data,
                'option_id'            => $product_option['option_id'],
                'name'                 => $product_option['name'],
                'type'                 => $product_option['type'],
                'value'                => $product_option['value'],
                'required'             => $product_option['required']
            );
        }

        return $product_option_data;
    }
}