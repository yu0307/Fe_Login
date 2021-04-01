<?php

namespace feiron\fe_login\http\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use feiron\fe_login\models\fe_userMetaTypes;

class FeUsrMetaManagement extends Controller
{

    public function __construct()
    {
        $this->middleware('FeAuthenticate');
    }

    public function show(){
        return view('fe_login::LoginUsrMetaManagerWindow');
    }

    public function saveMeta(Request $request){
        $validator = Validator::make($request->all(), [
            'meta_name' => 'required|max:255|unique:user_metatypes,meta_name,' . $request->input('MetaID') . ',id',
            'meta_type' => 'required|max:255|in:text,select,number,email,textarea,checkbox,radio,switch'
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'errors' => $validator->getMessageBag()->toArray()];
        } else {
            $meta= [
                'meta_name' => $request->input('meta_name'),
                'meta_type' => $request->input('meta_type'),
                'meta_label' => $request->input('meta_label') ?? $request->input('meta_name'),
                'meta_defaults' => (stripos($request->input('meta_defaults'),',')===false?$request->input('meta_defaults'):explode(',', $request->input('meta_defaults'))),
                'meta_options' => (in_array($request->input('meta_type'), ['select', 'radio', 'checkbox']) === false) ? $request->input('meta_options') : explode(',', $request->input('meta_options'))
            ];
            if($request->filled('MetaID')){
                fe_userMetaTypes::find($request->input('MetaID'))->update($meta);
            }else{
                fe_userMetaTypes::create($meta);
            }
        }
        return ['status' => 'success', 'message' => ['User Meta Field Information Saved.']];
    }

    public function removeMetaFields(Request $request,$MID){
        fe_userMetaTypes::destroy($MID);
        return response()->json(['status' => 'success', 'message' => 'User Meta Field Removed.']);
    }

    public function listMetaFields(Request $request){
        $datainfo = [];
        $QueryBuilder = fe_userMetaTypes::query();
        $columnName = $request->has('sorters')?$request->input('sorters')[0]['field']:'meta_name'; // Column name
        $columnSortOrder = $request->has('sorters')?$request->input('sorters')[0]['dir']:'asc'; // asc or desc

        $datainfo['recordsTotal'] = $QueryBuilder->count();
        $datainfo['rowperpage'] = $request->input('size');
        $datainfo['last_page'] = ceil($QueryBuilder->count()/$datainfo['rowperpage']);
        $datainfo['page'] = $request->input('page');
        // Building column specific search--------------------------
        $QueryBuilder->where(
            function ($query) use ($request) {
                foreach ($request->input('filters')??[] as $column) {
                    if (isset($column['value'])) {
                        $query->where($column['field'], 'like', ('%' . $column['value'] . '%'));
                    }
                }
            }
        );

        $datainfo['recordsFiltered'] = $QueryBuilder->count();
        $datainfo['data'] = $QueryBuilder->orderBy($columnName, $columnSortOrder)->paginate($datainfo['rowperpage'])->flatten()->toArray();

        return response()->json($datainfo);
    }

    public function load(Request $request, $MID)
    {
        return response()->json(fe_userMetaTypes::find($MID)->toArray());
    }
}
