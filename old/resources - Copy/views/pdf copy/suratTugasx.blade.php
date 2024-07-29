<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
    <!-- <link href="{{ asset('stylePDF.css') }}" rel="stylesheet"> -->
    <style>
        .page-break {
            page-break-after: always;
        }
        .fz12{ font-size: 12px;}
        .fz14{ font-size: 14px;}
        .fz16{font-size: 16px;}

        .w100p{width: 100%;}
        .w70p{width: 70%;}
        .w60p{width: 60%;}
        .w55p{width: 55%;}
        .w50p{width: 50%;}
        .w40p{width: 40%;}
        .w30p{width: 30%;}
        .w20p{width: 20%;}
        .w10p{width: 10%;}
        .w5p{width: 5%;}
        .w2p{width: 2%;}

        .container{
            margin: 0 auto;
            display: block;
            width: 90%;
            /* display: flex;
            flex-direction: column; */
        }
        .tupper{text-transform: uppercase;}
        table{
            box-sizing: 1.5px;
        }
        .right{
            width: 100%;
            margin-left: 60%;
        }
        .rightPanjang{
            width: 100%;
            margin-left: 45%;
        }
        .pm0{padding: 0px; margin: 0px;}
        .p0{padding: 0px;}
        .pwrap{padding: 0px 30px;}
        .tcenter{text-align: center;}
        .tend{text-align: end;}
        .fz40{font-size: 40px;}
        .fz30{font-size: 30px;}
        .fz25{font-size: 25px;}
        .fz20{font-size: 20px;}
        .bbottom{border-bottom: 1px solid;}

        .capitalize{text-transform: capitalize;}

        .noBold{font-weight: normal;}
        .verTop{vertical-align: top;}
    </style>
</head>
<body class="fz14" style="font-family: Arial, Helvetica, sans-serif;">
    @php
        $spaceTT = '<br><br><br><br>';
        $line ='____________________';
        $spaci4='&nbsp;&nbsp;&nbsp;&nbsp;';
        $kop='
            <table>
                <tr>
                    <td class="w30p">
                        <img src="logo/ksb.png" width="60px">
                    </td>
                    <td class="pwrap tcenter mKop">
                        <h2 class=" tupper fz20 noBold pm0 " >
                            PEMERINTAH '.$kab.'<br>
                            <b>'.$dinas->nmDinas.'</b>
                        </h2>
                        <i style="font-size: small;" class="pm0">'.$dinas->alamat.'</i>
                    </td>
                </tr>
            </table>
        ';
        $kopSetda='
            <table>
                <tr>
                    <td class="w30p">
                        <img src="logo/ksb.png" width="60px">
                    </td>
                    <td class="pwrap tcenter mKop">
                        <h2 class=" tupper fz20 noBold pm0 " >
                            PEMERINTAH '.$kab.'<br>
                            <b>'.$setda->nmDinas.'</b>
                        </h2>
                        <i style="font-size: small;" class="pm0">'.$setda->alamat.'</i>
                    </td>
                </tr>
            </table>
        ';

        $ttJabatan = $jabatanDinas.' '.$dinas->asDinas.'<br>'.$kab;
        $tt='
            <tr>
                <td colspan="3" >
                    <div class="right">
                        <p class="w40p tcenter">
                            '.$ttJabatan.'
                        </p>
                    </div>
                </td>
            </tr>
            <br>
            <br>
            <tr>
                <td colspan="3" >
                    <div class="right">
                        <p class="w40p tcenter"><u><b>'.$pimpinan->nmAnggota.'</b></u><br>
                        '.$pimpinan->golongan.'<br>
                        NIP. '.$pimpinan->nip.'</p>
                    </div>
                </td>
            </tr>
        ';
        $ttJabatanSetda = $jabatanSetda.$subPimpinan->nmJabatan;
        $ttSetda='
            <tr>
                <td colspan="3" >
                    <div class="rightPanjang tcenter">
                        <table style="margin-left: 15%;">
                            <tr>
                                <td>Dikeluarkan di</td><td>:</td>
                                <td>Taliwang</td>
                            </tr>
                            <tr>
                                <td>Pada Tanggal</td><td>:</td>
                                <td>'.$tglCetak.'</td>
                            </tr>
                        </table>
                        <br>
                        <p class="w55p">
                            '.$ttJabatanSetda.',
                            <!-- <br>'.$kab.' -->
                        </p>
                    </div>
                </td>
            </tr>
            <br>
            <br>
            <tr>
                <td colspan="3" >
                    <div class="rightPanjang">
                        <p class="w60p tcenter"><u><b>'.$subPimpinan->nmAnggota.'</b></u><br>
                        '.$subPimpinan->golongan.'<br>
                        NIP. '.$subPimpinan->nip.'</p>
                    </div>
                </td>
            </tr>
        ';

        $ttJabatanSub = $subPimpinan->nmJabatan.'<br>'.$kab;
        $ttSubSetda='
            <tr>
                <td colspan="3" >
                    <div class="rightPanjang tcenter">
                        <table style="margin-left: 15%;">
                            <tr>
                                <td>Dikeluarkan di</td><td>:</td>
                                <td>Taliwang</td>
                            </tr>
                            <tr>
                                <td>Pada Tanggal</td><td>:</td>
                                <td>'.$tglCetak.'</td>
                            </tr>
                        </table>
                        <br>
                        <p class="w55p">
                            '.$ttJabatanSub.',
                            <!-- <br>'.$kab.' -->
                        </p>
                    </div>
                </td>
            </tr>
            <br>
            <br>
            <tr>
                <td colspan="3" >
                    <div class="rightPanjang">
                        <p class="w60p tcenter"><u><b>'.$subPimpinan->nmAnggota.'</b></u><br>
                        '.$subPimpinan->golongan.'<br>
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
            <br>
            <!-- <br> -->
            <table class="fz12" class="w100p">
                <tr>
                    <td class="w10p"></td>
                    <td class="w60p"></td>
                    <td>Taliwang, {{$tglCetak}} </td>
                </tr>
                <br>
                <tr>
                    <td>Nomor <br>Lamp<br>Hal</td>
                    <td>: @php echo($nomor)  @endphp <br>: -<br>: Permohonan Penerbitan Surat Tugas</td>
                    <td>Kepada</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        Yth. Sekretaris Daerah {{$kab}}<br>
                        di- <br>Taliwang
                    </td>
                </tr>
                
                <br>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <p style="text-align: justify;padding: 0px; margin: 0px;">
                            {{$data->maksud}} pada tanggal
                            {{$textTanggal}}
                            di {{$data->lokasi}}.
                            untuk itu mohon diterbitkan SPD atas nama :
                        </p>
                        <ul>
                                @php $tamp=0; $tamHtml=""; @endphp
                                @foreach ($newMember as $dt)
                                    <ol style="list-style: disc;">
                                        <!-- <Table>
                                            <tr><td>{{$loop->index+1}}.   </td><td>Nama</td><td>: {{$dt->nmAnggota}}</td></tr>
                                            <tr><td></td><td>NIP</td><td>: {{$dt->nip}}</td></tr>
                                            <tr><td></td><td>Jabatan</td><td >: {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)}} {{$asdiskab}}</td></tr>
                                            <tr><td></td><td>Golongan</td><td>: {{$dt->golongan}}</td></tr>
                                            <tr><td></td><td>Tingkat</td><td>: {{($dt->tingkat)}}</td></tr>
                                        </Table> -->
                                        <Table>
                                            <tr><td >{{$loop->index+1}}.   </td><td class="verTop">Nama</td><td>:</td><td>{{$dt->nmAnggota}}</td></tr>
                                            <tr><td></td><td class="verTop">NIP</td><td>:</td><td> {{$dt->nip}}</td></tr>
                                            <tr><td></td><td class="verTop">Jabatan</td><td class="verTop">:</td><td> {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)}} {{ $asdiskab}}</td></tr>
                                            <tr><td></td><td class="verTop">Golongan</td><td>:</td><td> {{$dt->golongan}}</td></tr>
                                            <tr><td></td><td class="verTop">Tingkat</td><td>:</td><td> {{($dt->tingkat)}}</td></tr>
                                        </Table>
                                    </ol>
                                    @if(count($member)>4)
                                        @if(($loop->index+1)%5 === 0 && ($loop->index+1)<=5)
                                            <div class="page-break"></div>
                                            <div style="margin-left: 70px; width: 100%;">
                                            @php $tamp=0; $tamHtml='</div>'; @endphp
                                        @elseif(($tamp+1)%9 === 0)

                                            @if($tamHtml!='')
                                                @php echo($tamHtml); $tamp=0; $tamHtml=''; @endphp
                                            @endif

                                            <!-- loop member >9 -->
                                            @if($loop->index+1!=count($member))
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
                                    @if($loop->index+1 == count($member) && count($member)>4)
                                        @if($tamHtml!='')
                                            @php echo($tamHtml); @endphp
                                        @endif

                                        <!-- for spaci anggota dan tanda tangan  -->
                                        <!-- @for($a=8-$tamp; $a>0; $a--)
                                            <div style="min-height: 130px;"></div>
                                        @endfor -->
                                    @endif
                                @endforeach
                        </ul>
                        <!-- <div style="min-height: 400px;"></div> -->
                        <br>
                        @if(count($newMember)>4)
                            <div style="margin-left: 70px;">
                        @endif
                        <p style="width: 600px;">
                            Kegiatan tersebut dibebankan pada {{$data->anggaran}} {{$asKab}} Tahun Anggaran {{$tahun}}.
                            <br>
                            Demikian dan atas kebijakan Bapak dihaturkan terima kasih.
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
            <br>
            <!-- <br> -->
            <table class="fz12" class="w100p">
                <tr class="tcenter ">
                    <td colspan="3">
                        <b class="bbottom fz20">
                            SURAT TUGAS<br>
                        </b>
                        Nomor : @php echo($nomorTugas);  @endphp
                    </td>
                </tr>
                <br>
                <tr>
                    <td class="w20p">Nama</td><td>: {{$setdaPim->nmAnggota}}</td>
                </tr>
                <tr>
                    <td>NIP</td><td>: {{$setdaPim->nip}}</td>
                </tr>
                <tr>
                    <td>Jabatan</td><td>: @php echo($setdaPim->nmJabatan); @endphp {{$asKab}}</td>
                </tr>
                <br>
                <tr class="tcenter ">
                    <td colspan="3">
                        <b class="fz20">MEMERINTAHKAN<br></b>
                    </td>
                </tr>
                <tr>
                    <td class="w20p">Kepada</td><td>:</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="margin-left: 70px;">
                        <ul>
                            <!-- @foreach ($member as $dt)
                                <ol style="list-style: disc;">
                                    <Table>
                                        <tr><td>{{$loop->index+1}}. </td><td>Nama</td><td>: {{$dt->nmAnggota}}</td></tr>
                                        <tr><td></td><td>NIP</td><td>: {{$dt->nip}}</td></tr>
                                        <tr><td></td><td>Jabatan</td><td>: {{$dt->nmJabatan}} {{$asdiskab}}</td></tr>
                                        <tr><td></td><td>Golongan</td><td>: {{$dt->golongan}}</td></tr>
                                        <tr><td></td><td>Tingkat</td><td>: {{($dt->tingkat)}}</td></tr>
                                    </Table>
                                </ol>
                            @endforeach -->
                            @foreach ($newMember as $dt)
                                <ol style="list-style: disc;">
                                    <Table>
                                        <tr><td>{{$loop->index+1}}.   </td><td>Nama</td><td>: {{$dt->nmAnggota}}</td></tr>
                                        <tr><td></td><td>NIP</td><td>: {{$dt->nip}}</td></tr>
                                        <tr><td></td><td>Jabatan</td><td>: {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)}} {{$asdiskab}}</td></tr>
                                        <tr><td></td><td>Golongan</td><td>: {{$dt->golongan}}</td></tr>
                                        <tr><td></td><td>Tingkat</td><td>: {{($dt->tingkat)}}</td></tr>
                                    </Table>
                                </ol>
                                @if(count($member)>4)
                                    @if(($loop->index+1)%5 === 0 && ($loop->index+1)<=5)
                                        <div class="page-break"></div>
                                        @php $tamp=0; @endphp
                                    @elseif(($tamp+1)%8 === 0)
                                        @if($tamHtml!='')
                                            @php $tamp=0; $tamHtml=''; @endphp
                                        @endif

                                        <!-- loop member >9 -->
                                        @if($loop->index+1!=count($member))
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
                        </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <!-- <td class="w20p">Untuk</td> -->
                    <td class="w20p verTop">Untuk <span style="float:right;">:</span></td>
                    <td colspan="2">
                        <p style="text-align: justify;padding: 0px; margin: 0px;max-width:480px;">
                            {{$data->maksud}} pada tanggal
                            {{$textTanggal}}
                            di {{$data->lokasi}}.
                        </p>

                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Kegiatan tersebut dibebankan pada {{$data->anggaran}} {{$asKab}} Tahun Anggaran {{$tahun}}.
                    </td>
                </tr>
                <br>
                <tr>
                    <td colspan="3" >
                        <div class="rightPanjang">
                            <table style="margin-left: 15%;">
                                <tr>
                                    <td>Dikeluarkan di</td><td>:</td>
                                    <td>Taliwang</td>
                                </tr>
                                <tr>
                                    <td>Pada Tanggal</td><td>:</td>
                                    <td>{{$tglCetak}}</td>
                                </tr>
                            </table>
                            <p class="w55p tcenter">
                                <!-- a.n. Bupati Sumbawa Barat <br> -->
                                Sekretaris Daerah,
                                <br>{{$kab}}
                            </p>
                        </div>
                    </td>
                </tr>
                <br>
                <br>
                <tr>
                    <td colspan="3" >
                        <div class="rightPanjang">
                            <p class="w55p tcenter"><b><u>{{$setdaPim->nmAnggota}}</u></b><br>
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
            <br>
            <!-- <br> -->
            <table class="fz12" class="w100p">
                <tr>
                    <td class="w10p"></td>
                    <td class="w60p"></td>
                    <td>Taliwang, {{$tglCetak}} </td>
                </tr>
                <br>
                <tr>
                    <td>Nomor <br>Lamp<br>Hal</td>
                    <td>: @php echo($nomor)  @endphp <br>: -<br>: Permohonan Penerbitan Surat Tugas</td>
                    <td>Kepada</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        Yth. @php echo($ttJabatanSub); @endphp<br>
                        di- <br>Taliwang
                    </td>
                </tr>
                <br>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <p style="text-align: justify;padding: 0px; margin: 0px;">
                            {{$data->maksud}} pada tanggal
                            {{$textTanggal}}
                            di {{$data->lokasi}}.
                            untuk itu mohon diterbitkan SPD atas nama :
                        </p>
                        <ul>
                                @php $tamp=0; $tamHtml=""; @endphp
                                @foreach ($newMember as $dt)
                                    <ol style="list-style: disc;">
                                        <!-- <Table>
                                            <tr><td>{{$loop->index+1}}.   </td><td>Nama</td><td>: {{$dt->nmAnggota}}</td></tr>
                                            <tr><td></td><td>NIP</td><td>: {{$dt->nip}}</td></tr>
                                            <tr><td></td><td>Jabatan</td><td >: {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)}} {{$asdiskab}}</td></tr>
                                            <tr><td></td><td>Golongan</td><td>: {{$dt->golongan}}</td></tr>
                                            <tr><td></td><td>Tingkat</td><td>: {{($dt->tingkat)}}</td></tr>
                                        </Table> -->
                                        <Table>
                                            <tr><td >{{$loop->index+1}}.   </td><td class="verTop">Nama</td><td>:</td><td>{{$dt->nmAnggota}}</td></tr>
                                            <tr><td></td><td class="verTop">NIP</td><td>:</td><td> {{$dt->nip}}</td></tr>
                                            <tr><td></td><td class="verTop">Jabatan</td><td class="verTop">:</td><td> {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)}} {{ $asdiskab}}</td></tr>
                                            <tr><td></td><td class="verTop">Golongan</td><td>:</td><td> {{$dt->golongan}}</td></tr>
                                            <tr><td></td><td class="verTop">Tingkat</td><td>:</td><td> {{($dt->tingkat)}}</td></tr>
                                        </Table>
                                    </ol>
                                    @if(count($member)>4)
                                        @if(($loop->index+1)%5 === 0 && ($loop->index+1)<=5)
                                            <div class="page-break"></div>
                                            <div style="margin-left: 70px; width: 100%;">
                                            @php $tamp=0; $tamHtml='</div>'; @endphp
                                        @elseif(($tamp+1)%9 === 0)

                                            @if($tamHtml!='')
                                                @php echo($tamHtml); $tamp=0; $tamHtml=''; @endphp
                                            @endif

                                            <!-- loop member >9 -->
                                            @if($loop->index+1!=count($member))
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
                                    @if($loop->index+1 == count($member) && count($member)>4)
                                        @if($tamHtml!='')
                                            @php echo($tamHtml); @endphp
                                        @endif

                                        <!-- for spaci anggota dan tanda tangan  -->
                                        <!-- @for($a=8-$tamp; $a>0; $a--)
                                            <div style="min-height: 130px;"></div>
                                        @endfor -->
                                    @endif
                                @endforeach
                        </ul>
                        <!-- <div style="min-height: 400px;"></div> -->
                        <br>
                        @if(count($newMember)>4)
                            <div style="margin-left: 70px;">
                        @endif
                        <p style="width: 600px;">
                            Kegiatan tersebut dibebankan pada {{$data->anggaran}} {{$asKab}} Tahun Anggaran {{$tahun}}.
                            <br>
                            Demikian dan atas kebijakan Bapak dihaturkan terima kasih.
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
            <br>
            <!-- <br> -->
            <table class="w100p">
                <tr class="tcenter ">
                    <td colspan="3">
                        <b class="bbottom fz20">
                            SURAT TUGAS<br>
                        </b>
                        Nomor : @php echo($nomorTugas); @endphp
                    </td>
                </tr>
                <br>
                <tr>
                    <td class="w20p">Nama</td><td class="w2p">:</td><td >{{$subPimpinan->nmAnggota}}</td>
                </tr>
                <tr>
                    <td>NIP</td><td>:</td><td> {{$subPimpinan->nip}}</td>
                </tr>
                <tr>
                    <td>Jabatan</td><td>:</td><td>@php echo($subPimpinan->nmJabatan); @endphp {{$asKab}}</td>
                </tr>
                <br>
                <tr class="tcenter ">
                    <td colspan="3">
                        <b class="fz20">MEMERINTAHKAN<br></b>
                    </td>
                </tr>
                <tr>
                    <td class="w20p">Kepada</td><td>:</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="margin-left: 70px;">
                        <ul>
                            <!-- @foreach ($member as $dt)
                                <ol style="list-style: disc;">
                                    <Table>
                                        <tr><td>{{$loop->index+1}}. </td><td>Nama</td><td>: {{$dt->nmAnggota}}</td></tr>
                                        <tr><td></td><td>NIP</td><td>: {{$dt->nip}}</td></tr>
                                        <tr><td></td><td>Jabatan</td><td>: {{$dt->nmJabatan}} {{$asdiskab}}</td></tr>
                                        <tr><td></td><td>Golongan</td><td>: {{$dt->golongan}}</td></tr>
                                        <tr><td></td><td>Tingkat</td><td>: {{($dt->tingkat)}}</td></tr>
                                    </Table>
                                </ol>
                            @endforeach -->
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
                                <ol style="list-style: disc;">
                                    <Table>
                                        <tr><td>{{$loop->index+1}}.   </td><td>Nama</td><td>: {{$dt->nmAnggota}}</td></tr>
                                        <tr><td></td><td>NIP</td><td>: {{$dt->nip}}</td></tr>
                                        <tr><td></td><td>Jabatan</td><td>: {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)}} {{$asdiskab}}</td></tr>
                                        <tr><td></td><td>Golongan</td><td>: {{$dt->golongan}}</td></tr>
                                        <tr><td></td><td>Tingkat</td><td>: {{($dt->tingkat)}}</td></tr>
                                    </Table>
                                </ol>
                                @if(count($member)>4)
                                    @if(($loop->index+1)%5 === 0 && ($loop->index+1)<=5)
                                        <div class="page-break"></div>
                                        @php $tamp=0; @endphp
                                    @elseif(($tamp+1)%8 === 0)
                                        @if($tamHtml!='')
                                            @php $tamp=0; $tamHtml=''; @endphp
                                        @endif

                                        <!-- loop member >9 -->
                                        @if($loop->index+1!=count($member))
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
                        </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <!-- <td class="w20p">Untuk</td> -->
                    <td class="w20p verTop">Untuk <span style="float:right;">:</span></td>
                    <td colspan="2">
                        <p style="text-align: justify;padding: 0px; margin: 0px;max-width:480px;">
                            {{$data->maksud}} pada tanggal
                            {{$textTanggal}}
                            di {{$data->lokasi}}.
                        </p>

                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Kegiatan tersebut dibebankan pada {{$data->anggaran}} {{$asKab}} Tahun Anggaran {{$tahun}}.
                    </td>
                </tr>
                <br>
                @php echo($ttSubSetda); @endphp
            </table>
        </div>
    @endif
</body>
</html>
