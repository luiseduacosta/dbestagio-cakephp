<?php // pr($configuraplanejamentos); ?>

<?php
echo $this->element('submenu_configuraplanejamentos');
?>

<div align="center">
<table style="width:80%; border:1px solid black;">
    <tr>
        <th>Id</th>
        <th>Semestre</th>
        <th>Versão</th>
        <th>Planejamento</th>
    </tr>

    <?php
    foreach ($configuraplanejamentos as $c_configuraplanejamento) {
        // pr($c_configuraplanejamento);
        ?>
        <tr>
            <td><?php echo $c_configuraplanejamento['Configuraplanejamento']['id']; ?></td>
            <td><?php echo $this->Html->link($c_configuraplanejamento['Configuraplanejamento']['semestre'], '/configuraplanejamentos/view/' . $c_configuraplanejamento['Configuraplanejamento']['id']); ?></td>
            <td><?php echo $c_configuraplanejamento['Configuraplanejamento']['versao']; ?></td>
            <td><?php 
            if (sizeof($c_configuraplanejamento) > 0):
                echo $this->Html->link("Ver planejamento", 'http://graduacao.ess.ufrj.br/planejamentos/listar/semestre:' . $c_configuraplanejamento['Configuraplanejamento']['id']);
            // else:
                // echo $this->Html->link("Criar novo planejamento", '/planejamentos/novoplano/semestre:' . $c_configuraplanejamento['Configuraplanejamento']['id']);
            endif;
            ?></td>
        </tr>
        <?php
    }
    ?>

</table>
</div>