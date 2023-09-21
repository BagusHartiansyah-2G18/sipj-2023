<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
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
        .p0{padding: 0px;}
        .pwrap{padding: 0px 10px;}
        .tcenter{text-align: center;}
        .fz40{font-size: 40px;}
        .fz30{font-size: 30px;}
        .fz25{font-size: 25px;}
        .fz20{font-size: 20px;}
        .bbottom{border-bottom: 1px solid;}

        .capitalize{text-transform: capitalize;}
    </style>
</head>
<body class="fz14">
    @php
        $spaceTT = '<br><br><br><br>';
        $line ='____________________';
    @endphp


    <div class=" container">
        <table>
            <tr>
                <td>
                    <div class="w30p"><img src="logo/ksb.png" width="60px"></div>
                </td>
                <td>
                    <div class="tcenter pwrap">
                        <h2 class="tupper"  class="tcenter fz25">
                            PEMERINTAH {{$kab}}<br>
                            {{$dinas}}<br>
                            <label style="font-size: medium;"><i>{{$alamat}}</i></label>
                        </h2>
                    </div>
                </td>
            </tr>
        </table>
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
                <td>Nomor</td>
                <td>: {{$nomor}}</td>
                <td>Kepada</td>
            </tr>
            <tr>
                <td>Lamp</td>
                <td>: -</td>
                <td>
                    Yth. Bupati Sumbawa Barat<br>
                    di-
                </td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>: <b>Permohonan SPD</b></td>
                <td>
                    Taliwang
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
                            @foreach ($member as $dt)
                                <ol style="list-style: disc;">
                                    <Table>
                                        <tr><td>{{$loop->index+1}}.   </td><td>Nama</td><td>: {{$dt->nmAnggota}}</td></tr>
                                        <tr><td></td><td>NIP</td><td>: {{$dt->nip}}</td></tr>
                                        <tr><td></td><td>Jabatan</td><td >: {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)}} {{$asdiskab}}</td></tr>
                                        <tr><td></td><td>Golongan</td><td>: {{$dt->golongan}}</td></tr>
                                        <tr><td></td><td>Tingkat</td><td>: {{($dt->tingkat)}}</td></tr>
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
                    @if(count($member)>4)
                        <div style="margin-left: 70px;">
                    @endif
                        <p style="width: 650px;">
                            Kegiatan tersebut dibebankan pada {{$data->anggaran}} {{$asdiskab}} Tahun Anggaran {{$tahun}}.
                            <br>
                            Demikian dan atas kebijakan Bapak dihaturkan terima kasih.
                        </p>
                    @if(count($member)>4)
                        </div>
                    @endif
                </td>
            </tr>
            <br>
            <br>
            <tr class="tcenter">
                <td class="w10p"></td>
                <td class="w60p"></td>
                <td>
                    @php echo($jabatanPim.' '.$asDinas); @endphp <br>
                    {{$kab}}
                </td>
            </tr>
            <br>
            <br>
            <br>
            <tr class="tcenter">
                <td class="w10p"></td>
                <td class="w60p"></td>
                <td>
                    {{$pimpinan->nmAnggota}}<br>
                    NIP. {{$pimpinan->nip}}
                </td>
            </tr>
        </table>
    </div>
    <div class="page-break"></div>
    <div class=" container">
        <table>
            <tr>
                <td>
                    <div class="w30p"><img src="logo/ksb.png" width="60px"></div>
                </td>
                <td>
                    <div class="tcenter pwrap">
                        <h2 class="tupper">
                            PEMERINTAH {{$kab}}<br>
                            {{$dinas}}<br>
                            <label style="font-size: medium;"><i>jl. Bung Karno No. 5 Komplek KTC - Taliwang 84355</i></label>
                        </h2>
                    </div>
                </td>
            </tr>
        </table>
        <hr>
        <br>
        <!-- <br> -->
        <table class="fz12" class="w100p">
            <tr class="tcenter ">
                <td colspan="3">
                    <b class="bbottom fz30">
                        SURAT TUGAS<br>
                    </b>
                    Nomor : {{$nomorTugas}}
                </td>
            </tr>
            <br>
            <tr>
                <td class="w20p">Nama</td><td>: {{$pimpinan->nmAnggota}}</td>
            </tr>
            <tr>
                <td>NIP</td><td>: {{$pimpinan->nip}}</td>
            </tr>
            <tr>
                <td>Jabatan</td><td>: @php echo($pimpinan->nmJabatan); @endphp {{$asdiskab}}</td>
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
                        @php $tamp=0; $tamHtml=""; @endphp
                        @foreach ($member as $dt)
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
                <td class="w20p">Untuk</td>
                <td colspan="2">
                    <p style="text-align: justify;padding: 0px; margin: 0px;">
                        : {{$data->maksud}} pada tanggal
                        {{$textTanggal}}
                        di {{$data->lokasi}}.
                    </p>

                </td>
            </tr>
            <tr>
                <td colspan="3">
                    Kegiatan tersebut dibebankan pada {{$data->anggaran}} {{$asdiskab}} Tahun Anggaran {{$tahun}}.
                </td>
            </tr>
            <br>
            <tr>
                <td colspan="3" >
                    <div class="right">
                        <p class="w40p tcenter">
                            @php echo($jabatanPim); @endphp  {{$asDinas}}<br>
                            {{$kab}}
                        </p>
                    </div>
                </td>
            </tr>
            <br>
            <br>
            <tr>
                <td colspan="3" >
                    <div class="right">
                        <p class="w40p tcenter">{{$pimpinan->nmAnggota}}<br>
                        NIP. {{$pimpinan->nip}}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
