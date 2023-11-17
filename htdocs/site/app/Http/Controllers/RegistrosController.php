<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registros = ['Registro 1', 'Registro 2', 'Registro 3', 'Registro 4', 123458 => 'Registro 5'];
        return view('index', ['registros' => $registros]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
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
