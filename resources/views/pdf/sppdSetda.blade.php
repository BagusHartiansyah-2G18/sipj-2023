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

        .w20px{width: 20px;}

        .container{
            margin: 0 auto;
            display: block;
            width: 90%;
            /* display: flex;
            flex-direction: column; */
        }
        table{
            box-sizing: 1.5px;
        }
        #tabelNo{

        }
        #tabelNo td{
            padding: 0;
            margin: 0;
        }
        td{
            padding: 5px;
        }
        .pm0{padding: 0px; margin: 0px;}
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
        .tupper{text-transform: uppercase;}
        .tlower{text-transform: lowercase;}
        .pwrap{padding: 0px 30px;}
        .tcenter{text-align: center;}
        .tend{text-align: right;}
        .fz40{font-size: 40px;}
        .fz30{font-size: 30px;}
        .fz25{font-size: 25px;}
        .fz20{font-size: 20px;}
        .bbottom{border-bottom: 1px solid;}

        .capitalize{text-transform: capitalize;}
        .noBold{font-weight: normal;}
        .vtop{
            vertical-align: top;
        }
    </style>
</head>
<body class="fz14" style="font-family: Arial, Helvetica, sans-serif;">
    @php
        $spaceTT = '<br><br><br><br>';
        $line ='____________________';
        $titik ='..............................................';
        $br="<br><br><br>";
        $kop='
            <table>
                <tr>
                    <td class="w30p">
                        <img src="logo/ksb.png" width="60px">
                    </td>
                    <td class="pwrap tcenter mKop">
                        <h2 class=" tupper fz20 noBold pm0 " >
                            PEMERINTAH '.$kab.'<br>
                            <b>'.$dinas.'</b>
                        </h2>
                        <i style="font-size: small;" class="pm0">'.$alamat.'</i>
                    </td>
                </tr>
            </table>
        ';
        $spaci4='&nbsp;&nbsp;&nbsp;&nbsp;';
    @endphp

    @foreach ($member as $dt)
        <div class=" container">
            @php echo($kop); @endphp
            <hr>
            <br>
            <!-- <br> -->
            <table class="fz12" class="w100p">
                <tr>
                    <td colspan="3">
                        <div class="right">
                            <table class="w40p">
                                <tr>
                                    <td class="p0">Lembar Ke</td>
                                    <td class="p0">:</td>
                                </tr>
                                <tr>
                                    <td class="p0">Kode No.</td>
                                    <td class="p0">:  {{$no}}</td>
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
                            SURAT PERJALANAN DINAS
                        </b>
                        <b class="fz20">(SPD)</b>
                    </td>
                </tr>
                <br>
                <tr>
                    <td colspan="3" >
                        <table border="1" class="w100p">
                            <tr>
                                <td class="w5p">1</td>
                                <td class="w40p">Pejabat Pembuat Komitmen</td>
                                <td colspan="2">
                                        @php
                                            $ub = explode("ub",$jabatanPim);
                                            if(count($ub)>1){
                                                echo(substr($jabatanPim,31)." ".$asDinas);
                                            }else{
                                                echo($jabatanPim." ".$asDinas);
                                            }
                                        @endphp
                                        {{$kab}}
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Nama / NIP Pegawai yang Melaksanakan Perjalanan Dinas</td>
                                <td colspan="2">
                                    {{$dt->nmAnggota}}<br>
                                    {{$dt->snip}}. {{$dt->nip}}
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <ul>
                                        <ol type="a">
                                            <li>Pangkat dan Golongan</li>
                                            <li>Jabatan / Instansi</li>
                                            <li>Tingkat Biaya Perjalanan Dinas</li>
                                        </ol>
                                    </ul>
                                </td>
                                <td colspan="2">
                                    <ul>
                                        <ol type="a">
                                            <li>{{(empty($dt->golongan)?'-':$dt->golongan)}}</li>
                                            <li>{{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)." ".$asdiskab}}</li>
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
                                <td colspan="2">
                                    {{$data->maksud}}
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    Alat angkut yang dipergunakan
                                </td>
                                <td colspan="2">
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
                                <td colspan="2">
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
                                            <li>Lama Perjalanan Dinas</li>
                                            <li>Tanggal Berangkat</li>
                                            <li>Tanggal harus Kembali / tiba ditempat baru</li>
                                        </ol>
                                    </ul>
                                </td>
                                <td colspan="2">
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
                                <td rowspan="2">8</td>
                                <td>
                                    Pengikut
                                </td>
                                <td class="tcenter" >
                                    Tanggal Lahir
                                </td>
                                <td class="tcenter" >
                                    Keterangan
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <ul style="padding: 0px; margin: 0px;">
                                        <ol type="none" style="padding: 0px; margin: 0px;">
                                            <li>1.</li>
                                            <li>2.</li>
                                        </ol>
                                    </ul>
                                </td>
                                <td></td>
                                <td></td>
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
                                <td colspan="2">
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
                                <td colspan="2">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <br>
                <tr class="tcenter">
                    <td class="w10p" colspan="2" style="text-align: left; vertical-align: top;">*coret yang tidak perlu</td>
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
                                <td class="p0 tend">@php echo($spaci4); @endphp {{$tglCetak}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <br>
                <tr class="tcenter">
                    <td class="w10p"></td>
                    <td class="w50p"></td>
                    <td style="text-transform: uppercase;">
                        <span class="tlower">a.n.</span> Bupati Sumbawa Barat <br> Sekretaris Daerah,<br> @php echo($jabatanPim.' '.$asDinas); @endphp
                    </td>
                </tr>
                <br>
                <br>
                <br>
                <tr class="tcenter">
                    <td class="w10p"></td>
                    <td class="w50p"></td>
                    <td>
                        @if(count((array) $pimpinan)>2)
                            <u><b>{{$pimpinan->nmAnggota}}</b></u><br>
                            {{$pimpinan->golongan}}<br>
                            NIP. {{$pimpinan->nip}}
                        @else
                            @php echo($pimpinan->nmAnggota) @endphp
                        @endif

                    </td>
                </tr>
            </table>
        </div>
        @if($loop->index!=(count($member)-1))
            <div class="page-break"></div>
        @endif
    @endforeach
    <div class="page-break"></div>
    <table class="w100p" border="1">
        <tr>
            <td class="w50p"></td>
            <td class="w50p">
                <table border="0" id="tabelNo">
                    <tr >
                        <td rowspan="5" class="vtop w20px" >I.</td>
                        <td>Berangkat dari</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>(Tempat kedudukan)</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Ke</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr >
            <td >
                <table class="pm0" border="0"  id="tabelNo">
                    <tr class="pm0">
                        <td rowspan="4" class="w5p vtop w20px">II.</td>
                        <td>Tiba di</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Kepala</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table border="0" id="tabelNo" style="margin-left: 20px;">
                    <tr>
                        <td>Berangkat dari</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Ke</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Kepala</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr >
            <td >
                <table class="pm0" border="0"  id="tabelNo">
                    <tr class="pm0">
                        <td rowspan="4" class="w5p vtop w20px">III.</td>
                        <td>Tiba di</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Kepala</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table border="0" id="tabelNo" style="margin-left: 20px;">
                    <tr>
                        <td>Berangkat dari</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Ke</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Kepala</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr >
            <td >
                <table class="pm0" border="0"  id="tabelNo">
                    <tr class="pm0">
                        <td rowspan="4" class="w5p vtop w20px">IV.</td>
                        <td>Tiba di</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Kepala</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table border="0" id="tabelNo" style="margin-left: 20px;">
                    <tr>
                        <td>Berangkat dari</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Ke</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Kepala</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr >
            <td >
                <table class="pm0" border="0"  id="tabelNo">
                    <tr class="pm0">
                        <td rowspan="4" class="w5p vtop w20px">V.</td>
                        <td>Tiba di</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Kepala</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table border="0" id="tabelNo" style="margin-left: 20px;">
                    <tr>
                        <td>Berangkat dari</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Ke</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Kepala</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr >
            <td >
                <table class="pm0" border="0"  id="tabelNo">
                    <tr class="pm0">
                        <td rowspan="4" class="w5p vtop w20px">VI.</td>
                        <td>Tiba di</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Kepala</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td colspan="2"> @php echo($br); @endphp
                            (@php echo($titik); @endphp)<br>
                            NIP.
                        </td>
                    </tr>
                </table>
            </td>
            <td class="vtop">
                    Telah diperiksa dengan keterangan bahwa perjalanan tersebut
                    di atas benar dilakukan atas perintahnya dan semata - mata untuk
                    kepentingan jabatan dalam waktu yang sesingkat - singkatnya
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label class="tupper">
                    catatan lain - lain
                </label>
            </td>

        </tr>
        <tr>
            <td colspan="2">
                <label class="tupper">
                    perhatian
                </label><br>
                <p style="text-align: justify;">
                    PPK yang menerbitkan SPPD, pegawai yang melakukan perjalanan dinas,
                    para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggung jawab
                    berdasarkan peraturan - peraturan keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian dan kealpaannya.
                </p>
            </td>

        </tr>
    </table>
</body>
</html>
