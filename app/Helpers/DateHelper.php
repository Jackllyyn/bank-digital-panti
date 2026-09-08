<?php
// app/Helpers/DateHelper.php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function format($date, $format = 'd M Y')
    {
        if (empty($date)) {
            return '-';
        }
        
        try {
            return Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return $date;
        }
    }
    
    public static function diffForHumans($date)
    {
        if (empty($date)) {
            return '-';
        }
        
        try {
            return Carbon::parse($date)->diffForHumans();
        } catch (\Exception $e) {
            return $date;
        }
    }
}