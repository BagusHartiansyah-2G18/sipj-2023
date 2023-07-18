<?php

namespace App\Http\Controllers;
use App\Helper\Hdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Csppd extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index($param){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($param)));
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "tahun"=>$cek['ta']
            ];

            $data =Hdb::getDataSppd($param);
            $anggota = Hdb::getAllBidangAnggota($param);
            $dpendukung = Hdb::jenisDataDukung($cek);
            $param['kdBAnggota']='';
            $dwork = Hdb::dwork($param);
            // // return print_r($dwork);
            return response()->json([
                'exc' => true,
                'data' => [
                    "basic" => $data,
                    "dwork" => $dwork,
                    "anggota"=> $anggota,
                    "dpendukung" => $dpendukung
                ]
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
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',
                'date'=> 'required',
                'tujuan'=> 'required',
            ]);
            $data =Hdb::workAdded([
                $request->no,
                $request->kdDinas,
                $request->kdBidang,
                $request->date,
                $request->tujuan,

                $cek['ta'],
                $request->kdSub,
                $request->kdJudul,
                ""
            ]);
            $param = [
                "kdDinas"=>$request->kdDinas,
                "kdBidang"=>$request->kdBidang,
                "kdSub"=>$request->kdSub,
                "kdJudul"=>$request->kdJudul,
                "tahun"=>$cek['ta'],
                "kdBAnggota"=>''
            ];
            return response()->json([
                'exc' => true,
                'data' =>  Hdb::dwork($param)
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function addedUser(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request->validate([
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',
                'date'=> 'required',
                'kdBAnggota' => 'required',
            ]);
            $data =Hdb::workAdded([
                $request->no,
                $request->kdDinas,
                $request->kdBidang,
                $request->date,
                '',
                $cek['ta'],
                $request->kdSub,
                $request->kdJudul,
                $request->kdBAnggota,
            ]);

            return response()->json([
                'exc' => true,
                'data' =>[]
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
            $request->validate([
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',
                'date'=> 'required',
                'noOld'=> 'required',
                'tujuan'=> 'required',
            ]);
            // $param = $request->only("kdDinas","kdBidang","kdSub","kdJudul");
            // $param["tahun"]= $cek['ta'];
            if(
                DB::table('work')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdBidang',$request->kdBidang)
                ->where('kdSub',$request->kdSub)
                ->where('kdJudul',$request->kdJudul)
                ->where('taWork',$cek['ta'])
                ->where('no',$request->noOld)
                ->update([
                    'no' => $request->no,
                    'date'=> $request->date,
                    'tujuan'=> $request->tujuan,
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
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'noOld'=> 'required',
            ]);
            // $param = $request->only("kdDinas","kdBidang","kdSub","kdJudul");
            // $param["tahun"]= $cek['ta'];
            if(
                DB::table('work')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdBidang',$request->kdBidang)
                ->where('kdSub',$request->kdSub)
                ->where('kdJudul',$request->kdJudul)
                ->where('taWork',$cek['ta'])
                ->where('no',$request->noOld)
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
    public function nextStep(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request->validate([
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',
                'status'=> 'required',
            ]);
            // $param = $request->only("kdDinas","kdBidang","kdSub","kdJudul");
            // $param["tahun"]= $cek['ta'];
            if(
                DB::table('work')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdBidang',$request->kdBidang)
                ->where('kdSub',$request->kdSub)
                ->where('kdJudul',$request->kdJudul)
                ->where('taWork',$cek['ta'])
                ->where('no',$request->no)
                ->update([
                    'status'=> $request->status,
                ])
            ){
                return response()->json([
                    'exc' => true,
                    'data' => []
                ], 200);
            }
            return response()->json([
                'exc' => false,
                'msg' => 'query Error'
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function getAnggotaSelected(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request->validate([
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',
            ]);
            $param = $request->only("kdDinas","kdBidang","kdSub","kdJudul","no");
            $param["tahun"]= $cek['ta'];
            $param["where"]= ' and a.kdBAnggota !=""';

            $anggotaWork = Hdb::dwork($param);
            $param["where"]='';
            if(count($anggotaWork)>0){
                foreach ($anggotaWork as $key => $value) {
                    $param["kdBAnggota"]=$value->kdBAnggota;
                    $anggotaWork[$key]->ddukung = Hdb::jenisDataDukung($cek);
                    if(count($anggotaWork[$key]->ddukung)>0){
                        foreach ($anggotaWork[$key]->ddukung as $key1 => $value1) {
                            $param["kdBAnggota"]=$value->kdBAnggota;
                            $param["kdDP"]=$value1->kdDP;
                            $anggotaWork[$key]->ddukung[$key1]->uraian = Hdb::dworkUraian($param);
                        }
                    }
                    // $anggotaWork[$key]->uraian = Hdb::dworkUraian($param);
                }
            }
            return response()->json([
                'exc' => true,
                'data' => $anggotaWork
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function delAnggotaSelected(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request->validate([
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',
                'kdBAnggota'=> 'required',
            ]);
            if(
                DB::table('work')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdBidang',$request->kdBidang)
                ->where('kdSub',$request->kdSub)
                ->where('kdJudul',$request->kdJudul)
                ->where('taWork',$cek['ta'])
                ->where('no',$request->no)
                ->where('kdBAnggota',$request->kdBAnggota)
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

    public function addWorkUraian(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request->validate([
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',

                'kdJPJ'=> 'required',
                'kdBAnggota'=> 'required',
                'kdDP'=> 'required',
            ]);
            $data =Hdb::workUraianedded([
                $request->kdJPJ,
                $request->kdDP,
                $request->kdDinas,
                $request->kdBidang,

                $request->kdSub,
                $request->kdJudul,
                $cek['ta'],
                (strlen($request->uraian)==0? '-':$request->uraian),

                (strlen($request->nilai)==0? '0':$request->nilai),
                $request->no,
                $request->kdBAnggota,
                (strlen($request->volume)==0? '0':$request->volume),
                (strlen($request->satuan)==0? '-':$request->satuan),
            ]);
            $param = $request->only("kdDinas","kdBidang","kdSub","kdJudul","no","kdDP","kdJPJ","kdBAnggota");
            $param["tahun"]= $cek['ta'];
            return response()->json([
                'exc' => true,
                'data' => Hdb::dworkUraian($param)
            ], 200);
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function updWorkUraian(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request->validate([
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',

                'uraian'=> 'required',
                'nilai'=> 'required',
                'volume'=> 'required',
                'satuan'=> 'required',
                'kdJPJ'=> 'required',

                'kdBAnggota'=> 'required',
                'kdDP'=> 'required',
                'kdUraian'=> 'required',
            ]);
            if(
                DB::table('workuraian')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdBidang',$request->kdBidang)
                ->where('kdSub',$request->kdSub)
                ->where('kdJudul',$request->kdJudul)
                ->where('taWork',$cek['ta'])

                ->where('noWork',$request->no)
                ->where('kdJPJ',$request->kdJPJ)
                ->where('kdDP',$request->kdDP)
                ->where('kdBAnggota',$request->kdBAnggota)
                ->where('kdUraian',$request->kdUraian)

                ->update([
                    'uraian' => $request->uraian,
                    'volume'=> $request->volume,
                    'satuan'=> $request->satuan,
                    'nilai'=> $request->nilai,
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
    public function delWorkUraian(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request->validate([
                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',
                'kdJPJ'=> 'required',
                'kdBAnggota'=> 'required',
                'kdDP'=> 'required',
                'kdUraian'=> 'required',
            ]);
            if(
                DB::table('workuraian')
                ->where('kdDinas',$request->kdDinas)
                ->where('kdBidang',$request->kdBidang)
                ->where('kdSub',$request->kdSub)
                ->where('kdJudul',$request->kdJudul)
                ->where('taWork',$cek['ta'])

                ->where('noWork',$request->no)
                ->where('kdJPJ',$request->kdJPJ)
                ->where('kdDP',$request->kdDP)
                ->where('kdBAnggota',$request->kdBAnggota)
                ->where('kdUraian',$request->kdUraian)

                ->delete()
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
                "ta"=>"2024",
                "kdJPJ"=>'jp-1'
            ];
        }
        return [
            "exc"=>false,
            "msg"=>" user can't Dinas !!!"
        ];
    }
}
