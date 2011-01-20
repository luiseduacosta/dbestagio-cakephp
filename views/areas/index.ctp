<?php echo $html->link('Inserir', '/Areas/add/'); ?>


<br />

<h1>Áreas de orientação dos professores de OTP</h1>

<table>

<?php foreach ($areas as $c_area): ?>

<tr>
<td>
<?php echo $html->link($c_area['Area']['area'], '/Areas/view/' . $c_area['Area']['id']); ?>
</td>
</tr>

<?php endforeach; ?>

</table>