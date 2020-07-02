<?php ?>

<script>
    $(document).ready(function () {

        $("#EstudanteCpf").mask("999999999-99");
        $("#EstudanteTelefone").mask("9999.9999");
        $("#EstudanteCelular").mask("99999.9999");
        $("#EstudanteCep").mask("99999-999");
    });

    /* Adicionando Javascript para busca de CEP */
    $(document).ready(function () {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#EstudanteEndereco").val("");
            $("#EstudanteBairro").val("");
            $("#EstudanteMunicipio").val("");
            $("#uf").val("");
            $("#ibge").val("");
        }

        //Quando o campo cep perde o foco.
        $("#EstudanteCep").blur(function () {

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
                    $("#EstudanteEndereco").val("...");
                    $("#EstudanteBairro").val("...");
                    $("#EstudanteMunicipio").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");
                    //Consulta o webservice viacep.com.br/

                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#EstudanteEndereco").val(dados.logradouro);
                            $("#EstudanteBairro").val(dados.bairro);
                            $("#EstudanteMunicipio").val(dados.localidade);
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

<?= $this->element('submenu_estudantes'); ?>

<h5>Cadastro de estudante para estágio</h5>

<?php echo $this->Form->create('Estudante'); ?>

<fieldset>
    <legend>Dados do aluno</legend>

    <!--
    Verifico que tenha um número e que seja de um estudante
    //-->
    <?php if ($this->Session->read('numero') || ($this->Session->read('categoria') === 'estudante')): ?>
        <label for="EstudanteRegistro">Registro na UFRJ (DRE): <?php echo $this->Session->read('numero'); ?></label>
        <?php echo $this->Form->input('registro', ['label' => false, 'type' => 'hidden', 'value' => $registro, 'default' => $this->Session->read('numero'), 'class' => 'form-control']); ?>
        <!--
        Senão somente o administrador pode cadastrar um aluno novo
        //-->
    <?php else: ?>
        <?php echo "Estudante sem número de registro na UFRJ (DRE)? " . $this->Session->read('numero'); ?>
        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <?php $registro = isset($registro) ? $registro : null; ?>
            <?php echo $this->Form->input('registro', ['type' => 'text', 'value' => $registro, 'default' => $this->Session->read('numero'), 'class' => 'form-control']); ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php echo $this->Form->input('nome', ['class' => 'form-control']); ?>
    <div class='form-row'>
        <div class="col">
            <label for="EstudanteNascimento">Data de nascimento</label>
            <input type="date" name="data[Estudante][nascimento]" id='EstudanteNascimento' max="2100-12-31" min="1900-01-01" class="form-control">
        </div>
        <div class="col">
            <?php echo $this->Form->input('cpf', ['label' => 'CPF', 'placeholder' => '000000000-00', 'class' => 'form-control']); ?>
        </div>
        <div class="col">
            <?php echo $this->Form->input('identidade', ['class' => 'form-control']); ?>
        </div>
        <div class="col">
            <?php echo $this->Form->input('orgao', ['label' => 'Orgão', 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class="col-sm-2">        
            <?php if ($this->Session->read('numero') || ($this->Session->read('categoria') === 'estudante')): ?>
                <label for="EstudanteEmail">E-mail</label>
                <?php echo $this->Form->input('email', ['label' => false, 'type' => 'email', 'default' => $this->Session->read('user'), 'class' => 'form-control']); ?>
            <?php else: ?>
                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <?php echo $this->Form->input('email', ['class' => 'form-control']); ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="form-group row">
            <div class='col-sm-1'></div>
            <?php echo $this->Form->input('codigo_tel', ['label' => 'DDD' , 'default' => 21, 'class' => 'form-control']); ?>
        </div>
        <div class='col-sm-2'>
            <?php echo $this->Form->input('telefone', ['class' => 'form-control']); ?>
        </div>
        <div class='col-sm-1'>
            <?php echo $this->Form->input('codigo_cel', ['label' => 'DDD' , 'default' => 21, 'class' => 'form-control']); ?>
        </div>
        <div class='col-sm-2'>
            <?php echo $this->Form->input('celular', ['class' => 'form-control']); ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class="col">
            <?php echo $this->Form->input('cep', ['placeholder' => '00000-00', 'class' => 'form-control']); ?>
        </div>
        <div class='col'>
            <?php echo $this->Form->input('endereco', ['class' => 'form-control']); ?>
        </div>
        <div class='col'>
            <?php echo $this->Form->input('bairro', ['class' => 'form-control']); ?>
        </div>
        <div class='col'>
            <?php echo $this->Form->input('municipio', ['default' => 'Rio de Janeiro, RJ', 'class' => 'form-control']); ?>
        </div>
    </div>

    <?php
    if (isset($instituicao_id)) {
        echo $this->Form->input('instituicao_id', array('type' => 'hidden', 'value' => $instituicao_id));
    } else {
        echo $this->Form->input('instituicao_id', array('type' => 'hidden'));
    }
    ?>
</fieldset>
<br/>
<div class="row">
    <div class="col">
        <?php echo $this->Form->input('Confirima', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-primary position-static']); ?>
    </div>
</div>

<span style="text-align: center">
    <?php echo $this->Form->end(); ?>
</span>
