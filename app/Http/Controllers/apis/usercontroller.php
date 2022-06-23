<?php

namespace App\Http\Controllers\apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class usercontroller extends Controller
{
    public function index($id)
    {
        // $users = user::select('name','latitude','longitude')->get();
        // $users = user::select('name')->where('status', 1)
        //    where('langitude',$id)
        //     ->orderBy('latitude', 'desc')
        //     ->orderBy('longitude', 'desc')
        //     ->take(3)
        //     ->get();
        // return response()->json([compact('users')]);

        $user = user::findOrfail($id)->get();
        $given = user::select('latitude')->get();
        $users = user::select('name')
            ->where('status', 1)
            ->abs('(latitude-$given) as distance')
            ->from(
            (
            $users = user::select('latitude')
            ->where('latitude' >= $given)
            ->orderBy('latitude')
            ->limit(3)
            )
            ->union(
            $users = user::select('latitude')
            ->where('latitude' < $given)
            ->orderBy('latitude')
            ->limit(3)
            )
        )
            ->orderBy('distance')
            ->limit(3)
            ->get();

        return response()->json([compact('user','users','given')]);
    }
}
