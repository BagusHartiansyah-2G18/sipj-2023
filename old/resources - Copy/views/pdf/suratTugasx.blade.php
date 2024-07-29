<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
    <link rel="stylesheet" href="{{url('css/sf.css')}}" > 
</head>
<body class="fz14" style="font-family: Arial, Helvetica, sans-serif;">
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
                        <label class="fzD"><b>'.$dinas->nmDinas.'</b></label><br> 
                        <label class="pm0">'.$dinas->alamat.'</label>  
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
                        <label class="fzD"><b>'.$setda->nmDinas.'</b></label><br> 
                        <label class="pm0">'.$setda->alamat.'</label>
                    </td>
                </tr>
            </table>
        ';

        $ttJabatan = $jabatanDinas.' '.$dinas->asDinas.'<br>'.$kab;
        $tt='
            <tr>
                <td colspan="3" >
                    <div class="ml60p">
                        <p class="capitalize">
                            '.$jabatanDinas." ".strtolower(explode(" ",$dinas->nmDinas)[0]).',
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
        $ttJabatanSetda = $jabatanSetda.$subPimpinan->nmJabatan;
        $penyesuaian = (strlen($ttJabatanSetda)>25 ? "ml45p":"ml50p");

        $ttSetda='
            <tr>
                <td colspan="3" >
                    <div class="'.$penyesuaian.'">
                        Taliwang, '.$tglCetak.'
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
                        Taliwang '.$tglCetak.'
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
    @endphp



    @php
        $tamp=0; $tamHtml="";
        $newMember = array();
        foreach ($member as $key => $value) {
            if($value->tingkatan < 4){
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
                        @php $tamp=0; $tamHtml=""; @endphp
                        @foreach ($newMember as $dt)
                            <Table>
                                <tr><td >{{(count($newMember)>1 ? ($loop->index+1).".":'')}}</td><td class="verTop">Nama</td><td>:</td><td>{{$dt->nmAnggota}}</td></tr>
                                <tr><td></td><td class="verTop">Pangkat/Gol</td><td class="verTop">:</td><td style=""> {{$dt->golongan}}</td></tr>
                                <tr><td></td><td class="verTop">NIP</td><td>:</td><td> {{$dt->nip}}</td></tr>
                                <!-- <tr><td></td><td class="verTop">Golongan</td><td>:</td><td> {{$dt->golongan}}</td></tr> -->
                                <tr><td></td><td class="verTop">Jabatan</td><td>:</td><td> {{($dt->nmJabatan)." ".$asDinas}}</td></tr>
                            </Table>
                            @if(count($newMember)>4)
                                @if(($loop->index+1)%5 === 0 && ($loop->index+1)<=5)
                                    <div class="page-break"></div>
                                    <div style="margin-left: 70px; width: 100%;">
                                    @php $tamp=0; $tamHtml='</div>'; @endphp
                                @elseif(($tamp+1)%9 === 0)

                                    @if($tamHtml!='')
                                        @php echo($tamHtml); $tamp=0; $tamHtml=''; @endphp
                                    @endif

                                    <!-- loop member >9 -->
                                    @if($loop->index+1!=count($newMember))
                                        <div class="page-break"></div>
                                        <div style="margin-left: 70px;width: 100%;">
                                        @php $tamp=0; $tamHtml='</div>'; @endphp
                                    @endif
                                @endif
                                @php $tamp++; @endphp
                            @else
                                <!-- @if($loop->index+1 == count($member))
                                    @for($a=4-count($member); $a>0; $a--)
                                        <div style="min-height: 130px;"></div>
                                    @endfor
                                @endif -->
                            @endif

                            <!-- (@php echo($tamp); @endphp) -->
                            <!-- cek enter terakhir loop  -->
                            @if($loop->index+1 == count($newMember) && count($newMember)>4)
                                @if($tamHtml!='')
                                    @php echo($tamHtml); @endphp
                                @endif

                                <!-- for spaci anggota dan tanda tangan  -->
                                <!-- @for($a=8-$tamp; $a>0; $a--)
                                    <div style="min-height: 130px;"></div>
                                @endfor -->
                            @endif
                        @endforeach
                        <!-- <div style="min-height: 400px;"></div> -->
                        <br>
                        @if(count($newMember)>4)
                            <div style="margin-left: 70px;">
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
                    <td class="w20p">Nama</td><td>: {{$setdaPim->nmAnggota}}</td>
                </tr>
                <tr>
                    <td>NIP</td><td>: {{$setdaPim->nip}}</td>
                </tr>
                <tr>
                    <td>Jabatan</td><td>: @php echo($setdaPim->nmJabatan); @endphp {{$asKab}}</td>
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
                            @foreach ($newMember as $dt)
                                <Table>
                                    <tr><td >{{(count($newMember)>1 ? ($loop->index+1).".":'')}}</td><td class="verTop">Nama</td><td>:</td><td>{{$dt->nmAnggota}}</td></tr>
                                    <tr><td></td><td class="verTop">Pangkat/Gol</td><td>:</td><td> {{$dt->golongan}}</td></tr>
                                    <tr><td></td><td class="verTop">NIP</td><td>:</td><td> {{$dt->nip}}</td></tr>
                                    <tr><td></td><td class="verTop">Jabatan</td><td class="verTop">:</td><td> {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)}} {{ $asdiskab}}</td></tr>
                                    <!-- <tr><td></td><td class="verTop">Tingkat</td><td>:</td><td> {{($dt->tingkat)}}</td></tr> -->
                                </Table>
                                @if(count($newMember)>4)
                                    @if(($loop->index+1)%5 === 0 && ($loop->index+1)<=5)
                                        <div class="page-break"></div>
                                        @php $tamp=0; @endphp
                                    @elseif(($tamp+1)%8 === 0)
                                        @if($tamHtml!='')
                                            @php $tamp=0; $tamHtml=''; @endphp
                                        @endif

                                        <!-- loop member >9 -->
                                        @if($loop->index+1!=count($newMember))
                                            <div class="page-break"></div>
                                        @endif
                                    @endif
                                    @php $tamp++; @endphp
                                @else
                                    <!-- @for($a=4-count($member); $a>0; $a--)
                                        <div style="min-height: 130px;"></div>
                                    @endfor -->
                                @endif

                                <!-- (@php echo($tamp); @endphp) -->
                                <!-- cek enter terakhir loop  -->
                                <!-- @if($loop->index+1 == count($member) && count($member)>4)
                                    @for($a=8-$tamp; $a>0; $a--)
                                        <div style="min-height: 130px;"></div>
                                    @endfor
                                @endif -->
                            @endforeach
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
                            Taliwang {{$tglCetak}}
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
                            <p class=" ">{{$setdaPim->nmAnggota}}<br>
                            {{$setdaPim->golongan}} <br>
                            NIP. {{$setdaPim->nip}}</p>
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
            if($value->tingkatan >= 4){
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
                        Yth. @php echo($ttJabatanSub)  @endphp<br>
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
                        @php $tamp=0; $tamHtml=""; @endphp
                        @foreach ($newMember as $dt)
                            <Table>
                                <tr><td >{{(count($newMember)>1 ? ($loop->index+1).".":'')}}</td><td class="verTop">Nama</td><td>:</td><td>{{$dt->nmAnggota}}</td></tr>
                                <tr><td></td><td class="verTop">Pangkat/Gol</td><td class="verTop">:</td><td style=""> {{$dt->golongan}}</td></tr>
                                <tr><td></td><td class="verTop">NIP</td><td>:</td><td> {{$dt->nip}}</td></tr>
                                <!-- <tr><td></td><td class="verTop">Golongan</td><td>:</td><td> {{$dt->golongan}}</td></tr> -->
                                <tr><td></td><td class="verTop">Jabatan</td><td>:</td><td> {{($dt->nmJabatan)." ".$asDinas}}</td></tr>
                            </Table>
                            @if(count($newMember)>4)
                                @if(($loop->index+1)%5 === 0 && ($loop->index+1)<=5)
                                    <div class="page-break"></div>
                                    <div style="margin-left: 70px; width: 100%;">
                                    @php $tamp=0; $tamHtml='</div>'; @endphp
                                @elseif(($tamp+1)%9 === 0)

                                    @if($tamHtml!='')
                                        @php echo($tamHtml); $tamp=0; $tamHtml=''; @endphp
                                    @endif

                                    <!-- loop member >9 -->
                                    @if($loop->index+1!=count($newMember))
                                        <div class="page-break"></div>
                                        <div style="margin-left: 70px;width: 100%;">
                                        @php $tamp=0; $tamHtml='</div>'; @endphp
                                    @endif
                                @endif
                                @php $tamp++; @endphp
                            @else
                                <!-- @if($loop->index+1 == count($member))
                                    @for($a=4-count($member); $a>0; $a--)
                                        <div style="min-height: 130px;"></div>
                                    @endfor
                                @endif -->
                            @endif

                            <!-- (@php echo($tamp); @endphp) -->
                            <!-- cek enter terakhir loop  -->
                            @if($loop->index+1 == count($newMember) && count($newMember)>4)
                                @if($tamHtml!='')
                                    @php echo($tamHtml); @endphp
                                @endif

                                <!-- for spaci anggota dan tanda tangan  -->
                                <!-- @for($a=8-$tamp; $a>0; $a--)
                                    <div style="min-height: 130px;"></div>
                                @endfor -->
                            @endif
                        @endforeach
                        <!-- <div style="min-height: 400px;"></div> -->
                        <br>
                        @if(count($newMember)>4)
                            <div style="margin-left: 70px;">
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
                                if($value->tingkatan >= 4){
                                    array_push($newMember,$value);
                                }
                            }
                        @endphp
                            @foreach ($newMember as $dt)
                                <Table>
                                    <tr><td >{{(count($newMember)>1 ? ($loop->index+1).".":'')}}</td><td class="verTop">Nama</td><td>:</td><td>{{$dt->nmAnggota}}</td></tr>
                                    <tr><td></td><td class="verTop">Pangkat/Gol</td><td>:</td><td> {{$dt->golongan}}</td></tr>
                                    <tr><td></td><td class="verTop">NIP</td><td>:</td><td> {{$dt->nip}}</td></tr>
                                    <tr><td></td><td class="verTop">Jabatan</td><td class="verTop">:</td><td> {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)}} {{ $asdiskab}}</td></tr>
                                    <!-- <tr><td></td><td class="verTop">Tingkat</td><td>:</td><td> {{($dt->tingkat)}}</td></tr> -->
                                </Table>
                                @if(count($newMember)>4)
                                    @if(($loop->index+1)%5 === 0 && ($loop->index+1)<=5)
                                        <div class="page-break"></div>
                                        @php $tamp=0; @endphp
                                    @elseif(($tamp+1)%8 === 0)
                                        @if($tamHtml!='')
                                            @php $tamp=0; $tamHtml=''; @endphp
                                        @endif

                                        <!-- loop member >9 -->
                                        @if($loop->index+1!=count($newMember))
                                            <div class="page-break"></div>
                                        @endif
                                    @endif
                                    @php $tamp++; @endphp
                                @else
                                    <!-- @for($a=4-count($member); $a>0; $a--)
                                        <div style="min-height: 130px;"></div>
                                    @endfor -->
                                @endif

                                <!-- (@php echo($tamp); @endphp) -->
                                <!-- cek enter terakhir loop  -->
                                <!-- @if($loop->index+1 == count($member) && count($member)>4)
                                    @for($a=8-$tamp; $a>0; $a--)
                                        <div style="min-height: 130px;"></div>
                                    @endfor
                                @endif -->
                            @endforeach
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
