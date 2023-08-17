<?php

namespace App\Http\Controllers;

use App\Helper\Hdb;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Cdinas extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function sess(){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            return response()->json([
                'exc' => true,
                'data' =>[
                    "user" => $user,
                    "jenis" =>Hdb::jenisP()
                ]
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function index(){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $tahun = $cek['ta'];
            $data =Hdb::getDinas($user,$tahun);
            $data[0]->bidang = Hdb::getDBidang([
                "kdDinas" =>$data[0]->kdDinas,
                "tahun" => $tahun
            ]);
            if(count($data[0]->bidang)>0){
                $data[0]->bidang[0]->anggota= Hdb::getDAnggota([
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
        $user =Auth::user();
        $cek = $this->portal($user);
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
            $data =Hdb::dinasAdded([
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
        $user =Auth::user();
        $cek = $this->portal($user);
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
        $user =Auth::user();
        $cek = $this->portal($user);
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
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $tahun = $cek['ta'];
            $data =Hdb::getDBidang([
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun
            ]);
            if (count($data)>0) {
                $data[0]->anggota=Hdb::getDAnggota([
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
        $user =Auth::user();
        $cek = $this->portal($user);
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
            if (Hdb::bidangAdded($request->kdDinas, $request->nmBidang, $request->asBidang, $tahun)) {
                $data =Hdb::getDBidang([
                    "kdDinas" =>$request->kdDinas,
                    "tahun" => $tahun
                ]);
                if (count($data)>0) {
                    $data[0]->anggota=Hdb::getDAnggota([
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
        $user =Auth::user();
        $cek = $this->portal($user);
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
        $user =Auth::user();
        $cek = $this->portal($user);
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
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $tahun = $cek['ta'];
            return response()->json([
                'exc' => true,
                'data' => Hdb::getDAnggota([
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
        $user =Auth::user();
        $cek = $this->portal($user);
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
                Hdb::AnggotaAdded(
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
                    'data' => Hdb::getDAnggota([
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

        $user =Auth::user();
        $cek = $this->portal($user);
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
        $user =Auth::user();
        $cek = $this->portal($user);
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
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $tahun = $cek['ta'];
            $data =Hdb::getDinas($user,$tahun);
            $param = [
                "kdDinas" =>$data[0]->kdDinas,
                "tahun" => $tahun,
            ];
            if($user->kdJaba == 1){
                $param["kdBidang"] = $user->kdBidang;
            }
            $data[0]->bidang = Hdb::getDBidang($param);
            $param["kdBidang"] ='';
            $data[0]->sub = Hdb::getSub($param);
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
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $tahun = $cek['ta'];
            $param = [
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun,
            ];
            $bidang= Hdb::getDBidang($param);
            $sub=array();
            if(count($bidang)>0){
                $param["kdBidang"] ='';
                $sub = Hdb::getSub($param);
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
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $tahun = $cek['ta'];
            $param = [
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun,
            ];
            $bidang= Hdb::getDBidang($param);
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
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $tahun = $cek['ta'];
            $param = [
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun,
                "kdBidang"=> $kdBidang,
            ];
            $sub = Hdb::getSub($param);
            if(count($sub)>0){
                $param["kdSub"] = $sub[0]->kdSub;
                $sub[0]->rincian = Hdb::getRincian($param);
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
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $tahun = $cek['ta'];
            $param = [
                "kdDinas" =>$kdDinas,
                "tahun" => $tahun,
                "kdBidang"=> $kdBidang,
                "kdSub"=>$kdSub
            ];
            $rincian = Hdb::getRincian($param);
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
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $tahun = $cek['ta'];
            try {
                $data =Hdb::getDinasJoined($user,$tahun);
                if(count($data)==0){
                    throw " Fitur ini membutuhkan data Dinas";
                }
                $param = [
                    "kdDinas" =>$data[0]->kdDinas,
                    "tahun" => $tahun,
                    "kdBidang"=>''
                ];
                if($user->kdJaba == 1){
                    $param["kdBidang"] = $user->kdBidang;
                }
                $data[0]->bidang = Hdb::getDBidang($param);
                $data[0]->jenis = Hdb::jenisP();
                $data[0]->apbd = Hdb::apbd($param);
                if(count($data[0]->bidang)==0){
                    throw new Exception(" Fitur ini membutuhkan data Bidang", 1);
                }
                if(empty($param["kdBidang"])){
                    $param["kdBidang"] = $data[0]->bidang[0]->kdDBidang;
                }
                $data[0]->bidang[0]->sub = Hdb::getSub($param);
                if(count($data[0]->bidang[0]->sub)==0){
                    throw new Exception(" Fitur ini membutuhkan data Sub kegiatan", 1);
                }

                $param["kdSub"] = $data[0]->bidang[0]->sub[0]->kdSub;
                $data[0]->bidang[0]->sub[0]->rincian = Hdb::getRincian($param);

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
