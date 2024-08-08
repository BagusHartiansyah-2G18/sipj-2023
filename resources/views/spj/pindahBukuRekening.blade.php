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
        .pl10{
            padding-left:10px;
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

        .flexSb{
            justify-content: space-between;
            display: flex;
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
                <td>Nomor</td> 
                <td>: 900.1.3/@php echo(str_repeat('&nbsp;', 10)); @endphp /BAPPEDA/{{$tambahan['bulan']}}/{{$ta}}</td>
            </tr>
            <tr class="" >
                <td>Tanggal</td> 
                <td>: {{$tglC}}</td>
            </tr>
            <tr class="" >
                <td>Lampiran</td> 
                <td>: -</td>
            </tr>
            <tr class="tcenter h30" >
                <td colspan="2"> 
                </td>
            </tr>
            <tr class=" h30" >
                <td colspan="2">
                    Kepada Yth.<br/>
                    Branch Manager PT. Bank Ntb Syariah <br/>
                    Cabang Taliwang <br/>
                    di - <br/>
                    @php echo(str_repeat('&nbsp;', 10)); @endphp Tempat
                    <br/><br/>
                </td>
                
            </tr>  
            <tr class="" >
                <td class="flexSb">
                    <label>Perihal</label>
                    <label>:</label>
                </td> 
                <td class="capitalize">Permohonan Pemindahbukuan {{$spj->nmApbd6.' '}} 
                    @php echo(strtolower($kadis['asDinas'])); @endphp {{' '.$kab[0]}},  {{$staf[0][8]->label." ".$bulan." Tahun ".$ta}}
                    <br/><br/>
                </td>
            </tr> 
            <tr class=" h30" >
                <td colspan="2">
                    Bismillahirrahmanirrahim, <br/>
                    Assalamu'alaikum Warahmatullahi Wabarakatuh.
                </td>
            </tr>
            <tr class="h30">
                <td colspan="2">
                    <table class=" w100p">
                        <tr class="">
                            <td class="w5p vaTop tcenter" rowspan="3">1</td>
                            <td class="w10p">Nama</td>
                            <td>: {{$kadis['kadis']}}</td>
                        </tr>
                        <tr class=""> 
                            <td class="w15p">Jabatan</td>
                            <td class="capitalize">: Kepala @php echo(strtolower(explode(" ",$kadis['nmDinas'])[0])); @endphp </td>
                        </tr>
                        <tr class=""> 
                            <td class="w15p vaTop">Alamat</td>
                            <td class="capitalize">: @php echo(explode("Tlp",$kadis['alamat'])[0]); @endphp <br/><br/></td>
                        </tr>
                        
                        <tr class="">
                            <td class="vaTop tcenter" rowspan="3">2</td>
                            <td class=" ">Nama</td>
                            <td class=" ">: {{$bend['nmAnggota']}}</td>
                        </tr>
                        <tr class=""> 
                            <td class=" ">Jabatan</td>
                            <td class="  capitalize">: Bendahara Pengeluaran </td>
                        </tr>
                        <tr class=""> 
                            <td class=" vaTop">Alamat</td>
                            <td class="capitalize">: @php echo(explode("Tlp",$kadis['alamat'])[0]); @endphp  <br/><br/></td>
                        </tr>

                        <tr class="">
                            <td class="vaTop " colspan="3">Dengan ini mohon dipindahbukukan dari :</td>
                        </tr>

                        <tr class="">
                            <td class="vaTop tcenter" rowspan="4"></td>
                            <td class=" ">Rekening Giro</td>
                            <td class=" ">: 017.21.00017.02.5</td>
                        </tr>
                        <tr class=""> 
                            <td class=" ">Atas Nama</td>
                            <td class="  capitalize">: {{$kadis['asDinas']}} </td>
                        </tr>
                        <tr class=""> 
                            <td class=" ">Sebesar</td>
                            <td class=" tbold">: Rp. {{$tambahan['allTerima']}}</td>
                        </tr>
                        <tr class=""> 
                            <td class=" ">Terbilang</td>
                            <td class="capitalize ">: {{$tambahan['terbilang']}} </td>
                        </tr>

                        <tr class="">
                            <td class="vaTop " colspan="3">Ke masing-masing rekening berikut : <br/><br/></td>
                        </tr>
                    </table>
                </td> 
            </tr>   
            <tr class=" h30" >
                <td colspan="2">
                    <table class=" w100p border fz12">
                        <tr class="tupper tcenter tbold">
                            <td class="w5p vaTop tcenter">No</td>
                            <td class="w30p">Nomor Rekening</td>
                            <td class="w30p">Uraian</td>
                            <td class="w30p">Jumlah</td>
                        </tr>
                        @php 
                            foreach($staf as $key => $v){
                                echo('
                                    <tr class="tupper">
                                        <td class="w5p vaTop ">'.($key+1).'</td>
                                        <td class="w30p pl10" style="">'.$v[2]->label.'</td>
                                        <td class="w30p pl10 capitalize">'.strtolower($v[3]->label).'</td>
                                        <td class="w30p pl10">Rp. '.$v[(count($staf[$key])-1)].'</td>
                                    </tr>
                                ');
                            }
                        @endphp 
                        <tr class="tupper  tbold">
                            <td class="w5p tE" colspan="3" style="padding-right:5px;">Total</td>
                            <td class="w30p pl10">Rp. {{$tambahan['allTerima']}}</td>
                        </tr>
                    </table>
                </td>
            </tr>  
            <tr class=" h30" >
                <td colspan="2">
                    Demikian yang dapat kami sampaikan, atas perhatian dan kerjasamanya disampaikan terima kasih.
                    <br/>
                    <br/>
                    Wassalamu'alaikum Warahmatullahi Wabarakatuh,
                </td>
            </tr> 
            <tr>
                <td colspan="5">
                    <table class="w100p">
                        <tr>
                            <td class="tcenter w30p">  
                                Kepala {{$kadis['asDinas']}} 
                                <div class=" ">
                                    @php echo($spaceTT); @endphp
                                    <b><u>{{$kadis['kadis']}}</u></b><br>
                                    NIP. {{$kadis['nip']}}
                                </div>
                            </td>
                            <td class="tcenter w30p"></td>
                            <td class="tcenter ">  
                                Bendahara Pengeluaran, 
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