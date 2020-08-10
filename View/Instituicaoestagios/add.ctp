<?php
echo $this->Html->script("jquery.maskedinput-1.3.1", array('inline' => false));
?>

<?= $this->Html->script("jquery.mask.min"); ?>

<script>

    $(document).ready(function () {
        $("#InstituicaoCep").mask("99999-999");
        $("#InstituicaoCnpj").mask("99.999.999/9999-99");
    });
</script>

<?php
echo $this->Html->css('jquery.autocomplete');
echo $this->Html->script("jquery.autocomplete", array('inline' => false));
?>

<script>

    var urlbairro = "<?= $this->Html->url(["controller" => "Instituicaoestagio", "action" => "listabairro"]); ?>";
    var urlinstituicao = "<?= $this->Html->url(["controller" => "Instituicaoestagio", "action" => "listainstituicao"]); ?>";
    var urlnatureza = "<?= $this->Html->url(["controller" => "Instituicaoestagio", "action" => "listanatureza"]); ?>";

    $(document).ready(function () {

        $("#InstituicaoestagioInstituicao").autocomplete(urlinstituicao, {maxItemsToShow: 0});
        $("#InstituicaoestagioNatureza").autocomplete(urlnatureza, {maxItemsToShow: 0});
        $("#InstituicaoestagioBairro").autocomplete(urlbairro, {maxItemsToShow: 0});

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
        $("#InstituicaoCep").blur(function () {

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
                    $("#InstituicaoestagioEndereco").val("...");
                    $("#InstituicaoestagioBairro").val("...");
                    $("#InstituicaoestagioMunicipio").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");
                    //Consulta o webservice viacep.com.br/

                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#InstituicaoestagioEndereco").val(dados.logradouro);
                            $("#InstituicaoestagioBairro").val(dados.bairro);
                            $("#InstituicaoestagioMunicipio").val(dados.localidade);
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

<?php echo $this->element('submenu_instituicoes'); ?>

<h5>Cadastro de instituições</h5>

<?php
echo $this->Form->create("Instituicaoestagio");
?>
<div class="form-group row">
    <label for='InstituicaoInstituicao' class='col-lg-3 col-form-label'>Instituição</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('instituicao', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoCnpj' class='col-lg-3 col-form-label'>CNPJ</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('cnpj', ['label' => false, 'placeholder' => '99.999.999/9999-99', 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoEmail' class='col-lg-3 col-form-label'>E-mail</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('email', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoUrl' class='col-lg-3 col-form-label'>Site</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('url', ['label' => false, 'placeholder' => 'http://', 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoConvenio' class='col-lg-3 col-form-label'>Número de convênio</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('convenio', ['label' => false, 'default' => 0, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoExpira' class='col-lg-3 col-form-label'>Expira</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('expira', ['label' => false, 'dateFormat' => 'DMY', 'monthNames' => $meses, 'empty' => true, 'class' => 'form-horizontal']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoSeguro' class='col-lg-3 col-form-label'>Seguro</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('seguro', ['options' => ['0' => 'Não', '1' => 'Sim'], 'label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoAreaInstituicaoId' class='col-lg-3 col-form-label'>Área da Instituição</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('areainstituicao_id', ['label' => false, 'options' => $id_area_instituicao, 'empty' => ['0' => 'Selecione'], 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoNatureza' class='col-lg-3 col-form-label'>Natureza</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('natureza', ['placeholder' => 'pública', 'label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoCep' class='col-lg-3 col-form-label'>CEP</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('cep', ['label' => false, 'placeholder' => '99999-999', 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoEndereco' class='col-lg-3 col-form-label'>Endereço</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('endereco', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoBairro' class='col-lg-3 col-form-label'>Bairro</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('bairro', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoMunicipio' class='col-lg-3 col-form-label'>Município</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('municipio', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoTelefone' class='col-lg-3 col-form-label'>Telefone</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('telefone', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoFax' class='col-lg-3 col-form-label'>Fax</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('fax', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoBeneficio' class='col-lg-3 col-form-label'>Benefícios</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('beneficio', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoFinalDeSemana' class='col-lg-3 col-form-label'>Estágio na final de semana</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('final_de_semana', ['label' => false, 'options' => ['0' => 'Não', '1' => 'Sim', '2' => 'Parcialmente'], 'default' => 0, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoObservacoes' class='col-lg-3 col-form-label'>Observações</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('observacoes', ['label' => false, 'type' => 'textarea', ['rows' => 5, 'cols' => 60], 'class' => 'form-control']); ?>
    </div>
</div>
<br>
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $this->Form->submit('Confirmar', ['label' => false, 'class' => 'btn btn-success']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>