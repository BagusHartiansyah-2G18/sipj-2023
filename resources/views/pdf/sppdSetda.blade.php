<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
    <style>
        
    </style>
    <link rel="stylesheet" href="{{url('css/sf.css')}}" >

</head>
<body class="fzU" style="font-family: Arial, Helvetica, sans-serif;">
    @php
        $spaceTT = '<br><br><br><br>';
        $line ='____________________';
        $titik ='..............................................';
        $br="<br><br><br>";
        $kop='
            <table>
                <tr>
                    <td class="w5p">
                        <img src="/logo/ksb.png" width="60px">
                    </td>
                    <td class="pwrap tcenter mKop w85p">
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
            <table class="fz12 w100p">
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <table class="ml30p" style="padding-right:40px">
                            
                            <tr>
                                <td class="p0">Kode No.</td>
                                <td class="p0" id="titik2">:</td>
                                <td class="p0 ">{{$no}}</td>
                            </tr>
                            <tr>
                                <td class="p0">Nomor</td>
                                <td class="p0" id="titik2">:</td>
                                <td class="p0 "></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="tcenter">
                    <td colspan="3" >
                        <b class="bbottom fz20">
                            SURAT PERJALANAN DINAS
                        </b><br/>
                        <b class="fz20">(S P D)</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" >
                        <table  class="w100p bTabel">
                            <tr>
                                <td class="w5p">1</td>
                                <td class="w40p">Pejabat Pembuat Komitmen</td>
                                <td colspan="2">
                                    <span id="titik2">:</span>
                                        @php
                                            $ub = explode("ub",$jabatanPim);
                                            if(count($ub)>1){
                                                echo(substr($jabatanPim,31)." ".$asDinas);
                                            }else{
                                                echo($jabatanPim." ".$asDinas);
                                            }
                                        @endphp
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Nama/NIP Pegawai yang melaksanakan perjalanan dinas</td>
                                <td colspan="2">
                                    <div class="flexR">
                                        <span id="titik2">:</span>
                                        <label>{{$dt->nmAnggota}} /<br>
                                            {{$dt->snip}}. {{$dt->nip}}
                                        </label>
                                    </div>
                                </td> 
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <ol type="a">
                                        <li>Pangkat dan Golongan</li>
                                        <li>Jabatan/Instansi</li>
                                        <li>Tingkat Biaya Perjalanan Dinas</li>
                                    </ol>
                                </td>
                                <td colspan="2">
                                    <ul>
                                        <li id="addTitik2">a. {{(empty($dt->golongan)?'-':$dt->golongan)}}</li>
                                        <li id="addTitik2">b. {{(strlen($dt->nmJabatan)>15 ? $dt->asJabatan:$dt->nmJabatan)."/".$asDinas}}</li>
                                        <li id="addTitik2">c. {{$dt->tingkat}}</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    Maksud Perjalanan Dinas
                                </td>
                                <td colspan="2">
                                    <div class="flexR">
                                        <span id="titik2">:</span>
                                        <label>{{$data->maksud}}</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    Alat angkut yang dipergunakan
                                </td>
                                <td colspan="2">
                                    <span id="titik2">:</span>{{$data->angkut}}
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
                                        <li><span id="titik2">:</span>{{$data->tempatS}}</li>
                                        <li><span id="titik2">:</span>{{$data->tempatE}}</li>
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
                                <td colspan="2" class="vtop">
                                    <ul>
                                        <li><span id="titik2">:</span>{{$hari}}</li>
                                        <li><span id="titik2">:</span>{{$dateS}}</li>
                                        <li><span id="titik2">:</span>{{$dateE}}</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td >8</td>
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
                                <td ></td>
                                <td>
                                    <ul style="padding: 0px; margin: 0px;">
                                        <li>1.</li>
                                        <li>2.</li>
                                    </ul>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td> Pembebanan Anggaran  </td>
                                <td colspan="2">  </td>
                                
                            </tr>
                            <tr>
                                <td></td>
                                <td> 
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
                                            <li>{{$asDinas." ".$kab}} </li>
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
                <tr class="">
                    <td class="w10p" colspan="2" style="text-align: left; vertical-align: top;"></td>
                    <td >
                        <table class="">
                            <tr>
                                <td class="p0">Dikeluarkan di</td>
                                <td class="p0">:</td>
                                <td class="p0">{{$data->tempatS}}</td>
                            </tr>
                            <tr>
                                <td class="p0">Pada tanggal</td>
                                <td class="p0">:</td>
                                <td class="p0 tend">@php echo($spaci4); @endphp {{$tglCetak}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="">
                    <td class="w10p"></td>
                    <td class="w50p"></td>
                    <td class="capitalize">
                        @php
                            if(count($ub)>1){
                                echo(substr($jabatanPim,31)." ".$asDinas.",");
                            }else{
                                echo($jabatanPim." ".$asDinas.",");
                            }
                            echo($spaceTT);
                        @endphp
                        
                        <!-- <span class="tlower">a.n.</span> Bupati Sumbawa Barat <br> Sekretaris Daerah,<br> @php echo($jabatanPim.' '.$asDinas); @endphp -->
                    </td>
                </tr>
                <tr class="">
                    <td class="w10p"></td>
                    <td class="w50p"></td>
                    <td>
                        @if(count((array) $pimpinan)>2)
                            <u>{{$pimpinan->nmAnggota}}</u><br>
                            <!-- {{$pimpinan->golongan}}<br> -->
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
    <div class=" container">
        <table class="w100p bTabel">
            <tr>
                <td class="w5p"></td>
                <td class="w45p"></td>
                <td>
                    SPD No. <br>
                    <table id="tabelNo">
                        <tr >
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
                            <td>Pada tanggal</td>
                            <td>:</td>
                        </tr>
                    </table>
                    @php echo($br); @endphp
                    (@php echo($titik); @endphp)<br>
                    NIP. <!-- <label style="width: 70px;     border-bottom: 1px dotted black;"></label> -->
                </td>
            </tr>
            <tr>
                <td class="w5p">a</td>
                <td class="w45p">
                    <table border="0"  id="tabelNo">
                        <tr>
                            <td>Tiba di</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Pada tanggal</td>
                            <td>:</td>
                        </tr>
                    </table>
                    @php echo($br); @endphp
                    (@php echo($titik); @endphp)<br>
                    NIP.
                </td>
                <td>
                    <table border="0" id="tabelNo">
                        <tr>
                            <td>Berangkat dari</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Ke</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Pada tanggal</td>
                            <td>:</td>
                        </tr>
                    </table>
                    @php echo($br); @endphp
                    (@php echo($titik); @endphp)<br>
                    NIP.
                </td>
            </tr>
            <tr>
                <td class="w5p">b</td>
                <td class="w45p">
                    <table border="0" id="tabelNo">
                        <tr>
                            <td>Tiba di</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Pada tanggal</td>
                            <td>:</td>
                        </tr>
                    </table>
                    @php echo($br); @endphp
                    (@php echo($titik); @endphp)<br>
                    NIP.
                </td>
                <td>
                    <table border="0" id="tabelNo">
                        <tr>
                            <td>Berangkat dari</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Ke</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Pada tanggal</td>
                            <td>:</td>
                        </tr>
                    </table>
                    @php echo($br); @endphp
                    (@php echo($titik); @endphp)<br>
                    NIP.
                </td>
            </tr>
            <tr>
                <td class="w5p">c</td>
                <td class="w45p">
                    <table border="0" id="tabelNo">
                        <tr>
                            <td>Tiba di</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Pada tanggal</td>
                            <td>:</td>
                        </tr>
                    </table>
                    @php echo($br); @endphp
                    (@php echo($titik); @endphp) <br>
                    NIP.
                </td>
                <td>
                    <table border="0" id="tabelNo">
                        <tr>
                            <td>Berangkat dari</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Ke</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td>Pada tanggal</td>
                            <td>:</td>
                        </tr>
                    </table>
                    @php echo($br); @endphp
                    (@php echo($titik); @endphp) <br>
                    NIP.
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="ml40p">
                        <table border="0" id="tabelNo" class="w100p">
                            <tr>
                                <td class="w40p">Tiba kembali di</td>
                                <td>:</td>
                            </tr>
                            <tr>
                                <td>Pada tanggal</td>
                                <td>:</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p style="text-align: justify; ">
                                        Telah diperiksa dengan keterangan bahwa perjalanan tersebut
                                        diatas benar dilaksanakan atas perintahnya dan semata-mata untuk
                                        kepentingan jabatan dalam waktu yang sesingkat-singkatnya
                                    </p>
                                    <p class="">
                                        <label class="capitalize" >
                                                <!-- <span class="tlower">a.n.</span>
                                                Bupati Sumbawa Barat <br> Sekretaris Daerah,<br>
                                                @php echo($jabatanPim.' '.$asDinas); @endphp -->
                                                <!-- Pejabat Pembuat Komitmen -->
                                                @php
                                                echo($jabatanPim1." ".$asDinas.","); 
                                                @endphp
                                            </label>
                                            @php echo($br); @endphp
                                            <br><br>

                                            @if(count((array) $pimpinan)>2)
                                                {{$pimpinan->nmAnggota}}<br>
                                                <!-- {{$pimpinan->golongan}}<br> -->
                                                NIP. {{$pimpinan->nip}}
                                            @else
                                                @php echo($pimpinan->nmAnggota) @endphp
                                            @endif
                                            
                                        </br>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td >d</td>
                <td colspan="2">
                    <label class="tupper">
                        catatan lain - lain
                    </label>
                </td>

            </tr>
            <tr>
                <td >e</td>
                <td colspan="2">
                    <label class="tupper">
                        perhatian
                    </label><br>
                    <p style="text-align: justify;">
                        Pejabat yang berwenang menerbitkan SPPD, pegawai yang melakukan perjalanan  dinas,
                        para pejabat yang mengesahkan tanggal berangkat/tiba serta bendaharawan bertanggung jawab
                        berdasarkan peraturan - peraturan keuangan Negara apabila mendapat rugi akibat kesalahan, Kealpaannya.
                    </p>
                </td>

            </tr>
        </table>
    </div>
    
    <script>
        window.print();
    </script>
</body>
</html>
