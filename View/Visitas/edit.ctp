<?php // pr($this->data['Visita']['data']);   ?>
<h5><?php echo $this->data['Instituicao']['instituicao']; ?></h5>

<?= $this->Form->create('Visita'); ?>

<div class="form-group row">
    <label for="VisitaData" class="col-form-label col-sm-2">Data da visita</label>
    <div class="col-sm-6">
        <p style="line-height: 0,5%"></p>
        <?= $this->Form->input('data', array('label' => false, 'dateFormat' => 'DMY', 'class' => 'form-horizontal')); ?>
    </div>
</div>
<?php
echo $this->Form->input('motivo', ['class' => 'form-control']);
echo $this->Form->input('responsavel', ['class' => 'form-control']);
echo $this->Form->input('descricao', ['label' => 'Descripção', 'class' => 'form-control']);
echo $this->Form->input('avaliacao', ['class' => 'form-control']);
?>
<br>
<?php
echo $this->Form->submit('Confirma', ['class' => 'btn btn-primary']);
echo $this->Form->end();
?>
