<table>
    <caption>Natureza das instituições</caption>
<?php foreach ($natureza as $c_natureza): ?>
<tr>
    <td><?php echo $this->Html->link($c_natureza['Instituicao']['natureza'], '/Instituicaos/index/natureza:' . $c_natureza['Instituicao']['natureza']); ?></td>
    <td><?php echo $c_natureza['Instituicao']['qnatureza']; ?></td>
</tr>
<?php endforeach; ?>
</table>