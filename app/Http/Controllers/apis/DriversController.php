<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DriversController extends Controller
{
    public function drivers($Latitude, $Longitude)
    {
        $query = User::query()->where('type', 'driver')->select();
        $haversine = "(6371 
        * acos(cos(radians($Latitude))
         * cos(radians(latitude)) 
         * cos(radians(longitude) 
         - radians($Longitude)) 
         + sin(radians($Latitude)) 
         * sin(radians(latitude))))";

        return $query->selectRaw("{$haversine} AS distance")
            ->orderBy('distance')
            ->limit(3)
            ->get();
    }
}

// \DB::table("users")
//      ->select("users.id", \DB::raw("6371 * acos(cos(radians(" . $this->lat . "))
//      * cos(radians(users.latitude)) 
//      * cos(radians(users.longitude) - radians(" . $this->lng . ")) 
//      + sin(radians(" .$this->lat. ")) 
//      * sin(radians(users.latitude))) AS distance"))
//      ->having('distance', '<', $this->rad)
//      ->first();
// -------------------------------
// private function findNearestDrivers($latitude, $longitude)
// {
//     $drivers = DB::table('user')
//                     ->selectRaw("id, name, address, latitude, longitude,
//                      ( 6371000 * acos( cos( radians(?) ) *
//                        cos( radians( latitude ) )
//                        * cos( radians( longitude ) - radians(?)
//                        ) + sin( radians(?) ) *
//                        sin( radians( latitude ) ) )
//                      ) AS distance", [$latitude, $longitude, $latitude])
//         ->where('active', '=', 1)
//         ->orderBy("distance",'asc')
//         ->limit(3)
//         ->get();
//     return $drivers;
// }