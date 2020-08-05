<?php // pr($this->data['Aluno']['nascimento']);   ?>
<?= $this->Html->script("jquery.mask.min"); ?>
<script>
    $(document).ready(function () {

        $("#AlunoRegistro").mask("999999999");
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
<br>
<h5>Editar</h5>

<?php
$hoje = date('Y/m/d', strtotime('today'));
$datanascimento = date('Y-m-d', strtotime($this->data['Aluno']['nascimento']));
// echo $datanascimento;
?>

<?php
echo $this->Form->create("Aluno", ['inputDefaults' => [
        'div' => ['class' => 'form-group row'],
        'label' => ['class' => 'col-lg-3 col-form-label'],
        'between' => '<div class = "col-lg-9">',
        'after' => '</div>',
        'class' => 'form-control']
]);
?>
<?= $this->Form->input('nome'); ?>
<?= $this->Form->input('registro'); ?>
<div class = "form-group row">
    <label class = 'col-lg-3 col-form-label' for="AlunoNascimento">Data de nascimento</label>
    <div class ="col-lg-9">
        <input type="date" name="data[Aluno][nascimento]" id='AlunoNascimento' value="<?= $datanascimento ?>" max="2100-12-31" min="1900-01-01" class="form-control">
    </div>
</div>
<?= $this->Form->input('cpf'); ?>
<?= $this->Form->input('identidade'); ?>
<?= $this->Form->input('orgao'); ?>
<?= $this->Form->input('email'); ?>
<?= $this->Form->input('codigo_telefone', array('default' => 21)); ?>
<?= $this->Form->input('telefone'); ?>
<?= $this->Form->input('codigo_celular', array('default' => 21)); ?>
<?= $this->Form->input('celular'); ?>
<?= $this->Form->input('cep'); ?>
<?= $this->Form->input('endereco', ['label' => ['text' => 'Endereço', 'class' => 'col-lg-3 col-form-label']]); ?>
<?= $this->Form->input('bairro'); ?>
<?= $this->Form->input('municipio', array('default' => 'Rio de Janeiro')); ?>
<?= $this->Form->input('id', array('type' => 'hidden')); ?>
<br>
<div class="row justify-content-center">
    <div class="col-auto">
        <?= $this->Form->input('Atualizar', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-success position-static']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>