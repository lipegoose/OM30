<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\PacientesImport;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use Redirect;

use App\Models\Endereco;
use App\Models\Paciente;


class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }


    public function tableData(Request $request)
    {
        try{
            $controller = get_class($this);

            $limit  = $request->input('length');
            $start  = $request->input('start');
            $search = $request->input('search.value');
            $order  = $request->get('order');

            $page = ($start/$limit) + 1;

            $linhas = Paciente::getAllAjax($limit, $page, $search, $order);

            $totalFiltered = $linhas->total();
            $totalData = $linhas->total();

            $data = [];

            if (!empty($linhas)) {
                foreach ($linhas as $linha) {
                    $buttons = 
                            "<button type='button' data-toggle='tooltip' title='Visualizar' class='btn btn-sm btn-icon btn-primary btn_view' id-paciente='$linha->id'>
                                        <i class='fa fa-eye'></i>
                                    </button>" .
                            "<button type='button' data-toggle='tooltip' title='Editar Rápido' class='btn btn-sm btn-icon btn-warning btn_edit' id-paciente='$linha->id'>
                                        <i class='fa fa-edit'></i>
                                    </button>" .
                            "<a href='pacientes/$linha->id/edit' data-toggle='tooltip' title='Editar Completo' class='btn btn-sm btn-icon btn-success' id-paciente='$linha->id'>
                                        <i class='fa fa-file-pen'></i>
                                    </a>" .
                            "<button type='button' data-toggle='tooltip' title='Deletar' class='btn btn-sm btn-icon btn-danger btn_destroy' id-paciente='$linha->id'>
                                        <i class='fa fa-trash'></i>
                                    </button>";

                    $btn_checked = "<input type='checkbox' name='check_rep[]' value='$linha->id' />";

                    $nome = "<span>".$linha->nome_paciente."</span>";

                    $nestedData['btn_check']    = $btn_checked;
                    $nestedData['id']           = $linha->id;
                    $nestedData['buttons']      = $buttons;
                    $nestedData['nome_paciente']= $linha->nome_paciente;
                    $nestedData['mae_paciente'] = $linha->mae_paciente;

                    $data[] = $nestedData;
                }
            }

            $json_data = [
                "draw" => (int)$request->input('draw'),
                "recordsTotal" => $totalData,
                "recordsFiltered" => $totalFiltered,
                "data" => $data,
            ];

            return response()->json($json_data);
        }catch(Exception $e){
            return Response::json(array(
                'code'      =>  500,
                'message'   =>  "Ops, ocorreu um erro. Nossa equipe de engenheiros já está trabalhando para corrigir o problema!" #. $e->getMessage()
            ), 500);  
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $store = $request->all();

            DB::beginTransaction();

            $paciente = new Paciente();
            $paciente->nome_paciente = $store['nome'];
            $paciente->mae_paciente = $store['nomeMae'];
            $paciente->data_nasc = $store['dataNascimento'];
            $paciente->cpf = str_replace(['.', '-'], '', $store['cpf']);
            $paciente->cns = $store['cns'];

            // Verifica se uma imagem foi enviada
            if ($request->hasFile('foto')) {
                $fotoNome = 'paciente_'.$id.".".strtolower($request->file('foto')->getClientOriginalExtension());
                $request->file('foto')->move(public_path('imgs/pacientes'), $fotoNome);
                $paciente->foto = $fotoNome; // Salva o nome da imagem no BD
            }

            $paciente->save();

            $endereco = new Endereco();
            $endereco->id_paciente = $paciente->id;
            $endereco->cep = str_replace(['.', '-'], '', $store['cep']);
            $endereco->estado = $store['estado'];
            $endereco->cidade = $store['cidade'];
            $endereco->bairro = $store['bairro'];
            $endereco->endereco = $store['endereco'];
            $endereco->numero = $store['numero'];
            $endereco->complemento = $store['complemento'];
            $endereco->save();

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
        }

        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paciente = Paciente::getById($id);
        return response()->json($paciente);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paciente = Paciente::getById($id);
        return view('edit', ['paciente' => $paciente]);
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
        try {
            $request->validate([
                'nome' => 'required',
                'nomeMae' => 'required',
                'dataNascimento' => 'required|date',
                'cpf' => 'required',
                'cns' => 'required',
                'cep' => 'required',
                'estado' => 'required',
                'cidade' => 'required',
                'bairro' => 'required',
                'endereco' => 'required',
                'numero' => 'required'
            ]);

            DB::beginTransaction();

            $paciente = Paciente::find($id);
            $paciente->update([
                'nome_paciente' => $request->input('nome'),
                'mae_paciente' => $request->input('nomeMae'),
                'data_nasc' => $request->input('dataNascimento'),
                'cpf' => str_replace(['.', '-'], '', $request->input('cpf')),
                'cns' => $request->input('cns')
            ]);

            $paciente->endereco->update([
                'cep' => str_replace(['.', '-'], '', $request->input('cep')),
                'estado' => $request->input('estado'),
                'cidade' => $request->input('cidade'),
                'bairro' => $request->input('bairro'),
                'endereco' => $request->input('endereco'),
                'numero' => $request->input('numero'),
                'complemento' => $request->input('complemento')
            ]);
            // Verifica se uma imagem foi enviada
            if ($request->hasFile('foto')) {
                $fotoNome = 'paciente_'.$id.".".strtolower($request->file('foto')->getClientOriginalExtension());
                $request->file('foto')->move(public_path('imgs/pacientes'), $fotoNome);
                $paciente = Paciente::find($id);
                $paciente->foto = $fotoNome; // Salva o nome da imagem no BD
                $paciente->save();
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }

        if (empty($request->input('id_paciente')))
            return Redirect::to('/pacientes');
        else
            return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $store = $request->all();

            if (isset($store['check_rep']) && is_array($store['check_rep']) && count($store['check_rep']) > 0) {
                DB::beginTransaction();

                try {
                    Paciente::whereIn('id', $store['check_rep'])
                        ->with('endereco')
                        ->get()
                        ->each(function ($paciente) {
                            $paciente->endereco()->update(['deleted_at' => now()]);
                        });

                    Paciente::whereIn('id', $store['check_rep'])
                        ->update(['deleted_at' => now()]);

                    DB::commit();

                } catch (Exception $e) {
                    DB::rollback();
                    return response()->json(['flash_error' => 'Erro ao excluir Pacientes! Entre em contato com o Suporte.']);
                }
            }

        } catch (Exception $e) {
            return response()->json(['flash_error' => 'Erro ao processar a solicitação.']);
        }

        return response()->json(true);
    }

    public function consultaCep(Request $request)
    {
        $store = $request->all();
        $CURL = curl_init();
        curl_setopt($CURL, CURLOPT_URL, config("app.plug_cep_url").$store['cep'].'/json/');
        curl_setopt($CURL, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($CURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=UTF-8'
        ));
        curl_setopt($CURL, CURLOPT_POST, false);
        curl_setopt($CURL, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($CURL, CURLOPT_TIMEOUT, 10);
        curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
        $CURL_resp = curl_exec($CURL);
        $dados = json_decode($CURL_resp);
        $curl_resp_arr = array(
            'response' => $dados,
            'info' => curl_getinfo($CURL),
            'errors' => curl_error($CURL),
            'localidade' => empty($dados->localidade) ? null : $dados->localidade,
            'uf' => empty($dados->uf) ? null : $dados->uf,
            'bairro' => empty($dados->bairro) ? null : $dados->bairro,
            'logradouro' => empty($dados->logradouro) ? null : $dados->logradouro
        );

        curl_close($CURL);

        return response()->json($curl_resp_arr);
    }

    public function importar(Request $request)
    {
        $this->validate($request, [
            'ARQ' => 'required|mimes:csv,txt|max:10240', // Limite de 10MB
        ]);

        try {
            $file = $request->file('ARQ');

            // Processamento em fila
            Excel::queueImport(new PacientesImport, $file);
            // Excel::import(new PacientesImport, $file);

            return response()->json(['status' => 'A importação foi iniciada e será processada em segundo plano.']);
            // return redirect()->back()->with('status', 'A importação foi iniciada e será processada em segundo plano.');
        } catch (\Exception $e) {
            return response()->json(['status' => 'erro', 'mensagem' => $e->getMessage()]);
        }
    }
}
