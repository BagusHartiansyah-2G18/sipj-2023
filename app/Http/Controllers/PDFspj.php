<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Helper\Mfc;
use App\Helper\Hsf;

use App\Models\dinas;
use App\Models\Banggota;
use App\Helper\Hdb;
use PDF;



class PDFspj extends Controller {
    private $Mfc, $Hdb, $Hsf;
    public function __construct(){
        $this->Mfc = new Mfc();
        $this->Hdb = new Hdb();
        $this->Hsf = new Hsf();
        $this->middleware('auth');
    }
    function kwitansi($val){ 
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val))); 
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$baseEND->{'taSPJ'}
            ];
            
            $dinas = dinas::where([
                "kdDinas"=>$param['kdDinas'],
                "taDinas"=>$param['tahun'],
            ])->get();
            
            $dkadis = $this->Mfc->__valByKey($dinas[0],['kadis', 'nip','nmDinas','alamat','asDinas']);
            $dbendahara =Banggota::where([
                "kdDinas"=>$param['kdDinas'],
                "status"=>"bendahara",
            ])->get();
            $dbendahara = $this->Mfc->__valByKey($dbendahara[0],['nmAnggota', 'nip']);
            
            $param["where"]= '';
            $dspj = $this->Hdb->getDataSPJKegiatan($param)[0];
            $staf = json_decode(base64_decode($dspj->data));
            
            
            $NmDinas1= explode(" ",$dkadis['nmDinas']);
            if($NmDinas1[0]=="BADAN" || $NmDinas1[0]=="DINAS"){
                $NmDinas1 = substr($dkadis['nmDinas'],strlen($NmDinas1[0]));
            }

            $an = $staf[0][0]->label;
            $totalUang = $staf[0][4]->label * $dspj->totVol;
            $hapusDan =0;
            if(count($staf)>1){
                $an = "";
                foreach ($staf as $key => $value) {
                    if(count($staf)==2){
                        $an.=$value[0]->label." <label class='tlower'>dan</label> An. "; 
                        $hapusDan=1;
                    }else{
                        $an.=$value[0]->label.", "; 
                    }

                    if($key>0){
                        $totalUang+=$value[4]->label * $dspj->totVol;
                    }
                }
                $count = 2;
                if($hapusDan){
                    $count = 4;
                } 
                $an = substr($an,0,strlen($an)-$count); 
            }

            // $totalUang = $staf[0][4]->label * $dspj->totVol;
            $tambahan=[
                "terbilang"=>$this->Hsf->terbilang($totalUang)." Rupiah",
                "uang"=>number_format($totalUang,0,',','.'),
                "nipStaf"=>"-",
                "an"=>$an
            ];

            // $staf[7]=$this->Hsf->terbilang($staf[0][4]->label)." Rupiah";
            // $staf[8]=$staf[4]->label * $dspj->totVol;
            // $staf[9]="-";
            // return $this->Mfc->log([
            //     "kadis"=>$dkadis,
            //     "bend"=>$dbendahara,
            //     "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
            //     "spj"=>$dspj,
            //     "staf"=>$staf,
            //     "ta"=>$param['tahun'],
            //     "nmDinas1"=>$NmDinas1,
            //     "tambahan"=>$tambahan
            // ]);
            return view('spj.kwitansi',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1,
                "tambahan"=>$tambahan
            ]);
            $pdf = PDF::loadView('spj.kwitansi',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1
            ])->setPaper('legal','portrait');
            return $pdf->stream('kwitansi-'.$staf[0]->label."-".$dspj->keterangan.'.pdf');
        }
        return $this->Mfc->respError($cek['msg']);
    }
    function tandaTerima($val){ 
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val))); 
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$baseEND->{'taSPJ'}
            ];
            
            $dinas = dinas::where([
                "kdDinas"=>$param['kdDinas'],
                "taDinas"=>$param['tahun'],
            ])->get();
            
            $dkadis = $this->Mfc->__valByKey($dinas[0],['kadis', 'nip','nmDinas','alamat','asDinas']);
            $dbendahara =Banggota::where([
                "kdDinas"=>$param['kdDinas'],
                "status"=>"bendahara",
            ])->get();
            $dbendahara = $this->Mfc->__valByKey($dbendahara[0],['nmAnggota', 'nip']);
            
            $param["where"]= '';
            $dspj = $this->Hdb->getDataSPJKegiatan($param)[0];
            $staf = json_decode(base64_decode($dspj->data));
            
            
            $NmDinas1= explode(" ",$dkadis['nmDinas']);
            if($NmDinas1[0]=="BADAN" || $NmDinas1[0]=="DINAS"){
                $NmDinas1 = substr($dkadis['nmDinas'],strlen($NmDinas1[0]));
            }
            
            
            $totalUang = $staf[0][4]->label * $dspj->totVol;
            $ppn = (($totalUang/100)*$staf[0][5]->label);
            $zakat =((($totalUang-$ppn)/100)*$staf[0][6]->label); 
            $terima = $totalUang - ($ppn+$zakat);
            $tambahan=[
                "terbilang"=>$this->Hsf->terbilang($staf[0][4]->label)." Rupiah",
                "uang"=>number_format($totalUang,0,',','.'),
                "nipStaf"=>"-", 
                "pph"=>number_format($ppn,0,',','.'),
                "zakat"=>number_format($zakat,0,',','.'),
                "terima"=>number_format($terima,0,',','.') 
            ]; 


            $allUang = $totalUang; $allpph = $ppn; 
            $allzakat = $zakat;
            $allTerima=$terima;

            $an ='A<label class="tlower">n.</label> '.$staf[0][0]->label;
            // $hapusDan =0;
            if(count($staf)>1){
                $an = "A<label class='tlower'>n</label>. ";
                foreach ($staf as $key => $value) {
                    if($key == (count($staf)-1)){ 
                        $an.=$value[0]->label; 
                    }else{
                        $an.=$value[0]->label." <label class='tlower'>dan</label> A<label class='tlower'>n</label>. "; 
                    } 
                    if($key>0){
                        $allUang+=$totalUang;
                        $allpph+=$ppn;
                        $allzakat+=$zakat;
                        $allTerima+=$terima;
                    }
                }
                // $count = 2;
                // if($hapusDan){
                //     $count = 4;
                // } 
                // // $an = substr($an,0,strlen($an)-$count); 
            } 
            $tambahan['an']= $an;
            $tambahan['allUang']= number_format($allUang,0,',','.');
            $tambahan['allpph']= number_format($allpph,0,',','.');
            $tambahan['allzakat']= number_format($allzakat,0,',','.');
            $tambahan['allTerima']= number_format($allTerima,0,',','.');
            
            // return $this->Mfc->log([
            //     "kadis"=>$dkadis,
            //     "bend"=>$dbendahara,
            //     "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
            //     "spj"=>$dspj,
            //     "staf"=>$staf,
            //     "ta"=>$param['tahun'],
            //     "nmDinas1"=>$NmDinas1,
            //     "tambahan"=>$tambahan
            // ]);
            return view('spj.tandaTerima',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1,
                "tambahan"=>$tambahan
            ]);
            $pdf = PDF::loadView('spj.kwitansi',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1
            ])->setPaper('legal','portrait');
            return $pdf->stream('kwitansi-'.$staf[0]->label."-".$dspj->keterangan.'.pdf');
        }
        return $this->Mfc->respError($cek['msg']);
    }
    function daftarNominatif($val){ 
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val))); 
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$baseEND->{'taSPJ'}
            ];
            
            $dinas = dinas::where([
                "kdDinas"=>$param['kdDinas'],
                "taDinas"=>$param['tahun'],
            ])->get();
            
            $dkadis = $this->Mfc->__valByKey($dinas[0],['kadis', 'nip','nmDinas','alamat','asDinas']);
            $dbendahara =Banggota::where([
                "kdDinas"=>$param['kdDinas'],
                "status"=>"bendahara",
            ])->get();
            $dbendahara = $this->Mfc->__valByKey($dbendahara[0],['nmAnggota', 'nip']);
            
            $param["where"]= '';
            $dspj = $this->Hdb->getDataSPJKegiatan($param)[0];
            $staf = json_decode(base64_decode($dspj->data));
            
            
            $NmDinas1= explode(" ",$dkadis['nmDinas']);
            if($NmDinas1[0]=="BADAN" || $NmDinas1[0]=="DINAS"){
                $NmDinas1 = substr($dkadis['nmDinas'],strlen($NmDinas1[0]));
            }
            
            
            $totalUang = $staf[0][4]->label * $dspj->totVol;
            $ppn = (($totalUang/100)*$staf[0][5]->label);
            $zakat =((($totalUang-$ppn)/100)*$staf[0][6]->label);
            $terima = $totalUang - ($ppn+$zakat);
            $tambahan=[
                "terbilang"=>$this->Hsf->terbilang($staf[0][4]->label)." Rupiah",
                "uang"=>number_format($totalUang,0,',','.'),
                "nipStaf"=>"-", 
                "pph"=>number_format($ppn,0,',','.'),
                "zakat"=>number_format($zakat,0,',','.'),
                "terima"=>number_format($terima,0,',','.') 
            ]; 


            $allUang = $totalUang; $allpph = $ppn; 
            $allzakat = $zakat;
            $allTerima=$terima;

            $an = $staf[0][0]->label;
            $hapusDan =0;
            if(count($staf)>1){
                $an = "A<label class='tlower'>n</label>. ";
                foreach ($staf as $key => $value) {
                    if($key == (count($staf)-1)){ 
                        $an.=$value[0]->label; 
                    }else{
                        $an.=$value[0]->label." <label class='tlower'>dan</label> A<label class='tlower'>n</label>. "; 
                    } 
                    if($key>0){
                        $allUang+=$totalUang;
                        $allpph+=$ppn;
                        $allzakat+=$zakat;
                        $allTerima+=$terima;
                    }
                }
                // $count = 2;
                // if($hapusDan){
                //     $count = 4;
                // } 
                // // $an = substr($an,0,strlen($an)-$count); 
            } 
            
            $tambahan['an']= $an;
            $tambahan['allUang']= number_format($allUang,0,',','.');
            $tambahan['allpph']= number_format($allpph,0,',','.');
            $tambahan['allzakat']= number_format($allzakat,0,',','.');
            $tambahan['allTerima']= number_format($allTerima,0,',','.');
            
            // return $this->Mfc->log([
            //     "kadis"=>$dkadis,
            //     "bend"=>$dbendahara,
            //     "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
            //     "spj"=>$dspj,
            //     "staf"=>$staf,
            //     "ta"=>$param['tahun'],
            //     "nmDinas1"=>$NmDinas1,
            //     "tambahan"=>$tambahan
            // ]);
            return view('spj.daftarNominatif',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1,
                "tambahan"=>$tambahan
            ]);
            $pdf = PDF::loadView('spj.kwitansi',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1
            ])->setPaper('legal','portrait');
            return $pdf->stream('kwitansi-'.$staf[0]->label."-".$dspj->keterangan.'.pdf');
        }
        return $this->Mfc->respError($cek['msg']);
    } 

    function pindahBukuanPajak($val){ 
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val))); 
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$baseEND->{'taSPJ'}
            ];
            
            $dinas = dinas::where([
                "kdDinas"=>$param['kdDinas'],
                "taDinas"=>$param['tahun'],
            ])->get();
            
            $dkadis = $this->Mfc->__valByKey($dinas[0],['kadis', 'nip','nmDinas','alamat','asDinas']);
            $dbendahara =Banggota::where([
                "kdDinas"=>$param['kdDinas'],
                "status"=>"bendahara",
            ])->get();
            $dbendahara = $this->Mfc->__valByKey($dbendahara[0],['nmAnggota', 'nip']);
            
            $param["where"]= '';
            $dspj = $this->Hdb->getDataSPJKegiatan($param)[0];
            $staf = json_decode(base64_decode($dspj->data));
            
            
            $NmDinas1= explode(" ",$dkadis['nmDinas']);
            if($NmDinas1[0]=="BADAN" || $NmDinas1[0]=="DINAS"){
                $NmDinas1 = substr($dkadis['nmDinas'],strlen($NmDinas1[0]));
            }
            
            
            $totalUang = $staf[0][4]->label * $dspj->totVol;
            $ppn = (($totalUang/100)*$staf[0][5]->label);
            $zakat =((($totalUang-$ppn)/100)*$staf[0][6]->label);
            $terima = $totalUang - ($ppn+$zakat);
            $tambahan=[
                "terbilang"=>$this->Hsf->terbilang($staf[0][4]->label)." Rupiah",
                "uang"=>number_format($totalUang,0,',','.'),
                "nipStaf"=>"-", 
                "pph"=>number_format($ppn,0,',','.'),
                "zakat"=>number_format($zakat,0,',','.'),
                "terima"=>number_format($terima,0,',','.') 
            ]; 


            $allUang = $totalUang; $allpph = $ppn; 
            $allzakat = $zakat;
            $allTerima=$terima;

            $an = $staf[0][0]->label;
            $hapusDan =0;
            if(count($staf)>1){
                $an = "";
                foreach ($staf as $key => $value) {
                    if(count($staf)==2){
                        $an.=$value[0]->label." dan "; 
                        $hapusDan=1;
                    }else{
                        $an.=$value[0]->label.", "; 
                    }

                    if($key>0){
                        $allUang+=$totalUang;
                        $allpph+=$ppn;
                        $allzakat+=$zakat;
                        $allTerima+=$terima;
                    }
                }
                $count = 2;
                if($hapusDan){
                    $count = 4;
                } 
                $an = substr($an,0,strlen($an)-$count); 
            }
            
            $tambahan['an']= $an;
            $tambahan['allUang']= number_format($allUang,0,',','.');
            $tambahan['allpph']= number_format($allpph,0,',','.');
            $tambahan['allzakat']= number_format($allzakat,0,',','.');
            $tambahan['allTerima']= number_format($allTerima,0,',','.');
            
            $tambahan['terbilang']=$this->Hsf->terbilang($allpph+$allzakat)." Rupiah"; 
            $date = explode("/",date("Y/m/d")); 
            $tambahan['bulan']=$this->Mfc->__romawi($date[1]);
            
            return view('spj.pindahBukuPajak',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1,
                "tambahan"=>$tambahan,
                "tglC"=>$date[2]." ".$this->Mfc->__bulan($date[1])." ".$date[0],
                "bulan"=>strtolower(explode(")",explode("(",$dspj->keterangan)[1])[0]),
                "zakat"=>[
                    [
                        "502.03.00384.01.1","Baznas KSB Zakat (2,5 %)", $tambahan['allzakat']
                    ],[
                        "028336944563044","PPH 21", $tambahan['allpph']
                    ]
                ],"allZakat"=> number_format($allpph+$allzakat,0,',','.')
                    
            ]);
            $pdf = PDF::loadView('spj.kwitansi',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1
            ])->setPaper('legal','portrait');
            return $pdf->stream('kwitansi-'.$staf[0]->label."-".$dspj->keterangan.'.pdf');
        }
        return $this->Mfc->respError($cek['msg']);
    } 
    function pindahBukuanRekening($val){ 
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val))); 
            $param = [
                "kdDinas"=>$baseEND->{'kdDinas'},
                "kdBidang"=>$baseEND->{'kdBidang'},
                "kdSub"=>$baseEND->{'kdSub'},
                "kdJudul"=>$baseEND->{'kdJudul'},
                "no"=>$baseEND->{'no'},
                "tahun"=>$baseEND->{'taSPJ'}
            ];
            
            $dinas = dinas::where([
                "kdDinas"=>$param['kdDinas'],
                "taDinas"=>$param['tahun'],
            ])->get();
            
            $dkadis = $this->Mfc->__valByKey($dinas[0],['kadis', 'nip','nmDinas','alamat','asDinas']);
            $dbendahara =Banggota::where([
                "kdDinas"=>$param['kdDinas'],
                "status"=>"bendahara",
            ])->get();
            $dbendahara = $this->Mfc->__valByKey($dbendahara[0],['nmAnggota', 'nip']);
            
            $param["where"]= '';
            $dspj = $this->Hdb->getDataSPJKegiatan($param)[0];
            $staf = json_decode(base64_decode($dspj->data));
            
            
            $NmDinas1= explode(" ",$dkadis['nmDinas']);
            if($NmDinas1[0]=="BADAN" || $NmDinas1[0]=="DINAS"){
                $NmDinas1 = substr($dkadis['nmDinas'],strlen($NmDinas1[0]));
            }
            
            
            $totalUang = $staf[0][4]->label * $dspj->totVol;
            $ppn = (($totalUang/100)*$staf[0][5]->label);
            $zakat =((($totalUang-$ppn)/100)*$staf[0][6]->label);
            $terima = $totalUang - ($ppn+$zakat);

            $key=0;
            $staf[$key][count($staf[$key])]= number_format($totalUang,0,',','.');
            $staf[$key][count($staf[$key])]= number_format($ppn,0,',','.');
            $staf[$key][count($staf[$key])]= number_format($zakat,0,',','.');
            $staf[$key][count($staf[$key])]= number_format($terima,0,',','.');
            
            $tambahan=[
                "terbilang"=>$this->Hsf->terbilang($staf[0][4]->label)." Rupiah",
                "uang"=>number_format($totalUang,0,',','.'),
                "nipStaf"=>"-", 
                "pph"=>number_format($ppn,0,',','.'),
                "zakat"=>number_format($zakat,0,',','.'),
                "terima"=>number_format($terima,0,',','.') 
            ]; 


            $allUang = $totalUang; $allpph = $ppn; 
            $allzakat = $zakat;
            $allTerima=$terima;

            $an = $staf[0][0]->label;
            $hapusDan =0;
            if(count($staf)>1){
                $an = "";
                foreach ($staf as $key => $value) {
                    if(count($staf)==2){
                        $an.=$value[0]->label." dan "; 
                        $hapusDan=1;
                    }else{
                        $an.=$value[0]->label.", "; 
                    }

                    $totalUang = $value[4]->label * $dspj->totVol;
                    $ppn = (($totalUang/100)*$value[5]->label);
                    $zakat =((($totalUang-$ppn)/100)*$value[6]->label);
                    $terima = $totalUang - ($ppn+$zakat);
 
                    
                    if($key>0){
                        $allUang+=$totalUang;
                        $allpph+=$ppn;
                        $allzakat+=$zakat;
                        $allTerima+=$terima;

                        $staf[$key][count($staf[$key])] = number_format($totalUang,0,',','.');
                        $staf[$key][count($staf[$key])]= number_format($ppn,0,',','.');
                        $staf[$key][count($staf[$key])]= number_format($zakat,0,',','.');
                        $staf[$key][count($staf[$key])]= number_format($terima,0,',','.');

                    }
                }
                $count = 2;
                if($hapusDan){
                    $count = 4;
                } 
                $an = substr($an,0,strlen($an)-$count); 
            }
            
            $tambahan['an']= $an;
            $tambahan['allUang']= number_format($allUang,0,',','.');
            $tambahan['allpph']= number_format($allpph,0,',','.');
            $tambahan['allzakat']= number_format($allzakat,0,',','.');
            $tambahan['allTerima']= number_format($allTerima,0,',','.');
            
            $tambahan['terbilang']=$this->Hsf->terbilang($allTerima)." Rupiah"; 
            $date = explode("/",date("Y/m/d")); 
            $tambahan['bulan']=$this->Mfc->__romawi($date[1]);


            return view('spj.pindahBukuRekening',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1,
                "tambahan"=>$tambahan,
                "tglC"=>$date[2]." ".$this->Mfc->__bulan($date[1])." ".$date[0],
                "bulan"=>strtolower(explode(")",explode("(",$dspj->keterangan)[1])[0]), 
                    
            ]);
            $pdf = PDF::loadView('spj.kwitansi',[
                "kadis"=>$dkadis,
                "bend"=>$dbendahara,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                "spj"=>$dspj,
                "staf"=>$staf,
                "ta"=>$param['tahun'],
                "nmDinas1"=>$NmDinas1
            ])->setPaper('legal','portrait');
            return $pdf->stream('kwitansi-'.$staf[0]->label."-".$dspj->keterangan.'.pdf');
        }
        return $this->Mfc->respError($cek['msg']);
    } 

    function checkListSPM($val){
        $cek = $this->Mfc->portal();
        if($cek['exc']){
            $baseEND=json_decode((base64_decode($val)));
            $dt = [];
            foreach ($baseEND->checkList as $key => $value) {
                $dt[$key]= json_decode(base64_decode($value->data));  
            }

            $param = $baseEND->param;
            $dinas = dinas::where([
                "kdDinas"=>$param->kdDinas,
                "taDinas"=>$cek['ta'],
            ])->get()[0]; 
            
            $ppk = Banggota::where("nmJabatan","like","%Bagian Keuangan%")
                ->where("kdDinas",$param->kdDinas)
                ->get()[0]; 
            // return $this->Mfc->log([
            //     "noSPM"=>$baseEND->noSPM,
            //     "nilai"=>$baseEND->nilai,
            //     "list"=>$dt,
            //     "skpd"=>$dinas,
            //     "ppk"=>$ppk
                    
            // ]);
            return view('spj.checkListSPM',[
                "noSPM"=>$baseEND->noSPM,
                "nilai"=>$baseEND->nilai,
                "list"=>$dt,
                "skpd"=>$dinas,
                "ppk"=>$ppk,
                "kab"=>["Kabupaten Sumbawa Barat",'Kab. Sumbawa Barat'],
                    
            ]);
        }
        return $this->Mfc->respError($cek['msg']); 
    }
}
