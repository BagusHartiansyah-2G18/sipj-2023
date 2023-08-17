<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
    <style>
        .page-break {
            page-break-after: always;
        }
        .fz12{
            font-size: 12px;
        }
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
        .pwrap{padding: 0px 10px;}
        .tcenter{text-align: center;}
        .fz40{font-size: 40px;}
        .fz30{font-size: 30px;}
        .fz20{font-size: 20px;}
        .bbottom{border-bottom: 1px solid;}

        .capitalize{text-transform: capitalize;}
    </style>
</head>
<body>
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
            <tr>
                <td class="w10p"></td>
                <td class="w60p"></td>
                <td>Taliwang,@php echo($line.$tahun); @endphp </td>
            </tr>
            <br>
            <tr>
                <td>Nomor</td>
                <td>: {{$data->no}}/_____/Bappeda/VIII/2023</td>
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
                    {{$data->maksud}} pada tanggal
                    {{$data->date.' & '.$data->dateE}}
                    di {{$data->lokasi}}.
                    untuk itu mohon diterbitkan SPD atas nama :
                    <br>
                    <ul>
                        @foreach ($member as $dt)
                            <ol style="list-style: disc;">
                                <Table>
                                    <tr><td>{{$loop->index+1}}.   </td><td>Nama</td><td>: {{$dt->nmAnggota}}</td></tr>
                                    <tr><td></td><td>NIP</td><td>: {{$dt->nip}}</td></tr>
                                    <tr><td></td><td>Jabatan</td><td>: {{$dt->nmJabatan}} {{$asdiskab}}</td></tr>
                                    <tr><td></td><td>Golongan</td><td>: {{$dt->golongan}}</td></tr>
                                    <tr><td></td><td>Tingkat</td><td>: {{($dt->tingkat)}}</td></tr>
                                </Table>
                            </ol>
                        @endforeach
                    </ul>
                    <br>
                    Kegiatan tersebut dibebankan pada {{$data->anggaran}} {{$asdiskab}} Tahun Anggaran {{$tahun}}.
                    <br>
                    Demikian dan atas kebijakan Bapak dihaturkan terima kasih.
                </td>
            </tr>
            <br>
            <br>
            <tr class="tcenter">
                <td class="w10p"></td>
                <td class="w60p"></td>
                <td>
                    {{$pimpinan->nmJabatan." ".$asDinas}}<br>
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
                    Nomor : 800.1.11.1/_____/VIII/{{$tahun}}
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
                <td>Jabatan</td><td>: {{$pimpinan->nmJabatan}} {{$asdiskab}}</td>
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
                    <ul>
                        @foreach ($member as $dt)
                            <ol style="list-style: disc;">
                                <Table>
                                    <tr><td>{{$loop->index+1}}. </td><td>Nama</td><td>: {{$dt->nmAnggota}}</td></tr>
                                    <tr><td></td><td>NIP</td><td>: {{$dt->nip}}</td></tr>
                                    <tr><td></td><td>Jabatan</td><td>: {{$dt->nmJabatan}} {{$asdiskab}}</td></tr>
                                    <tr><td></td><td>Golongan</td><td>: {{$dt->golongan}}</td></tr>
                                    <tr><td></td><td>Tingkat</td><td>: {{($dt->tingkat)}}</td></tr>
                                </Table>
                            </ol>
                        @endforeach
                    </ul>
                </td>
            </tr>
            <tr>
                <td class="w20p">Untuk</td>
                <td colspan="2">:
                    {{$data->maksud}} pada tanggal
                    {{$data->date.' & '.$data->dateE}}
                    di {{$data->lokasi}}.
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
                            {{$pimpinan->nmJabatan." ".$asDinas}}<br>
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
