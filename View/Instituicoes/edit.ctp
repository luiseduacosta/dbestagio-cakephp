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

<?php echo $this->element('submenu_instituicoes'); ?>

<?php
echo $this->Form->create("Instituicao");
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
        <?php echo $this->Form->input('cnpj', ['label' => false, 'class' => 'form-control']); ?>
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
        <?php echo $this->Form->input('expira', ['label' => false, 'dateFormat' => 'DMY', 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoSeguro' class='col-lg-3 col-form-label'>Seguro</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('seguro', ['options' => ['0' => 'Não', '1' => 'Sim'], 'label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group row">
    <label for='InstituicaoAreaInstituicoesId' class='col-lg-3 col-form-label'>Área da Instituição</label>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('areainstituicoes_id', ['label' => false, 'options' => $area_instituicao, 'empty' => ['0' => 'Selecione'], 'class' => 'form-control']); ?>
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
        <?php echo $this->Form->input('cep', ['label' => false, 'class' => 'form-control']); ?>
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
<?php echo $this->Form->submit('Confirmar', ['label' => false, 'class' => 'btn btn-primary']); ?>
<?php echo $this->Form->end(); ?>
