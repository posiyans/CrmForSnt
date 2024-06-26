<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\VotingResource;
use App\Models\Voting\VotingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminVotingController extends Controller
{

    /**
     * проверка на суперадмин или на доступ а админ панель
     */
    public function __construct()
    {
        $this->middleware('ability:superAdmin,access-admin-panel');
    }

    /**
     * Получить список голосований
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = VotingModel::query();
        $query->orderBy('id', 'desc');
        // todo добавить фильтры
        $votings = $query->paginate($request->limit);
        return VotingResource::collection($votings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Создать новое голосование
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->voting;
        if ($data) {
            $voting = new VotingModel();
            $voting->fill($data);
            if ($voting->type == 'public') {
                $voting->date_start = '0000-01-01 00:00:00';
                $voting->date_stop = '9999-01-01 00:00:00';
                $voting->date_publish = now();
            }
            if ($voting->logAndSave('Создание голосования')) {
                if (isset($data['questions']) && is_array($data['questions'])) {
                    $voting->saveQuestions($data['questions']);
                }
                if (isset($data['files']) && is_array($data['files'])) {
                    $voting->attachedFiles($data['files']);
                }
                return json_encode(['status' => true, 'voting' => $voting, 'data' => $data]);
            }
            return json_encode(['voting' => $voting, 'data' => $data]);
        }
    }

    /**
     * Получить админом голосование
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $voting = VotingModel::find($id);
            if ($voting) {
                return new VotingResource($voting);
            }
        }
        return [];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->ability('superAdmin', 'сreate-polls')) {
            $data = $request->voting;
            if ($data) {
                $voting = VotingModel::find($id);
                if ($voting && $id == $voting->id) {
                    $voting->fill($data);
                    if ($voting->type == 'public') {
                        $voting->date_start = '0000-01-01 00:00:00';
                        $voting->date_stop = '9999-01-01 00:00:00';
                    }
                    if ($voting->logAndSave('Изменение')) {
                        if (isset($data['questions']) && is_array($data['questions'])) {
                            $voting->saveQuestions($data['questions']);
                        }
                        if (isset($data['files']) && is_array($data['files'])) {
                            $voting->attachedFiles($data['files']);
                        }
                        return new VotingResource($voting);
                    }
                }
            }
        }
        return ['status' => false];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
