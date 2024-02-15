<?php
namespace App\Helper;
use Illuminate\Support\Facades\DB;
class Hdb {
    //users
    function cbUsers($user){
        return DB::table('users')
            ->selectRaw('kdUser as value,name as valueName')
            ->where('kdJaba','<=',$user->kdJaba)
            ->where('kdUser','!=',$user->kdUser)
            ->get();
    }

    // dinas
    function getDinas($user,$tahun){
        $data =[];
        if($user->kdJaba==3){
            $data = DB::table('dinas')
                ->where('taDinas',$tahun)
                ->get();
        }else{
            $data = DB::table('dinas')
                ->where('taDinas',$tahun)
                ->where('kdDinas',$user->kdDinas)
                ->get();
        }
        return $data;
    }
    function getDinasOne($kdDinas,$tahun){
        $data = DB::table('dinas')
                ->where('taDinas',$tahun)
                ->where('kdDinas',$kdDinas)
                ->get();
        return $data[0];
    }
    function getDinasJoined($user,$tahun){
        $data =[];
        if($user->kdJaba==3){
            $data = DB::select('
                    select a.*
                    from dinas a
                    join dinas_bidang b on
                        a.kdDinas=b.kdDinas
                    join psub as c on
                        a.kdDinas = c.kdDinas and
                        b.kdDBidang = c.kdBidang and
                        a.taDinas = c.taSub
                    where a.taDinas="'.$tahun.'"
                    group by
                        a.kdDinas, a.nmDinas, a.asDinas, a.kadis, a.nip, a.taDinas, a.alamat
                ');
        }else{
            $data = DB::table('dinas')
                ->where('taDinas',$tahun)
                ->where('kdDinas',$user->kdDinas)
                ->get();
        }
        return $data;
    }
    function cbDinas(){
        return DB::table('dinas')
            ->selectRaw('kdDinas as value,nmDinas as valueName')
            ->get();
    }
    function dinasAdded($v){
        return DB::insert("
            INSERT INTO `dinas`(
                `kdDinas`, `nmDinas`, `asDinas`, `kadis`, `nip`, `taDinas`
            ) VALUES
            (?,?,?,?,?,?)
        ",$v);
    }

    //bidang
    function getDBidang($v){
        $data = DB::table('dinas_bidang')
                ->selectRaw('kdDBidang,nmBidang,asBidang')
                ->where('kdDinas',$v['kdDinas'])
                ->where('taDBidang',$v['tahun']);
        if(!empty($v['kdBidang'])){
            $data->where('kdDBidang',$v['kdBidang']);
        }
        return $data->get();
    }
    function bidangAdded($kdDinas, $nmBidang, $asBidang, $tahun){
        $getKD=DB::select("
            select kdDBidang+1 as kd from dinas_bidang
            where kdDinas = '".$kdDinas."' and
            taDBidang='".$tahun."'
            ORDER BY cast(kdDBidang as int) desc
            limit 1
        ");
        $kd=1;
        if(count($getKD)!=0){
            $kd = $getKD[0]->kd;
        }
        return DB::insert("
            insert dinas_bidang (kdDBidang, kdDinas, nmBidang, asBidang, taDBidang) values
            (?,?,?,?,?)
        ",[$kd,$kdDinas,$nmBidang,$asBidang,$tahun]);
    }

    //anggota
    function getDAnggota($v){
        $data = DB::table('dinas_b_anggota')
                ->selectRaw('kdBAnggota,nmAnggota,nmJabatan,nip,status,asJabatan,golongan,tingkatan')
                ->where('kdDinas',$v['kdDinas'])
                ->where('kdBidang',$v['kdBidang'])
                ->where('taBAnggota',$v['tahun'])
                ->get();
        return $data;
    }
    function AnggotaAdded(
            $kdDinas, $kdBidang, $nmAnggota, $nmJabatan, $nip, $status, $tahun,
            $asJabatan, $golongan, $tingkat
        ){
        $getKD=DB::select("
            select kdBAnggota+1 as kd from dinas_b_anggota
            where kdDinas = '".$kdDinas."' and
            kdBidang = '".$kdBidang."' and
            taBAnggota='".$tahun."'
            ORDER BY cast(kdBAnggota as int) desc
            limit 1
        ");
        $kd=1;
        if(count($getKD)!=0){
            $kd = $getKD[0]->kd;
        }
        return DB::insert("
        INSERT INTO `dinas_b_anggota`(
                `kdBAnggota`, `kdBidang`, `kdDinas`,
                `nmAnggota`, `nmJabatan`, `nip`, `status`,
                `taBAnggota`,asJabatan,golongan,tingkatan)
            values
            (?,?,?,?,?,?,?,?,?,?,?)
        ",[
            $kd,$kdBidang,$kdDinas,$nmAnggota,
            $nmJabatan, $nip, $status, $tahun,
            $asJabatan, $golongan, $tingkat
        ]);
    }
    function getAllBidangAnggota($v){
        $where ='';
        if(isset($v['status'])){
            $where =$v['status'];
        }
        // if(isset($v['kdBidang'])){
        //     $where =' and a.kdBidang ="'.$v['kdBidang'].'"';
        // }
        return DB::select('
            select
                a.kdBAnggota, a.nmAnggota, a.nmJabatan, a.nip, a.status,
                b.nmBidang, b.asBidang, b.kdDBidang,
                0 as aktif
            from dinas_b_anggota a
            join dinas_bidang b on
                b.kdDBidang = a.kdBidang and
                b.kdDinas = a.kdDinas and
                b.taDBidang = a.taBAnggota
            where a.kdDinas="'.$v['kdDinas'].'" and
                a.taBAnggota="'.$v['tahun'].'"
            order by a.tingkatan asc
        ');
    }
    function getAnggotaJabatan($v){
        $data = DB::table('dinas_b_anggota')
                ->selectRaw('kdBAnggota,nmAnggota,nmJabatan,nip,status,asJabatan,golongan,tingkatan, concat(kdBAnggota,"|",kdBidang,"|",kdDinas) as value ')
                ->where('kdDinas',$v['kdDinas'])
                ->where('taBAnggota',$v['tahun'])
                ->where('status',$v['status'])
                ->get();
        return $data;
    }
    function getOneAnggota($v){
        $data = DB::table('dinas_b_anggota')
                ->selectRaw('kdBAnggota,nmAnggota,nmJabatan,nip,status,asJabatan,golongan,tingkatan')
                ->where('kdDinas',$v['kdDinas'])
                ->where('taBAnggota',$v['tahun'])
                ->where('kdBAnggota',$v['kdBAnggota'])
                ->where('kdBidang',$v['kdBidang'])
                ->get();
        return $data;
    }

    // sub
    function getSubAll($v){
        return DB::select('
            SELECT
                a.kdSub,a.nmSub
                ,b.kdKeg,b.nmKeg
                ,c.kdProg,c.nmProg
                ,d.kdBidang,d.nmBidang
                ,e.kdUrusan,e.nmUrusan
            FROM psub a
                left JOIN pkegiatan b
                    ON a.kdKeg	=b.kdKeg
                    and a.taSub=b.taKeg
                JOIN pprogram c
                    ON b.kdProg 	=c.kdProg
                    and c.taProg=b.taKeg
                JOIN pbidang d
                    ON c.kdBidang		=d.kdBidang
                    and c.taProg=d.taBidang
                JOIN purusan e
                    ON d.kdUrusan		=e.kdUrusan
                    and e.taUrusan=d.taBidang
            WHERE a.kdDinas="'.$v['kdDinas'].'" and a.taSub="'.$v['tahun'].'"
            GROUP BY a.kdSub,a.nmSub,b.kdKeg,b.nmKeg,c.kdProg,c.nmProg ,d.kdBidang,d.nmBidang
                    ,e.kdUrusan,e.nmUrusan
            ORDER BY a.kdSub asc
        ');
        // WHERE a.kdDinas="'.$v['kdDinas'].'" and a.taSub="'.$v['tahun'].'"
    }
    function getSub($v){
        $query = '';
        if(!empty($v['kdBidang'])){
            $query .= ' and a.kdBidang ="'.$v['kdBidang'].'"  ';
        }
        return DB::select('
            SELECT
                a.kdSub, a.kdKeg, a.kdDinas, a.kdBidang, a.nmSub
            FROM psub a
            WHERE a.kdDinas="'.$v['kdDinas'].'" and a.taSub="'.$v['tahun'].'" '.$query.'
            ORDER BY a.kdSub asc
        ');
        // WHERE a.kdDinas="'.$v['kdDinas'].'" and a.taSub="'.$v['tahun'].'"
    }
    //rekening
    function getRekening($v){
        return DB::select('
            SELECT
                a.kdApbd6,a.nmApbd6
                ,b.kdApbd5,b.nmApbd5
                ,c.kdApbd4,c.nmApbd4
                ,d.kdApbd3,d.nmApbd3
                ,e.kdApbd2,e.nmApbd2
                ,f.kdApbd1,f.nmApbd1
            FROM apbd6 a
                left JOIN apbd5 b
                    ON a.kdApbd5	=b.kdApbd5
                    and a.taApbd6=b.taApbd5
                JOIN apbd4 c
                    ON b.kdApbd4 	=c.kdApbd4
                    and c.taApbd4   =b.taApbd5
                JOIN apbd3 d
                    ON c.kdApbd3	=d.kdApbd3
                    and c.taApbd4   =d.taApbd3
                JOIN apbd2 e
                    ON d.kdApbd2	=e.kdApbd2
                    and e.taApbd2   =d.taApbd3
                JOIN apbd1 f
                    ON f.kdApbd1	=e.kdApbd1
                    and e.taApbd2   =f.taApbd1
            where a.taApbd6 ="'.$v['tahun'].'"
            GROUP BY a.kdApbd6,a.nmApbd6
                    ,b.kdApbd5,b.nmApbd5
                    ,c.kdApbd4,c.nmApbd4
                    ,d.kdApbd3,d.nmApbd3
                    ,e.kdApbd2,e.nmApbd2
                    ,f.kdApbd1,f.nmApbd1

            ORDER BY a.kdApbd6 asc
        ');
        // WHERE a.kdDinas="'.$v['kdDinas'].'" and a.taSub="'.$v['tahun'].'"
    }

    //jenis
    function jenisP($kdJPJ=""){
        if(!empty($kdJPJ)){
            return DB::table('jenispj')
                ->where('kdJPJ',$kdJPJ)
                ->get();
        }
        return DB::table('jenispj')
            ->get();
    }
    function jenisAdded($nmJPJ){
        $getKD=DB::select("
            select concat('jp-',substring(kdJPJ,4)+1) as kd from jenispj
                ORDER BY substring(kdJPJ,4) desc
            limit 1
        ");
        $kd='jp-1';
        if(count($getKD)!=0){
            $kd = $getKD[0]->kd;
        }
        return DB::insert("
            insert jenispj (kdJPJ,nmJPJ) values
            (?,?)
        ",[$kd,$nmJPJ]);
    }

    // data dukung
    function jenisDataDukung($v){
        return DB::table('datapendukung')
            ->where('kdJPJ',$v['kdJPJ'])
            ->get();
    }
    function jenisDukungAdded($kdJPJ,$nmDP){
        $getKD=DB::select("
            select concat('dp-',substring(kdDP,4)+1) as kd from datapendukung
            where kdJPJ='".$kdJPJ."'
                ORDER BY substring(kdDP,4) desc
            limit 1
        ");
        $kd='dp-1';
        if(count($getKD)!=0){
            $kd = $getKD[0]->kd;
        }
        return DB::insert("
            insert datapendukung (kdJPJ,kdDP,nmDP) values
            (?,?,?)
        ",[$kdJPJ,$kd,$nmDP]);
    }

    // rincian Belanja
    function getRincian($v){
        return DB::select('
            select
                a.nama, a.total, a.kdJudul, a.kdJenis, a.kdApbd6,
                b.nmJPJ,
                c.nmApbd6,
                d.tw1, d.tw2, d.tw3, d.tw4, d.ada,
                (
                    select sum(a1.volume * a1.nilai)
                    from workuraian a1
                    join work b1 on
                        a1.kdDinas = b1.kdDinas and
                        a1.kdBidang = b1.kdBidang and
                        a1.kdSub = b1.kdSub and
                        a1.taWork = b1.taWork
                    where a1.kdDinas="'.$v['kdDinas'].'" and
                    a1.kdSub = "'.$v['kdSub'].'" and
                    a1.kdBidang = "'.$v['kdBidang'].'" and
                    a1.taWork  = "'.$v['tahun'].'" and
                    b1.status ="final" and
                    b1.kdJudul=a.kdJudul
                ) as realisasi
            from ubjudul a
            join jenispj b on
                a.kdJenis = b.kdJPJ
            join apbd6 c on
                a.kdApbd6 = c.kdApbd6 and
                a.taJudul = c.taApbd6
            left join triwulan d on
                a.kdDinas = d.kdDinas and
                a.kdBidang = d.kdBidang and
                a.kdSub = d.kdSub and
                a.kdJudul = d.kdJudul and
                a.taJudul = d.taJudul
            where a.kdDinas = "'.$v['kdDinas'].'" and
            a.kdSub = "'.$v['kdSub'].'" and
            a.kdBidang = "'.$v['kdBidang'].'" and
            a.taJudul = "'.$v['tahun'].'"
        ');
    }
    function rincianAdded($v){
        $getKD=DB::select('
            select (a.kdJudul+1) as kd from ubjudul a
            where a.kdDinas ="'.$v['kdDinas'].'"  and
            a.kdSub = "'.$v['kdSub'].'" and
            a.kdBidang = "'.$v['kdBidang'].'" and
            a.taJudul = "'.$v['tahun'].'"
            ORDER BY (a.kdJudul+1) desc
            limit 1
        ');
        $kd='1';
        if(count($getKD)>0){
            $kd = $getKD[0]->kd;
        }
        return DB::insert("
            insert ubjudul (kdJudul,kdDinas,kdBidang,kdSub,kdApbd6,taJudul,nama,total,kdJenis) values
            (?,?,?,?,? ,?,?,?,?)
        ",[
            $kd,
            $v['kdDinas'],$v['kdBidang'],$v['kdSub'],$v['kdApbd6'],
            $v['tahun'],$v['nama'],$v['total'],$v['kdJenis']
        ]);
    }
    function triwulanAdded($v){
        return DB::insert("
            insert triwulan (
                kdDinas, kdBidang, kdSub, kdJudul,
                taJudul, tw1, tw2, tw3, tw4
            ) values
            (?,?,?,?,? ,?,?,?,?)
        ",[
            $v['kdDinas'],$v['kdBidang'],$v['kdSub'],$v['kdJudul'],
            $v['tahun'],$v['tw1'],$v['tw2'],$v['tw3'],$v['tw4']
        ]);
    }

    // apbd
    function apbd($v= ''){
        if(!empty($v)){
            return DB::table('apbd6')
                ->where('taApbd6',$v['tahun'])
                ->get();
        }
        return DB::table('apbd6')
            ->where('taApbd6',$v['tahun'])
            ->get();
    }

    // sppd
    function getDataSppd($v){
    //     return print_r('
    //     select
    //         a.kdJudul, a.nama, a.total,
    //         b.kdSub, b.nmSub,
    //         c.tw1, c.tw2, c.tw3, c.tw4,
    //         (
    //             select sum(a1.volume * a1.nilai)
    //             from workuraian a1
    //             join work b1 on
    //                 a1.kdDinas = b1.kdDinas and
    //                 a1.kdBidang = b1.kdBidang and
    //                 a1.kdSub = b1.kdSub and
    //                 a1.taWork = b1.taWork
    //             where a1.kdDinas="'.$v['kdDinas'].'" and
    //             a1.kdSub = "'.$v['kdSub'].'" and
    //             a1.kdBidang = "'.$v['kdBidang'].'" and
    //             a1.taWork  = "'.$v['tahun'].'" and
    //             b1.status ="final" and
    //             b1.kdJudul=a.kdJudul
    //         ) as realisasi
    //     from  ubjudul a
    //     join triwulan c on
    //         a.kdDinas = c.kdDinas and
    //         a.kdBidang = c.kdBidang and
    //         a.kdJudul = c.kdJudul and
    //         a.taJudul = c.taJudul
    //     join psub b on
    //         a.kdSub = b.kdSub and
    //         a.taJudul = b.taSub and
    //         a.kdBidang = b.kdBidang and
    //         a.kdDinas = b.kdDinas
    //     where
    //         a.kdJudul="'.$v['kdJudul'].'" and
    //         a.kdSub="'.$v['kdSub'].'" and
    //         a.kdBidang="'.$v['kdBidang'].'" and
    //         a.kdDinas="'.$v['kdDinas'].'" and
    //         a.taJudul="'.$v['tahun'].'"
    // ');
        return DB::select('
            select
                a.kdJudul, a.nama, a.total,
                b.kdSub, b.nmSub,
                c.tw1, c.tw2, c.tw3, c.tw4,
                (
                    select sum(a1.volume * a1.nilai)
                    from workuraian a1
                    join work b1 on
                        a1.kdDinas = b1.kdDinas and
                        a1.kdBidang = b1.kdBidang and
                        a1.kdSub = b1.kdSub and
                        a1.taWork = b1.taWork
                    where a1.kdDinas="'.$v['kdDinas'].'" and
                    a1.kdSub = "'.$v['kdSub'].'" and
                    a1.kdBidang = "'.$v['kdBidang'].'" and
                    a1.taWork  = "'.$v['tahun'].'" and
                    b1.status ="final" and
                    b1.kdJudul=a.kdJudul
                ) as realisasi
            from  ubjudul a
            left join  triwulan c on
                a.kdDinas = c.kdDinas and
                a.kdBidang = c.kdBidang and
                a.kdJudul = c.kdJudul and
                a.taJudul = c.taJudul
            join psub b on
                a.kdSub = b.kdSub and
                a.taJudul = b.taSub and
                a.kdBidang = b.kdBidang and
                a.kdDinas = b.kdDinas
            where
                a.kdJudul="'.$v['kdJudul'].'" and
                a.kdSub="'.$v['kdSub'].'" and
                a.kdBidang="'.$v['kdBidang'].'" and
                a.kdDinas="'.$v['kdDinas'].'" and
                a.taJudul="'.$v['tahun'].'"
        ');
    }
    function getDataSppdKegiatan($v){
        return DB::select('
            select
                a.kdJudul, a.nama, a.total, a.kdApbd6,
                b.kdSub, b.nmSub,
                c.nmKeg, c.kdKeg,
                d.total as totWork, d.date,d.tujuan, d.tempatE
            from  ubjudul a
            join work d on
                a.kdJudul = d.kdJudul and
                a.kdDinas = d.kdDinas and
                a.kdBidang = d.kdBidang and
                a.taJudul = d.taWork
            join psub b on
                a.kdSub = b.kdSub and
                a.taJudul = b.taSub and
                a.kdBidang = b.kdBidang and
                a.kdDinas = b.kdDinas
            left join pkegiatan c on
                c.kdKeg = b.kdKeg and
                c.taKeg = b.taSub
            where
                a.kdJudul="'.$v['kdJudul'].'" and
                a.kdSub="'.$v['kdSub'].'" and
                a.kdBidang="'.$v['kdBidang'].'" and
                a.kdDinas="'.$v['kdDinas'].'" and
                a.taJudul="'.$v['tahun'].'" and
                d.no="'.$v['no'].'"
                '.$v['where'].'
        ');
    }



    function dwork($v){
        $where = '';
        if(isset($v['kdDinas'])){
            $where.=' where a.kdDinas="'.$v['kdDinas'].'"';
        }
        if(isset($v['kdBidang'])){
            $where.=' and a.kdBidang="'.$v['kdBidang'].'"';
        }
        if(isset($v['kdSub'])){
            $where.=' and a.kdSub="'.$v['kdSub'].'"';
        }
        if(isset($v['kdJudul'])){
            $where.=' and a.kdJudul="'.$v['kdJudul'].'"';
        }
        if(isset($v['tahun'])){
            $where.=' and a.taWork ="'.$v['tahun'].'"';
        }
        if(isset($v['no'])){
            $where.=' and a.no="'.$v['no'].'" ';
        }
        if(isset($v['kdBAnggota'])){
            $where.=' and a.kdBAnggota="'.$v['kdBAnggota'].'" ';
        }
        if(isset($v['where'])){
            $where.=$v['where'];
        }
        return DB::select('
            select
                a.no, a.date, a.status, a.kdBAnggota, a.kdBidang , a.kdBidang as kdDBidang, a.tujuan, a.noBuku, a.tglBuku, a.file,
                maksud, angkut, tempatS, tempatE, dateE, anggaran, keterangan, lokasi, fileD, dasar, pimOpd, pimBupati, pimSetda,
                tdOPD,tdBUPATI,tdSETDA,noSPPD,
                (
                    select sum(a1.volume * a1.nilai)
                    from workuraian a1
                    where a1.kdDinas=a.kdDinas and
                    a1.kdSub = a.kdSub and
                    a1.kdBidang = a.kdBidang and
                    a1.taWork  = a.taWork and
                    a1.kdJudul= a.kdJudul and
                    a1.noWork =a.no
                ) as total
            from work a
            '.$where.'

        ');
    }
    function dworkAnggotaBidang($v){
        $where = '';
        if(isset($v['kdDinas'])){
            $where.=' where a.kdDinas="'.$v['kdDinas'].'"';
        }
        if(isset($v['kdBidang'])){
            $where.=' and a.kdBidang="'.$v['kdBidang'].'"';
        }
        if(isset($v['kdSub'])){
            $where.=' and a.kdSub="'.$v['kdSub'].'"';
        }
        if(isset($v['kdJudul'])){
            $where.=' and a.kdJudul="'.$v['kdJudul'].'"';
        }
        if(isset($v['tahun'])){
            $where.=' and a.taWork ="'.$v['tahun'].'"';
        }
        if(isset($v['no'])){
            $where.=' and a.no="'.$v['no'].'" ';
        }
        if(isset($v['kdBAnggota'])){
            $where.=' and a.kdBAnggota="'.$v['kdBAnggota'].'" ';
        }
        if(isset($v['where'])){
            $where.=$v['where'];
        }
        return DB::select('
            select
                a.no, a.date, a.status, a.kdBAnggota,a.noSPPD,
                b.nip, b.nmAnggota, b.nip, b.nmJabatan, b.asJabatan, b.golongan, b.tingkatan, b.snip,
                c.nmBidang
            from work a
            join dinas_b_anggota b on
                a.kdBAnggota = b.kdBAnggota and
                a.kdBidang = b.kdBidang and
                a.kdDinas = b.kdDinas and
                a.taWork = b.taBAnggota
            join dinas_bidang c on
                b.kdDinas = c.kdDinas and
                b.kdBidang = c.kdDBidang and
                b.taBAnggota = c.taDBidang
            '.$where.'
            GROUP BY a.no, a.kdBAnggota, a.kdBidang, a.kdDinas, a.taWork, a.kdSub, a.kdJudul
            order by b.urutan asc 
        ');
    }
    function workAdded($v){
        $keyTabel="no";
        $kdTabel=DB::select("select ".$keyTabel." from work where
            kdDinas='".$v[0]."'and
            kdBidang='".$v[1]."' and
            taWork='".$v[10]."' and
            kdSub='".$v[11]."' and
            kdJudul='".$v[12]."' and
            kdBAnggota=''
            ORDER BY cast(".$keyTabel." as int) DESC limit 1
        ");
        if(count($kdTabel)>0){
            $kdTabel=$kdTabel[0]->no+1;
        }else{
            $kdTabel=1;
        }
        return DB::insert("
            insert work (
                no, kdDinas, kdBidang,

                maksud,angkut,tempatS,tempatE,
                date, dateE,anggaran,lokasi,

                taWork, kdSub, kdJudul,kdBAnggota
            ) values
            (
                '".$kdTabel."',?,?,
                ?,?,?,?,
                ?,?,?,?,
                ?,?,?,?
            )
        ",$v);
    }
    function workAdduser($v){
        return DB::insert("
            insert work (
                no, kdDinas, kdBidang,
                taWork, kdSub, kdJudul,kdBAnggota
            ) values
            (
                ?,?,?,
                ?,?,?,?
            )
        ",$v);
    }


    function workUraianedded($v){
        $getKD=DB::select("
            select (kdUraian+1) as kd from workuraian
                where kdJPJ='".$v[0]."' and
                    kdDP='".$v[1]."' and
                    kdDinas='".$v[2]."' and
                    kdBidang='".$v[3]."' and

                    kdSub='".$v[4]."' and
                    kdJudul='".$v[5]."' and
                    taWork='".$v[6]."' and
                    noWork='".$v[9]."' and
                    kdBAnggota='".$v[10]."'
                ORDER BY kdUraian desc
            limit 1
        ");
        $kd=1;
        if(count($getKD)!=0){
            $kd = $getKD[0]->kd;
        }
        return DB::insert("
            INSERT INTO workuraian(
                kdJPJ, kdDP, kdDinas, kdBidang,
                kdSub, kdJudul, taWork, uraian,
                nilai, noWork,kdBAnggota, volume,
                satuan, kdUraian
            ) values
            (
                ?,?,?,?,
                ?,?,?,?,
                ?,?,?,?,
                ?,?
            )
        ",array_merge($v,[$kd]));

    }
    function dworkUraian($v){
        $where = '';
        if(isset($v['kdDinas'])){
            $where.=' where a.kdDinas="'.$v['kdDinas'].'"';
        }
        if(isset($v['kdBidang'])){
            $where.=' and a.kdBidang="'.$v['kdBidang'].'"';
        }
        if(isset($v['kdSub'])){
            $where.=' and a.kdSub="'.$v['kdSub'].'"';
        }
        if(isset($v['kdJudul'])){
            $where.=' and a.kdJudul="'.$v['kdJudul'].'"';
        }
        if(isset($v['tahun'])){
            $where.=' and a.taWork ="'.$v['tahun'].'"';
        }
        if(isset($v['no'])){
            $where.=' and a.noWork="'.$v['no'].'" ';
        }
        if(isset($v['kdBAnggota'])){
            $where.=' and a.kdBAnggota="'.$v['kdBAnggota'].'" ';
        }
        if(isset($v['kdDP'])){
            $where.=' and a.kdDP="'.$v['kdDP'].'" ';
        }
        if(isset($v['where'])){
            $where.=$v['where'];
        }
        return DB::select('
            select
                a.uraian, a.nilai, a.volume, a.satuan, a.kdUraian
            from workuraian a
            '.$where.'
        ');
    }
}

?>
