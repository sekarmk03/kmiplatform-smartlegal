<?php 
namespace Modules\Smartlegal\Helpers;

class CurrencyFormatter {
    public static function formatIDR($amount) {
        $number = $amount;
        $formatted_number = "Rp" . number_format($number, 0, ',', '.');
        return $formatted_number;
    }
}
?>