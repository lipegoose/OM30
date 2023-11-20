<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste de Seleção OM30 - By Mr.Goose</title>

    <!-- Adicionando Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Adicionando Font-Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div id="app" class="container mt-5">
        <!-- Migalha de Pão (Breadcrumb) -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/pacientes">Página Inicial</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar Paciente</li>
            </ol>
        </nav>

        <h1>Editar Paciente</h1>

        <form action="{{route('pacientes.update', ['paciente' => $paciente->id])}}" method="post" enctype="multipart/form-data" id="formModalPaciente">
            @csrf
            @method('PUT')
            <!-- Foto do Paciente -->
            <div class="form-group">
                <label for="foto">Foto do Paciente:</label>
                <input type="file" class="form-control" id="foto" name="foto">
                @if(!empty($paciente->foto))
                    <img src="/imgs/pacientes/{{$paciente->foto}}" id="foto" style="max-height: 100px;">
                @endif
            </div>

            <!-- Nome Completo do Paciente -->
            <div class="form-group">
                <label for="nome">Nome Completo do Paciente:*</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{$paciente->nome_paciente}}" required>
            </div>

            <!-- Nome Completo da Mãe -->
            <div class="form-group">
                <label for="nomeMae">Nome Completo da Mãe:*</label>
                <input type="text" class="form-control" id="nomeMae" name="nomeMae" value="{{$paciente->mae_paciente}}" required>
            </div>

            <div class="form-row">
                <!-- Data de Nascimento -->
                <div class="form-group col-md-3" style="float:left;">
                    <label for="dataNascimento">Data de Nascimento:*</label>
                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" value="{{$paciente->data_nascimento}}" required>
                </div>

                <!-- CPF -->
                <div class="form-group col-md-3" style="float:left;">
                    <label for="cpf">CPF:*</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" value="{{$paciente->cpf}}" required > <!-- pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" -->
                </div>

                <!-- CNS -->
                <div class="form-group col-md-6" style="float:left;">
                    <label for="cns">CNS (Cartão Nacional de Saúde):*</label>
                    <input type="text" class="form-control" id="cns" name="cns" value="{{$paciente->cns}}" required pattern="\d{15}">
                </div>
            </div>

            <!-- Endereço Completo -->
            <div class="form-row">
                <div class="form-group col-md-2" style="float:left;">
                    <label for="cep">CEP:*</label>
                    <input type="text" class="form-control" id="cep" name="cep" value="{{$paciente->endereco->cep}}" required>
                </div>
                <div class="form-group col-md-1" style="float:left;">
                    <label for="estado">UF:*</label>
                    <input type="text" class="form-control" id="estado" name="estado" value="{{$paciente->endereco->estado}}" required>
                </div>
                <div class="form-group col-md-5" style="float:left;">
                    <label for="cidade">Cidade:*</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{$paciente->endereco->cidade}}" required>
                </div>
                <div class="form-group col-md-4" style="float:left;">
                    <label for="bairro">Bairro:*</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" value="{{$paciente->endereco->bairro}}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-7" style="float:left;">
                    <label for="endereco">Endereço:*</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" value="{{$paciente->endereco->endereco}}" required>
                </div>
                <div class="form-group col-md-2" style="float:left;">
                    <label for="numero">Nº:*</label>
                    <input type="text" class="form-control" id="numero" name="numero" value="{{$paciente->endereco->numero}}" required>
                </div>
                <div class="form-group col-md-3" style="float:left;">
                    <label for="complemento">Complemento:</label>
                    <input type="text" class="form-control" id="complemento" name="complemento" value="{{$paciente->endereco->complemento}}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="submitModalPaciente">Salvar</button>
        </form>                        

    </div>

    @include('elements.loading')

    <!-- Adicionando jQuery, DataTables, Bootstrap JS, SweetAlert2 e Mask -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        // Inicializando DataTables
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            // Aplicando máscara de CPF
            $('#cpf').mask('000.000.000-00', {reverse: true});

            // Aplicando máscara de CEP
            $('#cep').mask('00000-000');
        });

        $('#cep').on('keyup', function(){
            let _val = $(this).val().replace(/\D/g, '');
            if(_val.length < 8){ return false; }

            dados = [];
            dados.push({
                name: '_token',
                value: $('[name=\"_token\"]').val()
            });
            dados.push({
                name: 'cep',
                value: _val
            });
            $.ajax({
                url: "{{ URL('consulta_cep') }}",
                type: 'POST',
                dataType: 'json',
                data: dados,
                complete: function(data) {
                    data = data;
                },
                success: function(data) {
                    if (data.uf)
                        $('#estado').val(data.uf);
                    if (data.localidade)
                        $('#cidade').val(data.localidade);
                    if (data.bairro)
                        $('#bairro').val(data.bairro);
                    if (data.logradouro){
                        $('#endereco').val(data.logradouro);
                        $('#numero').focus();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erro na requisição:', textStatus, errorThrown);
                }
            });
        });

        $('#cns').on('keyup', function(){
            let _val = $(this).val().replace(/\D/g, '');
            if(_val.trim().length !== 15){ return false; }

            if(["1", "2", "7", "8", "9"].includes(_val[0]))
                validaCns(_val);
            else
                msgCnsInvalido();
        });

        function validaCns(cns){
            if (cns.trim().length == 15){
                if (["1", "2"].includes(cns[0])) {
                    let soma = 0;
                    let resto, dv;
                    let pis = "";
                    let resultado = "";

                    pis = cns.substring(0, 11);

                    for (let i = 0; i < 11; i++) {
                        soma += parseInt(pis.charAt(i)) * (15 - i);
                    }

                    resto = soma % 11;
                    dv = 11 - resto;

                    if (dv === 11) {
                        dv = 0;
                    }

                    if (dv === 10) {
                        soma = 0;
                        for (let i = 0; i < 11; i++) {
                            soma += parseInt(pis.charAt(i)) * (15 - i);
                        }
                        soma += 2;
                        resto = soma % 11;
                        dv = 11 - resto;
                        resultado = pis + "001" + String.valueOf(parseInt(dv));
                    } else {
                        resultado = pis + "000" + String.valueOf(parseInt(dv));
                    }

                    if(cns !== resultado)
                        return msgCnsInvalido();

                } // close if (["1", "2"].includes(cns[0]))
                else if(["7", "8", "9"].includes(cns[0])){
                    let dv, resto, soma;

                    soma =
                        parseInt(cns.substring(0, 1)) * 15 +
                        parseInt(cns.substring(1, 2)) * 14 +
                        parseInt(cns.substring(2, 3)) * 13 +
                        parseInt(cns.substring(3, 4)) * 12 +
                        parseInt(cns.substring(4, 5)) * 11 +
                        parseInt(cns.substring(5, 6)) * 10 +
                        parseInt(cns.substring(6, 7)) * 9 +
                        parseInt(cns.substring(7, 8)) * 8 +
                        parseInt(cns.substring(8, 9)) * 7 +
                        parseInt(cns.substring(9, 10)) * 6 +
                        parseInt(cns.substring(10, 11)) * 5 +
                        parseInt(cns.substring(11, 12)) * 4 +
                        parseInt(cns.substring(12, 13)) * 3 +
                        parseInt(cns.substring(13, 14)) * 2 +
                        parseInt(cns.substring(14, 15)) * 1;

                    resto = soma % 11;

                    if(resto !== 0)
                        return msgCnsInvalido();
                } // close if (["7", "8", "9"].includes(cns[0]))
                else
                    return msgCnsInvalido();

            } // close if (cns.trim().length == 15)
        }

        function msgCnsInvalido(){
            Swal.fire({
              title: "CNS Inválido!",
              text: "Este número não corresponde a um CNS válido!",
              icon: "error"
            });
            $('#cns').focus();
        }
    </script>

</body>
</html>