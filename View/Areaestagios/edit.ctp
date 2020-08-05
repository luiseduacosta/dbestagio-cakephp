<?= $this->Form->Create('Areaestagio'); ?>
<div class="form-group">
    <label for = "AreaestagioArea">Área</label>    
    <?= $this->Form->Input('area', ['label' => false, 'class' => 'form-control']); ?>
</div>
<?= $this->Form->Input('Confirma', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-success position-static']); ?>
<?= $this->Form->End(); ?>
