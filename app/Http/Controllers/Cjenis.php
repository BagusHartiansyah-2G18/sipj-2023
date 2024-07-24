<?php

namespace App\Http\Controllers;
use App\Helper\Mfc;

use App\Helper\Hdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class Cjenis extends Controller
{
    private $Mfc, $Hdb;
    public function __construct(){
        $this->Mfc = new Mfc();
        $this->Hdb = new Hdb();
        $this->middleware('auth');
    }
    public function index(){  
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $data =$this->Hdb->jenisP();
            if(count($data)>0){
                $data[0]->dukung = $this->Hdb->jenisDataDukung([
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
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $request->validate([
                'nmJPJ'=> 'required',
            ]);  
            $data =$this->Hdb->jenisAdded($request->nmJPJ);
            return $this->index();
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function upded(Request $request){ 
        
        $cek = $this->Mfc->portal();
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
        
        $cek = $this->Mfc->portal();
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
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta']; 
            return response()->json([
                'exc' => true,
                'data' => $this->Hdb->jenisDataDukung([
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
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $request->validate([
                'kdJPJ'=> 'required',
                'nmDP'=> 'required',
            ]);  
            $data =$this->Hdb->jenisDukungAdded($request->kdJPJ,$request->nmDP);
            return $this->dataDukung($request->kdJPJ);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function updedDukung(Request $request){ 
        
        $cek = $this->Mfc->portal();
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
        
        $cek = $this->Mfc->portal();
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
