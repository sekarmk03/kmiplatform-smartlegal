<?php 
namespace Modules\Smartlegal\Helpers;

class CurrencyFormatter {
    public static function formatIDR($amount, $prefix) {
        $number = $amount;
        $formatted_number = $prefix . number_format($number, 0, ',', '.');
        return $formatted_number;
    }
}
?>