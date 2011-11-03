<table>

<?php
foreach ($aros as $esteusuario) {
?>    

<tr>

    <td>
    <?php echo $html->link($esteusuario['aros_acos']['id'], '/aros/viewaros/'. $esteusuario['aros_acos']['id']); ?>
    </td>
    <td>
    <?php echo $esteusuario['aros']['alias']; ?>
    </td>
    <td>
    <?php echo $esteusuario['acos']['alias']; ?>
    </td>
    <td>
    <?php echo $esteusuario['aros_acos']['_create']; ?>
    </td>
    <td>
    <?php echo $esteusuario['aros_acos']['_read']; ?>
    </td>
    <td>
    <?php echo $esteusuario['aros_acos']['_update']; ?>
    </td>
    <td>
    <?php echo $esteusuario['aros_acos']['_delete']; ?>
    </td> 
</tr>

<?php
}
?>

</table>
