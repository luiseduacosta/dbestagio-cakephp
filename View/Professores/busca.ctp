<?php
// pr($professores);
echo $this->element('submenu_professores');
?>
<?php if (isset($professores)): ?>

    <h5>Resultado da busca por professores</h5>

    <div align='center'>
        <?php $this->Paginator->options(array('url' => array($busca))); ?>

        <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class' => 'disabled')); ?>
        <?php echo " | "; ?>
        <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class' => 'disabled')); ?>
        <br />
        <?php echo $this->Paginator->numbers(); ?>
    </div>

    <div class='row justify-content-center'>
        <div class='col-auto'>
            <div class='table-responsive'>
                <table class="table table-striped table-hover table-responsive">
                    <tr>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('siape', 'SIAPE') ?></th>
                        <th><?= $this->Paginator->sort('departamento', 'Departamento') ?></th>
                    </tr>

                    <?php foreach ($professores as $c_professor): ?>
                        <?php // pr($c_professor) ?>
                        <tr>
                            <td style='text-align:left'><?php echo $this->Html->link($c_professor['Professor']['nome'], '/Professores/view/' . $c_professor['Professor']['id']); ?></td>
                            <td><?= $c_professor['Professor']['siape'] ?></td>
                            <td><?= $c_professor['Professor']['departamento']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>

    <h5>Busca professores</h5>

    <?php echo $this->Form->create('Professor'); ?>
    <?php echo $this->Form->input('nome', ['label' => 'Digite o nome do professor', 'class' => 'form-control']); ?>
    <br>
    <?php echo $this->Form->submit('Confirma', ['class' => 'btn btn-success']); ?>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>
