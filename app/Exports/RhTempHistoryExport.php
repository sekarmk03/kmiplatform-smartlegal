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
use Modules\ROonline\Entities\LogRHTemp;

class RhTempHistoryExport implements FromView, ShouldAutoSize, WithEvents
{
    use RegistersEventListeners;
    use Exportable;
    protected $start, $end, $area;
    public function __construct($start, $end, $area)
    {
        $this->start = $start;
        $this->end = $end;
        $this->area = $area;
    }
    public function view(): View
    {
        $data = LogRHTemp::join('marea', 'marea.intArea_ID', '=', 'log_RhandTemp.intArea_ID')
            ->whereBetween('TimeStamp', [date('Y-m-d H:i:s', strtotime($this->start)), date('Y-m-d H:i:s', strtotime($this->end))])
            ->whereIn('log_RhandTemp.intArea_ID', $this->area)
            ->get(['log_RhandTemp.*', 'marea.txtAreaName']);
        return view('roonline::exports.logrhtemp', [
            'rhtemp' => $data
        ]);
    }
    public static function afterSheet(AfterSheet $event)
    {
        $range = 'A1:G1';
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
