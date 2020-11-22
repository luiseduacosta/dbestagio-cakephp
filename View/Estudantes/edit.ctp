<?php // pr($this->data);   ?>

<?= $this->Html->script("jquery.mask.min"); ?>

<script>
    $(document).ready(function () {

        $("#EstudanteRegistro").mask("999999999");
        $("#EstudanteCpf").mask("999999999-00");
        $("#EstudanteTelefone").mask("0000.0000");
        $("#EstudanteCelular").mask("00000.0000");
        $("#EstudanteCep").mask("00000-000");

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

<?php
$datanascimento = date('Y-m-d', strtotime($this->data['Estudante']['nascimento']));
// echo $datanascimento;
?>

<h5>Editar estudante</h5>

<?php echo $this->Form->create('Estudante', array('url' => 'edit/' . $this->data['Estudante']['id'])); ?>
<div class="form-row">
    <div class="col-2">
        <?php echo $this->Form->input('registro', ['class' => 'form-control']); ?>
    </div>
    <div class="col">
        <?php echo $this->Form->input('nome', ['class' => 'form-control']); ?>
    </div>
</div>
<div class="form-row">
    <div class="col-3">
        <label for="EstudanteNascimento">Data de nascimento</label>
        <?php echo $this->Form->input('nascimento', ['label' => false, 'type' => 'date', 'dateFormat' => 'DMY', 'minYear' => '1900', 'maxYear' => '2100', 'monthNames' => $meses, 'class' => 'form-group']); ?>
    </div>
    <div class="col-3">    
        <?php echo $this->Form->input('cpf', ['class' => 'form-control']); ?>
    </div>
    <div class="col-3">    
        <?php echo $this->Form->input('identidade', ['class' => 'form-control']); ?>
    </div>
    <div class="col-3">    
        <?php echo $this->Form->input('orgao', ['class' => 'form-control']); ?>
    </div>
</div>
<div class="form-row">
    <div class="col">
        <?php echo $this->Form->input('email', ['class' => 'form-control']); ?>
    </div>
</div>
<div class="form-row">
    <div class="col">
        <?php echo $this->Form->input('codigo_telefone', array('default' => 21, 'class' => 'form-control')); ?>
    </div>
    <div class="col">    
        <?php echo $this->Form->input('telefone', ['class' => 'form-control']); ?>
    </div>
    <div class="col">    
        <?php echo $this->Form->input('codigo_celular', array('default' => 21, 'class' => 'form-control')); ?>
    </div>
    <div class="col">    
        <?php echo $this->Form->input('celular', ['class' => 'form-control']); ?>
    </div>
</div>
<div class="form-row">
    <div class="col">    
        <?php echo $this->Form->input('cep', ['class' => 'form-control']); ?>
    </div>
    <div class="col">                
        <?php echo $this->Form->input('endereco', ['class' => 'form-control']); ?>
    </div>
    <div class="col">    
        <?php echo $this->Form->input('bairro', ['class' => 'form-control']); ?>
    </div>
    <div class="col">    
        <?php echo $this->Form->input('municipio', array('default' => 'Rio de Janeiro', 'class' => 'form-control')); ?>
    </div>
</div>
<br>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $this->Form->input('Atualizar', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-success']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>