<?php

class ControllerShippingNovaposhta extends \Controller
{
    /**
     * @var ModelShippingNovaposhta
     */
    protected $np_model;
    const SESSION_KEY_USER_WAREHOUSE = 'novaposhta_warehouse';
    const SESSION_KEY_USER_CITY = 'novaposhta_city';
    const SESSION_KEY_USER_REGION = 'novaposhta_region';

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->np_model = $this->load->singleton('shipping/novaposhta');
    }

    public function index(array $data = [])
    {
        $data = [];
        $data["areas"] = $this->getRegions();
        $data["cities"] = $this->getCities();
        $data["warehouses"] = $this->getWarehouses();

        return $this->load->view("shipping/novaposhta", $data);
    }

    public function changeRegionAction(){
        if (empty($this->request->post['novapochta_region'])) {
            throw new \Exception("Вы не выбрали регион для отправки!");
        }

        $this->setUserChosedArea($this->request->post['novapochta_region']);
        $this->response->setOutput($this->index());
    }

    public function changeCityAction(){
        if (empty($this->request->post['novapochta_city'])) {
            throw new \Exception("Вы не выбрали город для отправки!");
        }

        $this->setUserChosedCity($this->request->post['novapochta_city']);
        $this->response->setOutput($this->index());
    }

    public function changeWarehouseAction(){
        if (empty($this->request->post['novaposhta_warehouse'])) {
            throw new \Exception("Вы не выбрали склад для отправки!");
        }

        $this->setUserChosedWarehouse($this->request->post['novaposhta_warehouse']);
        $this->response->setOutput($this->index());
    }

    protected function getRegions():array{
        $areas = $this->np_model->getRegions();
        foreach ($areas as $key => $area){
            $areas[$key]["selected"] = $this->getUserChosedArea() === $area["Description"] ? true: false;
        }
        return $areas;
    }

    protected function getCities():array{
        if(null === $this->getUserChosedArea()){
            return [];
        }
        $cities = $this->np_model->getCities($this->getUserChosedArea());
        foreach ($cities as $key => $city){
            $cities[$key]["selected"] = $this->getUserChosedCity() === $city["Ref"] ? true: false;
        }
        return $cities;
    }

    protected function getWarehouses():array{
        if(null === $this->getUserChosedCity()){
            return [];
        }
        $warehouses = $this->np_model->getWarehouses($this->getUserChosedCity());
        foreach ($warehouses as $key => $warehouse){
            $warehouses[$key]["selected"] = $this->getUserChosedWarehouse() === $warehouse["Ref"] ? true: false;
        }
        return $warehouses;
    }

    protected function getUserChosedArea():?string{
        return !empty($this->session->data[self::SESSION_KEY_USER_REGION]) ? $this->session->data[self::SESSION_KEY_USER_REGION]: null;
    }

    protected function getUserChosedCity():?string{
        return !empty($this->session->data[self::SESSION_KEY_USER_CITY]) ? $this->session->data[self::SESSION_KEY_USER_CITY]: null;
    }

    protected function getUserChosedWarehouse():?string{
        return !empty($this->session->data[self::SESSION_KEY_USER_WAREHOUSE]) ? $this->session->data[self::SESSION_KEY_USER_WAREHOUSE]: null;
    }

    protected function setUserChosedArea(string $area):self{
        $this->session->data[self::SESSION_KEY_USER_REGION] = $area;
        $this->setUserChosedCity(null);
        $this->setUserChosedWarehouse(null);
        return $this;
    }

    protected function setUserChosedCity(?string $city):self{
        $this->session->data[self::SESSION_KEY_USER_CITY] = $city;
        $this->setUserChosedWarehouse(null);
        return $this;
    }

    protected function setUserChosedWarehouse(?string $warehouse):self{
        $this->session->data[self::SESSION_KEY_USER_WAREHOUSE] = $warehouse;
        return $this;
    }
}
