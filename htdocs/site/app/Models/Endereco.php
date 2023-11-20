<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Endereco
 * 
 * @property int $id
 * @property int $id_paciente
 * @property string|null $cep
 * @property string|null $estado
 * @property string|null $cidade
 * @property string|null $bairro
 * @property string|null $endereco
 * @property string|null $numero
 * @property string|null $complemento
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Paciente $paciente
 *
 * @package App\Models
 */
class Endereco extends Model
{
	use SoftDeletes;
	protected $table = 'enderecos';

	protected $casts = [
		'id_paciente' => 'int'
	];

	protected $fillable = [
		'id_paciente',
		'cep',
		'estado',
		'cidade',
		'bairro',
		'endereco',
		'numero',
		'complemento'
	];

	public function paciente()
	{
		return $this->belongsTo(Paciente::class, 'id_paciente');
	}
}
