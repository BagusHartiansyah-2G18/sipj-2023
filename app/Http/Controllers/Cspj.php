<?php

namespace App\Http\Controllers;
use App\Helper\Hdb;
use Illuminate\Http\Request;
use App\Models\spj;
use App\Helper\Mfc;
class Cspj extends Controller
{
    private $Mfc, $Hdb;
    public function __construct(){
        $this->Mfc = new Mfc();
        $this->Hdb = new Hdb();
        $this->middleware('auth');
    }
    function getSpj($param) {
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($param)));
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "tahun"=>$cek['ta']
            ]; 
            $data =$this->Hdb->getDataJudulSub($param);
            unset($param['tahun']);
            $param['taSPJ']=$cek['ta'];
            return $this->Mfc->resp([
                "basic" => $data[0],
                "data" => spj::where($param)->get()
            ]);
        }
        return $this->Mfc->respError($cek['msg']);  
    }
    function setSpj(Request $request) {
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $vld = $request;
            try {
                $vld = $vld->validate([
                    'kdDinas' => 'required',
                    'kdBidang' => 'required',
                    'kdSub' => 'required',
                    'kdJudul' => 'required',
    
                    'data'=> 'required', 
                    'volume'=> 'required',
                    'satuan'=> 'required',
    
                    'totVol'=> 'required',
                    'totSatuan'=> 'required',
                    'keterangan'=> 'required',
                    'an'=> 'required',
                ]);
            } catch (\Throwable $th) {
                return $this->Mfc->respError('body not valid');
            }
            $vld['idMember']=$cek['kdMember'];
            $vld['taSPJ']=$cek['ta'];
            $vld['no']=1;
            $vld['status']='1';
            
            $where = [
                'kdDinas' => $vld['kdDinas'],
                'kdBidang'=>$vld['kdBidang'],
                'kdSub' => $vld['kdSub'],
                'kdJudul'=>$vld['kdJudul'],
                'taSPJ' => $vld['taSPJ'] 
            ];
            $fdt = spj::where($where)->orderByRaw("CAST(no AS int) desc")->limit(1)->get();
            if(count($fdt)>0){
                $vld['no']=$fdt[0]->no+1;
            }   
            if(spj::create($vld)){
                return $this->Mfc->resp(spj::where($where)->get());
            }
            return $this->Mfc->respError('error, bagian setSpj');  
        }
        return $this->Mfc->respError($cek['msg']);  
    }
    function updSpj(Request $request) {
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $vld = $request;
            try {
                $vld = $vld->validate([
                    'kdDinas' => 'required',
                    'kdBidang' => 'required',
                    'kdSub' => 'required',
                    'kdJudul' => 'required', 
                    'data'=> 'required', 

                    'volume'=> 'required',
                    'satuan'=> 'required',
                    'totVol'=> 'required',
                    'totSatuan'=> 'required',
                    'keterangan'=> 'required',

                    'an'=> 'required',
                    'no'=> 'required',
                ]);
            } catch (\Throwable $th) {
                return $this->Mfc->respError('body not valid');
            }
            $vld['idMember']=$cek['kdMember']; 
            
            $where = [
                'kdDinas' => $vld['kdDinas'],
                'kdBidang'=>$vld['kdBidang'],
                'kdSub' => $vld['kdSub'],
                'kdJudul'=>$vld['kdJudul'],
                'taSPJ' => $cek['ta'],
                'no' => $vld['no'] 
            ];
            $upd = [
                "an" => $vld['an'],
                'data' => $vld['data'],
                'volume'=> $vld['volume'],
                'totVol' => $vld['totVol'],
                'idMember'=> $vld['idMember'],
                'totSatuan'=> $vld['totSatuan'],
                'keterangan' => $vld['keterangan'],
            ];
            $fdt = spj::where($where);
            if($fdt->update($upd)){ 
                return $this->Mfc->resp([]);
            }   
            return $this->Mfc->respError('error, bagian updSpj');  
        }
        return $this->Mfc->respError($cek['msg']);  
    }
}
