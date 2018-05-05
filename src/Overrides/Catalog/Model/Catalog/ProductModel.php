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
			$options[$option['id']]['availability'] = $this->formatOptionByAvailability($option);

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
            $options[$option['id']]['options'][$option['option_id']] = $option;
        }
        foreach ($options as &$option){
            $option['options'] = array_values($option['options']);
        }
        return $options;
    }

    protected function formatOptionByAvailability(&$option){
        static $shops;
        if(!$shops) {
            $localisationModel = $this->load->model('localisation/location');
            $shops = $localisationModel->getShops();
        }
        if(!empty($option["availability"])) {
            $unserializerOptions = unserialize($option["availability"])->toArray();
            unset($option["availability"]);

            foreach ($unserializerOptions as &$shopAviability){
				$shopAviability->stock = $shops->get($shopAviability->stockErpId);
				$geocode = isset($shopAviability->stock['geocode']) ? explode(',', $shopAviability->stock['geocode']) : [[],[]];
				$shopAviability->stock['geocode'] = ['lat' => $geocode[0], 'lng' => $geocode[1]];
				unset($shopAviability->stockErpId);
				unset($shopAviability->priceWholesale);
				unset($shopAviability->stock['id_erp']);
            }
        }
        return $unserializerOptions;
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
                  ORDER BY opog.product_id, option_value_name";

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

    public function getProducts($data = array()) {
        $sql = "SELECT DISTINCT *, pd.name AS name, p.image,
            
            (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, 
            (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, 
            (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $sql .= " " . implode(" AND ", $implode) . "";
                }

                if (!empty($data['filter_description'])) {
                    $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            $sql .= ")";
        }

        // OCFilter start
        if (!empty($data['filter_ocfilter'])) {
            $this->load->model('catalog/ocfilter');

            $ocfilter_product_sql = $this->model_catalog_ocfilter->getProductSQL($data['filter_ocfilter']);

            if ($ocfilter_product_sql) {
                $sql .= $ocfilter_product_sql;
            }
        }
        // OCFilter end

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        $sql .= " GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'rating',
            'p.sort_order',
            'p.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == 'p.price') {
                $sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY p.sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $result;
            $product_data[$result['product_id']]['price']  = ($result['discount'] ? $result['discount'] : $result['price']);
        }

        return $product_data;
    }

    public function getTotalProducts($data = array()) {
        $sql = "SELECT COUNT(DISTINCT p.product_id) AS total";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $sql .= " " . implode(" AND ", $implode) . "";
                }

                if (!empty($data['filter_description'])) {
                    $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $sql .= "pd.tag LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            $sql .= ")";
        }

        // OCFilter start
        if (!empty($data['filter_ocfilter'])) {
            $this->load->model('catalog/ocfilter');

            $ocfilter_product_sql = $this->model_catalog_ocfilter->getProductSQL($data['filter_ocfilter']);

            if ($ocfilter_product_sql) {
                $sql .= $ocfilter_product_sql;
            }
        }
        // OCFilter end

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }


}
