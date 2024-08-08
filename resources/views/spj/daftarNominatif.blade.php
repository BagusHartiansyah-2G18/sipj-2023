<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
    <style>
        .page-break {
            page-break-after: always;
        }
        .fz12{font-size: 12px;}
        .fz14{ font-size: 14px;}

        .w100p{width: 100%;}
        .w85p{width: 85%;}
        .w70p{width: 70%;}
        .w60p{width: 60%;}
        .w50p{width: 50%;}
        .w45p{width: 45%;}
        .w40p{width: 40%;}
        .w30p{width: 30%;}
        .w20p{width: 20%;}
        .w15p{width: 15%;}
        .w10p{width: 10%;}
        .w7p{width: 7%;}
        .w5p{width: 5%;}
        .w2p{width: 2%;}
        .pm0{padding: 0px; margin: 0px;}
        .container{
            margin: 0 auto;
            display: block;
            /* display: flex;
            flex-direction: column; */
        }
        table{
            box-sizing: 1.5px;
        }
        .tdB{
            border: 1px solid black; padding-left: 10px;
        }
        .right{
            width: 100%;
            margin-left: 60%;
        }
        
        .fz40{font-size: 40px;}
        .fz20{font-size: 20px;}
        .fz15{font-size: 15px;}
        .fz12{font-size: 12px;}
        .fz10{font-size: 10px;}
        .fz8{font-size: 8px;}
        .bbottom{border-bottom: 1px solid;}

        .capitalize{text-transform: capitalize;}
        .tupper{text-transform: uppercase;}
        .tlower{text-transform: lowercase;}
        .tS{text-align: left;}
        .tE{text-align: end;}
        .tcenter{text-align: center;}
        .bgaris{
            border-top:1px dashed black;
            border-bottom:1px dashed black;
        }
        .bgaris2{
            border-top:3px double black;
            border-bottom:3px double black;
        }
        .vaTop{
            vertical-align: top;
        }
        tr{
            padding: 10px;
        }
        .h30{ height: 30px; }
        .h50{ height: 50px; }
        .h70{ height: 70px; }
        .border{
            border:1px solid black;  
        } 
        .border td{
            border:1px solid black;  
        }
        .justify{
          text-align:justify;  
        }
        .tbold{
            font-weight: bold;
        }
    </style>
</head>
<body class="fz14" style="font-family: Arial, Helvetica, sans-serif;">
    @php
        $spaceTT = '<br><br><br><br><br>';
        $line ='____________________';
        $space=str_repeat('&nbsp;', 25);
        $hurup="abcdefghijklmnopqrstupwxyz";
    @endphp
    <div >
        <table style="">
            <tr>
                <td class="w5p">
                    <img src="{{url('logo/ksb.png')}}" width="60px">
                </td>
                <!-- <td class="w10p"></td> -->
                <td   class="pwrap tcenter mKop w85p">
                    <h2 class=" tupper fz20 noBold pm0 " >
                        PEMERINTAH {{$kab[0]}}<br>
                        <b>{{$kadis['nmDinas']}}</b>
                    </h2>
                    <i style="font-size: small;" class="pm0">@php echo($kadis['alamat']); @endphp</i>
                </td>
                 
            </tr> 
            <tr class="tcenter " >
                <td colspan="2" class="bgaris2"> 
                </td>
            </tr> 
            <tr class="tcenter h30" >
                <td colspan="2"> 
                </td>
            </tr> 
            <tr class="" >
                <td colspan="2">
                <!-- justify -->
                    <label class="  tupper tcenter w100p" style="display:inline-block" >Daftar nominatif {{$spj->nmApbd6.' '.$nmDinas1.' '.$kab[0]}}
                        tahun anggaran {{$ta}} kegiatan {{$spj->nmKeg}} pada sub kegiatan {{$spj->nmSub}}
                        pada {{$kadis['nmDinas'].' '.$kab[0]}} tahun {{$ta}} sesuai SK {{$staf[0][1]->label.' '}}
                        @php echo($tambahan['an']); @endphp selama {{$spj->keterangan}}
                    </label>
                </td> 
            </tr>
            <tr class="tcenter h30" >
                <td colspan="2"> 
                </td>
            </tr> 
            <tr class="h30">
                <td colspan="2">
                    <table class="border w100p fz12" style="border-collapse: collapse;">
                        <tr class="tcenter">
                            <td class="w5p">No</td>
                            <td class="w17p">Nama</td>
                            <td class="w17p">Kedudukan Dalam Kegiatan</td>
                            <td colspan="4">Besaran Belanja Jasa / Bulan (RP)</td>
                            <td class="w7p">Total</td>
                            <td class="w10p">PPH 21 (5%)</td>
                            <td class="w15p">Zakat (2.5%)</td>
                            <td class="w10p">Jumlah Terima</td>
                        </tr>
                        <tr class="tcenter tbold">
                            <td>(1)</td>
                            <td>(2)</td>
                            <td>(3)</td>
                            <td colspan="4">(4)</td>
                            <td>(5)</td>
                            <td>(6)</td>
                            <td>(7)</td>
                            <td>(8)</td>
                        </tr>
                        @php
                            foreach ($staf as $key => $v) {
                                echo("
                                    <tr class='h70 tcenter'>
                                        <td>".($key+1)."</td>
                                        <td class='tS'>".$v[0]->label."</td>
                                        <td>".$v[7]->label."</td>

                                        <td>".$spj->totVol."</td>
                                        <td>x</td>
                                        <td>".number_format($v[4]->label,0,',','.')."</td>
                                        <td>".$v[9]->label."</td> 
                                        <td>".$tambahan['uang']."</td>
                                        <td>".$tambahan['pph']."</td>
                                        <td>".$tambahan['zakat']."</td>
                                        <td>".$tambahan['terima']."</td>
                                    </tr>
                                ");
                            }
                        @endphp 
                        <tr class="tcenter tbold">
                            <td colspan="7"  class="tupper"><b>Total</b></td>
                             
                            <td class="tE"  style="padding-right:5px;">{{$tambahan['allUang']}}</td>
                            <td class="tE"  style="padding-right:5px;">{{$tambahan['allpph']}}</td>
                            <td class="tE"  style="padding-right:5px;">{{$tambahan['allzakat']}}</td>
                            <td class="tE"  style="padding-right:5px;">{{$tambahan['allTerima']}}</td>
                             
                        </tr>
                    </table>
                </td> 
            </tr>  
            <tr class="tcenter h30" >
                <td colspan="2"> 
                </td>
            </tr> 
            <tr>
                <td colspan="5">
                    <table class="w100p">
                        <tr>
                            <td class="tcenter w30p">
                                <br/>
                                Mengetahui,
                                <br>
                                Pengguna Anggaran {{$kadis['asDinas']}}
                                <br>{{$kab[0]}} <br><br>
                                <div class=" ">
                                    @php echo($spaceTT); @endphp
                                    <b><u>{{$kadis['kadis']}}</u></b><br>
                                    NIP. {{$kadis['nip']}}
                                </div>
                            </td>
                            <td class="tcenter w30p"></td>
                            <td class="tcenter ">
                                Taliwang, @php echo($space); @endphp {{$ta}}
                                <br/> 
                                <br> 
                                Bendahara,<br> <br><br>
                                <div class=" "> 
                                    @php echo($spaceTT); @endphp
                                    <b><u>{{$bend['nmAnggota']}}</u></b><br>
                                    NIP. {{$bend['nip']}}
                                </div>
                            </td>
                             
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>