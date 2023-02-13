<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibraryFunctionController extends Controller
{
    public static function replaceamount($amount){
        $str = array(".","Rp"," ");
        if($amount!=""):
            $newtext = str_replace($str,"",$amount);
        else:
            $newtext = 0;
        endif;

        return $newtext;
    }

    public static function formatRupiah($angka){
        $hasil_rupiah = "Rp" . number_format($angka,0,',','.');

        return $hasil_rupiah;
    }
}
