<?php

namespace App\Overrides\Catalog\Model\Localisation;

use Doctrine\Common\Collections\ArrayCollection;

require_once DIR_OPENCART . 'admin/model/localisation/location.php';

class LocationModel extends \ModelLocalisationLocation
{
    public function getShops(array $data = array()){
        $shops = new ArrayCollection();
        foreach ($this->getLocations($data) as $shop){
            $shops->set($shop["id_erp"], $shop);
        }
        return $shops;
    }

    public function getLocations($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "location";

        $sort_data = array(
            'name',
            'address',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
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

        $query = $this->db->query($sql);

        return $query->rows;
    }
}