<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    public function profile(Request $id) {
        $profile = User::find($id);
        return response()->json([
            "status"=>"success",
            "profile"=>$profile,
        ], 200);
    }

    public function interested_in() {

        $id = Auth::user()->id;
        $interest = Auth::user()->interested_in;
        $latitude = Auth::user()->Latitude;
        $longitude = Auth::user()->Longitude;

        $distance_cal = "(6371 * acos(cos(radians(".$latitude.")) 
                        * cos(radians(users.Latitude)) 
                        * cos(radians(users.Longitude) 
                        - radians(".$longitude.")) 
                        + sin(radians(".$latitude.")) 
                        * sin(radians(users.Latitude))))";

        if ($interest != "both"){
            $users = User::query()
                    ->where('gender', $interest)
                    ->where('users.visible', 1)
                    ->whereNot('users.id', $id)
                    ->select()
                    ->selectRaw("{$distance_cal} AS distance")
                    ->orderBy('distance')
                    ->get();
        }
        else{
            $users = User::query()
                    ->where('users.visible', 1)
                    ->whereNot('users.id', $id)
                    ->select()
                    ->selectRaw("{$distance_cal} AS distance")
                    ->orderBy('distance')
                    ->get();
        }
 
        return response()->json([
            "status"=>"success",
            "users"=>$users,
        ], 200);
    }

    public function favorite() {

        $user_id = Auth::user()->id;
        $favorites = DB::table('users')
                        ->join('favorite', 'users.id', '=', 'favorite.favorited_id')
                        ->where('favorite.user_id','=', $user_id)
                        ->select('users.*')
                        ->get();
        
        return response()->json([
            "status"=>"success",
            "users"=>$favorites,
        ], 200);
    }

    public function inbox(Request $request) {

        $id = $request->id;
        $sender_id = Auth::user()->id;
        $messages = DB::table('messages')
        ->where(function($q) use ($sender_id, $id){
            $q->where('messages.sender_id','=', $sender_id);
            $q->where('messages.resever_id','=', $id);
        })->orWhere(function($q) use($id, $sender_id){
            $q->where('messages.sender_id','=', $id);
            $q->where('messages.resever_id','=', $sender_id);
        })
        ->select('messages.*')
        ->orderBy('created_at', 'asc')
        ->get();
        
        return response()->json([
            "status"=>"success",
            "messages"=>$messages,
        ], 200);
    }


    public function add_favorite(Request $request) {

        $favoriteId = $request->id;
        $userId = Auth::user()->id;
        $deleted = false;
        if(DB::table('favorite')
            ->where('user_id', $userId)
            ->where('favorited_id', $favoriteId)
            ->exists()){
                $success = DB::table('favorite')
                ->where('user_id', $userId)
                ->where('favorited_id', $favoriteId)
                ->delete() == 1;
                $deleted = true;
        }else{
            $success = DB::table('favorite')
            ->insert([
                'user_id' => $userId,
                'favorited_id' => $favoriteId
            ]);
        }
        return response()->json([
            "status"=> $success,
            "deleted" => $deleted
        ], 200);
    }

    public function search(Request $request) {

        $filter = $request->filter;
        $user = Auth::user();

        DB::enableQueryLog();
        $result = User::query();

        if($user->interested_in != 'both'){
            $result = $result
                    ->where('gender', $user->interested_in);
        }
        $result = $result
                    ->where('username', 'LIKE', "%".$filter."%")
                    ->get();

        return response()->json([
            "status"=> 'success',
            "users" => $result
        ], 200);
    }

    public function add_block(Request $request) {

        $blocked_id = $request->id;
        $user_id = Auth::user()->id;
        $deleted = false;
        if(DB::table('blockes')
            ->where('blocker_id', $user_id)
            ->where('blocked_id', $blocked_id)
            ->exists()){
                $success = DB::table('blockes')
                ->where('blocker_id', $user_id)
                ->where('blocked_id', $blocked_id)
                ->delete() == 1;
                $deleted = true;
        }else{
            $success = DB::table('blockes')
            ->insert([
                'blocker_id' => $user_id,
                'blocked_id' => $blocked_id
            ]);
        }
        return response()->json([
            "status"=> $success,
            "deleted" => $deleted
        ], 200);
    }

}
