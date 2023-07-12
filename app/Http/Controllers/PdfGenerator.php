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
    public function sppd($val){
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
            $pdf = PDF::loadView('pdf.resume', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('resume.pdf');
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
            ];
        }
        return [
            "exc"=>false,
            "msg"=>" user can't Dinas !!!"
        ];
    }
}
