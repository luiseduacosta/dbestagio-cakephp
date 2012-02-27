<?php echo $html->link('Configurações','/configuracaos/view/1'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Usuários','/aros/listausuarios/'); ?>
<?php echo " | "; ?>
<?php echo $html->link('Permissões','/aros/indexaros/'); ?>

<table>
    
    <thead>
        <tr>
            <th>Id</th>
            <th>Categoria</th>
            <th>Objeto</th>
            <th>Crear</th>
            <th>Ver</th>
            <th>Editar</th>
            <th>Excluir</th>
        </tr>
    </thead>     
   
    
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
