<?php

namespace App\Http\Controllers;

use App\Helper\Hdb;
use App\Helper\Mfc;
use App\Models\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Cdinas extends Controller
{
    private $Mfc, $Hdb;
    public function __construct(){
        $this->Mfc = new Mfc();
        $this->Hdb = new Hdb(); 
        $this->middleware('auth'); 
    }
    public function sess(){ 
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            return response()->json([
                'exc' => true,
                'data' =>[
                    "user" => Auth::user(),
                    "jenis" =>$this->Hdb->jenisP()
                ]
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function index(){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $data =$this->Hdb->getDinas($cek['user'],$tahun);
            $data[0]->bidang = $this->Hdb->getDBidang([
                "kdDinas" =>$data[0]->kdDinas,
                "tahun" => $tahun
            ]);
            if(count($data[0]->bidang)>0){
                $data[0]->bidang[0]->anggota= $this->Hdb->getDAnggota([
                    "kdDinas" =>  $data[0]->kdDinas,
                    "kdBidang"=> $data[0]->bidang[0]->kdDBidang,
                    "tahun"   =>$tahun
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
            $tahun = $cek['ta'];
            try {
                $request->validate([
                    'kdDinas'=> 'required',
                    'nmDinas'=> 'required',
                    'asDinas'=> 'required',
                    'kadis'=> 'required',
                    'nip'=> 'required',
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'exc' => false,
                    'msg' => $th->getMessage()
                ], 200);
            }
            $data =$this->Hdb->dinasAdded([
                $request->kdDinas,
                $request->nmDinas,
                $request->asDinas,
                $request->kadis,
                $request->nip,
                $tahun,
            ]);
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
            $tahun = $cek['ta'];
            try {
                $request->validate([
                    'kdDinas'=> 'required',
                    'nmDinas'=> 'required',
                    'asDinas'=> 'required',
                    'kadis'=> 'required',
                    'nip'=> 'required',
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'exc' => false,
                    'msg' => $th->getMessage()
                ], 200);
            }
            if(
                DB::table('dinas')
                ->where('kdDinas',$request->kdDinas)
                ->where('taDinas',$tahun)
                ->update([
                    'nmDinas' => $request->nmDinas,
                    'asDinas' => $request->asDinas,
                    'kadis' => $request->kadis,
                    'nip' => $request->nip,
                ])
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
            return response()->json([
                'exc' => false,
                'msg' => "Execute query error !!!"
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function deled(Request $request){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $request->validate([
                'kdDinas'=> 'required',
            ]);

            if(
                DB::table('dinas')
                ->where('kdDinas',$request->kdDinas)
                ->where('taDinas',$tahun)
                ->delete()
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
            return response()->json([
                'exc' => false,
                'msg' => "Execute query error !!!"
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }

    public function bidang($kdDinas){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $data =$this->Hdb->getDBidang([
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun
            ]);
            if (count($data)>0) {
                $data[0]->anggota=$this->Hdb->getDAnggota([
                    "kdDinas" =>  $kdDinas,
                    "kdBidang"=> $data[0]->kdDBidang,
                    "tahun"   => $tahun
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
    public function addedBidang(Request $request){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            try {
                $request->validate([
                    'kdDinas'=> 'required',
                    'nmBidang'=> 'required',
                    'asBidang'=> 'required',
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'exc' => false,
                    'msg' => $th->getMessage()
                ], 200);
            }
            if ($this->Hdb->bidangAdded($request->kdDinas, $request->nmBidang, $request->asBidang, $tahun)) {
                $data =$this->Hdb->getDBidang([
                    "kdDinas" =>$request->kdDinas,
                    "tahun" => $tahun
                ]);
                if (count($data)>0) {
                    $data[0]->anggota=$this->Hdb->getDAnggota([
                        "kdDinas" =>  $request->kdDinas,
                        "kdBidang"=> $data[0]->kdDBidang,
                        "tahun"   => $tahun
                    ]);
                }
                return response()->json([
                    'exc' => true,
                    'data' => $data
                ], 200);
            }

            return response()->json([
                'exc' => false,
                'msg' => "Execute query error !!!"
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function updedBidang(Request $request){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            try {
                $request->validate([
                    'kdDinas'=> 'required',
                    'kdDBidang'=> 'required',
                    'nmBidang'=> 'required',
                    'asBidang'=> 'required',
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'exc' => false,
                    'msg' => "Kurangnya Data yang di Upload !!!"
                ], 200);
            }

            if(
                DB::table('dinas_bidang')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdDBidang',$request->kdDBidang)
                ->where('taDBidang',$tahun)

                ->update([
                    'nmBidang' => $request->nmBidang,
                    'asBidang' => $request->asBidang,
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
    public function deledBidang(Request $request){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $request->validate([
                'kdDinas'=> 'required',
                'kdDBidang'=> 'required',
            ]);

            if(
                DB::table('dinas_bidang')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdDBidang',$request->kdDBidang)
                ->where('taDBidang',$tahun)
                ->delete()
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
            return response()->json([
                'exc' => false,
                'msg' => "Execute query error !!!"
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }


    public function anggota($kdDinas,$kdDBidang){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            return response()->json([
                'exc' => true,
                'data' => $this->Hdb->getDAnggota([
                    "kdDinas" =>  $kdDinas,
                    "kdBidang"=> $kdDBidang,
                    "tahun"   => $tahun
                ])
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function addedAnggota(Request $request){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            try {
                $request->validate([
                    'kdDinas'=> 'required',
                    'kdDBidang'=> 'required',
                    'nmAnggota'=> 'required',
                    'nip'=> 'required',
                    'nmJabatan'=> 'required',
                    'asJabatan'=> 'required',
                    'golongan'=> 'required',
                    'tingkat'=> 'required',
                    'selStatus'=> 'required',
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'exc' => false,
                    'msg' => $th->getMessage()
                ], 200);
            }

            if (
                $this->Hdb->AnggotaAdded(
                    $request->kdDinas,
                    $request->kdDBidang,
                    $request->nmAnggota,
                    $request->nmJabatan,
                    $request->nip,
                    $request->selStatus,
                    $tahun,
                    $request->asJabatan,
                    $request->golongan,
                    $request->tingkat,
                )
            ){
                return response()->json([
                    'exc' => true,
                    'data' => $this->Hdb->getDAnggota([
                        "kdDinas" =>  $request->kdDinas,
                        "kdBidang"=> $request->kdDBidang,
                        "tahun"   => $tahun
                    ])
                ], 200);
            }

            return response()->json([
                'exc' => false,
                'msg' => "Execute query error !!!"
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function updedAnggota(Request $request){

        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            try {
                $request->validate([
                    'kdBAnggota'=> 'required',
                    'kdDinas'=> 'required',
                    'kdDBidang'=> 'required',
                    'nmAnggota'=> 'required',
                    'nmJabatan'=> 'required',
                    'nip'=> 'required',
                    'asJabatan'=> 'required',
                    'golongan'=> 'required',
                    'tingkat'=> 'required',
                    'selStatus'=> 'required',
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'exc' => false,
                    'data' => "Kurangnya Data yang di Upload !!!"
                ], 200);
            }

            if(
                DB::table('dinas_b_anggota')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdBidang',$request->kdDBidang)
                ->where('kdBAnggota',$request->kdBAnggota)
                ->where('taBAnggota',$tahun)
                ->update([
                    'nmAnggota' => $request->nmAnggota,
                    'nmJabatan' => $request->nmJabatan,
                    'nip' => $request->nip,
                    'status' => $request->selStatus,
                    'asJabatan' => $request->asJabatan,
                    'golongan' => $request->golongan,
                    'tingkatan' => $request->tingkat,
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
    public function deledAnggota(Request $request){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $request->validate([
                'kdBAnggota'=> 'required',
                'kdDinas'=> 'required',
                'kdDBidang'=> 'required',
            ]);

            if(
                DB::table('dinas_b_anggota')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdBidang',$request->kdDBidang)
                ->where('kdBAnggota',$request->kdBAnggota)
                ->where('taBAnggota',$tahun)
                ->delete()
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
        }
        return response()->json([
            'exc' => true,
            'msg' => $cek['msg']
        ], 200);
    }

    public function dinasBidangSub(){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];  
            $data =$this->Hdb->getDinas($cek['user'],$tahun);
            
            $param = [
                "kdDinas" =>$data[0]->kdDinas,
                "tahun" => $tahun,
            ];
            if($cek['user']->kdJaba == 1){
                $param["kdBidang"] = $cek['user']->kdBidang;
            }
            $data[0]->bidang = $this->Hdb->getDBidang($param);
            $param["kdBidang"] ='';
            $data[0]->sub = $this->Hdb->getSub($param);
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
    public function dinasDataBidangSub($kdDinas){ // all data 1 list
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $param = [
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun,
            ];
            $bidang= $this->Hdb->getDBidang($param);
            $sub=array();
            if(count($bidang)>0){
                $param["kdBidang"] ='';
                $sub = $this->Hdb->getSub($param);
            }
            return response()->json([
                'exc' => true,
                'data' => [
                    "bidang"=>$bidang,
                    "sub"=>$sub
                ]
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function dinasDataBidang($kdDinas){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $param = [
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun,
            ];
            $bidang= $this->Hdb->getDBidang($param);
            return response()->json([
                'exc' => true,
                'data' => $bidang
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function getSubBidang($kdDinas,$kdBidang){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $param = [
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun,
                "kdBidang"=> $kdBidang,
            ];
            $sub = $this->Hdb->getSub($param);
            if(count($sub)>0){
                $param["kdSub"] = $sub[0]->kdSub;
                $sub[0]->rincian = $this->Hdb->getRincian($param);
            }


            return response()->json([
                'exc' => true,
                'data' => $sub
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function getUraianSub($kdDinas,$kdBidang,$kdSub){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            $param = [
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun,
                "kdBidang"=> $kdBidang,
                "kdSub"=>$kdSub
            ];
            $rincian = $this->Hdb->getRincian($param);
            return response()->json([
                'exc' => true,
                'data' => $rincian
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }

    public function rincian(){
        
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $tahun = $cek['ta'];
            try {
                $data =$this->Hdb->getDinasJoined($cek['user'],$tahun);
                if(count($data)==0){
                    throw " Fitur ini membutuhkan data Dinas";
                }
                $param = [
                    "kdDinas" =>$data[0]->kdDinas,
                    "tahun" => $tahun,
                    "kdBidang"=>''
                ];
                if($cek['user']->kdJaba == 1){
                    $param["kdBidang"] = $cek['user']->kdBidang;
                }
                $data[0]->bidang = $this->Hdb->getDBidang($param);
                $data[0]->jenis = $this->Hdb->jenisP();
                $data[0]->apbd = $this->Hdb->apbd($param);
                if(count($data[0]->bidang)==0){
                    throw new Exception(" Fitur ini membutuhkan data Bidang", 1);
                }
                if(empty($param["kdBidang"])){
                    $param["kdBidang"] = $data[0]->bidang[0]->kdDBidang;
                }
                $data[0]->bidang[0]->sub = $this->Hdb->getSub($param);
                if(count($data[0]->bidang[0]->sub)==0){
                    throw new Exception(" Fitur ini membutuhkan data Sub kegiatan", 1);
                }

                $param["kdSub"] = $data[0]->bidang[0]->sub[0]->kdSub; 
                $data[0]->bidang[0]->sub[0]->rincian = $this->Hdb->getRincian($param);

                return response()->json([
                    'exc' => true,
                    'data' => $data
                ], 200);
            }catch (Exception $e){
                return response()->json([
                'exc' => false,
                'msg' => $e->getMessage()
                ], 200);
            }
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }

     
}
