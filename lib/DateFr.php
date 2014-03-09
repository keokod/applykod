<?php

class DateFr {

    public static function afficheDate($date_sql) {
        $date_us = new DateTime($date_sql);
        echo $date_us->format('d-m-Y');
    }

}
?>
