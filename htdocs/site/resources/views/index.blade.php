<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste de Seleção OM30 - By Mr.Goose</title>

    <!-- Adicionando Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Adicionando DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- Adicionando Font-Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div id="app" class="container mt-5">
        <h1>Lista de Pacientes</h1>

        <!-- Botões -->
        <div class="mb-3 d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-danger btn_excluir_massa"><i class="fa fa-trash"></i> Excluir em Massa</button>
            <button class="btn btn-success ms-auto btn_new" data-toggle="modal" data-target="#novoPacienteModal">Novo Paciente</button>
        </div>

        <form id="form_excluir_massa">
            @csrf
            <!-- Tabela com DataTables -->
            <table class="table table-striped" id="pacientesTable" style="width:100%">
                <thead>
                    <tr>
                        <th class="no-sort" style="width: 10px;"><span><input name="check_todos" type="checkbox" class="ml-2" id="check_todos" style="cursor: pointer;" /> </span></th>
                        <th class="text-center" style="width: 20px;">ID</th>
                        <th class="text-center" style="width: 130px;">Ações</th>
                        <th>Paciente</th>
                        <th>Mãe</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>

    <!-- Modal para Novo Paciente -->
    <div class="modal fade" id="novoPacienteModal" tabindex="-1" role="dialog" aria-labelledby="novoPacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novoPacienteModalLabel"><span id="acaoModal">Novo</span> Paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" enctype="multipart/form-data" id="formModalPaciente">
                        @csrf
                        <input type="hidden" name="id_paciente" id="id_paciente">
                        <!-- Foto do Paciente -->
                        <div class="form-group">
                            <label for="foto">Foto do Paciente:</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>

                        <!-- Nome Completo do Paciente -->
                        <div class="form-group">
                            <label for="nome">Nome Completo do Paciente:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>

                        <!-- Nome Completo da Mãe -->
                        <div class="form-group">
                            <label for="nomeMae">Nome Completo da Mãe:</label>
                            <input type="text" class="form-control" id="nomeMae" name="nomeMae" required>
                        </div>

                        <div class="form-row">
                            <!-- Data de Nascimento -->
                            <div class="form-group col-md-3" style="float:left;">
                                <label for="dataNascimento">Data de Nascimento:</label>
                                <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required>
                            </div>

                            <!-- CPF -->
                            <div class="form-group col-md-3" style="float:left;">
                                <label for="cpf">CPF:</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}">
                            </div>

                            <!-- CNS -->
                            <div class="form-group col-md-6" style="float:left;">
                                <label for="cns">CNS (Cartão Nacional de Saúde):</label>
                                <input type="text" class="form-control" id="cns" name="cns" required pattern="\d{15}">
                            </div>
                        </div>

                        <!-- Endereço Completo -->
                        <div class="form-row">
                            <div class="form-group col-md-2" style="float:left;">
                                <label for="cep">CEP:</label>
                                <input type="text" class="form-control" id="cep" name="cep" required>
                            </div>
                            <div class="form-group col-md-1" style="float:left;">
                                <label for="estado">UF:</label>
                                <input type="text" class="form-control" id="estado" name="estado" required>
                            </div>
                            <div class="form-group col-md-5" style="float:left;">
                                <label for="cidade">Cidade:</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" required>
                            </div>
                            <div class="form-group col-md-4" style="float:left;">
                                <label for="bairro">Bairro:</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-7" style="float:left;">
                                <label for="endereco">Endereço:</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" required>
                            </div>
                            <div class="form-group col-md-2" style="float:left;">
                                <label for="numero">Nº:</label>
                                <input type="text" class="form-control" id="numero" name="numero" required>
                            </div>
                            <div class="form-group col-md-3" style="float:left;">
                                <label for="complemento">Complemento:</label>
                                <input type="text" class="form-control" id="complemento" name="complemento">
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary" id="submitModalPaciente">Salvar</button>
                    </form>                        
                </div>
            </div>
        </div>
    </div>
    @include('elements.loading')

    <!-- Adicionando jQuery, DataTables, Bootstrap JS e SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        // Inicializando DataTables
        $(document).ready(function () {
            table = $('#pacientesTable').DataTable({
                "processing": true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "pacientes/table_data",
                    type: "GET",
                    data: function(d) {
                        // console.log(d)
                    },
                    complete: function(data) {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    error: function (xhr, error, code) {
                        Swal.fire({
                            title: "Erro interno",
                            text: "Ops, ocorreu um erro. Nossa equipe de engenheiros já está trabalhando para corrigir o problema!",
                            icon: "error",
                            confirmButtonText: "Ok!",
                            buttonsStyling: true
                        });
                    }
                },
                columns: [
                    {"data": "btn_check",  class: 'cod text-center', orderable: false},
                    {"data": "id",  class: 'cod text-center'},
                    {"data": "buttons", orderable: false, class: 'align-items-center justify-content-center text-center ws_nwrap',
                        "render": function(data){
                            return '<div class="btn-group align-items-center justify-content-center"> '+data+'</div>';
                        }
                    },
                    {"data": "nome_paciente", class: 'ws_nwrap'},
                    {"data": "mae_paciente", class: 'ws_nwrap'}
                ],
                order: [[1, 'desc']],
                "pageLength": 10,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
                }
            });
        });

        $("#check_todos").on("change", function () {
            var _checked = $('#check_todos:checked');

            if (_checked.length > 0) {
                $('[name="check_rep[]"]').prop("checked", true)
            } else {
                $('[name="check_rep[]"]').prop("checked", false)
            }
        })

        $("#pacientesTable").on("change", '[name="check_rep[]"]', function () {
            var _checked = $(this).prop('checked');
            if (!_checked)
                $('#check_todos').prop("checked", false)
        })

        $(".btn_excluir_massa").on("click", function() {
            Swal.fire({
                title: "ATENÇÃO",
                text: "Tem certeza que quer deletar estes Pacientes em massa? Esta ação não terá volta.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
                buttonsStyling: true
            }).then(function(result) {
                if(result.value) {
                    $("#myLoading").modal();
                    dados = $('#form_excluir_massa').serializeArray(); // Dados do Formulário atual.
                    dados.push({
                        name: '_method',
                        value: 'DELETE'
                    });
                    $.ajax({
                        url: "{{ URL('pacientes') }}/delete",
                        type: 'POST',
                        dataType: 'json',
                        data: dados,
                        complete: function(data) {
                            data = data.responseJSON;
                        },
                        success: function(data) {
                            if (data.flash_error){
                                Swal.fire({
                                    text: data.flash_error,
                                    icon: "info",
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Entendi!",
                                    buttonsStyling: true
                                });                        
                            }
                            $("#myLoading").modal('hide');
                            table.draw();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Erro na requisição:', textStatus, errorThrown);
                        }
                    });
                }
            });
        });

        $("#pacientesTable").on("click", ".btn_destroy", function() {
            let _this = $(this);
            Swal.fire({
                title: "ATENÇÃO",
                text: "Tem certeza que quer deletar este Paciente? Esta ação não terá volta.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
                buttonsStyling: true
            }).then(function(result) {
                if(result.value) {
                    $("#myLoading").modal();
                    dados = [];
                    dados.push({
                        name: 'check_rep[]',
                        value: _this.attr('id-paciente')
                    });
                    dados.push({
                        name: '_token',
                        value: $('[name=\"_token\"]').val()
                    });
                    dados.push({
                        name: '_method',
                        value: 'DELETE'
                    });
                    $.ajax({
                        url: "{{ URL('pacientes') }}/delete",
                        type: 'POST',
                        dataType: 'json',
                        data: dados,
                        complete: function(data) {
                            data = data.responseJSON;
                        },
                        success: function(data) {
                            $("#myLoading").modal('hide');
                            if(data == true){
                                Swal.fire({
                                    text: "Paciente excluído com sucesso!",
                                    icon: "success",
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Entendi!",
                                    buttonsStyling: true
                                }).then(function(result) {
                                    table.draw();
                                });
                            }else{
                                $("#myLoading").modal('hide');
                                Swal.fire({
                                    text: data,
                                    icon: "info",
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Entendi!",
                                    buttonsStyling: true
                                });
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Erro na requisição:', textStatus, errorThrown);
                        }
                    });
                }
            });
        });

        $("#app").on("click", ".btn_new", function() {
            $('#acaoModal').html('Novo');
            $('#submitModalPaciente').show();
            reset_form_add_paciente();
        });

        $("#pacientesTable").on("click", ".btn_edit", function() {
            $('#acaoModal').html('Editar');
            $("#novoPacienteModal").modal();
            $('#submitModalPaciente').show();
            populaFormPaciente($(this).attr('id-paciente'));
            $('#id_paciente').val($(this).attr('id-paciente'));
        });

        $("#pacientesTable").on("click", ".btn_view", function() {
            $('#acaoModal').html('Visualizar');
            $('#submitModalPaciente').hide();
            $("#novoPacienteModal").modal();
            populaFormPaciente($(this).attr('id-paciente'));
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
                    $('#endereco').val(data.logradouro);
                    $('#bairro').val(data.bairro);
                    $('#estado').val(data.uf);
                    $('#cidade').val(data.localidade);
                    $('#numero').focus();
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

        $('#formModalPaciente').on('click', "#submitModalPaciente", function(){
            dados = $(this).closest('form').serializeArray(); // Dados do Formulário atual.
            pacienteId = $('#id_paciente').val();
            if (!pacienteId) {
                url = "{{URL('pacientes')}}";
                type = 'POST';
            }
            else{
                url = "{{ route('pacientes.update', ['paciente' => '__pacienteId__']) }}".replace('__pacienteId__', pacienteId);
                type = 'PUT';                
            }
            $.ajax({
                url: url,
                type: type,
                dataType: 'json',
                data: dados,
                complete: function(data) {
                    data = data.responseJSON;
                    // console.log(data);
                },
                success: function(data) {
                    reset_form_add_paciente();
                    table.draw();
                    $("#novoPacienteModal").modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erro na requisição:', textStatus, errorThrown);
                }
            });
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

        function populaFormPaciente(pacienteId){
            reset_form_add_paciente();
            $.ajax({
                url: "{{ route('pacientes.show', ['paciente' => '__pacienteId__']) }}".replace('__pacienteId__', pacienteId),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#nome').val(data.nome_paciente);
                    $('#nomeMae').val(data.mae_paciente);
                    $('#dataNascimento').val(data.data_nascimento);
                    $('#cns').val(data.cns);
                    $('#cpf').val(data.cpf);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erro na requisição:', textStatus, errorThrown);
                }
            });
        }

        function reset_form_add_paciente() {
            $('#id_paciente').val('');
            $('#formModalPaciente').each(function() {
                this.reset();
            }); // limpa os inputs
        }
    </script>

</body>
</html>