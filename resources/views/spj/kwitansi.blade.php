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
        .h30{
            height: 30px;
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
    <div style="border:1px solid black; padding:5px;">
        <table class="fz12">
            <tr>
                <td class="vaTop" style="width: 2%;">
                    <img src="{{url('logo/ksb.png')}}" width="35px">
                </td>
                <!-- <td class="w10p"></td> -->
                <td colspan="3" class="pwrap tcenter mKop w50p">
                    <h2 class=" tupper fz14 noBold pm0 " >
                        PEMERINTAH {{$kab[0]}}<br>
                        <b>{{$kadis['nmDinas']}}</b>
                    </h2>
                    <i  class="pm0 fz10">@php echo($kadis['alamat']); @endphp</i>
                </td>
                <td colspan="2 " class="pwrap mKop fz12 w40p vaTop">
                    <table style="border:0px">
                        <tr>
                            <td>Kode Rekening </td>
                            <td>:</td>
                            <td class="fz10">{{$spj->kdSub.' '.$spj->kdApbd6}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Buku</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No Buku</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr> 
            <tr class="tcenter vaTop" >
                <td colspan="5" style="border-top: 2px solid #404040;">
                    <label class="fz40 tupper">kuitansi</label>
                </td>
            </tr>
            <tr class=" vaTop" >
                <td colspan="4" class="w10p ">
                    <label class="tupper"></label>
                </td> 
            </tr>
            <tr class="h30 vaTop" >
                <td colspan="2" class=" w15p">
                    <label class="tupper">terima dari</label>
                </td>
                <td class="w2p tE">:</td>
                <td class="w60p" colspan="3">
                    <label class="capitalize">Pengguna&nbsp;&nbsp;Anggaran {{strtolower($kadis['nmDinas'].' '.$kab[0])}}</label>
                </td>
            </tr> 
            <tr class="h30" >
                <td colspan="2" class="w10p ">
                    <label class="tupper">banyaknya uang</label>
                </td>
                <td class="tE">:</td>
                <td class="bgaris " colspan="3">
                    <label class="tupper"><b><i>{{$tambahan['terbilang']}}</i></b></label>
                </td>
            </tr> 
            <tr class="h30" >
                <td colspan="2" class="w10p vaTop">
                    <label class="tupper">untuk pembayaran</label>
                </td>
                <td class="tE vaTop">:</td>
                <td class=" " style="text-align: justify;" colspan="3">  
                    <label class=" capitalize">{{$spj->nmApbd6.' '.ucwords(strtolower($nmDinas1)).' '.$kab[0]}}
                        tahun anggaran {{$ta}} kegiatan {{$spj->nmKeg}} <label class="tlower">pada</label> sub kegiatan {{$spj->nmSub}}
                        <label class="tlower">pada</label> {{ucwords(strtolower($kadis['nmDinas'])).' '.$kab[0]}} tahun {{$ta}} 
                        <label class="tlower">sesuai</label> <label class="tupper">SK</label> {{ucwords(strtolower($staf[0][1]->label)).'. '}}
                        A<label class="tlower">n</label> @php echo($tambahan['an']); @endphp <label class="tlower">selama</label> {{ucwords(strtolower($spj->keterangan))}}
                    </label>
                </td>
            </tr>
            <tr class="" >
                <td colspan="4" class="w10p ">
                    <label class="tupper"></label>
                </td> 
            </tr>
            <tr class="h30" style="">
                <td colspan="2 " class="w10p bgaris2">
                    <label class="tupper"><b><i>terbilang</i></b></label>
                </td>
                <td class="tE bgaris2">:</td>
                <td class="bgaris2 " colspan="1">
                    <div style="display:flex; justify-content: space-between;"><label>Rp.</label><label>{{$tambahan['uang']}}</label></div>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <table class="w100p">
                        <tr>
                            <td class="tcenter">
                                <br/>
                                Mengetahui :
                                <br>
                                <b>Pengguna Anggaran</b><br>
                                {{$kadis['asDinas'].' '.$kab[1]}} <br><br>
                                <div class=" ">
                                    @php echo($spaceTT); @endphp
                                    <b><u>{{$kadis['kadis']}}</u></b><br>
                                    NIP. {{$kadis['nip']}}
                                </div>
                            </td>
                            <td class="tcenter ">
                                <br/>
                                Lunas Dibayar,
                                <br>
                                <b>Bendahara Pengeluaran</b><br> <br><br>
                                <div class=" "> 
                                    @php echo($spaceTT); @endphp
                                    <b><u>{{$bend['nmAnggota']}}</u></b><br>
                                    NIP. {{$bend['nip']}}
                                </div>
                            </td>
                            <td class=" tcenter">
                                Taliwang, @php echo($space); @endphp {{$ta}}<br> <br>
                                <b>Yang Menerima Uang</b>,@php echo($spaceTT); @endphp <br><br><br>  
                                <b><u>{{$staf[0][0]->label}}</u></b> <br>
                                {{$tambahan['nipStaf']}}

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