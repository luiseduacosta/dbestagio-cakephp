<?php 
// pr($superivosres);
echo $this->element('submenu_supervisores');
?>
<?php if (isset($supervisores)): ?>

    <h1>Resultado da busca por supervisores</h1>

    <div align='center'>
        <?php $this->Paginator->options(array('url' => array($busca))); ?>

        <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class' => 'disabled')); ?>
        <?php echo " | "; ?>
        <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class' => 'disabled')); ?>
        <br />
        <?php echo $this->Paginator->numbers(); ?>
    </div>

    <table>
        <tr>
            <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
            <th><?= $this->Paginator->sort('cress', 'CRESS') ?></th>
            <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
        </tr>

        <?php foreach ($supervisores as $c_supervisor): ?>
        <?php // pr($c_supervisor) ?>
            <tr>
                <td style='text-align:left'><?php echo $this->Html->link($c_supervisor['Supervisor']['nome'], '/Supervisores/view/' . $c_supervisor['Supervisor']['id']); ?></td>
                <td><?= $c_supervisor['Supervisor']['cress'] ?></td>
                <td>
                <?php 
                     if (sizeof($c_supervisor['Instituicao']) > 0):
                         echo $c_supervisor['Instituicao'][array_key_last($c_supervisor['Instituicao'])]['instituicao'];
                     else:
                         null; 
                     endif;
                ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

    <h1>Busca supervisores</h1>

    <?php echo $this->Form->create('Supervisor'); ?>
    <?php echo $this->Form->input('nome', ['label' => 'Digite o nome do supervisor']); ?>
    <?php echo $this->Form->end('Confirma'); ?>

<?php endif; ?>
