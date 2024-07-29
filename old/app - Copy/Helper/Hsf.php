<?php
namespace App\Helper;
use Illuminate\Support\Facades\DB;
class Hsf {

    function _cekEmpty($v){
        return (empty($v)=="");
    }
    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = (new static)->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = (new static)->penyebut($nilai/10)." puluh". (new static)->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . (new static)->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = (new static)->penyebut($nilai/100) . " ratus" . (new static)->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . (new static)->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = (new static)->penyebut($nilai/1000) . " ribu" . (new static)->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = (new static)->penyebut($nilai/1000000) . " juta" . (new static)->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = (new static)->penyebut($nilai/1000000000) . " milyar" . (new static)->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = (new static)->penyebut($nilai/1000000000000) . " trilyun" . (new static)->penyebut(fmod($nilai,1000000000000));
		}
		return $temp;
	}

	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim((new static)->penyebut($nilai));
		} else {
			$hasil = trim((new static)->penyebut($nilai));
		}
		return $hasil;
	}
}

?>
