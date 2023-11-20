<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

/**
 * Class Paciente
 * 
 * @property int $id
 * @property string $nome_paciente
 * @property string $mae_paciente
 * @property Carbon $data_nasc
 * @property string $cpf
 * @property string $cns
 * @property string|null $foto
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Endereco[] $enderecos
 *
 * @package App\Models
 */
class Paciente extends Model
{
	use SoftDeletes;
	protected $table = 'pacientes';

	protected $casts = [
		'data_nasc' => 'datetime'
	];

	protected $fillable = [
		'nome_paciente',
		'mae_paciente',
		'data_nasc',
		'cpf',
		'cns',
		'foto'
	];

    /* Colunas habilitadas na busca via Ajax */
    protected static  $searchableColumns = [
        'id',
        'nome_paciente',
        'mae_paciente',
    ];

    /* Colunas habilitadas para ordenação via Ajax */
    protected static  $orderableColumns = [
        // 0 => 'id',
        1 => 'id',
        3 => 'nome_paciente',
        4 => 'mae_paciente',
    ];

	public function endereco()
	{
		return $this->hasOne(Endereco::class, 'id_paciente');
	}

    public static function getAllAjax($limit = 10, $page = 1, $search = '', $order, $filtro = null)
    {
        $list = Paciente::query();

        if(!empty( $search )){
            $searchableColumns = self::$searchableColumns;
            $list->where(function ($query) use ($searchableColumns, $search) {
                foreach($searchableColumns as $key => $column)
                    $query->orWhere($column, 'ILIKE', '%' . $search . '%');
            });
        }
        
        $list->orderBy( self::$orderableColumns[ $order[0]['column'] ] , $order[0]['dir']);
        
        return $list->paginate($limit, ['*'], 'page', $page);
    }

    public static function getById($id)
    {
	    $paciente = Paciente::with('endereco')
	        ->select('id', 'nome_paciente', 'mae_paciente', 'data_nasc', 'cpf', 'cns', 'foto', DB::raw("TO_CHAR(data_nasc, 'YYYY-MM-DD') AS data_nascimento"))
	        ->where('id', $id)
	        ->first();

	    return $paciente;
    }
}
