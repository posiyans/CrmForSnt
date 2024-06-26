<?php

namespace App\Modules\MeteringDevice\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\MeteringDevice\Repositories\InstrumentReadingRepository;
use App\Modules\MeteringDevice\Resources\InstrumentReadingListXlsxFileResource;
use App\Modules\MeteringDevice\Resources\InstrumentReadingResource;
use App\Modules\MeteringDevice\Validators\GetInstrumentReadingListValidator;
use Illuminate\Support\Facades\Auth;

/**
 * Получить показания приборов
 */
class GetInstrumentReadingListController extends Controller
{

    // 'instrument_reading-edit'
    public function __construct()
    {
        $this->middleware('ability:superAdmin|owner,stead-show');
    }

    public function __invoke(GetInstrumentReadingListValidator $request)
    {
        try {
            $user = Auth::user();
            if (!$user->ability('superAdmin', 'stead-show')) {
                $steads = $user->owner->steads->map(function ($item) {
                    return $item->id;
                });
                if (!in_array($request->stead_id, $steads->toArray())) {
                    throw new \Exception('Ошибка доступа');
                }
            }

            $readings = (new InstrumentReadingRepository())
                ->for_stead($request->stead_id)
                ->for_device($request->device_id)
                ->forRateType($request->rate_type_id)
                ->between_date($request->date_start, $request->date_end)
                ->orderBy('date', 'desc');
            if ($request->xlsx) {
                $readings = $readings
                    ->get();
                $tmpfname = tempnam(sys_get_temp_dir(), "reading");
                (new InstrumentReadingListXlsxFileResource())->render($readings, $tmpfname);
                return response()->download($tmpfname, 'Показания_приборов_' . date("Y-m-d_H-i-s") . '.xlsx');
            } else {
                $result = $readings
                    ->getGroup();
                $total = count($result);
                $limit = $request->limit;
                $page = $request->page;
                $offset = ($page - 1) * $limit;
                $data = [];
                foreach ($result->slice($offset, $limit) as $items) {
                    $data[] = InstrumentReadingResource::collection($items);
                }

                return ['meta' => ['total' => $total], 'data' => $data];
            }
        } catch (\Exception $e) {
            return response(['errors' => $e->getMessage()], 450);
        }
    }

}
