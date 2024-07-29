<?php
namespace App\Helper;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Mfc {
    function portal(){
        $user= Auth::user();
        if(!empty($user->id)){
            return [
                "exc"=>true,
                "ta"=>"2024",
                "kdMember"=>base64_encode($user->id),
                "name"=>$user->name,
                "user"=>$user,
                "kdJPJ"=>'jp-1',
                "setda"=>'4.01.2.10.0.00.01.0000'
            ];
        }
        return (new static)->respError(" user can't ID !!!");
    }
    function apiPortal($v){
        $v = json_decode(base64_decode($v)); 
        $where=[];
        foreach ($v as $key => $value) {
            if($key == "kdMember"){
                $v->$key = base64_decode($value);
                $where["id"]=$v->$key;
            }
            if($key == "updated_at"){ 
                $where[$key]=$value;
            }
        }

        $duser = User::where($where)->get();
        if(count($duser)>0){
            return [
                "dparam"=>$v,
                "exc"=>true,
                "duser"=>$duser[0],
            ];
        }
        return (new static)->respError("tidak sesuai keamanan dengan keamanan sistem !!!");
    }
    function respError($msg){
        return [
            "exc"=>false,
            "msg"=>$msg
        ];
    }
    function resp($data){
        return [
            "exc"=>true,
            "data"=>$data
        ];
    }
    function log($dt){
        echo "<pre>";
        print_r($dt);
    }
    function __valByKey($mapping, $keys) {
        foreach($keys as $key) {
            $output_arr[$key] = $mapping[$key];
        }
        return $output_arr;
    }
    function __bulan($bulan){
        switch ($bulan) {
            case 1 : return "Januari";
            case 2 : return "Februari";
            case 3 : return "Maret";
            case 4 : return "April";
            case 5 : return "Mei";

            case 6 : return "Juni";
            case 7 : return "Juli";
            case 8 : return "Agustus";
            case 9 : return "September";
            case 10 : return "Oktober";

            case 11 : return "November";
            default: return "Desember";
        }
    }
    function __romawi($bulan){
        switch ($bulan) {
            case 1 : return "I";
            case 2 : return "II";
            case 3 : return "III";
            case 4 : return "IV";
            case 5 : return "V";

            case 6 : return "VI";
            case 7 : return "VII";
            case 8 : return "VIII";
            case 9 : return "IX";
            case 10 : return "X";

            case 11 : return "XI";
            default: return "XII";
        }
    }
}   
?>