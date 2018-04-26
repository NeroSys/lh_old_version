<?php
namespace App\Overrides\Admin\Model\Localisation;

use App\Entity\Location;
require_once(DIR_OPENCART . 'admin/model/localisation/location.php');

class LocationModel extends \ModelLocalisationLocation
{
    public function addLocation($data) {
        $locationModel = new Location($data);
        $locationModel->save();
        return $locationModel->id;
    }

    public function editLocation($location_id, $data) {
        $location = Location::find($location_id);
        foreach ($data as $attributeName => $attrubiteValue){
            $location->{$attributeName} = $attrubiteValue;
        }
        $location->save();
    }

}