<?php // pr($this->data['Visita']['data']);  ?>
<h1><?php echo $this->data['Instituicao']['instituicao']; ?></h1>

<?php
echo $this->Form->create('Visita');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('data', array('dateFormat'=>'DMY', 'empty'=>FALSE));
echo $this->Form->input('motivo');
echo $this->Form->input('responsavel');
echo $this->Form->input('descricao');
echo $this->Form->input('avaliacao');
echo $this->Form->end('Confirma');
?>