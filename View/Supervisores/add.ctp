<?= $this->element('submenu_supervisores'); ?>

<?= $this->Html->script("jquery.mask.min"); ?>

<script>
    $(document).ready(function () {

        $("#SupervisorCpf").mask('999999999-99');
        $("#SupervisorTelefone").mask('9999.9999');
        $("#SupervisorCelular").mask('99999.9999');
        $("#SupervisorCep").mask('99999-999');

    });

    /* Adicionando Javascript para busca de CEP */
    $(document).ready(function () {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#SupervisorEndereco").val("");
            $("#SupervisorBairro").val("");
            $("#SupervisorMunicipio").val("");
            $("#uf").val("");
            $("#ibge").val("");
        }

        //Quando o campo cep perde o foco.
        $("#SupervisorCep").blur(function () {

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
                    $("#SupervisorEndereco").val("...");
                    $("#SupervisorBairro").val("...");
                    $("#SupervisorMunicipio").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");
                    //Consulta o webservice viacep.com.br/

                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#SupervisorEndereco").val(dados.logradouro);
                            $("#SupervisorBairro").val(dados.bairro);
                            $("#SupervisorMunicipio").val(dados.localidade);
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

<?= $this->Form->create('Supervisor'); ?>
<div class="form-group row">
    <label for="SupervisorRegiao" class="col-sm-2 col-form-label">Região</label>
    <div class="col-sm-2">
        <?= $this->Form->input('regiao', ['label' => false, 'default' => 7, 'class' => 'form-control']); ?>
    </div>
    <label for="SupervisorCress" class="col-sm-1 col-form-label">CRESS</label>
    <div class="col-sm-4">
        <?= $this->Form->input('cress', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorNome" class="col-sm-2 col-form-label">Nome</label>
    <div class="col-sm-10">
        <?= $this->Form->input('nome', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorCpf" class="col-sm-2 col-form-label">CPF</label>
    <div class="col-sm-10">
        <?= $this->Form->input('cpf', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class='form-group row'>
    <label for="SupervisorTelefone" class="col-sm-2 col-form-label">Telefone</label>
    <div class="col-sm-3">
        <?= $this->Form->input('codigo_tel', array('label' => false, 'default' => 21, 'class' => 'form-control')); ?>
    </div>
    <div class="col-sm-5">
        <?= $this->Form->input('telefone', ['label' => false, 'div' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class='form-group row'>
    <label for="SupervisorCelular" class="col-sm-2 col-form-label">Celular</label>
    <div class="col-sm-3">
        <?= $this->Form->input('codigo_cel', array('label' => false, 'default' => 21, 'class' => 'form-control')); ?>
    </div>
    <div class="col-sm-5">
        <?= $this->Form->input('celular', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorEmail" class="col-sm-2 col-form-label">E-mail</label>
    <div class="col-sm-10">
        <?= $this->Form->input('email', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorCep" class="col-sm-2 col-form-label">CEP</label>
    <div class="col-sm-10">
        <?= $this->Form->input('cep', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorEndereco" class="col-sm-2 col-form-label">Endereço</label>
    <div class="col-sm-10">
        <?= $this->Form->input('endereco', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorBairro" class="col-sm-2 col-form-label">Bairro</label>
    <div class="col-sm-10">
        <?= $this->Form->input('bairro', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorMunicipio" class="col-sm-2 col-form-label">Município</label>
    <div class="col-sm-10">
        <?= $this->Form->input('municipio', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorEscola" class="col-sm-2 col-form-label">Escola</label>
    <div class="col-sm-10">
        <?= $this->Form->input('escola', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorAnoFormatura" class="col-sm-2 col-form-label">Ano da formatura</label>
    <div class="col-sm-10">
        <?= $this->Form->input('ano_formatura', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorOutrosEstudos" class="col-sm-2 col-form-label">Outros estudos</label>
    <div class="col-sm-10">
        <?= $this->Form->input('outros_estudos', ['label' => false, 'placeholder' => 'Atualização, Especialização, Mestrado, Doutorado, Pós-doutorado', 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorAreaCurso" class="col-sm-2 col-form-label">Área do curso</label>
    <div class="col-sm-10">
        <?= $this->Form->input('area_curso', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorAnoCurso" class="col-sm-2 col-form-label">Ano do curso</label>
    <div class="col-sm-10">
        <?= $this->Form->input('ano_curso', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <?= $this->Form->label('curso_turma', 'Turma do curso de supervisores', ['class' => 'col-sm-2 col-form-label']); ?>
    <div class="col-sm-10">
        <?= $this->Form->input('curso_turma', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <?= $this->Form->label('num_inscricao', 'Número de inscrição', ['class' => 'col-sm-2 col-form-label']); ?>
    <div class="col-sm-10">
        <?= $this->Form->input('num_inscricao', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorObservacores" class="col-sm-2 col-form-label">Observações</label>
    <div class="col-sm-10">
        <?= $this->Form->input('observacoes', ['label' => false, 'class' => 'col-lg-2 col-form-label', 'textarea' => ['rows' => 5, 'cols' => 60], 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group row">
    <label for="SupervisorInstituicaoId" class="col-sm-2 col-form-label">Instituições</label>
    <div class="col-sm-10">
        <?= $this->Form->input('Instituicao.id', ['label' => false, 'class' => 'col-lg-2 col-form-label', 'options' => $instituicoes, 'default' => 0, 'class' => 'form-control']); ?>
    </div>
</div>
<br>
<div class='row justify-content-center'>
    <div class='col-auto'>
        <?= $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>