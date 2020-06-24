<?= $this->element('submenu_areainstituicoes'); ?>

<?= $this->Form->Create('Areainstituicao'); ?>
<div class="form-group">
    <?= $this->Form->Input('area', ['label' => 'Área da instituição', 'class' => 'form-control']); ?>
</div>
<?= $this->Form->Input('Confirma', ['type' => 'submit', 'label' => false, 'class' => 'btn  btn-primary position-static']); ?>
<?= $this->Form->End(); ?>

