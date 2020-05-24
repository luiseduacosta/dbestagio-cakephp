<?php // pr($professores);   ?>

<?php echo $this->element('submenu_professores'); ?>

<script>

$(document).ready(function() {

var url = "<?= $this->Html->url(['controller' => 'Professores', 'action' => 'pauta/periodo:']) ?>";

$("#ProfessorPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */ 
        window.location= url+periodo;
	})

})
</script>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Professor', array('controller' => 'Professor', 'url' => 'pauta')); ?>
    <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => array('text' => 'Período ', 'style' => 'display: inline'), 'options' => $todosPeriodo, 'default' => $periodo)); ?>
    <?php echo $this->Form->end(); ?>
<?php else: ?>
    <h1>Pauta: <?php echo $periodo; ?></h1>
<?php endif; ?>

<?php if (isset($professores) && !empty($professores)): ?>    

    <?php $total = NULL; ?>

    <table>
        <caption>Pauta: <?php echo $this->Html->link($periodo, '/Estagiarios/index/periodo:' . $periodo); ?></caption>
        <thead>
            <tr>
                <th><?php echo 'Professor'; ?></th>
                <th><?php echo 'Departamento'; ?></th>
                <th><?php echo 'Turma'; ?></th>
                <th><?php // echo 'Turno';   ?></th>
                <th><?php echo 'Turma'; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($professores as $c_professores): ?>
                <tr>
                    <td><?php echo $this->Html->link($c_professores['professor'], '/Estagiarios/index/docente_id:' . $c_professores['docente_id'] . '/periodo:' . $periodo); ?></td>
                    <td><?php echo $c_professores['departamento']; ?></td>
                    <td><?php
                        if ($c_professores['area']) :
                            echo $c_professores['area'];
                        endif;
                        ?></td>
                    <td><?php // echo $c_professores['periodo'];  ?></td>
                    <td><?php echo $c_professores['estagiariosperiodo']; ?></td>
                </tr>
                <?php $total += $c_professores['estagiariosperiodo']; ?>
            <?php endforeach; ?>
            <tr>
                <td>Total estudantes</td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $total; ?></td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <?php echo "Sem pauta para o período"; ?>    
<?php endif; ?>
