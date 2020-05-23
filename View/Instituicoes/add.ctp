<?php

echo $this->Html->script("jquery", array('inline' => false));
echo $this->Html->script("jquery.maskedinput", array('inline' => false));
?>

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

    var urlbairro = "<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listabairro"]); ?>";
    var urlinstituicao = "<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listainstituicao"]); ?>";
    var urlnatureza = "<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listanatureza"]); ?>";

    $(document).ready(function () {

        $("#InstituicaoInstituicao").autocomplete(urlinstituicao, {maxItemsToShow: 0});
        $("#InstituicaoNatureza").autocomplete(urlnatureza, {maxItemsToShow: 0});
        $("#InstituicaoBairro").autocomplete(urlbairro, {maxItemsToShow: 0});

    });

</script>

<h1>Cadastro de instituições</h1>

<?php

echo $this->Form->create('Instituicao');
echo $this->Form->input('instituicao', ['label' => 'Instituição']);
echo $this->Form->input('cnpj', ['label' => 'CNPJ']);
echo $this->Form->input('email');
echo $this->Form->input('url', ['label' => 'Endereço na internet (inclua o protocolo: http://)', 'placeholder' => 'http://']);
echo $this->Form->input('convenio', ['label' => 'Número de convênio na UFRJ', 'default' => 0]);
echo $this->Form->input('expira', ['label' => 'Expira']);
echo $this->Form->input('seguro', ['options' => ['0' => 'Não', '1' => 'Sim']]);
echo $this->Form->input('area_instituicoes_id', ['label' => 'Área da Instituição (não é a área da OTP)', 'options' => $id_area_instituicao, 'empty' => ['0' => 'Selecione']]);
echo $this->Form->input('natureza', ['placeholder' => 'pública']);
echo $this->Form->input('endereco');
echo $this->Form->input('cep', ['label' => 'CEP']);
echo $this->Form->input('bairro');
echo $this->Form->input('municipio', ['label' => 'Município']);
echo $this->Form->input('telefone');
echo $this->Form->input('fax');
echo $this->Form->input('beneficio', ['label' => 'Benefícios']);
echo $this->Form->input('final_de_semana', ['label' => 'Estágio no final de semana?', 'options' => ['0' => 'Não', '1' => 'Sim', '2' => 'Parcialmente'], 'default' => 0]);
echo $this->Form->input('observacoes', ['label' => 'Observações', 'type' => 'textarea', ['rows' => 5, 'cols' => 60]]);
echo $this->Form->end('Confirmar');
?>
