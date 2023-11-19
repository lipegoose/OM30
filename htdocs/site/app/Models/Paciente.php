<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
