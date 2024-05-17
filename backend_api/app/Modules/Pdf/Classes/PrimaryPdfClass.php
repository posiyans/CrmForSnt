<?php

namespace App\Modules\Pdf\Classes;

abstract class PrimaryPdfClass
{
    protected $pdf;


    public function __construct()
    {
        mb_internal_encoding('UTF-8');
        $this->pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
    }

    /**
     * вернуть pdf
     *
     * @param $name
     */
    public function Output($name)
    {
        $this->pdf->Output($name, 'F');
    }

}
