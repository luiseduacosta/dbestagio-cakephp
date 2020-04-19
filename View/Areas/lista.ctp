<?php /* pr($areas); */ ?>
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Áreas por professor', '/Areas/index/'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Inserir', '/Areas/add/'); ?>
    <br />
<?php endif; ?>

<h1>Áreas de orientação dos professores de OTP</h1>

<table>

<?php foreach ($areas as $c_area): ?>

<tr>
<td>
<?php echo $this->Html->link($c_area['Area']['id'], '/Areas/view/' . $c_area['Area']['id']); ?>
</td>
<td>
<?php echo $this->Html->link($c_area['Area']['area'], '/Estagiarios/index/id_area:' . $c_area['Area']['id']); ?>
</td>
</tr>

<?php endforeach; ?>

</table>