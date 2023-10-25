<?php

use Illuminate\Support\Facades\Request;

class GoogleMapClass
{
    public function getAddress(Request $request)
    {
//        $geocodeResult = $this->gmaps->geocode(request()->input);
//
//        $addressData = [];
//
//        if (count($geocodeResult) > 0) {
//
//            foreach ($geocodeResult as $index => $fAddress) {
//                $data = ['address' => $fAddress['formatted_address'] , 'lat' => $fAddress['geometry']['location']['lat'] ,
//                            'lng' => $fAddress['geometry']['location']['lng']];
//                $addressData  = $data;
//            }
//            return [
//                'success' => true,
//                'data' =>  $addressData
//            ];
//        }
//
//        return [
//            'success' => false,
//            'data' => []
//        ];
    }
}