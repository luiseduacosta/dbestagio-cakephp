<?php /* pr($areas); */ ?>
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Áreas por professor', '/Areaestagios/index/'); ?>
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
<?php echo $this->Html->link($c_area['Areaestagio']['area'], '/Estagiarios/index/areaestagio_id:' . $c_area['Areaestagio']['id']); ?>
</td>
</tr>

<?php endforeach; ?>

</table>
