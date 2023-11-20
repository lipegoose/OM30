<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Paciente;

class PacientesImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        return new Paciente([
            'nome_paciente' => $row['nome_paciente'],
            'mae_paciente'  => $row['mae_paciente'],
            'data_nasc'     => $row['data_nasc'],
            'cpf'           => $row['cpf'],
            'cns'           => $row['cns'],
            // 'endereco' => $row['endereco'],
        ]);
    }

    public function chunkSize(): int
    {
        // Definir o tamanho do chunk (por exemplo, 100) conforme necessário
        return 100;
    }
}
