<?php 
namespace Modules\Smartlegal\Helpers;

use Modules\Smartlegal\Entities\Document;

class NumberIDGenerator {
    public static function generateRequestNumber($type, $department) {
        // 2023/Reg-03/BDA/0001
        // Reset to 0001 every year change

        $year = date('Y');
        $latestData = Document::whereYear('dtmCreatedAt', $year)
        ->orderBy('intDocID', 'DESC')
        ->first();

        if ($latestData) {
            $latestYear = date('Y', strtotime($latestData->dtmCreatedAt));
            if ($year == $latestYear) {
                $count = intval(substr($latestData->txtRequestNumber, -4)) + 1;
            } else {
                $count = 1;
            }
        } else {
            $count = 1;
        }

        $count = str_pad($count, 4, '0', STR_PAD_LEFT);
        $type = str_pad($type, 2, '0', STR_PAD_LEFT);

        return "{$year}/Reg-{$type}/{$department}/{$count}";
    }

    public static function generateDocumentNumber($document, $type, $department, $id = null) {
        // PM03BDA0001-00
        $add = 0;
        $version = 0;

        if ($id == null) {
            // create new document
            $latestData = Document::where('txtDocNumber', 'like', $document . '%')
            ->orderBy('intDocID', 'DESC')
            ->first();
            $add = 1;
            $version = 0;
        } else {
            // update document
            $latestData = Document::where('intDocID', $id)->first();
            $add = 0;
            $version = intval(substr($latestData->txtDocNumber, -2)) + 1;
        }

        $count = $latestData ? intval(substr($latestData->txtDocNumber, 7, 4)) + $add : 1;
        $count = str_pad($count, 4, '0', STR_PAD_LEFT);
        $type = str_pad($type, 2, '0', STR_PAD_LEFT);
        $version = str_pad($version, 2, '0', STR_PAD_LEFT);

        return $document . $type . $department . $count . '-' . $version;
    }
}
?>