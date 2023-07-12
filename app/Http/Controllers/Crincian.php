<?php

namespace App\Http\Controllers;
use App\Helper\Hdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;  

class Crincian extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 
    public function added(Request $request){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta'];
            try {
                $request->validate([
                    'kdDinas'=> 'required',
                    'kdBidang'=> 'required',
                    'kdSub'=> 'required',
                    'nama'=> 'required',
                    'total'=> 'required',
                    'kdJenis'=> 'required',
                    'kdApbd6'=> 'required',
                ]);
            } catch (\Throwable $th) { 
                return response()->json([
                    'exc' => false,
                    'data' => "Kurangnya Data yang di Upload !!!"
                ], 200);
            }
            
            $request['tahun'] = $tahun;
            $data =Hdb::rincianAdded($request); 
            return response()->json([
                'exc' => true,
                'data' => Hdb::getRincian($request)
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function upded(Request $request){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta'];
            $request->validate([
                'kdDinas'=> 'required',
                'kdBidang'=> 'required',
                'kdSub'=> 'required',
                'nama'=> 'required',
                'total'=> 'required',
                'kdJenis'=> 'required',
                'kdApbd6'=> 'required',
                'kdJudul'=> 'required',
            ]);
            if(
                DB::table('ubjudul')
                ->where('kdDinas',$request->kdDinas) 
                ->where('kdBidang',$request->kdBidang) 
                ->where('kdSub',$request->kdSub) 
                ->where('kdJudul',$request->kdJudul) 
                ->where('taJudul',$tahun)
                ->update([ 
                    'nama' => $request->nama, 
                    'total' => $request->total, 
                    'kdJenis' => $request->kdJenis, 
                    'kdApbd6' => $request->kdApbd6, 
                ])
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function deled(Request $request){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta'];
            $request->validate([
                'kdDinas'=> 'required',
                'kdBidang'=> 'required',
                'kdSub'=> 'required',
                'kdJudul'=> 'required',
            ]);
            if(
                DB::table('ubjudul')
                ->where('kdDinas',$request->kdDinas) 
                ->where('kdBidang',$request->kdBidang) 
                ->where('kdSub',$request->kdSub) 
                ->where('kdJudul',$request->kdJudul) 
                ->where('taJudul',$tahun)
                ->delete()
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    } 

    public function addedTriwulan(Request $request){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta'];
            $request->validate([
                'kdDinas'=> 'required',
                'kdBidang'=> 'required',
                'kdSub'=> 'required',
                'kdJudul'=> 'required',
                'tw1'=> 'required',
                'tw2'=> 'required',
                'tw3'=> 'required',
                'tw4'=> 'required',
            ]);
            $request['tahun'] = $tahun;
            $data =Hdb::triwulanAdded($request); 
            return response()->json([
                'exc' => true,
                'data' => []
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    } 
    public function updedTriwulan(Request $request){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta'];
            $request->validate([
                'kdDinas'=> 'required',
                'kdBidang'=> 'required',
                'kdSub'=> 'required',
                'kdJudul'=> 'required',
                'tw1'=> 'required',
                'tw2'=> 'required',
                'tw3'=> 'required',
                'tw4'=> 'required',
            ]); 
            if(
                DB::table('triwulan')
                ->where('kdDinas',$request->kdDinas) 
                ->where('kdBidang',$request->kdBidang) 
                ->where('kdSub',$request->kdSub) 
                ->where('kdJudul',$request->kdJudul) 
                ->where('taJudul',$tahun)
                ->update([
                    'tw1' => $request->tw1,
                    'tw2' => $request->tw2,
                    'tw3' => $request->tw3,
                    'tw4' => $request->tw4,
                ])
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
            return response()->json([
                'exc' => false,
                'msg' => 'execute query error !!!'
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
