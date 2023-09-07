<?php 
namespace Modules\Smartlegal\Helpers;

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
}

?>