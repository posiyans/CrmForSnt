<?php

namespace App\Modules\Stead\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Stead\Repositories\AdminSteadListXlsxFileResource;
use App\Modules\Stead\Repositories\SteadRepository;
use App\Modules\Stead\Resources\AdminSteadResource;
use App\Modules\Stead\Resources\SteadResource;
use App\Modules\Stead\Validators\GetSteadListValidator;
use Illuminate\Support\Facades\Auth;


class GetSteadListController extends Controller
{
    public function __construct()
    {
    }

    public function index(GetSteadListValidator $request)
    {
        $repository = (new SteadRepository())
            ->findByNumber($request->find)
            ->findById($request->steadsId);
        if ($request->page) {
            $steads = $repository->paginate($request->limit);
        } else {
            $steads = $repository->get();
        }
        if ($request->admin && Auth::user() && Auth::user()->ability('superAdmin', ['owner-show', 'owner-edit', 'stead-show', 'stead-edit'])) {
            if ($request->xlsx) {
                $tmpfname = tempnam(sys_get_temp_dir(), "stead");
                $steads = $repository->get();
                (new AdminSteadListXlsxFileResource())->render($steads, $tmpfname);
                return response()->download($tmpfname, 'Список_участков_' . date("Y-m-d_H-i-s") . '.xlsx');
            }
            return AdminSteadResource::collection($steads);
        }
        return SteadResource::collection($steads);
    }


}
