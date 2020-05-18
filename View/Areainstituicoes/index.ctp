<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Inserir', '/Areainstituicoes/add/'); ?>
    <br />
<?php endif; ?>

<h1>Áreas das instituições</h1>

<table>

<?php foreach ($areas as $c_area): ?>

<tr>
<td>
<?php echo $this->Html->link($c_area['Areainstituicao']['id'], '/Areainstituicoes/view/' . $c_area['Areainstituicao']['id']); ?>
</td>

<td>
<?php echo $this->Html->link($c_area['Areainstituicao']['area'], '/Areainstituicoes/view/' . $c_area['Areainstituicao']['id']); ?>
</td>

<td>
<?php echo $c_area['Areainstituicao']['quantidadearea']; ?>
</td>
</tr>

<?php endforeach; ?>

</table>
