<?php /* pr($areas); */ ?>
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Listar', '/Areaestagios/lista/'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Inserir', '/Areaestagios/add/'); ?>
    <br />
<?php endif; ?>

<h1>Áreas de orientação dos professores de OTP</h1>

<table>

<?php foreach ($areas as $c_area): ?>

<tr>
<td>
<?php echo $this->Html->link($c_area['Areaestagio']['id'], '/Areaestagios/view/' . $c_area['Areaestagio']['id']); ?>
</td>
<td>
<?php echo $this->Html->link($c_area['Areaestagio']['area'], '/Areaestagios/view/' . $c_area['Areaestagio']['id']); ?>
</td>
<td>
<?php echo $this->Html->link($c_area['Professor']['nome'], '/Professors/view/' . $c_area['Professor']['id']); ?>
</td>
<td>
<?php echo $c_area['Professor']['departamento']; ?>
</td>
<td>
<?php echo $c_area['Areaestagio']['virtualMinPeriodo']; ?>
</td>
<td>
<?php echo $c_area['Areaestagio']['virtualMaxPeriodo']; ?>
</td>
</tr>

<?php endforeach; ?>

</table>
