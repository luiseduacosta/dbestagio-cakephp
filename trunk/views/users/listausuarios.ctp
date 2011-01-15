<table>

<?php
echo $html->tableHeaders(array_keys($listausuarios[0]['User']));

foreach ($listausuarios as $esteusuario) {
	echo $html->tableCells($esteusuario['User']);
}

?>

</table>

<pre>
<?php var_dump($listausuarios); ?>
</pre>
