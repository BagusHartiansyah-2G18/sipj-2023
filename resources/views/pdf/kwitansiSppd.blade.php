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
        .right{
            width: 100%;
            margin-left: 60%;
        }
        .tcenter{text-align: center;}
        .fz40{font-size: 40px;}
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


    @foreach ($data as $dt)
        <div class=" container">
            <div class="right">
                <table border="1" class="fz12" width="300px">

                    <tr>
                        <td class="w50p">Nomor Rekening</td>
                        <td>{{$noRek}}</td>
                    </tr>
                    <tr>
                        <td>Dibukukan Tanggal</td>
                        <td>{{$dibukukan}}</td>
                    </tr>
                    <tr>
                        <td>Nomor Buku</td>
                        <td>{{$noBuku}}</td>
                    </tr>
                </table>
            </div>
            <table  class="fz12 w100p ">

                <tr>
                    <td class="w20p"></td>
                    <td class="w2p"></td>
                    <td class="fz40"><b class="bbottom">KWITANSI</b></td>
                </tr>
                <tr>
                    <td>TERIMA DARI</td>
                    <td>:</td>
                    <td>{{$terimaDari}}</td>
                </tr>
                <tr>
                    <td>BANYAKNYA UANG</td>
                    <td>:</td>
                    <td><b class="capitalize">{{(strlen($textTotal[$loop->index])===7? '-': $textTotal[$loop->index])}}</b></td>
                </tr>
                <tr>
                    <td>UNTUK PEMBAYARAN</td>
                    <td>:</td>
                    <td>
                        <p style="text-align: justify;">
                            {{
                                $uraian." ke ".
                                $tujuan." An. ".
                                $dt->nmAnggota." jabatan ".
                                $dt->nmJabatan." ".
                                ($dt->status==='bidang' || $dt->status==='kabid'?$dt->nmBidang." ":"").
                                $asDinas." ".
                                " pada Kegiatan ".
                                $keg." ".
                                " pada Sub Kegiatan ".
                                $sub." "
                            }}
                        </p>
                        <br><br>
                        <table >
                            <tr>
                                <td>sesuai SPPD No.</td>
                                <td>{{$no}} Tanggal :</td>
                                <td>{{$tglSppd}}</td>
                                <td>dengan perincian sbb :</td>
                            </tr>
                            <br>
                            @php
                                $num = 1;
                                $totalSubJenis = 0;
                                $totalJenis = 0;
                                $totalPerJenis=array();
                            @endphp
                            @foreach ($dt->ddukung as $dt1)
                                @php
                                    $totalSubJenis = 0;
                                @endphp
                                @foreach ($dt1->uraian as $dt2)
                                    <tr>
                                        <td colspan="2">{{$num.". ".$dt2->uraian." ".$dt->tingkat." (".$dt2->volume." x ".$dt2->satuan.")"}}</td>
                                        <td>{{ number_format($dt2->nilai,0,',','.')}}</td>
                                        <td>Rp. {{number_format(($dt2->nilai*$dt2->volume),0,',','.')}}</td>
                                    </tr>
                                    @php
                                        $num += 1;
                                        $totalSubJenis +=$dt2->nilai*$dt2->volume;
                                    @endphp
                                @endforeach
                                @php
                                    $totalPerJenis[$loop->index]=$totalSubJenis;
                                    $totalJenis+=$totalSubJenis;
                                @endphp
                            @endforeach
                            <tr>
                                <td colspan="3">Jumlah</td>
                                <td>Rp. {{number_format($totalJenis,0,',','.')}}</td>
                            </tr>
                        </table>

                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>TERBILANG</td>
                    <td>:</td>
                    <td>RP. {{number_format($totalJenis,0,',','.')}}</td>
                </tr>
                <br>
                <tr>
                    <td colspan="3">
                        <table class="w100p" >
                            <tr>
                                <td class="w30p tcenter">
                                    MENGETAHUI / MENYETUJU <br>
                                    Pengguna Anggaran @php echo($spaceTT); @endphp
                                    {{$kaban}} <br>
                                    NIP. {{$nipKaban}}
                                </td>
                                <td class="w30p tcenter">
                                    LUNAS DIBAYAR <br>
                                    Bendahara @php echo($spaceTT); @endphp
                                    {{$bendahara}} <br>
                                    NIP. {{$nipBendahara}}
                                </td>
                                <td class="w30p tcenter">
                                    Taliwang, @php echo($line); @endphp {{$tahun}}<br>
                                    Yang Menerima Uang, @php echo($spaceTT); @endphp
                                    {{$dt->nmAnggota}} <br>
                                    NIP. {{$dt->nip}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <br>
                <tr>
                    <td colspan="3" class="tcenter fz20">
                        RINCIAN BIAYA PERJALANAN DINAS
                    </td>
                </tr>
                <br>
                <tr>
                    <td>Lampiran SPPD Nomor</td>
                    <td>:</td>
                    <td>{{$noSppd}}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{$tglSppd}}</td>
                </tr>
                <tr>
                    <td colspan="3" border="0">
                        <table class="w100p" border="1">
                            <tr>
                                <td class="w2p">No</td>
                                <td class="w30p">PERINCIAN BIAYA</td>
                                <td class="w30p">JUMLAH</td>
                                <td class="w30p">KETERANGAN</td>
                            </tr>
                            @foreach ($dt->ddukung as $dt1)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$dt1->nmDP}}</td>
                                    <td>Rp. {{number_format($totalPerJenis[$loop->index],0,',','.')}}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <br>
                <tr>
                    <td colspan="3">
                        <table class="w100p">
                            <tr>
                                <td class="w50p ">
                                    <br>
                                    Telah dibayarkan uang sebesar <br>
                                    Rp. {{number_format($totalJenis,0,',','.')}} <br><br>
                                    <div class="tcenter w50p">
                                        Bendahara Pengeluaran,@php echo($spaceTT); @endphp
                                        {{$bendahara}} <br>
                                        NIP. {{$bendahara}}
                                    </div>
                                </td>
                                <td class="w50p tcenter">
                                    Taliwang, @php echo($line); @endphp {{$tahun}}<br>
                                    Telah Menerima Uang Sebesar, <br>
                                    Rp. {{number_format($totalJenis,0,',','.')}} <br><br>
                                    Yang Menerima Uang,@php echo($spaceTT); @endphp
                                    {{$dt->nmAnggota}} <br>
                                    NIP. {{$dt->nip}}

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" >
                        <hr><br>
                        PERHITUNGAN RAMPUNG SPPD <br>
                        <table>
                            <tr>
                                <td>Ditetapkan sejumlah</td>
                                <td>:</td>
                                <td>Rp. {{number_format($totalJenis,0,',','.')}}</td>
                            </tr>
                            <tr>
                                <td>Yang telah dibayarkan semua</td>
                                <td>:</td>
                                <td>Rp. -</td>
                            </tr>
                            <tr>
                                <td>Sisa kurang / lebih</td>
                                <td>:</td>
                                <td>Rp. {{number_format($totalJenis,0,',','.')}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="w100p">
                        <div class="right">
                            <div class="w30p tcenter">
                                Mengetahui <br>
                                Kepala {{$asDinas}} <br>
                                {{$asKab}} @php echo($spaceTT); @endphp

                                {{$kaban}} <br>
                                NIP. {{$nipKaban}}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        @if($loop->index!=(count($data)-1))
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
