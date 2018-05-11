<?php

class ModelShippingNovaposhta extends Model
{
    protected $api;

    public function __construct($registry)
    {
        parent::__construct($registry);
        $api_key = $this->config->get("novaposhta_api_key");
        $this->api = new \LisDev\Delivery\NovaPoshtaApi2($api_key);
    }

    function getQuote($address)
    {
        $this->load->language('shipping/novaposhta');

        if (!empty($address['country_id'])) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pickup_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
        }
        if (!$this->config->get('pickup_geo_zone_id')) {
            $status = true;
        } elseif (!empty($query->num_rows)) {
            $status = true;
        } else {
            $status = false;
        }


        if (!$status) {
            return [];
        }

        $quote_data = array();

        $quote_data['novaposhta'] = array(
            'code' => 'novaposhta.novaposhta',
            'title' => $this->language->get('text_description'),
            'cost' => 0.00,
            'tax_class_id' => 0,
            'text' => ""
        );


        $method_data = array(
            'code' => 'novaposhta',
            'title' => $this->language->get('text_title'),
            'quote' => $quote_data,
            'sort_order' => $this->config->get('novaposhta_sort_order'),
            'error' => false,
            'controller'=> 'shipping/novaposhta'
        );


        return $method_data;
    }

    public function getRegions():array{
        return $this->prepareResponse($this->api->getAreas());
    }

    public function getCities(string $area):array{
        return $this->prepareResponse($this->api->getCitiesByArea($area));
    }

    /**
     * @param $cityRef ID of city
     * @return array
     */
    public function getWarehouses(string $cityRef):array{
        return $this->prepareResponse($this->api->getWarehouses($cityRef));
    }

    public function getWarehouseByRef(string $cityRef, string $warehouseRef):array{
        return $this->api->getWarehouseByRef($cityRef, $warehouseRef);
    }

    public function getCityByRef(string $cityRef, string $area_name):array{

        $cities = $this->getCities($area_name);
        foreach ($cities as $city){
            if($city["Ref"] === $cityRef){
                return $city;
            }
        }
    }


    protected function prepareResponse(array $response):array{
        if($response['success'] === false){
            throw new \Exception("There was error. please try latter.".implode(",", $response["errors"]));
        }
        return $response["data"];
    }
}