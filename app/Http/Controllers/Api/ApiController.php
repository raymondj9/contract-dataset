<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Imports\DataImport;
use App\Models\DataSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ApiController extends Controller {
    
    public function uploadDataset(Request $request) {
        $data = $request->only('dataset');
        $validator = Validator::make($data,[
            'dataset' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages()->all(),
            ], 400);
        }

        try {
            $import = new DataImport;
            Excel::import($import,$request->file('dataset'));
            $rows = $import->data->toArray();
            dd($rows[0]);
            return response()->json([
                'success' => false,
                'message' => 'Data upload was successful',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function search(Request $request) {
        $query = $request->all();
        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid search parameter'
            ], 400);
        }

        $dataSet = DataSet::whereNotNull('id');
        if (isset($query['date'])) {
           $dataSet = $dataSet->where('dataCelebracaoContrato',$query['date']);
        }

        if (isset($query['amount'])) {
            $amount = explode('-',$query['amount']);
            $from = $amount[0];
            $to = $amount[1];
            $dataSet = $dataSet->whereBetween('precoContratual',[$from,$to]);
        }

        if (isset($query['winning_company'])) {
            $winning_company = $query['winning_company'];
            $dataSet = $dataSet->where('adjudicatarios',$winning_company);
        }

        return response()->json([
            'success' => true,
            'data' => $dataSet->get(),
        ], 200);
    }

    public function getContractById($id) {
        $data = DataSet::find($id);
        DataSet::find($id)->update([
            'read' => 1
        ]);
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function checkReadStatus($id) {
        $data = DataSet::find($id);
        $status = ($data->read) ? true : false;
        return response()->json([
            'status' => $status
        ], 400);
    }

    
}
