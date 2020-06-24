<?php
echo $this->Html->script("jquery.maskedinput-1.3.1", array('inline' => false));
?>
<script>

    $(document).ready(function () {

        /* $("#AlunoRegistro").mask("99999.9999"); */
        $("#AlunoCpf").mask("999999999-99");
        $("#AlunoTelefone").mask("9999.9999");
        $("#AlunoCelular").mask("99999.9999");
        $("#AlunoCep").mask("99999-999");
    });

    /* Adicionando Javascript para busca de CEP */
    $(document).ready(function () {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#AlunoEndereco").val("");
            $("#AlunoBairro").val("");
            $("#AlunoMunicipio").val("");
            $("#uf").val("");
            $("#ibge").val("");
        }

        //Quando o campo cep perde o foco.
        $("#AlunoCep").blur(function () {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
                /* alert(cep); */
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;
                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#AlunoEndereco").val("...");
                    $("#Alunobairro").val("...");
                    $("#AlunoMunicipio").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");
                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#AlunoEndereco").val(dados.logradouro);
                            $("#AlunoBairro").val(dados.bairro);
                            $("#AlunoMunicipio").val(dados.localidade);
                            $("#uf").val(dados.uf);
                            $("#ibge").val(dados.ibge);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else
                {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });
    });

</script>

<?= $this->element('submenu_alunos'); ?>

<?php
/*
 * O cadastro do aluno pode receber a informacao da tabela Estudante
 */

if (!isset($alunonovo['Estudante']['nome']))
    $alunonovo['Estudante']['nome'] = NULL;
if (!isset($alunonovo['Estudante']['registro']))
    $alunonovo['Estudante']['registro'] = NULL;
if (!isset($registro))
    $registro = NULL;
if (!isset($alunonovo['Estudante']['nascimento'])):
    $datanascimento = NULL;
else:
    $datanascimento = date('d/m/Y', strtotime($alunonovo['Estudante']['nascimento']));
endif;
if (!isset($alunonovo['Estudante']['cpf']))
    $alunonovo['Estudante']['cpf'] = NULL;
if (!isset($alunonovo['Estudante']['identidade']))
    $alunonovo['Estudante']['identidade'] = NULL;
if (!isset($alunonovo['Estudante']['orgao']))
    $alunonovo['Estudante']['orgao'] = NULL;
if (!isset($alunonovo['Estudante']['email']))
    $alunonovo['Estudante']['email'] = NULL;
if (!isset($alunonovo['Estudante']['codigo_telefone']))
    $alunonovo['Estudante']['codigo_telefone'] = 21;
if (!isset($alunonovo['Estudante']['telefone']))
    $alunonovo['Estudante']['telefone'] = NULL;
if (!isset($alunonovo['Estudante']['codigo_celular']))
    $alunonovo['Estudante']['codigo_celular'] = NULL;
if (!isset($alunonovo['Estudante']['celular']))
    $alunonovo['Estudante']['celular'] = NULL;
if (!isset($alunonovo['Estudante']['endereco']))
    $alunonovo['Estudante']['endereco'] = NULL;
if (!isset($alunonovo['Estudante']['bairro']))
    $alunonovo['Estudante']['bairro'] = NULL;
if (!isset($alunonovo['Estudante']['municipio']))
    $alunonovo['Estudante']['municipio'] = NULL;
if (!isset($alunonovo['Estudante']['cep']))
    $alunonovo['Estudante']['cep'] = NULL;
?>

<h1>Cadastro de estudante</h1>

<?php
echo $this->Form->create('Aluno');
?>

<fieldset class="form-group">
    <legend>Dados do estudante</legend>

    <div class="form-row">
        <div class='col-7'>
            <?php echo $this->Form->input('nome', ['value' => $alunonovo['Estudante']['nome'], 'class' => 'form-control']); ?>
        </div>
        <div class='col'>
            <?php echo $this->Form->input('registro', ['value' => $registro, 'size' => '9', 'maxLenght' => '9', 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class='form-row'>
        <div class="col">
            <label for="AlunoNascimento">Data de nascimento</label>
            <input type="date" name="data[Aluno][nascimento]" id='AlunoNascimento' value="<?= $datanascimento ?>" max="2100-12-31" min="1900-01-01" class="form-control">
        </div>
        <div class="col">
            <?php echo $this->Form->input('cpf', ['label' => 'CPF', 'value' => $alunonovo['Estudante']['cpf'], 'class' => 'form-control']); ?>
        </div>
        <div class='col'>
            <?php echo $this->Form->input('identidade', ['label' => 'Cartera de identidade', 'value' => $alunonovo['Estudante']['identidade'], 'class' => 'form-control']); ?>
        </div>
        <div class='col'>
            <?php echo $this->Form->input('orgao', ['label' => 'Orgão expedidor', 'legend' => false, 'value' => $alunonovo['Estudante']['orgao'], 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class='form-row'>
        <div class="col">
            <?php echo $this->Form->input('email', ['value' => $alunonovo['Estudante']['email'], 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class='form-row'>
        <div class="col">
            <?php echo $this->Form->input('codigo_telefone', ['default' => 21, 'value' => $alunonovo['Estudante']['codigo_telefone'], 'class' => 'form-control']); ?>
        </div>
        <div class="col">
            <?php echo $this->Form->input('telefone', ['value' => $alunonovo['Estudante']['telefone'], 'class' => 'form-control']); ?>
        </div>
        <div class="col">
            <?php echo $this->Form->input('codigo_celular', ['default' => 21, 'value' => $alunonovo['Estudante']['codigo_celular'], 'class' => 'form-control']); ?>
        </div>
        <div class="col">
            <?php echo $this->Form->input('celular', ['value' => $alunonovo['Estudante']['celular'], 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class='form-row'>
        <div class="col-2">
            <?php echo $this->Form->input('cep', ['value' => $alunonovo['Estudante']['cep'], 'class' => 'form-control']); ?>
        </div>
        <div class="col">
            <?php echo $this->Form->input('endereco', ['label' => 'Endereço', 'value' => $alunonovo['Estudante']['endereco'], 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class='form-row'>
        <div class="col">
            <?php echo $this->Form->input('bairro', ['value' => $alunonovo['Estudante']['bairro'], 'class' => 'form-control']); ?>
        </div>
        <div class="col">
            <?php echo $this->Form->input('municipio', ['value' => $alunonovo['Estudante']['municipio'], 'default' => 'Rio de Janeiro, RJ', 'class' => 'form-control']); ?>
        </div>
    </div>
    <br/>
    <div class="form-row">
        <div class="col">
            <?php echo $this->Form->input('Confirima', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-primary position-static']); ?>
        </div>
    </div>
</fieldset>

<?php
echo $this->Form->end();
?>
