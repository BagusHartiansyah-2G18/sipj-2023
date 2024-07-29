<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
    <link rel="stylesheet" href="{{url('css/sf.css')}}" > 
</head>
<body class="fzU" style="font-family: Arial, Helvetica, sans-serif;">
    @php
        $spaceTT = '<br><br><br><br>';
        $line ='____________________';
        $spaci4='&nbsp;&nbsp;&nbsp;&nbsp;';
        $kop='
            <table>
                <tr>
                    <td class="w5p">
                        <img src="/logo/ksb.png" width="60px">
                    </td>
                    <td class="pwrap tcenter mKop w85p">
                        <label class="fzK">PEMERINTAH '.$kab.'</label><br>
                        <label class="fzD"><b>'.$pimpinan->nmDinas.'</b></label><br> 
                        <label class="pm0">'.$pimpinan->alamat.'</label>  
                    </td>
                </tr>
            </table>
        ';
        $kopSetda='
            <table>
                <tr>
                    <td class="w5p">
                        <img src="/logo/ksb.png" width="60px">
                    </td>
                    <td class="pwrap tcenter mKop w85p">
                        <label class="fzK">PEMERINTAH '.$kab.'</label><br>
                        <label class="fzD"><b>'.$subPimpinan->nmDinas.'</b></label><br> 
                        <label class="pm0">'.$subPimpinan->alamat.'</label>
                    </td>
                </tr>
            </table>
        ';

        $tt='
            <tr>
                <td colspan="3" >
                    <div class="ml60p">
                        <p class="capitalize">
                            '.$pimpinan->jabatanx.',
                        </p>
                    </div>
                </td>
            </tr>
            
            <tr>
                <td colspan="3" >
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="ml60p">
                        <p class="  ">'.$pimpinan->nmAnggota.'<br>
                        '.$pimpinan->golongan.'<br>
                        NIP. '.$pimpinan->nip.'</p>
                    </div>
                </td>
            </tr>
        ';
        $ttJabatanSetda = $subPimpinan->nmJabatan;
        $penyesuaian = (strlen($ttJabatanSetda)>25 ? "ml45p":"ml50p");

        $ttSetda='
            <tr>
                <td colspan="3" >
                    <div class="'.$penyesuaian.'">
                        Taliwang, '.$spaci4.$tglCetak.'
                        <br>
                        <p class="w55p">
                            '.$ttJabatanSetda.',
                            <!-- <br>'.$kab.' -->
                        </p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" >
                    <br/><br/>
                    <br/><br/>
                    <div class="'.$penyesuaian.'">
                        <p class="  "><u>'.$subPimpinan->nmAnggota.'</u><br>
                        <!-- '.$subPimpinan->golongan.'<br> -->
                        NIP. '.$subPimpinan->nip.'</p>
                    </div> 
                </td>
            </tr>
        ';

        $ttJabatanSub = $subPimpinan->nmJabatan.'<br>'.$kab;
        $penyesuaian = (strlen($ttJabatanSub)>25 ? "ml45p":"ml50p"); 
        $ttSubSetda='
            <tr>
                <td colspan="3" >
                    <div class="'.$penyesuaian.'">
                        Taliwang, '.$spaci4.$tglCetak.'
                        <br>
                        <p class="w55p">
                            '.$ttJabatanSub.', 
                        </p>
                    </div>
                </td>
            </tr>
            <br>
            <br>
            <tr>
                <td colspan="3" >
                    <br/><br/>
                    <br/><br/>
                    <div class="'.$penyesuaian.'">
                        <p class=" "><u>'.$subPimpinan->nmAnggota.'</u><br>
                        <!-- '.$subPimpinan->golongan.'<br> -->
                        NIP. '.$subPimpinan->nip.'</p>
                    </div>
                </td>
            </tr>
        ';
        function viewTabel($data){
            $html='';
            $tamp=0;
            $tamHtml='';
            $countAwal = (count($data)>7 ? 7:6);
            $countNext = (count($data)>7 ? 12:9);
            foreach ($data as $loop =>$dt){
                $html.="
                    <Table>
                        <tr><td >".(count($data)>1 ? ($loop+1).'.':'')."</td><td class='verTop'>Nama</td><td>:</td><td>".$dt['nmAnggota']."</td></tr>
                        <tr><td></td><td class='verTop'>Pangkat/Gol</td><td class='verTop'>:</td><td >".$dt['golongan']."</td></tr>
                        <tr><td></td><td class='verTop'>NIP</td><td>:</td><td>".$dt['nip']."</td></tr>
                        <tr><td></td><td class='verTop'>Jabatan</td><td>:</td><td>".$dt['nmJabatan']." "."</td></tr>
                    </Table>
                ";
                if(count($data)>4){
                    if(($loop+1)% $countAwal === 0 && ($loop+1)<=$countAwal){
                        $html.='
                            <div class="page-break"></div>
                            <div style="width: 100%;">
                        ';
                        $tamp=0; $tamHtml='</div>';
                    }elseif(($tamp+1)% $countNext === 0){
                        if($tamHtml!=''){
                            $html.=$tamHtml; 
                            $tamp=0; $tamHtml='';
                        }  
                        if($loop+1!=count($data)){
                            $html.='
                                <div class="page-break"></div>
                                <div style="width: 100%;">
                            ';
                            $tamp=0; $tamHtml='</div>';
                        } 
                    }
                    $tamp++;
                }
                if($loop+1 == count($data) && count($data)>4){
                    if($tamHtml!=''){
                        $html.=$tamHtml;  
                    } 
                } 

            } 
            echo($html); 
        }
    @endphp



    @php
        $tamp=0; $tamHtml="";
        $newMember = array();
        foreach ($member as $key => $value) {
            if($value['tingkatan'] < 4){
                array_push($newMember,$value);
            }
        }
    @endphp
    @if(count($newMember)>0)
        <div class=" container">
            @php echo($kop); @endphp
            <hr> 
            <!-- <br> -->
            <table  class="w100p">
                <tr>
                    <td class="w10p"></td>
                    <td class="w60p"></td>
                    <td>Taliwang,  @php echo($spaci4); @endphp {{$tglCetak}} </td>
                </tr> 
                <tr>
                    <td>Nomor <br>Sifat <br>Lampiran<br>Hal</td>
                    <td><span id="addTitik2">B-@php echo($nomor)  @endphp </span>
                        <br/><span id="addTitik2">Biasa</span>
                        <br><span id="addTitik2">-</span>
                        <br><span id="addTitik2">Permohonan Penerbitan Surat Tugas</span>
                    </td>
                    <td></td>
                </tr>    
                <tr> 
                    <td colspan="2">
                        <br/>
                        Yth. Sekretaris Daerah {{$kab}}<br>
                        @php echo($spaci4); @endphp di <br>
                        @php echo($spaci4); @endphp Tempat
                        @php echo($spaceTT); @endphp
                        Dengan hormat,
                    </td>
                    <td></td>
                </tr>  
                <tr> 
                    <td colspan="3">
                        <p style="text-align: justify;padding: 0px; margin: 0px;">
                            @php echo($spaci4); @endphp {{$data->maksud}} pada tanggal
                            {{$textTanggal}}
                            di {{$data->lokasi}}.
                            untuk itu mohon diterbitkan SPD atas nama :
                        </p>
                        @php 
                            $tamp=0; $tamHtml=""; 
                            viewTabel($newMember);
                        @endphp 
                        <!-- <div style="min-height: 400px;"></div> -->
                        <br>
                        @if(count($newMember)>4)
                            <div>
                        @endif
                        <p style="width: 600px;">
                            Kegiatan tersebut dibebankan pada {{$data->anggaran}} {{$kab}} Tahun Anggaran {{$tahun}}.
                            <br><br>
                            @php echo($spaci4); @endphp  Demikian dan atas kebijakan Bapak dihaturkan terima kasih.
                        </p>
                        @if(count($newMember)>4)
                            </div>
                        @endif
                    </td>
                </tr>
                <br>
                @php echo($tt); @endphp
            </table>
        </div>
        <div class="page-break"></div>
        <div class=" container">
            @php echo($kopSetda);$tamp =0; @endphp
            <hr>  
            <table class="w100p">
                <tr class="tcenter ">
                    <td colspan="3">
                        <b class="fzK">
                            SURAT TUGAS<br>
                        </b>
                        Nomor : @php echo($nomorTugas);  @endphp
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br/>
                        <br/>
                        Yang bertanda tangan di bawah ini :
                    </td> 
                </tr>
                <tr>
                    <td class="w20p">Nama</td><td>: {{$setda->kadis}}</td>
                </tr>
                <tr>
                    <td>NIP</td><td>: {{$setda->nip}}</td>
                </tr>
                <tr>
                    <td>Jabatan</td><td>: Sekretaris Daerah {{$asKab}}</td>
                </tr> 
                <tr class="tcenter ">
                    <td colspan="3">
                        <b class="fzK"><br/>MEMERINTAHKAN<br></b>
                    </td>
                </tr>
                <tr>
                    <td class="w20p">Kepada :</td><td></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="margin-left: 70px;">
                            @php viewTabel($newMember); @endphp 
                        </div>
                    </td>
                </tr>
                <tr>
                    <!-- class="w20p verTop"  -->
                    <td colspan="3" >
                        <div class="flexR">
                            <span class="w26p">Untuk/Maksud</span>
                            <span class="w2p">:</span>
                            <p class="w70p" style="text-align: justify;padding: 0px; margin: 0px;max-width:480px;">
                                {{$data->maksud}} 
                                <!-- pada tanggal
                                {{$textTanggal}} -->
                                yang akan dilaksanakan di {{$data->lokasi}}.
                            </p>
                        </div>
                    </td>  
                </tr>
                <tr>
                    <td colspan="3" >
                        <div class="flexR">
                            <span class="w26p">Daerah Tujuan</span>
                            <span class="w2p">:</span>
                            <span class="w70p">
                                {{$data->tempatE}}
                            </span>
                        </div>
                    </td>   
                </tr>
                <tr>
                    <td colspan="3" >
                        <div class="flexR">
                            <span class="w26p">Jangka Waktu Perintah Penugasan</span>
                            <span class="w2p">:</span>
                            <span class="w70p">
                                {{$hari.", tanggal ".$textTanggal}}
                            </span>
                        </div>
                    </td>   
                </tr>  
                <tr> 
                    <td colspan="3" >
                        <div class="ml60p">
                            Taliwang, @php echo($spaci4); @endphp {{$tglCetak}}
                            <br>
                            <p class="w55p">
                                Sekretaris Daerah,
                                <br>{{$kab}}
                            </p>
                        </div>
                         
                    </td>
                </tr> 
                <tr>
                    <td colspan="3" >
                        <br/><br/>
                        <br/><br/>
                        <div class="ml60p">
                            <p class=" ">{{$subPimpinan->nmAnggota}}<br>
                            {{$subPimpinan->golongan}} <br>
                            NIP. {{$subPimpinan->nip}}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="page-break"></div>
    @endif
    @php
        $tamp=0; $tamHtml="";
        $newMember = array();
        foreach ($member as $key => $value) {
            if($value['tingkatan'] >= 4){
                array_push($newMember,$value);
            }
        }
    @endphp
    @if(count($newMember)>0)
        <div class=" container">
            @php echo($kop); @endphp
            <hr> 
            <!-- <br> -->
            <table class="w100p">
                <tr>
                    <td class="w10p"></td>
                    <td class="w60p"></td>
                    <td>Taliwang, {{$tglCetak}} </td>
                </tr> 
                <tr>
                    <td>Nomor <br>Sifat <br>Lampiran<br>Hal</td>
                    <td><span id="addTitik2">B-@php echo($nomor)  @endphp </span>
                        <br/><span id="addTitik2">Biasa</span>
                        <br><span id="addTitik2">-</span>
                        <br><span id="addTitik2">Permohonan Penerbitan Surat Tugas</span>
                    </td>
                    <td></td>
                </tr>  
                <tr> 
                    <td colspan="2">
                        <br/>
                        <div class="flexR">
                            <p class="pm0">Yth.</p>
                            <p class="pm0">@php echo($ttJabatanSub)  @endphp</p>
                        </div>
                        @php echo($spaci4); @endphp di <br>
                        @php echo($spaci4); @endphp Tempat
                        @php echo($spaceTT); @endphp
                        Dengan hormat,
                    </td>
                    <td></td>
                </tr> 
                <tr> 
                    <td colspan="3">
                        <p style="text-align: justify;padding: 0px; margin: 0px;">
                            @php echo($spaci4); @endphp {{$data->maksud}} pada tanggal
                            {{$textTanggal}}
                            di {{$data->lokasi}}.
                            untuk itu mohon diterbitkan SPD atas nama :
                        </p>
                        @php $tamp=0; $tamHtml=""; 
                            viewTabel($newMember)
                        @endphp
                         
                        <br>
                        @if(count($newMember)>4)
                            <div >
                        @endif
                        <p style="width: 600px;">
                            Kegiatan tersebut dibebankan pada {{$data->anggaran}} {{$kab}} Tahun Anggaran {{$tahun}}.
                            <br><br>
                            @php echo($spaci4); @endphp Demikian dan atas kebijakan Bapak dihaturkan terima kasih.
                        </p>
                        @if(count($newMember)>4)
                            </div>
                        @endif
                    </td>
                </tr> 
                @php echo($tt); @endphp
            </table>
        </div>
        <div class="page-break"></div>
        <div class=" container">
            @php echo($kopSetda);$tamp =0; @endphp
            <hr> 
            <!-- <br> -->
            <table class="w100p">
                <tr class="tcenter">
                    <td colspan="3">
                        <b class=" fzK">
                            SURAT TUGAS<br>
                        </b>
                        Nomor : @php echo($nomorTugas); @endphp
                    </td>
                </tr> 
                <tr>
                    <td colspan="3">
                        <br/>
                        <br/>
                        Yang bertanda tangan di bawah ini :
                    </td> 
                </tr>
                <tr>
                    <td class="w20p">Nama</td><td class="w2p">:</td><td >{{$subPimpinan->nmAnggota}}</td>
                </tr>
                <tr>
                    <td>NIP</td><td>:</td><td> {{$subPimpinan->nip}}</td>
                </tr>
                <tr>
                    <td>Jabatan</td><td>:</td><td>@php echo($subPimpinan->nmJabatan); @endphp {{$asKab}}</td>
                </tr> 
                <tr class="tcenter ">
                    <td colspan="3">
                        <b class="fzK"><br/>MEMERINTAHKAN<br></b>
                    </td>
                </tr>
                <tr>
                    <td class="w20p">Kepada :</td><td></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="margin-left: 70px;">
                        @php
                            $tamp=0; $tamHtml="";
                            $newMember = array();
                            foreach ($member as $key => $value) {
                                if($value['tingkatan'] >= 4){
                                    array_push($newMember,$value);
                                }
                            }

                            viewTabel($newMember);
                        @endphp 
                        </div>
                    </td>
                </tr>
                <tr>
                    <!-- class="w20p verTop"  -->
                    <td colspan="3" >
                        <div class="flexR">
                            <span class="w26p">Untuk/Maksud</span>
                            <span class="w2p">:</span>
                            <p class="w70p" style="text-align: justify;padding: 0px; margin: 0px;max-width:480px;">
                                {{$data->maksud}} 
                                <!-- pada tanggal
                                {{$textTanggal}} -->
                                yang akan dilaksanakan di {{$data->lokasi}}.
                            </p>
                        </div>
                    </td>  
                </tr>
                <tr>
                    <td colspan="3" >
                        <div class="flexR">
                            <span class="w26p">Daerah Tujuan</span>
                            <span class="w2p">:</span>
                            <span class="w70p">
                                {{$data->tempatE}}
                            </span>
                        </div>
                    </td>   
                </tr>
                <tr>
                    <td colspan="3" >
                        <div class="flexR">
                            <span class="w26p">Jangka Waktu Perintah Penugasan</span>
                            <span class="w2p">:</span>
                            <span class="w70p">
                                {{$hari.", tanggal ".$textTanggal}}
                            </span>
                        </div>
                    </td>   
                </tr>
                @php echo($ttSubSetda); @endphp
            </table>
        </div>
    @endif

    <script>
        window.print();
    </script>
</body>
</html>
