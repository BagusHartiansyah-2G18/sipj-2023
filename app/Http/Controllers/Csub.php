<?php

namespace App\Http\Controllers;

use App\Helper\Hdb;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Csub extends Controller
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
                'data' => Hdb::getSubAll([
                    "kdDinas"=>$user->kdDinas,
                    "tahun"=>$tahun,
                ])
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function sub($kdDinas){
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta'];
            return response()->json([
                'exc' => true,
                'data' => Hdb::getSub([
                    "kdDinas"=>$kdDinas,
                    "tahun"=>$tahun,
                ])
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function setSubBidang(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta']; 
            try {
                $request->validate([
                    'kdSub'=> 'required', 
                    'kdDinas'=> 'required',  
                    'kdBidang'=> 'required', 
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'exc' => false,
                    'data' => "Kurangnya Data yang di Upload !!!"
                ], 200);
            }
            
            if(
                DB::table('psub')
                ->where('kdDinas',$request->kdDinas) 
                ->where('kdSub',$request->kdSub)
                ->where('taSub',$tahun)
                ->update([ 
                    'kdBidang' => $request->kdBidang
                ])
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
            
            return response()->json([
                'exc' => false,
                'data' => "Execute query error !!!"
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function delSubBidang(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta']; 
            try {
                $request->validate([
                    'kdSub'=> 'required', 
                    'kdDinas'=> 'required',  
                    'kdBidang'=> 'required', 
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'exc' => false,
                    'data' => "Kurangnya Data yang di Upload !!!"
                ], 200);
            }
            
            if(
                DB::table('psub')
                ->where('kdDinas',$request->kdDinas) 
                ->where('kdSub',$request->kdSub)
                ->where('taSub',$tahun)
                ->where('kdBidang', $request->kdBidang)
                ->update([ 
                    'kdBidang' => ''
                ])
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
            
            return response()->json([
                'exc' => false,
                'data' => "Execute query error !!!"
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
