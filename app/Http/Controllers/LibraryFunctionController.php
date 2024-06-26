<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Spatie\Permission\Models\Role;

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

    public static function countdownHari($time){
        $date = strtotime($time);
        if ($date > time()) {
            $remaining = $date - time();
            $days_remaining = floor($remaining / 86400);
            return $days_remaining;
        } else {
            return 'selesai';
        }
    }

    public static function persentaseBiayaTerkumpul($dana_terkumpul, $target_biaya){

        $persentase = ($dana_terkumpul / $target_biaya) * 100;
        if ($persentase <= 100) {
            return $persentase;
        } else {
            return 100;
        }
    }

    public static function getNameCampaign($campaign_id){
        $dataCampaign = Campaign::where('id', $campaign_id)->first();
        $nameCampaign = $dataCampaign->judul;
        return $nameCampaign;

    }

    public static function getRoleName($roleNames){
        $array = json_decode($roleNames,true);
        $string = implode(",",$array);
        return $string;
    }

    public static function cekRoleAdmin($auth){
        $array = json_decode($auth->getRoleNames(),true);
        $role = implode(",",$array);
        $roleName = $role == 'Superadmin' || $role == 'HelperAdmin' || $role == 'HelperCelsyahid' || $role == 'HelperEventMart' || $role == 'HelperSPAM' || $role == 'HelperMedia' || $role == 'HelperLetter';

        return $roleName;
    }
}
