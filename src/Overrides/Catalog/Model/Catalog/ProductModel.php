<?php
namespace App\Overrides\Catalog\Model\Catalog;
use App\Entity\ProductOptionGroup;

require_once(DIR_OPENCART . 'catalog/model/catalog/product.php');

class ProductModel extends \ModelCatalogProduct
{
    const PRODUCT_OPTION_IMAGE_PATH = null;
    const PRODUCT_OPTION_REQUIRED   = 1;
    const PRICE_DISCOUNT_TYPE_PERCENT = 'persent';
	const PRICE_DISCOUNT_TYPE_AMOUNT = 'amount';

    public function getAviableProductSpecifications(int $product_id):?array{
        $options = $this->getProductSpecificationOptionsFromDatabase($product_id);
        return $this->groupingOptionsAsSpecificationID($options);
    }

	public function getProductOptionsOld($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("
SELECT * FROM " . DB_PREFIX . "product_option po 
LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) 
LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) 
WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' 
ORDER BY o.sort_order");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'name'                    => $product_option_value['name'],
					'image'                   => $product_option_value['image'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']
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

    public function getProductOptions($product_id) {
        $product_option_data = array();

        $options = $this->getProductSpecificationOptionsFromDatabase($product_id);
        foreach ($options as $option) {
            $product_option_data[$option['option_id']]['product_option_id']     = $option['product_option_id'];
            $product_option_data[$option['option_id']]['option_id']             = $option['option_id'];
            $product_option_data[$option['option_id']]['name']                  = $option['option_name'];
            $product_option_data[$option['option_id']]['type']                  = $option['type'];
            $product_option_data[$option['option_id']]['value']                 = $option['option_value_name'];
            $product_option_data[$option['option_id']]['required']              = self::PRODUCT_OPTION_REQUIRED;
            $product_option_data[$option['option_id']]['product_option_value'][$option['option_value_id']] = [
                'product_option_value_id' => $option['option_value_id'],
                'option_value_id'         => $option['option_value_id'],
                'quantity'                => $option['quantity'],
                'subtract'                => $option['subtract'],
                'price'                   => $option['price'],
                'name'                    => $option['option_value_name'],
                'price_prefix'            => $option['price_prefix'],
                'points'                  => $option['points'],
                'points_prefix'           => $option['points_prefix'],
                'weight'                  => $option['weight'],
                'weight_prefix'           => $option['weight_prefix'],
                'product_option_group'    => $option['product_option_group'],
                'image'                   => self::PRODUCT_OPTION_IMAGE_PATH
            ];
        }

        return $product_option_data;
    }

    private function groupingOptionsAsSpecificationID(array $data):?array{
        $options = array();
        foreach ($data as $option){
        	if($option['price_discount'] > 0 && $option['price_discount_type'] == self::PRICE_DISCOUNT_TYPE_PERCENT) {
				$price_old = $option['price'];
				$price = $option['price'] - ($option['price'] * ($option['price_discount']/100));
			} elseif ($option['price_discount'] > 0 && $option['price_discount_type'] == self::PRICE_DISCOUNT_TYPE_AMOUNT){
				$price_old = $option['price'];
				$price = $option['price'] - $option['price_discount'];
			} else {
				$price_old = 0;
				$price = $option['price'];
			}

			$option['status'] = true;
			$options[$option['id']]['id'] = $option['id'];
			$options[$option['id']]['number'] = $option['id_erp'];
			$options[$option['id']]['status'] = true;
			$options[$option['id']]['price'] = (float) $price;
			$options[$option['id']]['price_old'] = (float) $price_old;
			$option = $this->formatOption($option);
            $options[$option['id']]['options'][$option['option_id']] = $option;
        }
        foreach ($options as &$option){
            $option['options'] = array_values($option['options']);
        }
        return $options;
    }

    protected function formatOption($option){
        static $shops;
        if(!$shops) {
            $localisationModel = $this->load->model('localisation/location');
            $shops = $localisationModel->getShops();
        }
        if(!empty($option["availability"])) {
            $unserializerOptions = unserialize($option["availability"])->toArray();
            unset($unserializerOptions["availability"]["priceWholesale"]);
            foreach ($unserializerOptions as $shopAviability){
                $shopAviability->stock = $shops->get($shopAviability->stockErpId);
            }
            $option["availability"] = $unserializerOptions;

        }
        return $option;
    }

    private function getProductSpecificationOptionsFromDatabase(int $product_id):?array{
        $sql = "SELECT opog.*, opog.price_base price, 
                  ood.option_id, ood.name option_name, 
                  oo.type, oo.sort_order,
                  oovd.option_value_id, oovd.name option_value_name, 
                  pov.price_prefix, pov.subtract, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix, 
                  pov.product_option_group, pov.product_option_id 
                FROM " . DB_PREFIX . "product_option_value pov 
                  LEFT JOIN " . DB_PREFIX . "product_option_group opog ON pov.product_option_group = opog.id
                  LEFT JOIN " . DB_PREFIX . "option_value oov ON pov.option_value_id = oov.option_value_id
                  LEFT JOIN " . DB_PREFIX . "option_description ood ON pov.option_id = ood.option_id
                  LEFT JOIN " . DB_PREFIX . "option_value_description oovd ON pov.option_value_id = oovd.option_value_id
                  LEFT JOIN " . DB_PREFIX . "option oo ON pov.option_id = oo.option_id
                  WHERE opog.product_id = $product_id
                  ORDER BY opog.id, ood.option_id";

        return $this->db->query($sql)->rows;
    }

    public function generateProductDescription(int $product_id):string{
        $product_attributes = $this->getProductAttributes($product_id);
        $product_description = '';
        //$product_description = "Производитель: ". $result["manufacturer"]."<br>";

        foreach ($product_attributes as $attribute_group) {
            foreach ($attribute_group["attribute"] as $attribute) {
                $product_description .= $attribute["name"] . ": " . $attribute["text"] . "<br>";
            }
        }

        $product_description = utf8_substr(
            html_entity_decode($product_description, ENT_QUOTES, 'UTF-8'), 0, 180
        );

        if (mb_strlen($product_description) === 180) {
            $product_description .= '..';
        }
        return $product_description;
    }
}
