<?php
// pr($instituicoes);
?>

<script>
    $(document).ready(function () {

        var url = '<?= $this->Html->url(["controller" => "Instituicoes", "action" => "periodo/periodo:"]) ?>';

        $("#InstituicaoPeriodo").change(function () {
            var periodo = $(this).val();
                /* alert(url); */
                window.location = url + periodo;
        })
    })
</script>

<?php echo $this->element('submenu_instituicoes'); ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>

    <?php echo $this->Form->create('Instituicao'); ?>
    <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => array('text' => 'Período ', 'style' => 'display: inline'), 'options' => $todosPeriodos, 'default' => $periodo, 'empty' => ['0' => 'Selecione'])); ?>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>

<div align="center">
    <?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->prev('< Anterior ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->next(' Posterior > ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->last(' Último >> ', null, null, array('class' => 'disabled')); ?>

    <br />

    <?php echo $this->Paginator->numbers(); ?>

</div>

<div class="table-responsive">
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
        <tr>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.id', 'Id'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.instituicao', 'Instituição'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.expira', 'Expira'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.periodo', 'Último estágio'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.Estagiarios', 'Estagiarios'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.Supervisores', 'Supervisores'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Areainstituicao.area', 'Área'); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Instituicao.natureza', 'Natureza'); ?>
            </th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($instituicoes as $c_instituicao): ?>
            <?php // pr($c_instituicao)  ?>

            <tr>
                <td><?php echo $this->Html->link($c_instituicao['Instituicao']['id'], '/Instituicoes/view/' . $c_instituicao['Instituicao']['id']); ?></td>
                <td><?php echo $this->Html->link($c_instituicao['Instituicao']['instituicao'], '/Instituicoes/view/' . $c_instituicao['Instituicao']['id']); ?></td>
                <td><?php
                    if ($c_instituicao['Instituicao']['expira']):
                        echo date('d-m-Y', strtotime($c_instituicao['Instituicao']['expira']));
                    endif;
                    ?></td>
                <td>
                    <?php
                    if (!empty($c_instituicao['Estagiario'])):
                        // pr($c_instituicao['Estagiario']['periodo']);
                        echo $c_instituicao['Estagiario'][array_key_last($c_instituicao['Estagiario'])]['periodo'];
                    endif;
                    ?>
                </td> 
                <td>   
                    <?php echo count($c_instituicao['Estagiario']); ?>
                </td>
                <td><?php echo count($c_instituicao['Supervisor']); ?></td>
                <td><?php echo $c_instituicao['Areainstituicao']['area']; ?></td>
                <td><?php echo $c_instituicao['Instituicao']['natureza']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot></tfoot>
</table>
</div>

<?php
echo $this->Paginator->counter(array(
    'format' => 'Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
));
?>
