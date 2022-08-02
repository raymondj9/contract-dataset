<?php

namespace App\Imports;

use App\Models\DataSet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Group;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class DataImport implements ToModel
{
    public function model(array $row)
    {
        if ($row[0] == 'idcontrato') {
            return null;
        }

        if (DataSet::where('idcontrato',$row[0])->exists()) {
            return null;
        }

        return new DataSet([
            'idcontrato' => $row[0],
            'nAnuncio' => $row[1],
            'tipoContrato' => $row[2],
            'tipoprocedimento' => $row[3],
            'objectoContrato' => $row[4],
            'adjudicantes' => $row[5],
            'adjudicatarios' => $row[6],
            'dataPublicacao' => $row[7],
            'dataCelebracaoContrato' => $row[8],
            'precoContratual' => $row[9],
            'cpv' => $row[10],
            'prazoExecucao' => $row[11],
            'localExecucao' => $row[12],
            'fundamentacao' => $row[13],
        ]);
    }

    public function chunkSize(): int {
        return 1000;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
