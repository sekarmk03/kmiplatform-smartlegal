<?php 
namespace Modules\Smartlegal\Helpers;

class TextFormatter {
    public static function getInitials($string) {
        $words = explode(' ', $string);
        $initials = '';
    
        foreach ($words as $word) {
            $initials .= ucfirst(substr($word, 0, 1));
        }
    
        return $initials;
    }
}

?>