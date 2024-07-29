<?php

namespace App\Http\Controllers;

use App\Helper\Hdb;
use App\Helper\Hsf;
use App\Helper\Mfc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

use function PHPUnit\Framework\returnSelf;

class PdfGenerator extends Controller
{
    private $Mfc, $Hdb, $Hsf;
    public function __construct(){
        $this->Mfc = new Mfc();
        $this->Hdb = new Hdb();
        $this->Hsf = new Hsf();
        $this->middleware('auth');
    }
    public function kwitansiSppd($val){
        
        $cek = $this->Mfc->portal(); 
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val)));
            // return print_r($baseEND);
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                // "no"=>$baseEND->{'noSPPD'},
                "tahun"=>$cek['ta'],
                "kdJPJ"=>'jp-1',
                "tglCetak"=>$baseEND->{'tglCetak'},
                "noSPPD"=>$baseEND->{'noSPPD'}
            ];
            // return print_r($param['no']);
            $param["where"]= ' and d.kdBAnggota =""';

            // DB::table('work')
            // ->where('kdDinas',$param['kdDinas'])
            // ->where('kdBidang',$param['kdBidang'])
            // ->where('kdSub',$param['kdSub'])
            // ->where('kdJudul',$param['kdJudul'])
            // ->where('taWork',$cek['ta'])
            // ->where('no',$param['no'])
            // ->where('kdBAnggota','')
            // ->update([
            //     'noSPPD'=> $param['noSPPD'],
            // ]);
            // echo("<pre>");
            // return print_r($this->Hdb->getDataSppdKegiatan($param));

            $data =$this->Hdb->getDataSppdKegiatan($param)[0];
            $param["where"]= ' and a.kdBAnggota !=""';
            unset($param['kdBidang']);
            // unset($param['kdBidang']);
            $member = $this->Hdb->dworkAnggotaBidang($param);
            
            // return $this->Mfc->log($member);
            $dinas = $this->Hdb->getDinasOne($param['kdDinas'],$param['tahun']);

            $total=[];

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $xtotal=0;
                    $param["kdBAnggota"]=$value->kdBAnggota;
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                    $member[$key]->ddukung = $this->Hdb->jenisDataDukung($param);
                    if(count($member[$key]->ddukung)>0){
                        foreach ($member[$key]->ddukung as $key1 => $value1) {
                            $param["kdBAnggota"]=$value->kdBAnggota;
                            $param["kdDP"]=$value1->kdDP;
                            $param["kdBidang"]=$value->kdBidang;
                            // return print_r($value);
                            $member[$key]->ddukung[$key1]->uraian = $this->Hdb->dworkUraian($param);

                            foreach ($member[$key]->ddukung[$key1]->uraian as $key2 => $value2) {
                                $xtotal+=$value2->nilai*$value2->volume;
                            }
                        }
                    }
                    $total[$key]=$xtotal;
                    // $anggotaWork[$key]->uraian = $this->Hdb->dworkUraian($param);
                }
            }


            // echo "<pre>";
            // return print_r($member);
            $date =  explode("-",$param['tglCetak']);

            $textTotal=[];
            foreach ($total as $key => $value) {
                $textTotal[$key]=$this->Hsf->terbilang($value)." Rupiah";
            }
            // return print_r($data);
            $asKab = 'Kabupaten Sumbawa Barat';
            $asdiskab= $dinas->asDinas.' '.$asKab;
            $datax = [
                'asDinas' => $dinas->asDinas,
                "dinas" => $dinas->nmDinas,
                'asKab' => $asKab,
                'asdiskab' => $asdiskab,
                'noRek'     =>$data->kdSub.'.'.$data->kdApbd6,
                'dibukukan' => '',
                'noBuku'    => '',
                'terimaDari'=> 'Pengguna Anggaran '.$asdiskab,
                'uraian'    => $data->nama,
                // 'tujuan'    => $baseEND->{'tujuan'},
                // 'nama'      => 'Bagus H',
                // 'jabatan'   => 'Staf',

                'nmBidang'     => 'Perencanaan, Pengendalian dan Evaluasi Pembangunan Daerah',
                'keg' => $data->nmKeg,
                'sub'    => $data->nmSub,
                'uraian' => $data->nama,
                'tujuan' => $data->tempatE,
                "no" =>"000.1.2.3/",
                // 'noSppd' => $param['no'],
                'tglSppd' => $date[2]." ".$this->Mfc->__bulan($date[1])." ".$date[0],

                'kaban' => 'Data Pimpinan 0',
                'nipKaban' => '-',
                'bendahara'=>'Data Bendahara 0',
                'nipBendahara' => '12101001110221',
                "tahun"=> $cek['ta'],
                'data' => $member,
                'textTotal'=> $textTotal
            ];


            $param['status']=' and a.status!="lainnya"';
            $danggota =$this->Hdb->getAllBidangAnggota($param);
            foreach ($danggota as $key => $value) {
                if($value->status=='pimpinan'){
                    $datax['kaban']= $value->nmAnggota;
                    $datax['nipKaban']=$value->nip;
                }else if($value->status=='bendahara'){
                    $datax['bendahara']= $value->nmAnggota;
                    $datax['nipBendahara']=$value->nip;
                }
            }
            // echo("<pre>");
            // return print_r($datax);
            return view('pdf.kwitansiSppd', $datax);
            $pdf = PDF::loadView('pdf.kwitansiSppd', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('kwitansi-'.$datax['noRek']."-".$param['no'].'.pdf');
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }

    public function SuratTugasSppd($val){
        
        $cek = $this->Mfc->portal(); 
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
            $data =$this->Hdb->dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""';
            // Anggota Bidang
            $member = $this->Hdb->dworkAnggotaBidang($param);

            //kepala SKPD
            $pimpinan = $this->getTTPimpinan(
                $param['kdDinas'],"pimpinan",$param['tahun'],
                $data->pimOpd,$data->tdOPD
            );
            $jabatanPim = $pimpinan->nmJabatan;
            if(!$pimpinan->manual){
                if($pimpinan->status !=='pimpinan'){
                    $jabatanPim = "Plh. ".$pimpinan->nmJabatanR;
                }
            }
            //kepala SETDA / Asisten
            $subPimpinan = $this->getTTPimpinan(
                $cek['setda'],"setda",$param['tahun'],
                $data->pimSetda,$data->tdSETDA
            );
            $jabatanSetda = "";
            // $jabatanSetda = "a.n. Bupati Sumbawa Barat <br>";
            if(!$subPimpinan->manual){
                // return print_r($subPimpinan->nmJabatan);
                if($subPimpinan->status !=='setda'){
                    $jabatanSetda .="Plh. Sekretaris Daerah, <br> " ;
                }
            }
            // $jabatanSetda = "";
            // echo("<pre>");
            // return print_r($subPimpinan);

            $dinas = $this->Hdb->getDinasOne($param['kdDinas'],$param['tahun']);
            $setda = $this->Hdb->getDinasOne( $cek['setda'],$param['tahun']);
            // echo("<pre>");
            // return print_r($dinas);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            // $member = array_merge($member, $member);
            $date =  explode("-",$param['tglCetak']);
            // Array ( [0] => 2023 [1] => 08 [2] => 27 )

            $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
            if(strlen($data->dateE)>1){
                $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
                $hari++;
            }

            $dateS = explode("-",$data->date);
            $dateE = [];
            $textTanggal = $dateS[2];
            if(!empty($data->dateE) && $data->dateE!=$data->date){
                $dateE = explode("-",$data->dateE);
                if($dateS[1]==$dateE[1]){
                    $textTanggal.=" s/d ".$dateE[2]." ".$this->Mfc->__bulan($dateS[1])." ".$dateE[0] ;
                }else{
                    $textTanggal.=" ".$this->Mfc->__bulan($dateS[1])." s/d ".$dateE[2]." ".$this->Mfc->__bulan($dateE[1])." ".$dateE[0] ;
                }
            }else{
                $textTanggal .= " ".$this->Mfc->__bulan($dateS[1])." ".$dateS[0] ;
            }

            $spaci = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

            $tglCetak = $date[2]." ".$this->Mfc->__bulan($date[1])." ".$date[0];
            // $asdiskab= $dinas->asDinas.' '.$asKab;
            $datax = [
                // 'dinas' =>$dinas->nmDinas,
                'asDinas' => $dinas->asDinas,
                // 'alamat'    => $dinas->alamat,
                'asKab' => 'Kab. Sumbawa Barat',
                'kab' => 'Kabupaten Sumbawa Barat',
                'asdiskab' => $dinas->asDinas.' Kab. Sumbawa Barat',

                "dinas"=> $dinas,
                // 'jabatanPim' => $jabatanPim,
                'pimpinan'=> $pimpinan,
                'jabatanDinas' => $jabatanPim, // kerena ada tambahan plh dll
                "setda"=> $setda,
                "subPimpinan"=>$subPimpinan,
                'jabatanSetda' => $jabatanSetda,

                "tahun"=> $date[0],
                'data' => $data,
                'member' => $member,

                'tglCetak'=> $tglCetak,
                "textTanggal"=>$textTanggal ,
                'hari'  => $hari." (".$this->Hsf->terbilang($hari).") "."hari",
                
                // /".$this->getRomawi($date[1])."
                'nomor' =>"000.1.2.3/".$spaci."/ <span class='tupper'>".$dinas->asDinas."</span> /".$date[0],
                'nomorTugas' =>"800.1.11.1/".$spaci."/".$this->getRomawi($date[1])."/".$date[0]
            ];
            return view('pdf.suratTugas', $datax);
            $pdf = PDF::loadView('pdf.suratTugas', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('Surat-Tugas-Sppd-'.$data->no.'.pdf');
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }
    public function SuratTugasSppdx($val){
        
        $cek = $this->Mfc->portal(); 
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val)));
           
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'}, 
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta'],
                "tglCetak"=>$baseEND->{'tglCetak'}
            ];
            $param["where"]= ' and a.kdBAnggota =""';

            // dwork
            $data =$this->Hdb->dwork($param)[0]; 
            $param["where"]= ' and a.kdBAnggota !=""';
            // Anggota Bidang
            $member = $this->Hdb->dworkAnggotaBidang($param);
            // echo("<pre>");
            // return print_r($member);

            //kepala SKPD
            $pimpinan = $this->getTTPimpinan(
                $param['kdDinas'],"pimpinan",$param['tahun'],
                $data->pimOpd,$data->tdOPD
            );
            $jabatanPim = $pimpinan->nmJabatan;
            if(!$pimpinan->manual){
                if($pimpinan->status !=='pimpinan'){
                    $jabatanPim = "Plh. ".$pimpinan->nmJabatanR;
                }
            }

            //kepala SETDA / Asisten
            $subPimpinan = $this->getTTPimpinan(
                $cek['setda'],"setda",$param['tahun'],
                $data->pimSetda,$data->tdSETDA
            );
            $jabatanSetda = "a.n. Bupati Sumbawa Barat <br>";
            if(!$subPimpinan->manual){
                // return print_r($subPimpinan->nmJabatan);
                if($subPimpinan->status !=='setda'){
                    $jabatanSetda .="Sekretaris Daerah, <br> u.b. " ;
                }
            }

            $setdaPim = $this->Hdb->getAnggotaJabatan([
                "kdDinas"=>$cek['setda'],
                "tahun"=>$param['tahun'],
                "status"=>"setda"
            ])[0];
            // echo("<pre>");
            // return print_r($subPimpinan);

            $dinas = $this->Hdb->getDinasOne($param['kdDinas'],$param['tahun']);
            $setda = $this->Hdb->getDinasOne( $cek['setda'],$param['tahun']);
            // echo("<pre>");
            // return print_r($dinas);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            // $member = array_merge($member, $member);
            $date =  explode("-",$param['tglCetak']);
            // Array ( [0] => 2023 [1] => 08 [2] => 27 )

            $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
            if(strlen($data->dateE)>1){
                $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
                $hari++;
            }
            $dateS = explode("-",$data->date);
            $dateE = [];
            $textTanggal = $dateS[2];
            if(!empty($data->dateE) && $data->dateE!=$data->date){
                $dateE = explode("-",$data->dateE);
                if($dateS[1]==$dateE[1]){
                    $textTanggal.=" s/d ".$dateE[2]." ".$this->Mfc->__bulan($dateS[1])." ".$dateE[0] ;
                }else{
                    $textTanggal.=" ".$this->Mfc->__bulan($dateS[1])." s/d ".$dateE[2]." ".$this->Mfc->__bulan($dateE[1])." ".$dateE[0] ;
                }
            }else{
                $textTanggal .= " ".$this->Mfc->__bulan($dateS[1])." ".$dateS[0] ;
            }

            $spaci = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

            $tglCetak = $date[2]." ".$this->Mfc->__bulan($date[1])." ".$date[0];
            // $asdiskab= $dinas->asDinas.' '.$asKab;
            $datax = [
                // 'dinas' =>$dinas->nmDinas,
                'asDinas' => $dinas->asDinas,
                // 'alamat'    => $dinas->alamat,
                'asKab' => 'Kab. Sumbawa Barat',
                'kab' => 'Kabupaten Sumbawa Barat',
                'asdiskab' => $dinas->asDinas.' Kab. Sumbawa Barat',

                "dinas"=> $dinas,
                // 'jabatanPim' => $jabatanPim,
                'pimpinan'=> $pimpinan,
                'jabatanDinas' => $jabatanPim, // kerena ada tambahan plh dll
                "setda"=> $setda, //bisa setda / asisten2
                "subPimpinan"=>$subPimpinan,
                'jabatanSetda' => $jabatanSetda,
                "setdaPim"=>$setdaPim, //asli sekretaris daerah

                "tahun"=> $date[0],
                'data' => $data,
                'member' => $member,

                'tglCetak'=> $tglCetak,
                "textTanggal"=>$textTanggal ,
                'hari'  => $hari." (".$this->Hsf->terbilang($hari).") "."hari",
                // ".$this->getRomawi($date[1])."/
                'nomor' =>"000.1.2.3/".$spaci."/<span class='tupper'>".$dinas->asDinas."</span>/".$date[0],
                // 'nomor' =>"000.1.2.3/".$spaci."/".$dinas->asDinas."/".$date[0],
                'nomorTugas' =>"800.1.11.1/".$spaci."/".$this->getRomawi($date[1])."/".$date[0]
            ];
            return view('pdf.suratTugasx', $datax);
            $pdf = PDF::loadView('pdf.suratTugasx', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('Surat-Tugas-Sppd-'.$data->no.'.pdf');
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }

    public function SuratTugasSppdDaerah($val){
        
        $cek = $this->Mfc->portal(); 
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
            // $param["where"]= ' and d.kdBAnggota =""'; 
            // $subRek =$this->Hdb->getDataSppdKegiatan($param)[0];
            // unset($param['kdBidang']);
            $param["where"]= ' and a.kdBAnggota =""';

            // return print_r($subRek);
            // dwork
            $data =$this->Hdb->dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""';
            // Anggota Bidang
            $member = $this->Hdb->dworkAnggotaBidang($param);
            
            //kepala SKPD
            $pimpinan = $this->getTTPimpinan(
                $param['kdDinas'],"pimpinan",$param['tahun'],
                $data->pimOpd,$data->tdOPD
            );
            $jabatanPim = $pimpinan->nmJabatan;
            if(!$pimpinan->manual){
                if($pimpinan->status !=='pimpinan'){
                    $jabatanPim = "Plh. ".$pimpinan->nmJabatanR;
                }
            }
            //kepala SETDA / Asisten
            $subPimpinan = $this->getTTPimpinan(
                $cek['setda'],"setda",$param['tahun'],
                $data->pimSetda,$data->tdSETDA
            );
            $jabatanSetda = "a.n. Bupati Sumbawa Barat <br>";
            if(!$subPimpinan->manual){
                // return print_r($subPimpinan->nmJabatan);
                if($subPimpinan->status !=='setda'){
                    $jabatanSetda .="Sekretaris Daerah, <br> u.b. " ;
                }
            }
            $jabatanSetda = "";
            // echo("<pre>");
            // return print_r($subPimpinan);

            $dinas = $this->Hdb->getDinasOne($param['kdDinas'],$param['tahun']);
            $setda = $this->Hdb->getDinasOne( $cek['setda'],$param['tahun']);
            // echo("<pre>");
            // return print_r($dinas);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            // $member = array_merge($member, $member);
            $date =  explode("-",$param['tglCetak']);
            // Array ( [0] => 2023 [1] => 08 [2] => 27 )

            $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
            if(strlen($data->dateE)>1){
                $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
                $hari++;
            }

            $dateS = explode("-",$data->date);
            $dateE = [];
            $textTanggal = $dateS[2];
            if(!empty($data->dateE) && $data->dateE!=$data->date){
                $dateE = explode("-",$data->dateE);
                if($dateS[1]==$dateE[1]){
                    $textTanggal.=" s/d ".$dateE[2]." ".$this->Mfc->__bulan($dateS[1])." ".$dateE[0] ;
                }else{
                    $textTanggal.=" ".$this->Mfc->__bulan($dateS[1])." s/d ".$dateE[2]." ".$this->Mfc->__bulan($dateE[1])." ".$dateE[0] ;
                }
            }else{
                $textTanggal .= " ".$this->Mfc->__bulan($dateS[1])." ".$dateS[0] ;
            }

            $spaci = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

            $tglCetak = $date[2]." ".$this->Mfc->__bulan($date[1])." ".$date[0];
            // $asdiskab= $dinas->asDinas.' '.$asKab;
            $datax = [
                // 'dinas' =>$dinas->nmDinas,
                'asDinas' => $dinas->asDinas,
                // 'alamat'    => $dinas->alamat,
                'asKab' => 'Kab. Sumbawa Barat',
                'kab' => 'Kabupaten Sumbawa Barat',
                'asdiskab' => $dinas->asDinas.' Kab. Sumbawa Barat',

                "dinas"=> $dinas,
                // 'jabatanPim' => $jabatanPim,
                'pimpinan'=> $pimpinan,
                'jabatanDinas' => $jabatanPim, // kerena ada tambahan plh dll
                "setda"=> $setda,
                "subPimpinan"=>$subPimpinan,
                'jabatanSetda' => $jabatanSetda,

                "tahun"=> $date[0],
                'data' => $data,
                'member' => $member,

                'tglCetak'=> $tglCetak,
                "textTanggal"=>$textTanggal ,
                'hari'  => $hari." (".$this->Hsf->terbilang($hari).") "."hari",
                // ".$this->getRomawi($date[1])." /".$dinas->asDinas."
                'nomor' =>"000.1.2.3/".$spaci."/<span class='tupper'>".$dinas->asDinas."</span>/".$date[0],
                'nomorTugas' =>"800.1.11.1/".$spaci."/".$this->getRomawi($date[1])."/".$date[0]
            ];
            // echo("<pre>");
            // return print_r($datax);
            return view('pdf.suratTugasDaerah', $datax);
            $pdf = PDF::loadView('pdf.suratTugasDaerah', $datax)
                    ->setPaper('legal','portrait');
            return $pdf->stream('Surat-Tugas-Sppd-'.$data->no.'.pdf');
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }

    public function sppdSetda($val){
        
        $cek = $this->Mfc->portal(); 
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val)));
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                // "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta'],
                "tglCetak"=>$baseEND->{'tglCetak'},
                "sppdDaerah"=>$baseEND->{'sppdDaerah'}
            ];
            $param["where"]= ' and a.kdBAnggota =""';
            $data =$this->Hdb->dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""';  // and b.tingkatan>3
            $member = $this->Hdb->dworkAnggotaBidang($param);


            $pimpinan = $this->getTTPimpinan(
                $param['kdDinas'],"pimpinan",$param['tahun'],
                $data->pimOpd,$data->tdOPD
            );

            $jabatanPim = "<span class='tlower'>ub.</span> ".$pimpinan->nmJabatan;
            if(!$pimpinan->manual){
                if($pimpinan->status !=='pimpinan'){
                    $jabatanPim="<span class='tlower'>plh.</span> ".$pimpinan->nmJabatanR;
                }
            }

            $dinas = $this->Hdb->getDinasOne($param['kdDinas'],$param['tahun']);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            $date =  explode("-",$param['tglCetak']);
            // Array ( [0] => 2023 [1] => 08 [2] => 27 )
            // $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
            $hari = 1;
            if(strlen($data->dateE)>1){
                $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
                $hari++;
            }

            $dateS = explode("-",$data->date);
            $dateE = ["","",""];
            $textTanggal = $dateS[2];
            if(!empty($data->dateE)){
                $dateE = explode("-",$data->dateE);
            }else{
                $dateE = explode("-",$data->date);
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

                "dateS"=>((int)$dateS[2])." ".$this->Mfc->__bulan($dateS[1])." ".$dateS[0] ,
                "dateE"=>((int)$dateE[2])." ".$this->Mfc->__bulan($dateE[1])." ".$dateE[0] ,
                "no" =>"000.1.2.3",
                'member' => $member,
                // 'jabatanPimReal'=>$jabatanPimReal,
                'pimpinan'=> $pimpinan,
                'jabatanPim' => $jabatanPim,
                'jabatanPim1' => $pimpinan->nmJabatan,
                'tglCetak'=> $this->Mfc->__bulan($date[1])." ".$date[0],
                'hari'  => $hari." (".$this->Hsf->terbilang($hari).") "."hari"
            ];
            return view('pdf.sppdSetda', $datax);
            // $pdf = PDF::loadView('pdf.sppdSetda', $datax)
            //         ->setPaper('legal','portrait');
            // return $pdf->stream('sppd-Setda'.$data->no.'.pdf');
        }
        return response()->json([
            'exc' => false,
            'msg' => $cek['msg']
        ], 200);
    }

    public function sppdBupati($val){
        
        $cek = $this->Mfc->portal(); 
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
            $data =$this->Hdb->dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""
                and b.tingkatan<=3
            ';
            $member = $this->Hdb->dworkAnggotaBidang($param);

            // getPimpinan
            $pimpinan = $this->Hdb->getAnggotaJabatan([
                "kdDinas"=>$cek['setda'],
                "tahun"=>$param['tahun'],
                "status"=>"bupati"
            ])[0];
            $jabatanPim = $pimpinan->nmJabatan;
            if(!empty($data->pimBupati) && $data->pimBupati!='Manual'){
                // get Pimpinan selected
                $split = explode("|",$data->pimBupati);
                $selectPim = $this->Hdb->getOneAnggota([
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
                //     $selectPim1 = $this->Hdb->getAnggotaJabatan([
                //         "kdDinas"=>$param['kdDinas'],
                //         "tahun"=>$param['tahun'],
                //         "status"=>"sekretaris"
                //     ]);
                // }
            }else if($data->pimBupati=='Manual'){
                $tamPimpinan = explode("&",$data->tdBUPATI);
                $pimpinan =  (object)[
                    'nmAnggota'=>$this->getNewLineInText($tamPimpinan[1]),
                    'nmJabatan'=>$this->getNewLineInText($tamPimpinan[0])
                ] ;
                // return print_r($pimpinan->nmAnggota);
            }
            // $member = [$member[0]];

            $dinas = $this->Hdb->getDinasOne($param['kdDinas'],$param['tahun']);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            $date =  explode("-",$param['tglCetak']);
            // Array ( [0] => 2023 [1] => 08 [2] => 27 )

            $hari = 1;
            if(strlen($data->date)>0){
                $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
                $hari++;
            }



            $dateS = explode("-",$data->date);
            $dateE = [];
            $textTanggal = $dateS[2];
            if(!empty($data->dateE)){
                $dateE = explode("-",$data->dateE);
            }

            $asDinas ='Bupati';
            $asKab = 'Kab. Sumbawa Barat';
            $kab = 'Sumbawa Barat';
            $asdiskab= $dinas->asDinas.' '.$asKab;
            $datax = [
                'dinas' => 'BUPATI',
                'asDinas' => $asDinas,
                'asKab' => $asKab,
                'kab' => $kab,
                'asdiskab' => $asdiskab,
                'alamat'    => $dinas->alamat,
                "tahun"=> $cek['ta'],
                'data' => $data,
                "dateS"=>$dateS[2]." ".$this->Mfc->__bulan($dateS[1])." ".$dateS[0] ,
                "dateE"=>$dateE[2]." ".$this->Mfc->__bulan($dateE[1])." ".$dateE[0] ,
                "no" =>"000.1.2.3",
                'member' => $member,
                'pimpinan'=> $pimpinan,
                // 'tglCetak'=> $date[2]." ".$this->Mfc->__bulan($date[1])." ".$date[0],
                'tglCetak'=>$this->Mfc->__bulan($date[1])." ".$date[0],
                'hari'  => $hari." (".$this->Hsf->terbilang($hari).") "."Hari"
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
    public function sppdBupatiSetda($val){
        
        $cek = $this->Mfc->portal(); 
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val)));
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                // "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$cek['ta'],
                "tglCetak"=>$baseEND->{'tglCetak'},
                "sppdDaerah"=>$baseEND->{'sppdDaerah'}
            ];
            $param["where"]= ' and a.kdBAnggota =""';
            $data =$this->Hdb->dwork($param)[0];

            $param["where"]= ' and a.kdBAnggota !=""
                and b.tingkatan<=3
            ';
            $member = $this->Hdb->dworkAnggotaBidang($param);

            // getPimpinan
            $pimpinan = $this->Hdb->getAnggotaJabatan([
                "kdDinas"=>$cek['setda'],
                "tahun"=>$param['tahun'],
                "status"=>"setda"
            ])[0];
            $jabatanPimReal= $pimpinan->nmJabatan;
            // <label style='text-transform: lowercase'>a.n</label> BUPATI SUMBAWA BARAT <br> "<label style='text-transform: capitalize'>Plh</label>. ".
            $jabatanPim = $pimpinan->nmJabatan;
            if(!empty($data->pimSetda) && $data->pimSetda!='Manual'){
                // get Pimpinan selected
                $split = explode("|",$data->pimSetda);
                $selectPim = $this->Hdb->getOneAnggota([
                    "kdDinas"=>$split[2],
                    "tahun"=>$param['tahun'],
                    "kdBAnggota"=>$split[0],
                    "kdBidang"=>$split[1]
                ])[0];
                if($selectPim->status !=='setda'){
                    $jabatanPimReal = $selectPim->nmJabatan;
                    if($param['sppdDaerah']){
                        $jabatanPim = "An. BUPATI SUMBAWA BARAT <br> <label style='text-transform: capitalize'>Plh.</label> ".$selectPim->nmJabatan;
                    }else{
                        $jabatanPim .= "<br> <label style='text-transform: capitalize'>Plh.</label> ".$selectPim->nmJabatan;
                    }

                    $pimpinan = $selectPim;
                }

                // if($selectPim->status === "kabid "){
                //     $selectPim1 = $this->Hdb->getAnggotaJabatan([
                //         "kdDinas"=>$param['kdDinas'],
                //         "tahun"=>$param['tahun'],
                //         "status"=>"sekretaris"
                //     ]);
                // }
            }else if($data->pimSetda=='Manual'){
                $tamPimpinan = explode("&",$data->tdSETDA);
                $pimpinan =  (object)[
                    'nmAnggota'=>$this->getNewLineInText($tamPimpinan[1]),
                    'nmJabatan'=>$this->getNewLineInText($tamPimpinan[0])
                ];
                $jabatanPim = $this->getNewLineInText($tamPimpinan[0]);
            }

            $dinas = $this->Hdb->getDinasOne($cek['setda'],$param['tahun']);

            if(count($member)>0){
                foreach ($member as $key => $value) {
                    $member[$key]->tingkat=$this->getTingkat($value->tingkatan);
                }
            }

            $date =  explode("-",$param['tglCetak']);
            // Array ( [0] => 2023 [1] => 08 [2] => 27 )
            $hari = 1;
            if(strlen($data->date)>0){
                $hari = (strtotime($data->dateE) - strtotime($data->date)) / 60 / 60 / 24;
                $hari++;
            }

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

                "dateS"=>$dateS[2]." ".$this->Mfc->__bulan($dateS[1])." ".$dateS[0] ,
                "dateE"=>$dateE[2]." ".$this->Mfc->__bulan($dateE[1])." ".$dateE[0] ,
                "no" =>"000.1.2.3",
                'member' => $member,
                'jabatanPimReal'=>$jabatanPimReal,
                'pimpinan'=> $pimpinan,
                'jabatanPim' => $jabatanPim,
                // 'tglCetak'=> $date[2]." ".$this->Mfc->__bulan($date[1])." ".$date[0],
                'tglCetak'=> $this->Mfc->__bulan($date[1])." ".$date[0],
                'hari'  => $hari." (".$this->Hsf->terbilang($hari).") "."Hari"
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


    function getTTPimpinan($kdDinas,$status,$tahun, $_pim,$_td){ //_ artinya isi manual
        // 1. data pimpinan asli
        $pimpinan = $this->Hdb->getAnggotaJabatan([
            "kdDinas"=>$kdDinas,
            "tahun"=>$tahun,
            "status"=>$status
        ])[0]; 
        $tamJabatanSKPD = $pimpinan->nmJabatan;
        // if(!empty($_pim) && $_pim!='Manual'){
        //     // 2. data plh pimpinan
        //     $split = explode("|",$_pim);
        //     $pimpinan = $this->Hdb->getOneAnggota([
        //         "kdDinas"=>$split[2],
        //         "tahun"=>$tahun,
        //         "kdBAnggota"=>$split[0],
        //         "kdBidang"=>$split[1]
        //     ])[0];
        //     $pimpinan->manual=0;
        // }else if($_pim=='Manual'){
        //     // 3. data manual pimpinan
        //     $tamPimpinan = explode("&",$_td); //td = tampung data
        //     $nmAnggota = $this->getArrayNewLineInText($tamPimpinan[1]);
        //     if(count($nmAnggota)<3){
        //         return print_r('harus terdapat Data nama, Golongan dan NIP pimpinan');
        //     }
        //     $pimpinan =  (object)[
        //         'nmAnggota'=>$nmAnggota[0],
        //         'golongan'=>$nmAnggota[1],
        //         'nip'=>$nmAnggota[2],
        //         'nmJabatan'=>$this->getNewLineInText($tamPimpinan[0]),
        //         'manual'=>1
        //     ];
        // }
        $pimpinan->nmJabatanR = $tamJabatanSKPD;
        return $pimpinan;
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
    function getNewLineInText($text){
        $array = preg_split("/\r\n|\n|\r/", $text);
        $resp ='';
        foreach ($array as $key => $value) {
            if(strlen($value)>0){
                $resp.=$value.'<br>';
            }
        }
        return substr($resp,0,strlen($resp)-4);
    }
    function getArrayNewLineInText($text){
        return preg_split("/\r\n|\n|\r/", $text);
    }
}
