<?php
namespace App\Helpers;

class Date {
    public static function tgl($tanggal)
    {
        $pecahkan = explode('-', $tanggal);
     
        return $pecahkan[2] . '/' .$pecahkan[1]. '/' . $pecahkan[0];
    }

    
}

?>