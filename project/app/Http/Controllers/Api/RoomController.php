<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Room;
use App\Traits\RespondsWithHttpStatus;
use Yajra\DataTables\Facades\DataTables;


class RoomController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct() {
        $this->middleware('auth');
    }     

    public function get_data(Request $request){
        $room = new Room;
        $datas = $room->get_data();

        return DataTables::of($datas)
        ->filter(function ($query) use ($request) {
            $query->when($request->has('search.value'), function ($q) use ($request) {
                $value = $request->input('search.value');
                $q->where(function ($query) use ($value) {
                    $query->where('rooms.name', 'like', "%$value%");
                });
            });
            $query->OrderBy('rooms.price', 'asc');
            $query->where('rooms.status', '!=', 1);
        })
        ->make(true);
    }

    public function detail($id){
        $room = new Room;
        $datas = $room->get_data();

        $res = $datas->find($id);
        if(!$res){
            return $this->errorNotFound(null);
        }    
        return $this->ok($res, null);
    }

}
