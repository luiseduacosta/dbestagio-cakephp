<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Inserir', '/AreaInstituicaos/add/'); ?>
    <br />
<?php endif; ?>

<h1>Áreas das instituições</h1>

<table>

<?php foreach ($areas as $c_area): ?>

<tr>
<td>
<?php echo $this->Html->link($c_area['AreaInstituicao']['id'], '/AreaInstituicaos/view/' . $c_area['AreaInstituicao']['id']); ?>
</td>

<td>
<?php echo $this->Html->link($c_area['AreaInstituicao']['area'], '/AreaInstituicaos/view/' . $c_area['AreaInstituicao']['id']); ?>
</td>

<td>
<?php echo $c_area['AreaInstituicao']['quantidadeArea']; ?>
</td>
</tr>

<?php endforeach; ?>

</table>
