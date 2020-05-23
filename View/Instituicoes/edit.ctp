<?php ?>

<?= $this->Html->script('jquery.SimpleMask') ?>

<script>

    $(document).ready(function () {

        $("#InstituicaoCep").simpleMask({'mask': ["#####-###"]});
        $("#InstituicaoCnpj").simpleMask({'mask': ["##.###.###/####-##"]});

    });

</script>

<?= $this->Html->css('jquery.autocomplete'); ?>
<?= $this->Html->script("jquery.autocomplete", array('inline' => false)); ?>

<script>

    var urlbairro = "<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listabairro"]); ?>";
    var urlinstituicao = "<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listainstituicao"]); ?>";
    var urlnatureza = "<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listanatureza"]); ?>";
    
    $(document).ready(function () {

        $("#InstituicaoBairro").autocomplete("<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listabairro"]); ?>", {maxItemsToShow: 2});
        $("#InstituicaoInstituicao").autocomplete("<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listainstituicao"]); ?>", {maxItemsToShow: 0});
        $("#InstituicaoNatureza").autocomplete("<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listanatureza"]); ?>", {maxItemsToShow: 0});

    });

</script>


<?php
echo $this->Form->create('Instituicao');
echo $this->Form->input('instituicao', ['label' => 'Instituição']);
echo $this->Form->input('cnpj', ['label' => 'CNPJ', 'placeholder' => '__.___.___/____-__']);
echo $this->Form->input('email');
echo $this->Form->input('url', ['placeholder' => 'http://', 'label' => 'Página web (inclua o protocolo: http://)']);
echo $this->Form->input('convenio', ['label' => 'Número de convênio na UFRJ', 'default' => 0]);
echo $this->Form->input('expira', ['label' => 'Expira', 'empty' => true]);
echo $this->Form->input('seguro', array('options' => array('0' => 'Não', '1' => 'Sim')));
echo $this->Form->input('area_instituicoes_id', ['label' => 'Área da instituição', 'options' => $area_instituicao, 'empty' => 'Selecione']);
echo $this->Form->input('natureza', ['placeholder' => 'pública ou privada']);
echo $this->Form->input('endereco', ['Endereço']);
echo $this->Form->input('cep', ['label' => 'CEP', 'placeholder' => '_____-__']);
echo $this->Form->input('bairro');
echo $this->Form->input('municipio', ['label' => 'Município']);
echo $this->Form->input('telefone');
echo $this->Form->input('fax');
echo $this->Form->input('beneficio', ['label' => 'Benefícios']);
echo $this->Form->input('final_de_semana', array('options' => array('0' => 'Não', '1' => 'Sim', '2' => 'Parcialmente'), 'default' => 0));
echo $this->Form->input('observacoes', ['label' => 'Observações', 'type' => 'textarea', ['rows' => 5, 'cols' => 60]]);
echo $this->Form->end('Confirmar');
?>
