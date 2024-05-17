<?php

namespace App\Modules\Billing\Resources;


use App\Http\Abstracts\AbstaractXlsxFile;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

/**
 * @refactory
 *
 */
class PaymentXlsxFileResource extends AbstaractXlsxFile
{

    protected $spreadsheet;


    /**
     * @throws Exception
     */
    public function render($payments, $file_name)
    {
        $this->createHeader();
        $this->fillLine($payments);
        $this->setAutoSize(['B', 'F']);
        $this->setAutoFilter();
        $this->output($file_name);
    }


    public function createHeader()
    {
        $sheet = $this->spreadsheet->getActiveSheet()->setTitle('Платежи');
        $row = 1;
        $i = 1;
        $sheet->setCellValue([$i++, $row], '№');
        $sheet->setCellValue([$i++, $row], 'Дата');
        $sheet->setCellValue([$i++, $row], 'Сумма, руб');
        $sheet->setCellValue([$i++, $row], 'Назначение');
        $sheet->setCellValue([$i++, $row], 'Участок');
        $sheet->setCellValue([$i++, $row], 'Группа');
    }


    private function fillLine($balances)
    {
        $sheet = $this->spreadsheet->getActiveSheet();
        $row = 2;
        foreach ($balances as $item) {
            $this->set_line($sheet, $item, $row++);
        }
    }


    private function set_line($sheet, $item, $row)
    {
        $i = 1;
        $sheet->setCellValue([$i++, $row], $item->id);
        $sheet->setCellValue([$i++, $row], $item->payment_date);
        $sheet->setCellValue([$i++, $row], $item->price);
        $sheet->setCellValue([$i++, $row], $item->raw_data[4] ?? '');
        $sheet->setCellValue([$i++, $row], $item->stead->number ?? '');
        $sheet->setCellValue([$i++, $row], $item->rate_group->name ?? '');
    }


}
