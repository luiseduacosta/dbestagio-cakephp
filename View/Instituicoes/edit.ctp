<?php ?>

<?php // $meses = ['01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro']; ?>
<?php // pr($meses); ?>

<?= $this->Html->script("jquery.mask.min"); ?>
<script>

    $(document).ready(function () {

        $("#InstituicaoCep").mask("99999-999");
        $("#InstituicaoCnpj").mask("99.999.999/9999-99");

    });

</script>

<?= $this->Html->script("jquery.autocomplete.min"); ?>
<?= $this->Html->css("jquery.autocomplete"); ?>

<script>

    $(document).ready(function () {

        var urlbairro = "<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listabairro"]); ?>";
        var urlinstituicao = "<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listainstituicao"]); ?>";
        var urlnatureza = "<?= $this->Html->url(["controller" => "Instituicoes", "action" => "listanatureza"]); ?>";

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
    <?= $this->Form->label('expira', 'Expira', ['class' => 'col-lg-3 col-form-label']); ?>
    <div class='col-lg-9'>
        <?php echo $this->Form->input('expira', ['label' => false, 'dateFormat' => 'DMY', 'monthNames' => $meses, 'class' => 'form-horizontal']); ?>
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
        <?php echo $this->Form->input('areainstituicao_id', ['label' => false, 'options' => $area_instituicao, 'empty' => ['0' => 'Selecione'], 'class' => 'form-control']); ?>
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
<div class="row justify-content-center">
    <div class="col-auto">
        <?php echo $this->Form->submit('Confirmar', ['label' => false, 'class' => 'btn btn-success']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>