<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title> 
    <link rel="stylesheet" href="{{url('css/sf.css')}}" >

</head>
<body class="fzU" style="font-family: Arial, Helvetica, sans-serif;">
    @php
        $spaceTT = '<br><br><br><br><br>';
        $line ='____________________';
        $space=str_repeat('&nbsp;', 25);
        $hurup="abcdefghijklmnopqrstupwxyz";
    @endphp


    @foreach ($data as $dt)
        <div class=" container w100p">
            <div style="display:grid; justify-content: end;">
                <table  class="fz12 bTabel" >

                    <tr>
                        <td class="">Nomor Rekening</td>
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
            <table  class="fz12 w100p " style="border-collapse: collapse;"> 
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
                    <td class="tdB"><b class="capitalize"><i>{{(strlen($textTotal[$loop->index])===7? '-': $textTotal[$loop->index])}}</i></b></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">UNTUK PEMBAYARAN</td>
                    <td style="vertical-align: top;">:</td>
                    <td>
                        <p style="text-align: justify;" class="pm0">
                            {{
                                "Biaya ".substr($uraian,7)." ke ".
                                $tujuan." An. ".
                                $dt->nmAnggota." jabatan ".
                                $dt->nmJabatan." ".
                                ($dt->status==='bidang' || $dt->status==='kabid'?$dt->nmBidang." ":"").
                                $asDinas." ".
                                " pada Kegiatan ".
                                $keg." ".
                                " pada Sub Kegiatan ".
                                $sub." ".
                                "pada ".ucwords(strtolower($dinas)).
                                " Tahun Anggaran ".$tahun
                            }}
                        </p>
                        <!-- <br> -->

                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <table >
                            <tr>
                                <td>sesuai SPPD No. {{$no}} {{$dt->noSPPD}}</td>
                                <td colspan="2" style="text-align: right;"> Tanggal :</td>
                                <td >{{$tglSppd}}</td>
                                <td>dengan perincian sbb :</td>
                            </tr>
                            <!-- <br> -->
                            @php
                                $num = 1;
                                $totalSubJenis = 0;
                                $totalJenis = 0;
                                $totalPerJenis=array();
                            @endphp
                            @foreach ($dt->ddukung as $ind1 => $dt1)
                                @php
                                    $totalSubJenis = 0;
                                @endphp
                                @foreach ($dt1->uraian as $ind2 => $dt2)
                                    <tr>
                                        <td colspan="2">{{$hurup[$num-1].". ".$dt2->uraian." ".( $ind1 == 0 ? $dt->tingkat:'')}}</td>
                                        <td>{{($dt2->volume > 1 || $dt1->kdDP !="dp-2" ? " (".$dt2->volume." x ".$dt2->satuan.")":"")}}</td>
                                        <td style="text-align: center;">{{number_format($dt2->nilai,0,',','.')}}</td>
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
                                <td colspan="5"><hr></td>
                            </tr>
                            <tr>
                                <td colspan="4">Jumlah</td>
                                <td>Rp. {{number_format($totalJenis,0,',','.')}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>TERBILANG</td>
                    <td>:</td>
                    <td ><b>Rp. {{number_format($totalJenis,0,',','.')}}</b></td>
                </tr>
                <tr>
                    <td colspan="3"><br></td>
                </tr> 
                <tr>
                    <td colspan="3">
                        <table class="w100p" >
                            <tr>
                                <td class="w30p tcenter">
                                    MENGETAHUI / MENYETUJUI <br>
                                    Pengguna Anggaran @php echo($spaceTT); @endphp
                                    <b><u>{{$kaban}}</u></b> <br>
                                    NIP. {{$nipKaban}}
                                </td>
                                <td class="w30p tcenter">
                                    LUNAS DIBAYAR <br>
                                    Bendahara @php echo($spaceTT); @endphp
                                    <b><u>{{$bendahara}}</u></b> <br>
                                    NIP. {{$nipBendahara}}
                                </td>
                                <td class="w30p tcenter">
                                    Taliwang, @php echo($space); @endphp {{$tahun}}<br>
                                    Yang Menerima Uang, @php echo($spaceTT); @endphp
                                    <b><u>{{$dt->nmAnggota}}</u></b><br>
                                    {{$dt->snip}}. {{$dt->nip}}
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
                    <td>{{$no}} {{$dt->noSPPD}}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{$tglSppd}}</td>
                </tr>
                <tr>
                    <td colspan="3"  >
                        <table class="w100p bTabel">
                            <tr>
                                <td class="w2p">No</td>
                                <td class="w30p tcenter">PERINCIAN BIAYA</td>
                                <td class="w30p tcenter">JUMLAH</td>
                                <td class="w30p tcenter">KETERANGAN</td>
                            </tr>
                            @foreach ($dt->ddukung as $dt1)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$dt1->nmDP}}</td>
                                    <td>
                                        <label>Rp. </label>
                                        <label style="float: right;">{{number_format($totalPerJenis[$loop->index],0,',','.')}}</label>
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td><b>JUMLAH</b></td>
                                <td>
                                    <label>Rp. </label>
                                    <label style="float: right; font-weight: bold;">{{number_format($totalJenis,0,',','.')}}</label>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <br>
                <tr> 
                    <td colspan="3">
                        <table class="w100p">
                            <tr>
                                <td class="w30p ">
                                    <br>
                                    Telah dibayarkan uang sebesar <br>
                                    Rp. {{number_format($totalJenis,0,',','.')}}<br><br>
                                    <div class="tcenter w50p">
                                        Bendahara Pengeluaran,@php echo($spaceTT); @endphp
                                        <b><u>{{$bendahara}}</u></b><br>
                                        NIP. {{$nipBendahara}}
                                    </div>
                                </td>
                                <td class="w30p"></td>
                                <td class="w30p tcenter">
                                    Taliwang, @php echo($space); @endphp {{$tahun}}<br>
                                    Telah Menerima Uang Sebesar, <br>
                                    Rp. {{number_format($totalJenis,0,',','.')}}<br><br>
                                    <!-- Rp. {{number_format($totalJenis,0,',','.')}} <br><br> -->
                                    Yang Menerima Uang,@php echo($spaceTT); @endphp
                                    <b><u>{{$dt->nmAnggota}}</u></b> <br>
                                    {{$dt->snip}}. {{$dt->nip}}

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
                                <td>Yang telah dibayarkan semula</td>
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
                    <td colspan="3" >
                        <table class="w100p">
                            <tr>
                                <td class="w30p "> 
                                </td>
                                <td class="w30p"></td>
                                <td class="w30p tcenter">
                                    Mengetahui <br>
                                    Kepala {{$asDinas}} <br>
                                    {{$asKab}} @php echo($spaceTT); @endphp

                                    <b><u>{{$kaban}}</u></b> <br>
                                    NIP. {{$nipKaban}}
                                </td>
                            </tr>
                        </table> 
                    </td>
                </tr>
            </table>
        </div>
        @if($loop->index!=(count($data)-1))
            <div class="page-break"></div>
        @endif
    @endforeach

    <script>
        window.print();
    </script>
</body>
</html>
