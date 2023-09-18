<?php 
namespace Modules\Smartlegal\Helpers;

use Carbon\Carbon;
use DateTime;

class PeriodFormatter {
    // type = day, min
    public static function date($start, $end, $type) {
        $start_date = new DateTime($start);
        $end_date = new DateTime($end);
        $dd = date_diff($start_date, $end_date);
        if ($type == 'day') {
            $result = $dd->y." year(s) ".$dd->m." month(s) ".$dd->d." day(s)";
        } else if ($type == 'min') {
            $result = $dd->format('%a day(s) %h hour(s) %i minute(s)');
        }
        return $result;
    }

    public static function dayCounter($start, $end) {
        $date1 = Carbon::parse($start);
        $date2 = Carbon::parse($end);

        $diffInDays = $date1->diffInDays($date2);
        return $diffInDays;
    }

    public static function readablePeriod($start, $end) {
        if (!$end) return null;
        $date1 = Carbon::parse($start);
        $date2 = Carbon::parse($end);

        $diff = $date1->diffForHumans($date2);
        return $diff;
    }

    public static function countInputToDay($n, $unit) {
        $result = 0;
        if ($unit == 'tahun') $result = $n * 365;
        else if ($unit == 'bulan') $result = $n * 31;
        else if ($unit == 'minggu') $result = $n * 7;
        return $result;
    }

    public static function convertDaysToReadable($days) {
        $periods = [
            'week'   => 7,
            'month'  => 30,
            'year'   => 365,
        ];

        foreach ($periods as $period => $value) {
            if ($days >= $value) {
                $num = floor($days / $value);
                return "$num $period" . ($num > 1 ? 's' : '');
            }
        }

        return "$days day" . ($days > 1 ? 's' : '');
    }

    // public static function countDayToUnit($n) {
    //     if ($n <= 31) $unit = ''
    // }
}

?>