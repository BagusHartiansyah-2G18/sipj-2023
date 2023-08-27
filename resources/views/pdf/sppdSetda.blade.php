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
        table{
            box-sizing: 1.5px;
        }
        td{
            padding: 5px;
        }
        .p0{padding: 0px;}
        .right{
            width: 100%;
            margin-left: 60%;
        }
        ul{
            padding: 0px;
            margin: 0px;
        }
        ol{
            padding: 0px 0px 0px 20px;
            margin: 0px;
        }
        .pwrap{padding: 0px 10px;}
        .tcenter{text-align: center;}
        .tend{text-align: right;}
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

    @foreach ($member as $dt)
        <div class=" container">
            <table>
                <tr>
                    <td>
                        <div class="w30p"><img src="logo/ksb.png" width="60px"></div>
                    </td>
                    <td>
                        <div class="tcenter pwrap">
                            <h2 style="text-transform: uppercase;">
                                PEMERINTAH {{$kab}}<br>
                                {{$dinas}}<br>
                            </h2>
                            <label style="font-size: medium;"><i>{{$alamat}}</i></label>
                        </div>
                    </td>
                </tr>
            </table>
            <hr>
            <br>
            <!-- <br> -->
            <table class="fz12" class="w100p">
                <tr>
                    <td colspan="3">
                        <div class="right">
                            <table class="w40p">
                                <tr>
                                    <td class="p0">Kode No.</td>
                                    <td class="p0">:  {{$data->no}}</td>
                                </tr>
                                <tr>
                                    <td class="p0">Nomor</td>
                                    <td class="p0">:  </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <br>
                <tr class="tcenter">
                    <td colspan="3" >
                        <b class="bbottom fz20">
                            SURAT PERJALANAN DINAS<br>
                        </b>
                        <b class="fz30">(SPD)</b>
                    </td>
                </tr>
                <br>
                <tr>
                    <td colspan="3" >
                        <table border="1" class="w100p">
                            <tr>
                                <td class="w5p">1</td>
                                <td class="w40p">Pejabat yang Memberi Perintah</td>
                                <td>
                                    <b style="text-transform: uppercase;">
                                        @php echo($jabatanPim); @endphp <br>
                                        <!-- {{$kab}} -->
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Nama/NIP Pegawai yang Melaksanakan Perjalanan Dinas</td>
                                <td>
                                    {{$dt->nmAnggota}}<br>
                                    {{$dt->nip}}
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <ul>
                                        <ol type="a">
                                            <li>Pangkat dan golongan</li>
                                            <li>Jabatan / Instansi</li>
                                            <li>Tingkat Biaya Perjalanan Dinas</li>
                                        </ol>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <ol type="a">
                                            <li>{{(empty($dt->golongan)?'-':$dt->golongan)}}</li>
                                            <li>{{$dt->nmJabatan}}</li>
                                            <li>{{$dt->tingkat}}</li>
                                        </ol>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    Maksud Perjalanan Dinas
                                </td>
                                <td>
                                    {{$data->maksud}}
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    Alat Angkut yang digunakan
                                </td>
                                <td>
                                    {{$data->angkut}}
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>
                                    <ul>
                                        <ol type="a">
                                            <li>Tempat Berangkat</li>
                                            <li>Tempat Tujuan</li>
                                        </ol>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <ol type="a">
                                            <li>{{$data->tempatS}}</li>
                                            <li>{{$data->tempatE}}</li>
                                        </ol>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>
                                    <ul>
                                        <ol type="a">
                                            <li>Lama Perjalanan</li>
                                            <li>Tanggal Berangkat</li>
                                            <li>Tanggal harus Kembali / tiba ditempat baru</li>
                                        </ol>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <ol type="a">
                                            <li>{{$hari}}</li>
                                            <li>{{$dateS}}</li>
                                            <li>{{$dateE}}</li>
                                        </ol>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>
                                    Pengikut
                                    <ul>
                                        <ol type="none">
                                            <li>1.</li>
                                            <li>2.</li>
                                        </ol>
                                    </ul>
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>
                                    Pembebanan Anggaran
                                    <ul>
                                        <ol type="a">
                                            <li>Instansi</li>
                                            <li>Akun</li>
                                        </ol>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <ol type="a">
                                            <li>{{$data->anggaran}}</li>
                                            <li></li>
                                        </ol>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>
                                    Keterangan Lainnya
                                </td>
                                <td>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <br>
                <br>
                <tr class="tcenter">
                    <td class="w10p"></td>
                    <td class="w50p"></td>
                    <td>
                        <table>
                            <tr>
                                <td class="p0">Dikeluarkan di</td>
                                <td class="p0">:</td>
                                <td class="p0">{{$data->tempatS}}</td>
                            </tr>
                            <tr>
                                <td class="p0">Pada Tanggal</td>
                                <td class="p0">:</td>
                                <td class="p0 tend">{{$tglCetak}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <br>
                <tr class="tcenter">
                    <td class="w10p"></td>
                    <td class="w50p"></td>
                    <td style="text-transform: uppercase;">
                        @php echo($jabatanPim); @endphp
                    </td>
                </tr>
                <br>
                <br>
                <br>
                <tr class="tcenter">
                    <td class="w10p"></td>
                    <td class="w50p"></td>
                    <td>
                        {{$pimpinan->nmAnggota}}<br>
                        NIP. {{$pimpinan->nip}}
                    </td>
                </tr>
            </table>
        </div>
        @if($loop->index!=(count($member)-1))
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
