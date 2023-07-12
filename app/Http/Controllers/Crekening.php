<?php

namespace App\Http\Controllers;

use App\Helper\Hdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Crekening extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta'];
            return response()->json([
                'exc' => true,
                'data' => Hdb::getRekening([ 
                    "tahun"=>$tahun,
                ])
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    function portal($user){
        if(!empty($user->kdDinas)){
            return [
                "exc"=>true,
                "ta"=>"2024"
            ];
        }
        return [
            "exc"=>false,
            "msg"=>" user can't Dinas !!!"
        ];
    }
}
