<?php

namespace App\Http\Controllers;
use App\Helper\Hdb;
use Dotenv\Validator;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Inline\Element\Strong;
use Psy\Readline\Hoa\FileReadWrite;

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
            $pimpinan=[
                "dinas" => Hdb::getAnggotaJabatan([
                    "kdDinas"=>$param['kdDinas'],
                    "tahun"=>$param['tahun'],
                    "status"=>"pimpinan"
                ]),
                "plhdinas" => Hdb::getAnggotaJabatan([
                    "kdDinas"=>$param['kdDinas'],
                    "tahun"=>$param['tahun'],
                    "status"=>"sekretaris"
                ]),
                "plhdinas1" => Hdb::getAnggotaJabatan([
                    "kdDinas"=>$param['kdDinas'],
                    "tahun"=>$param['tahun'],
                    "status"=>"kabid"
                ]),

                "setda" => Hdb::getAnggotaJabatan([
                    "kdDinas"=>$cek['setda'],
                    "tahun"=>$param['tahun'],
                    "status"=>"setda"
                ]),
                "plhsetda" => Hdb::getAnggotaJabatan([
                    "kdDinas"=>$cek['setda'],
                    "tahun"=>$param['tahun'],
                    "status"=>"asisten"
                ]),

                "bupati" => Hdb::getAnggotaJabatan([
                    "kdDinas"=>$cek['setda'],
                    "tahun"=>$param['tahun'],
                    "status"=>"bupati"
                ]),
                "plhbupati" => Hdb::getAnggotaJabatan([
                    "kdDinas"=>$cek['setda'],
                    "tahun"=>$param['tahun'],
                    "status"=>"wabup"
                ]),
            ];
            return response()->json([
                'exc' => true,
                'data' => [
                    "basic" => $data,
                    "dwork" => $dwork,
                    "anggota"=> $anggota,
                    "dpendukung" => $dpendukung,
                    "pimpinan"  => $pimpinan
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
                // 'no'=> 'required',
                'lokasi'=> 'required',

                'date'=> 'required',
                'dateE'=> 'required',
                'maksud'=> 'required',
                'angkut'=> 'required',

                'tempatS'=> 'required',
                'tempatE'=> 'required',
                'anggaran'=> 'required',
            ]);
            $data =Hdb::workAdded([
                $request->kdDinas,$request->kdBidang,

                $request->maksud,$request->angkut,$request->tempatS,$request->tempatE,

                $request->date,$request->dateE,$request->anggaran,$request->lokasi,

                $cek['ta'],$request->kdSub,$request->kdJudul,""
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
                'kdDBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',
                'date'=> 'required',
                'kdBAnggota' => 'required',
            ]);
            $data =Hdb::workAdduser([
                $request->no,
                $request->kdDinas,
                $request->kdDBidang,
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

                'noOld'=> 'required',
                'no'=> 'required',
                'lokasi'=> 'required',

                'date'=> 'required',
                'dateE'=> 'required',
                'maksud'=> 'required',
                'angkut'=> 'required',

                'tempatS'=> 'required',
                'tempatE'=> 'required',
                'anggaran'=> 'required',
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
                ->where('kdBAnggota','')
                ->update([
                    'no'    => $request->no,
                    'lokasi'=> $request->lokasi,
                    'date'=> $request->date,
                    'dateE'=> $request->dateE,

                    'maksud'=> $request->maksud,
                    'angkut'=> $request->angkut,
                    'tempatS'=> $request->tempatS,
                    'tempatE'=> $request->tempatE,
                    'anggaran'=> $request->anggaran,
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
    public function setPimpinan(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request->validate([
                'col' => 'required',
                'value' => 'required',

                'kdDinas' => 'required',
                'kdBidang' => 'required',
                'kdSub' => 'required',
                'kdJudul' => 'required',
                'no'=> 'required',
            ]);
            if(
                DB::table('work')
                ->where('kdDinas',$request['kdDinas'])
                ->where('kdBidang',$request['kdBidang'])
                ->where('kdSub',$request['kdSub'])
                ->where('kdJudul',$request['kdJudul'])
                ->where('taWork',$cek['ta'])
                ->where('no',$request['no'])
                ->where('kdBAnggota','')
                ->update([
                    $request['col']=> $request['value']
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

    public function step3(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request = $request->all();
            $namaFile = $this->_uploadImage($request['files']['data'],$request['files']['nama']);
            if(
                DB::table('work')
                ->where('kdDinas',$request['kdDinas'])
                ->where('kdBidang',$request['kdBidang'])
                ->where('kdSub',$request['kdSub'])
                ->where('kdJudul',$request['kdJudul'])
                ->where('taWork',$cek['ta'])
                ->where('no',$request['no'])
                ->where('kdBAnggota','')
                ->update([
                    'status'=> $request['status'],
                    'noBuku'=> $request['noBuku'],
                    'tglBuku'=> $request['tglBuku'],
                    'file' => $namaFile
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
    public function uploadDasar(Request $request){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $request = $request->all();
            $namaFile ='';
            $dtUpd =['dasar'=> $request['dasar']];
            if(count($request['files'])>1){
                $namaFile = $this->_uploadImage($request['files']['data'],"dasar/".$request['files']['nama']);
                $dtUpd['fileD'] = $namaFile;
            }
            if(
                DB::table('work')
                ->where('kdDinas',$request['kdDinas'])
                ->where('kdBidang',$request['kdBidang'])
                ->where('kdSub',$request['kdSub'])
                ->where('kdJudul',$request['kdJudul'])
                ->where('taWork',$cek['ta'])
                ->where('no',$request['no'])
                ->where('kdBAnggota','')
                ->update($dtUpd)
            ){
                return response()->json([
                    'exc' => true,
                    'data' => $namaFile
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
            $param = $request->only("kdDinas","kdSub","kdJudul","no");
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
                "kdJPJ"=>'jp-1',
                "setda"=>'4.01.2.10.0.00.01.0000'
            ];
        }
        return [
            "exc"=>false,
            "msg"=>" user can't Dinas !!!"
        ];
    }

    public function _uploadImage($file,$nama){
        $split=explode("/",$nama);
        $flokasi="sppd/";// default foldar jika ber ubah maka tambahakan dinamanya
        if(count($split)>1){
            $flokasi='';
            foreach ($split as $key => $v) {
                if($key==count($split)-1){
                    $nama=$v;
                }else{
                    $flokasi.=$v."/";
                }
            }
            // $flokasi.=$split[0]."/";
            // $nama=$split[count($split)-1];
        }
        // return print_r($file);
        // $nama=explode(".",$nama);
        // switch($nama[count($nama)-1]){
        //     case "png":$image=substr($file,22);break;
        //     case "PNG":$image=substr($file,22);break;
        //     case "pdf":$image=substr($file,22);break;
        //     default:$image=substr($file,23);break;
        // }
        // $image=substr($file,23);
        // return print_r($nama[1]);
        date_default_timezone_set("America/New_York");
        // $namaFile=$nama[count($nama)-2]."-".date("Y-m-d-h-i-sa").".".$nama[count($nama)-1];
        $namaFile=date("Y-m-d-h-i-sa")."-".$nama;


        $delspace=explode(" ",$namaFile);
        $namaFile="";
        foreach ($delspace as $key => $value) {
            $namaFile.=$value;
        }
        $lokasiFile='public/pdf/'.$flokasi.$namaFile;
        Storage::put($lokasiFile,base64_decode($file));
        return $namaFile;
    }

    function checkArrayMerge($a1,$a2){
        if(count($a2)>0){
            return array_merge($a1,$a2);
        }
        return $a1;
    }
}
