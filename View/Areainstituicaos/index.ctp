<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Inserir', '/areainstituicaos/add/'); ?>
    <br />
<?php endif; ?>

<h1>Áreas das instituições</h1>

<table>
    <tr>
        <th>
            Id
        </th>
        <th>
            Área
        </th>
        <th>
            Quantidade de instituições
        </th>
    </tr>
<?php foreach ($areas as $c_area): ?>

<tr>
<td>
<?php echo $this->Html->link($c_area['Areainstituicao']['id'], '/areainstituicaos/view/' . $c_area['Areainstituicao']['id']); ?>
</td>

<td>
<?php echo $this->Html->link($c_area['Areainstituicao']['area'], '/areainstituicaos/view/' . $c_area['Areainstituicao']['id']); ?>
</td>

<td>
<?php echo $c_area['Areainstituicao']['quantidadeArea']; ?>
</td>
</tr>

<?php endforeach; ?>

</table>
