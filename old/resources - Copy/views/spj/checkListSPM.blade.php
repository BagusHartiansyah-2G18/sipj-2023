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
            border-top:1px dashed black !important;
            border-bottom:1px dashed black !important;
        }
        .bgaris2{
            border-top:3px double black;
            border-bottom:3px double black;
        }
        .vaTop{
            vertical-align: top;
        }
        td{
            padding:5px 10px;
        }
        .h30{
            height: 30px;
        }
        .btable tr td{
            border:1px solid black;
        }
        .btableNo tr td{
            border:0px solid black;
        }
        .bnone{
            border:0px solid black;
        }
        .txNone{
            text-transform:none;
        }
    </style>
</head>
<body class="fz14" style="font-family: Arial, Helvetica, sans-serif;">
    @php
        $space4 = str_repeat('<br>', 4);
        $space7 = str_repeat('<br>', 7);
        $line ='____________________';
        $space=str_repeat('&nbsp;', 25);
        $space10=str_repeat('&nbsp;', 10);
        $hurup="abcdefghijklmnopqrstupwxyz";
    @endphp
    <div style="padding:5px;">
        <table class="fz12 tupper btable" >
            <tr>
                <td class="w20p">nama skpd </td><td class="w2p" >:</td><td >{{$skpd->nmDinas}}</td>  
            </tr> 
            <tr>
                <td>No / Tgl spm</td><td>:</td><td>{{$noSPM}}</td>  
            </tr>
            <tr>
                <td>nilai</td><td>:</td><td>{{$nilai}}</td>  
            </tr> 
        </table>
        @php echo($space4);  @endphp
        <table class="fz12 tupper btable" >
            <tr>
                <td class="w10p" style="margin:auto;">
                    <div style="display: flex;justify-content: center;">
                        <img src="{{url('logo/ksb.png')}}" width="35px">
                    </div>
                </td>
                <td class="w85p" colspan="3">spp/spm-ls tambahan penghasilan, insentif, honorarium, uang saku, uang transfortasi dan lain- lain yang sejenisnya</td>  
            </tr> 
            @php 
                foreach ($list as $key => $v) {
                    echo("
                        <tr>
                            <td class='tcenter'>".($key+1)."</td>
                            <td class='w10p'></td>
                            <td class='capitalize'>".$v[0]->label."</td>
                            <td class='w10p'></td>  
                        </tr> 
                    ");
                }
            @endphp
            <tr>
                <td colspan="4" >
                    <table class="btableNo txNone w100p"  >
                        <tr>
                            <td class='w20p'>Keterangan</td>
                            <td>: {{"(v)= Lengkap; "}} @php echo($space); @endphp {{"(x)=Tidak Lengkap"}}</td>
                        </tr>
                        
                    </table>    
                </td> 
            </tr> 
            <tr>
                <td colspan="4" >
                    <table class="btableNo txNone w100p" > 
                        <tr>
                            <td class='w20p'>Catatan</td>
                            <td >:</td>
                        </tr>
                    </table>    
                </td> 
            </tr>  
            <tr>
                <td colspan="2" style=" border-right:0px;"></td>
                <td colspan="2" style=" border-left:0px;">
                    <table class="btableNo txNone">
                        <tr>
                            <td>a. Dapat diproses lebih lanjut</td>
                            <td>@php echo("(".$space10.")"); @endphp</td>
                        </tr>
                        <tr>
                            <td>b. Belum dapat diproses</td>
                            <td>@php echo("(".$space10.")"); @endphp</td>
                        </tr>
                    </table>
                    
                </td> 
            </tr>
        </table>
        <br/>
        <br/>
        <div class="tcenter w100p">
            <b><u>Pejabat Penatausahaan Keuangan (PPK)</u></b>
            @php echo($space7); @endphp
            <b>
                {{$ppk->nmAnggota}} <br/>
                NIP {{$ppk->nip}} <br/>
                {{$ppk->asJabatan." ".$skpd->asDinas." ".$kab[1] }} 
            </b>
        </div>
        <hr style="height:3px; background:black;"/>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>