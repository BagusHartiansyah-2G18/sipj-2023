<?php

namespace App\Http\Controllers;

use App\Helper\Hdb;
use App\Helper\Hsf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class PdfGenerator extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function kwitansiSppd($val){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val)));
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta'],
                "kdJPJ"=>'jp-1'
            ];
            $param["where"]= ' and d.kdBAnggota =""';
            $data =Hdb::getDataSppdKegiatan($param)[0];
            $param["where"]= ' and a.kdBAnggota !=""';
            $member = Hdb::dworkAnggotaBidang($param);

            $total=[];

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $xtotal=0;
                    $param["kdBAnggota"]=$value->kdBAnggota;
                    $member[$key]->ddukung = Hdb::jenisDataDukung($param);
                    if(count($member[$key]->ddukung)>0){
                        foreach ($member[$key]->ddukung as $key1 => $value1) {
                            $param["kdBAnggota"]=$value->kdBAnggota;
                            $param["kdDP"]=$value1->kdDP;
                            $member[$key]->ddukung[$key1]->uraian = Hdb::dworkUraian($param);

                            foreach ($member[$key]->ddukung[$key1]->uraian as $key2 => $value2) {
                                $xtotal+=$value2->nilai*$value2->volume;
                            }
                        }
                    }
                    $total[$key]=$xtotal;
                    // $anggotaWork[$key]->uraian = Hdb::dworkUraian($param);
                }
            }
            // echo "<pre>";
            // return print_r($member);
            $textTotal=[];
            foreach ($total as $key => $value) {
                $textTotal[$key]=Hsf::terbilang($value);
            }

            $asDinas ='Bappeda';
            $asKab = 'Kabupaten Sumbawa Barat';
            $asdiskab= $asDinas.' '.$asKab;
            $datax = [
                'asDinas' => $asDinas,
                'asKab' => $asKab,
                'asdiskab' => $asdiskab,
                'noRek'     => '-',
                'dibukukan' => '-',
                'noBuku'    => $param['no'],
                'terimaDari'=> 'Pengguna Anggaran '.$asdiskab,
                'uraian'    => $data->nama,
                // 'tujuan'    => $baseEND->{'tujuan'},
                // 'nama'      => 'Bagus H',
                // 'jabatan'   => 'Staf',

                'nmBidang'     => 'Perencanaan, Pengendalian dan Evaluasi Pembangunan Daerah',
                'keg' => $data->nmKeg,
                'sub'    => $data->nmSub,
                'uraian' => $data->nama,
                'tujuan' => $data->tujuan,

                'noSppd' => $param['no'],
                'tglSppd' => '30 Januari 2023',

                'kaban' => 'Bagus H',
                'nipKaban' => '121010011102',
                'bendahara'=>'diding S',
                'nipBendahara' => '12101001110221',
                "tahun"=> $cek['ta'],
                'data' => $member,
                'textTotal'=> $textTotal
            ];


            $param['status']=' and a.status!="lainnya"';
            $danggota =Hdb::getAllBidangAnggota($param);
            foreach ($danggota as $key => $value) {
                if($value->status=='pimpinan'){
                    $datax['kaban']= $value->nmAnggota;
                    $datax['nipKaban']=$value->nip;
                }else if($value->status=='bendahara'){
                    $datax['bendahara']= $value->nmAnggota;
                    $datax['nipBendahara']=$value->nip;
                }
            }
            $pdf = PDF::loadView('pdf.kwitansiSppd', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('resume.pdf');
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function SuratTugasSppd($val){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val)));
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta']
            ];
            $param["where"]= ' and a.kdBAnggota =""';
            $data =Hdb::dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""';
            $member = Hdb::dworkAnggotaBidang($param);

            $pimpinan = Hdb::getAnggotaJabatan([
                "kdDinas"=>$param['kdDinas'],
                "tahun"=>$param['tahun'],
                "status"=>"pimpinan"
            ]);
            // "plhdinas" => Hdb::getAnggotaJabatan([
            //     "kdDinas"=>$param['kdDinas'],
            //     "tahun"=>$param['tahun'],
            //     "status"=>"sekretaris"
            // ]),
            // echo("<pre>");
            // return print_r($member);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            $tglCetak = "03 Agustus 2023";
            $dinas ='BADAN PERENCANAAN PEMBANGUNAN DAERAH';
            $asDinas ='Bappeda';
            $asKab = 'Kab. Sumbawa Barat';
            $kab = 'Kabupaten Sumbawa Barat';
            $asdiskab= $asDinas.' '.$asKab;
            $datax = [
                'dinas' => $dinas,
                'asDinas' => $asDinas,
                'asKab' => $asKab,
                'kab' => $kab,
                'asdiskab' => $asdiskab,
                "tahun"=> $cek['ta'],
                'data' => $data,
                'member' => $member,
                'pimpinan'=> $pimpinan[0],
                'tglCetak'=> $tglCetak,
            ];
            $pdf = PDF::loadView('pdf.suratTugas', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('resume.pdf');
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function sppdSetda($val){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val)));
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta']
            ];
            $param["where"]= ' and a.kdBAnggota =""';
            $data =Hdb::dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""
                and b.tingkatan>3
            ';
            $member = Hdb::dworkAnggotaBidang($param);

            $pimpinan = Hdb::getAnggotaJabatan([
                "kdDinas"=>$cek['setda'],
                "tahun"=>$param['tahun'],
                "status"=>"setda"
            ]);
            // "plhdinas" => Hdb::getAnggotaJabatan([
            //     "kdDinas"=>$param['kdDinas'],
            //     "tahun"=>$param['tahun'],
            //     "status"=>"sekretaris"
            // ]),
            // echo("<pre>");
            // return print_r($member);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            $tglCetak = "03 Agustus 2023";
            $dinas ='SEKRETARIAT DAERAH';
            $asDinas ='Setda';
            $asKab = 'Kab. Sumbawa Barat';
            $kab = 'Kabupaten Sumbawa Barat';
            $asdiskab= $asDinas.' '.$asKab;
            $datax = [
                'dinas' => $dinas,
                'asDinas' => $asDinas,
                'asKab' => $asKab,
                'kab' => $kab,
                'asdiskab' => $asdiskab,
                "tahun"=> $cek['ta'],
                'data' => $data,
                'member' => $member,
                'pimpinan'=> $pimpinan[0],
                'tglCetak'=> $tglCetak,
            ];
            $pdf = PDF::loadView('pdf.sppdSetda', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('resume.pdf');
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function sppdBupati($val){
        $user =Auth::user();
        $cek = $this->portal($user);
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val)));
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta']
            ];
            $param["where"]= ' and a.kdBAnggota =""';
            $data =Hdb::dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""
                and b.tingkatan<=3
            ';
            $member = Hdb::dworkAnggotaBidang($param);

            $pimpinan = Hdb::getAnggotaJabatan([
                "kdDinas"=>$cek['setda'],
                "tahun"=>$param['tahun'],
                "status"=>"bupati"
            ]);
            // "plhdinas" => Hdb::getAnggotaJabatan([
            //     "kdDinas"=>$param['kdDinas'],
            //     "tahun"=>$param['tahun'],
            //     "status"=>"sekretaris"
            // ]),
            // echo("<pre>");
            // return print_r($member);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            $tglCetak = "03 Agustus 2023";
            $dinas ='BUPATI';
            $asDinas ='Bupati';
            $asKab = 'Kab. Sumbawa Barat';
            $kab = 'Sumbawa Barat';
            $asdiskab= $asDinas.' '.$asKab;
            $datax = [
                'dinas' => $dinas,
                'asDinas' => $asDinas,
                'asKab' => $asKab,
                'kab' => $kab,
                'asdiskab' => $asdiskab,
                "tahun"=> $cek['ta'],
                'data' => $data,
                'member' => $member,
                'pimpinan'=> $pimpinan[0],
                'tglCetak'=> $tglCetak,
            ];
            $pdf = PDF::loadView('pdf.sppdBupati', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('resume.pdf');
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    function getTingkat($num){
        switch ($num) {
            case 2: return 'B';
            case 3: return 'C';
            case 4: return 'D';
            case 5: return 'E';
            default:
                return '-';
        }
    }
    function portal($user){
        if(!empty($user->kdDinas)){
            return [
                "exc"=>true,
                "ta"=>"2024",
                "setda"=>'4.01.2.10.0.00.01.0000'
            ];
        }
        return [
            "exc"=>false,
            "msg"=>" user can't Dinas !!!"
        ];
    }
}
