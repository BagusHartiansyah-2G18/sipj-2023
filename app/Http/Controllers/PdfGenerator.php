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
                // "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta'],
                "tglCetak"=>$baseEND->{'tglCetak'}
            ];
            $param["where"]= ' and a.kdBAnggota =""';

            // dwork
            $data =Hdb::dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""';
            // Anggota Bidang
            $member = Hdb::dworkAnggotaBidang($param);
            // echo("<pre>");
            // return print_r($member);
            // getPimpinan
            $pimpinan = Hdb::getAnggotaJabatan([
                "kdDinas"=>$param['kdDinas'],
                "tahun"=>$param['tahun'],
                "status"=>"pimpinan"
            ])[0];
            $jabatanPim = $pimpinan->nmJabatan;
            if(!empty($data->pimOpd)){
                // get Pimpinan selected
                $split = explode("|",$data->pimOpd);
                $selectPim = Hdb::getOneAnggota([
                    "kdDinas"=>$split[2],
                    "tahun"=>$param['tahun'],
                    "kdBAnggota"=>$split[0],
                    "kdBidang"=>$split[1]
                ])[0];

                if($selectPim->nmJabatan !=='Kepala'){
                    $jabatanPim = "Plh. ".$jabatanPim;
                    $pimpinan = $selectPim;
                }

                // if($selectPim->status === "kabid "){
                //     $selectPim1 = Hdb::getAnggotaJabatan([
                //         "kdDinas"=>$param['kdDinas'],
                //         "tahun"=>$param['tahun'],
                //         "status"=>"sekretaris"
                //     ]);
                // }
            }

            $dinas = Hdb::getDinasOne($param['kdDinas'],$param['tahun']);


            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            // $member = array_merge( $member, $member);
            $date =  explode("-",$param['tglCetak']);
            // Array ( [0] => 2023 [1] => 08 [2] => 27 )

            $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
            $dateS = explode("-",$data->date);
            $dateE = [];
            $textTanggal = $dateS[2];
            if(!empty($data->dateE)){
                $dateE = explode("-",$data->dateE);
                if($dateS[1]==$dateE[1]){
                    $textTanggal.=" s/d ".$dateE[2]." ".$this->getBulan($dateS[1])." ".$dateE[0] ;
                }else{
                    $textTanggal.=" ".$this->getBulan($dateS[1])." s/d ".$dateE[2]." ".$this->getBulan($dateE[1])." ".$dateE[0] ;
                }
            }else{
                $textTanggal .= " ".$this->getBulan($dateS[1])." ".$dateS[0] ;
            }




            // return print_r($hari);

            // return print_r($date);

            $tglCetak = $date[2]." ".$this->getBulan($date[1])." ".$date[0];
            $asKab = 'Kab. Sumbawa Barat';
            $kab = 'Kabupaten Sumbawa Barat';
            $asdiskab= $dinas->asDinas.' '.$asKab;
            $datax = [
                'dinas' =>$dinas->nmDinas,
                'asDinas' => $dinas->asDinas,
                'alamat'    => $dinas->alamat,
                'asKab' => $asKab,
                'kab' => $kab,
                'asdiskab' => $asdiskab,

                "tahun"=> $date[0],
                'data' => $data,
                'member' => $member,

                'pimpinan'=> $pimpinan,
                'jabatanPim' => $jabatanPim,

                'tglCetak'=> $tglCetak,
                "textTanggal"=>$textTanggal ,

                'nomor' =>$data->no."/_____/".$dinas->asDinas."/".$this->getRomawi($date[1])."/".$date[0],
                'nomorTugas' =>"800.1.11.1/_____/".$this->getRomawi($date[1])."/".$date[0]
            ];
            $pdf = PDF::loadView('pdf.suratTugas', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('Surat-Tugas-Sppd-'.$data->no.'.pdf');
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
                // "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta'],
                "tglCetak"=>$baseEND->{'tglCetak'}
            ];
            $param["where"]= ' and a.kdBAnggota =""';
            $data =Hdb::dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""
                and b.tingkatan>3
            ';
            $member = Hdb::dworkAnggotaBidang($param);

            // getPimpinan
            $pimpinan = Hdb::getAnggotaJabatan([
                "kdDinas"=>$cek['setda'],
                "tahun"=>$param['tahun'],
                "status"=>"setda"
            ])[0];
            $jabatanPim = "A.n. BUPATI SUMBAWA BARAT <br> Plh. ".$pimpinan->nmJabatan;
            if(!empty($data->pimSetda)){
                // get Pimpinan selected
                $split = explode("|",$data->pimSetda);
                $selectPim = Hdb::getOneAnggota([
                    "kdDinas"=>$split[2],
                    "tahun"=>$param['tahun'],
                    "kdBAnggota"=>$split[0],
                    "kdBidang"=>$split[1]
                ])[0];
                if($selectPim->status !=='setda'){
                    $jabatanPim .= "<br> u.b ".$selectPim->nmJabatan;
                    $pimpinan = $selectPim;
                }

                // if($selectPim->status === "kabid "){
                //     $selectPim1 = Hdb::getAnggotaJabatan([
                //         "kdDinas"=>$param['kdDinas'],
                //         "tahun"=>$param['tahun'],
                //         "status"=>"sekretaris"
                //     ]);
                // }
            }

            $dinas = Hdb::getDinasOne($cek['setda'],$param['tahun']);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            $date =  explode("-",$param['tglCetak']);
            // Array ( [0] => 2023 [1] => 08 [2] => 27 )
            $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;

            $dateS = explode("-",$data->date);
            $dateE = [];
            $textTanggal = $dateS[2];
            if(!empty($data->dateE)){
                $dateE = explode("-",$data->dateE);
            }

            $asKab = 'Kab. Sumbawa Barat';
            $kab = 'Kabupaten Sumbawa Barat';
            $asdiskab= $dinas->asDinas.' '.$asKab;
            $datax = [
                'dinas' =>$dinas->nmDinas,
                'asDinas' => $dinas->asDinas,
                'asKab' => $asKab,
                'kab' => $kab,
                'asdiskab' => $asdiskab,
                'alamat'    => $dinas->alamat,
                "tahun"=> $cek['ta'],
                'data' => $data,

                "dateS"=>$dateS[2]." ".$this->getBulan($dateS[1])." ".$dateS[0] ,
                "dateE"=>$dateE[2]." ".$this->getBulan($dateE[1])." ".$dateE[0] ,

                'member' => $member,
                'pimpinan'=> $pimpinan,
                'jabatanPim' => $jabatanPim,
                'tglCetak'=> $date[2]." ".$this->getBulan($date[1])." ".$date[0],
                'hari'  => $hari." Hari"
            ];
            $pdf = PDF::loadView('pdf.sppdSetda', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('sppd-Setda'.$data->no.'.pdf');
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
                // "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta'],
                "tglCetak"=>$baseEND->{'tglCetak'}
            ];
            $param["where"]= ' and a.kdBAnggota =""';
            $data =Hdb::dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""
                and b.tingkatan<=3
            ';
            $member = Hdb::dworkAnggotaBidang($param);

            // getPimpinan
            $pimpinan = Hdb::getAnggotaJabatan([
                "kdDinas"=>$cek['setda'],
                "tahun"=>$param['tahun'],
                "status"=>"bupati"
            ])[0];
            $jabatanPim = $pimpinan->nmJabatan;
            if(!empty($data->pimBupati)){
                // get Pimpinan selected
                $split = explode("|",$data->pimBupati);
                $selectPim = Hdb::getOneAnggota([
                    "kdDinas"=>$split[2],
                    "tahun"=>$param['tahun'],
                    "kdBAnggota"=>$split[0],
                    "kdBidang"=>$split[1]
                ])[0];

                if($selectPim->nmJabatan !=='BUPATI'){
                    $jabatanPim = $pimpinan->nmJabatan;
                    $pimpinan = $selectPim;
                }

                // if($selectPim->status === "kabid "){
                //     $selectPim1 = Hdb::getAnggotaJabatan([
                //         "kdDinas"=>$param['kdDinas'],
                //         "tahun"=>$param['tahun'],
                //         "status"=>"sekretaris"
                //     ]);
                // }
            }

            $dinas = Hdb::getDinasOne($cek['setda'],$param['tahun']);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            $date =  explode("-",$param['tglCetak']);
            // Array ( [0] => 2023 [1] => 08 [2] => 27 )
            $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;

            $dateS = explode("-",$data->date);
            $dateE = [];
            $textTanggal = $dateS[2];
            if(!empty($data->dateE)){
                $dateE = explode("-",$data->dateE);
            }

            $asDinas ='Bupati';
            $asKab = 'Kab. Sumbawa Barat';
            $kab = 'Sumbawa Barat';
            $asdiskab= $asDinas.' '.$asKab;
            $datax = [
                'dinas' => 'BUPATI',
                'asDinas' => $asDinas,
                'asKab' => $asKab,
                'kab' => $kab,
                'asdiskab' => $asdiskab,
                'alamat'    => $dinas->alamat,
                "tahun"=> $cek['ta'],
                'data' => $data,
                "dateS"=>$dateS[2]." ".$this->getBulan($dateS[1])." ".$dateS[0] ,
                "dateE"=>$dateE[2]." ".$this->getBulan($dateE[1])." ".$dateE[0] ,

                'member' => $member,
                'pimpinan'=> $pimpinan,
                'tglCetak'=> $date[2]." ".$this->getBulan($date[1])." ".$date[0],
                'hari'  => $hari." Hari"
            ];
            $pdf = PDF::loadView('pdf.sppdBupati', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('sppd-Bupati-'.$data->no.'.pdf');
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
    function getRomawi($bulan){
        switch ($bulan) {
            case 1 : return "I";
            case 2 : return "II";
            case 3 : return "III";
            case 4 : return "IV";
            case 5 : return "V";

            case 6 : return "VI";
            case 7 : return "VII";
            case 8 : return "VIII";
            case 9 : return "IX";
            case 10 : return "X";

            case 11 : return "XI";
            default: return "XII";
        }
    }
    function getBulan($bulan){
        switch ($bulan) {
            case 1 : return "Januari";
            case 2 : return "Februari";
            case 3 : return "Maret";
            case 4 : return "April";
            case 5 : return "Mei";

            case 6 : return "Juni";
            case 7 : return "Juli";
            case 8 : return "Agustus";
            case 9 : return "September";
            case 10 : return "Oktober";

            case 11 : return "November";
            default: return "Desember";
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
