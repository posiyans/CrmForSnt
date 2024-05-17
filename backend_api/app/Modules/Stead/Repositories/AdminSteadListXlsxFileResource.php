<?php

namespace App\Modules\Stead\Repositories;


use App\Http\Abstracts\AbstaractXlsxFile;
use App\Modules\AdvancedOptions\Repositories\AdvancedOptionsRepository;
use App\Modules\AdvancedOptions\Repositories\AdvancedOptionsValueRepository;
use App\Modules\Stead\Models\SteadModel;


class AdminSteadListXlsxFileResource extends AbstaractXlsxFile
{

    protected $spreadsheet;
    protected $options;

    /**
     * Список участков XLSX формате
     *
     * @return \Illuminate\Http\Response
     */
    public function render($steads, $file_name)
    {
        $this->createHeader();
        $this->fillLine($steads);
        $this->setAutoSize(['C', 'E']);
        $this->setAutoFilter();
        $this->output($file_name);
    }


    public function createHeader()
    {
        $sheet = $this->spreadsheet->getActiveSheet()->setTitle('Участки');
        $row = 1;
        $i = 0;
        $sheet->setCellValue([++$i, $row], '№');
        $sheet->setCellValue([++$i, $row], 'Участок');
        $sheet->setCellValue([++$i, $row], 'Размер, кв.м');
        $sheet->setCellValue([++$i, $row], 'Собственник');
//        $this->setCenter('E');
        $this->createHeaderAdvanced($i);
    }

    private function createHeaderAdvanced($i)
    {
        $sheet = $this->spreadsheet->getActiveSheet()->setTitle('Участки');
        $this->options = (new AdvancedOptionsRepository())
            ->forClass(SteadModel::class)
            ->type('options')
            ->get();
        $row = 1;
        foreach ($this->options as $opt) {
            $sheet->setCellValue([++$i, $row], $opt->name);
        }
    }


    private function fillLine($items)
    {
        $sheet = $this->spreadsheet->getActiveSheet();
        $row = 2;
        foreach ($items as $item) {
            $owners = '';
            $owner_count = 0;
            foreach ($item->owners as $owner) {
                if (strlen($owners) > 0) {
                    $owners .= ', ' . "\n";
                }
                $owners .= $owner->nameForMyRole();
                if ($owner->pivot->proportion != 100) {
                    $owners .= ' (' . $owner->pivot->proportion . '%)';
                }
                $owner_count++;
            }
            if ($owner_count > 1) {
                $this->spreadsheet->getActiveSheet()->getRowDimension($row)->setRowHeight(14 * $owner_count);
            }
            $i = 0;
            $sheet->setCellValue([++$i, $row], $row - 1);
            $sheet->setCellValue([++$i, $row], $item->number);
            $sheet->setCellValue([++$i, $row], $item->size);
            $sheet->setCellValue([++$i, $row], $owners);
            $this->advancedOptionsFill($item, $i, $row);
            $row++;
        }
    }

    private function advancedOptionsFill($stead, $i, $row)
    {
        $sheet = $this->spreadsheet->getActiveSheet();
        foreach ($this->options as $opt) {
            // todo по 1 шт в базе искать долго
            $value = (new AdvancedOptionsValueRepository())->forObject($stead, 'options')->where('advanced_options_id', $opt->id)->first();
            $text = '';
            if ($value) {
                $advanced_opt = $value->advanced_options;
                if ($advanced_opt->type_value == 'boolean') {
                    $text = $value->value['value'] == true ? 'ДА' : 'НЕТ';
                } else {
                    $unitName = isset($value->advanced_options->options['unitName']) ? ' ' . $value->advanced_options->options['unitName'] : '';
                    $text = $value ? $value->value['value'] : '';
                    if (is_array($text)) {
                        $text = implode($unitName . ', ', $text);
                    } else {
                        $text = $text . $unitName;
                    }
                }
            }
            $sheet->setCellValue([++$i, $row], $text);
        }
    }


}
