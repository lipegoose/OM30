<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Paciente;

use DB;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pacientes = ['Registro 1', 'Registro 2', 'Registro 3', 'Registro 4', 123458 => 'Registro 5'];
        return view('index', ['pacientes' => $pacientes]);
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
                            "<button type='button' data-toggle='tooltip' title='Editar' class='btn btn-sm btn-icon btn-warning btn_edit' id-paciente='$linha->id'>
                                        <i class='fa fa-edit'></i>
                                    </button>" .
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
            $paciente->cpf = $store['cpf'];
            $paciente->cns = $store['cns'];
            // $paciente->foto = $store['foto'];
            $paciente->save();

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

            if (isset($store['check_rep']) && is_array($store['check_rep']) && count($store['check_rep']) > 0)
            foreach($store['check_rep'] AS $id){
                if (!empty($id)) {
                    DB::beginTransaction();

                    $paciente               = Paciente::find($id);

                    $paciente->deleted_at   = date('Y-m-d H:i:s');
                    $paciente->save();

                    DB::commit();
                }
            } // close foreach($store['check_rep'] AS $id)

        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['flash_error' => 'Erro ao excluir Paciente! Entre em contato com o Suporte.']);
        }

        return response()->json(true);
    }

    public function consultaCep(Request $request)
    {
        $store = $request->all();

        $CURL = curl_init();
        curl_setopt($CURL, CURLOPT_URL, ENV("PLUG_CEP").$store['cep'].'/json/');
        curl_setopt($CURL, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($CURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=UTF-8',
            'x-api-key: '. ENV("PLUG_KEY")
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
}
