<?php

namespace App\Modules\Receipt\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Gardening\Repositories\GardeningRepository;
use App\Modules\Pdf\Classes\PrimaryReceiptPdfClass;


class ReceiptClearController extends Controller
{


    public function __invoke()
    {
        $gardieng = (new GardeningRepository())->all();
        $file_name = 'Квитанция_' . $gardieng['name'] . '.pdf';

        return (new PrimaryReceiptPdfClass())
            ->render()
            ->response($file_name);
    }

}
