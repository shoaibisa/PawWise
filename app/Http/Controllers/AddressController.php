<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\country;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //

    public function getSateByCity(int $id)
    {

        // $city = City::find($id);
        // $state = $city->state;
        // cities on a country
        $cities = country::find($id)->getAllCity;
        return $cities;
        // return [$city->name, $state->name, $country->name];
    }
}
