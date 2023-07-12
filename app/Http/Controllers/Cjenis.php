<?php

namespace App\Http\Controllers;

use App\Helper\Hdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class Cjenis extends Controller
{
    public function __construct(){
        // $this->middleware('auth');
    }
    public function index(){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta'];
            $data =Hdb::jenisP();
            if(count($data)>0){
                $data[0]->dukung = Hdb::jenisDataDukung([
                    "kdJPJ" =>  $data[0]->kdJPJ,
                ]); 
            }
            return response()->json([
                'exc' => true,
                'data' => $data
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function added(Request $request){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $request->validate([
                'nmJPJ'=> 'required',
            ]);  
            $data =Hdb::jenisAdded($request->nmJPJ);
            return $this->index();
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
            $request->validate([
                'kdJPJ'=> 'required',
                'nmJPJ'=> 'required', 
            ]); 
            if(
                DB::table('jenispj')
                ->where('kdJPJ',$request->kdJPJ) 
                ->update([ 
                    'nmJPJ' => $request->nmJPJ, 
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
            $request->validate([
                'kdJPJ'=> 'required',
            ]);  
            
            if(
                DB::table('jenispj')
                ->where('kdJPJ',$request->kdJPJ) 
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

    public function dataDukung($jenisP){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $tahun = $cek['ta']; 
            return response()->json([
                'exc' => true,
                'data' => Hdb::jenisDataDukung([
                            "kdJPJ" =>  $jenisP,
                        ])
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function addedDukung(Request $request){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $request->validate([
                'kdJPJ'=> 'required',
                'nmDP'=> 'required',
            ]);  
            $data =Hdb::jenisDukungAdded($request->kdJPJ,$request->nmDP);
            return $this->dataDukung($request->kdJPJ);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function updedDukung(Request $request){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $request->validate([
                'kdJPJ'=> 'required',
                'kdDP'=> 'required',
                'nmDP'=> 'required',
            ]); 
            if(
                DB::table('datapendukung')
                ->where('kdJPJ',$request->kdJPJ) 
                ->where('kdDP',$request->kdDP) 
                ->update([ 
                    'nmDP' => $request->nmDP, 
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
    public function deledDukung(Request $request){ 
        $user =Auth::user();
        $cek = $this->portal($user); 
        if($cek['exc']){
            $request->validate([
                'kdJPJ'=> 'required',
                'kdDP'=> 'required',
            ]);  
            
            if(
                DB::table('datapendukung')
                ->where('kdJPJ',$request->kdJPJ) 
                ->where('kdDP',$request->kdDP) 
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
