<?php

class ControllerShippingPickup extends \Controller
{

    public function index(array $data = [])
    {
        return $this->load->view("shipping/pickup", []);
    }
}
