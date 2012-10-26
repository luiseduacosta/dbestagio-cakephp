<?php /* pr($areas); */ ?>
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
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
<?php echo $this->Html->link($c_area['Area']['area'], '/Areas/view/' . $c_area['Area']['id']); ?>
</td>
<td>
<?php echo $this->Html->link($c_area['Professor']['nome'], '/Professors/view/' . $c_area['Professor']['id']); ?>
</td>
<td>
<?php echo $c_area['Professor']['departamento']; ?>
</td>
<td>
<?php echo $c_area['Area']['virtualMinPeriodo']; ?>
</td>
<td>
<?php echo $c_area['Area']['virtualMaxPeriodo']; ?>
</td>
</tr>

<?php endforeach; ?>

</table>