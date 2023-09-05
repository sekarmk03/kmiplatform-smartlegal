<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\ROonline\Entities\LogHistoryModel as LogHistory;

class RoHistoryExport implements FromView, ShouldAutoSize, WithEvents
{
    use RegistersEventListeners;
    use Exportable;
    protected $start, $end, $lines;
    public function __construct($start, $end, $lines)
    {
        $this->start = $start;
        $this->end = $end;
        $this->lines = $lines;
    }
    public function view(): View
    {
        if ($this->start != '' && $this->end != '') {
            $data = LogHistory::where('txtStatus', 'Measuring')
                ->where('txtLineProcessName', '<>', 'undefined')
                ->whereBetween('TimeStamp', [date('Y-m-d H:i:s', strtotime($this->start)), date('Y-m-d H:i:s', strtotime($this->end))])
                ->whereIn('txtLineProcessName', $this->lines)
                ->get();
        } else {
            $from = LogHistory::selectRaw("DATE_SUB(`TimeStamp`, INTERVAL 1 HOUR) AS `from`")
                ->orderBy('intLog_History_ID', 'DESC')
                ->take(1)
                ->first()->from;
            $to = LogHistory::orderBy('intLog_History_ID', 'DESC')->first(['TimeStamp'])->TimeStamp;
            $data = LogHistory::where('txtStatus', 'Measuring')
                ->whereBetween('TimeStamp', [$from, $to])
                ->where('txtLineProcessName', '<>', 'undefined')
                ->whereIn('txtLineProcessName', $this->lines)
                ->get();
        }
        return view('roonline::exports.loghistory', [
            'loghistories' => $data
        ]);
    }
    public static function afterSheet(AfterSheet $event)
    {
        $range = 'A1:I1';
        $centering = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];
        $sheet = $event->sheet->getDelegate();
            $sheet->getStyle($range)->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle($range)->getFont()->getColor()
                ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);;
            $sheet->getStyle($range)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('1565C0');
            $sheet->getStyle($range)->applyFromArray($centering);
            $sheet->setAutoFilter($range);
        }
}
