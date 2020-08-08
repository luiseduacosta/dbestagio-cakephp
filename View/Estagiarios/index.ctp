<?php
// pr($periodoatual);
// pr($nivel);
// pr($periodos_todos);
// pr($supervisor_id);
// pr($supervisores);
// pr($estagiarios);
?>

<script>

    $(document).ready(function () {

        var url = "<?= $this->Html->url(["controller" => "Estagiarios", "action" => "index/"]); ?>";
        // alert(link);

        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = url + "/periodo:" + periodo;
        })

        $("#EstagiarioAreaestagioId").change(function () {
            var areaestagio_id = $(this).val();
            /* alert(areaestagio_id); */
            window.location = url + "/areaestagio_id:" + areaestagio_id;
        })

        $("#EstagiarioDocenteId").change(function () {
            var docente_id = $(this).val();
            /* alert(docente_id); */
            window.location = url + "/docente_id:" + docente_id;
        })

        $("#EstagiarioInstituicaoId").change(function () {
            var instituicao_id = $(this).val();
            /* alert(instituicao_id); */
            window.location = url + "/instituicao_id:" + instituicao_id;
        })

        $("#EstagiarioSupervisorId").change(function () {
            var supervisor_id = $(this).val();
            /* alert(supervisor_id); */
            window.location = url + "/supervisor_id:" + supervisor_id;
        })

        $("#EstagiarioNivel").change(function () {
            var nivel = $(this).val();
            /* alert(nivel); */
            window.location = url + "/nivel:" + nivel;
        })

        $("#EstagiarioTurno").change(function () {
            var turno = $(this).val();
            /* alert(turno); */
            window.location = url + "/turno:" + turno;
        })

    })
</script>

<?= $this->element('submenu_estagiarios'); ?>

<div id="estagiario_seleciona" style="align-content: center;">
    <table class='table table-striped table-hover table-responsive'>
        <tr>
            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('periodo', array('type' => 'select', 'options' => $periodos_todos, 'selected' => $periodo, 'empty' => array('0' => 'Período'), 'style' => 'width: 7em', 'class' => 'form-control')); ?>
                <?php // echo $this->Form->end();?>
            </td>
            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('nivel', array('type' => 'select', 'options' => array('1' => 'OTP 1', '2' => 'OTP 2', '3' => 'OTP 3', '4' => 'OTP 4', '9' => 'Não obrigatório'), 'selected' => $nivel, 'default' => 0, 'empty' => array('0' => 'OTP'), 'style' => 'width: 7em', 'class' => 'form-control')); ?>
                <?php // echo $this->Form->end();?>
            </td>
            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('turno', array('type' => 'select', 'options' => array('D' => 'Diurno', 'N' => 'Noturno'), 'selected' => $turno, 'empty' => array('0' => 'Turno'), 'style' => 'width: 7em', 'class' => 'form-control')); ?>
                <?php // echo $this->Form->end();?>
            </td>
            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('areaestagio_id', array('type' => 'select', 'options' => $areaestagios, 'selected' => $areaestagio_id, 'empty' => array('0' => 'Área'), 'style' => 'width: 7em', 'class' => 'form-control')); ?>
                <?php // echo $this->Form->end();?>
            </td>
            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('docente_id', array('type' => 'select', 'options' => $professores, 'selected' => $docente_id, 'default' => 0, 'empty' => array('0' => 'Professor/a'), 'style' => 'width: 10em', 'class' => 'form-control')); ?>
                <?php // echo $this->Form->end();?>
            </td>
            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('supervisor_id', array('type' => 'select', 'options' => $supervisores, 'selected' => $supervisor_id, 'default' => 0, 'empty' => array('0' => 'Supervisor/a'), 'style' => 'width: 10em', 'class' => 'form-control')); ?>
                <?php // echo $this->Form->end();?>
            </td>
            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('instituicao_id', array('type' => 'select', 'options' => $instituicoes, 'selected' => $instituicao_id, 'default' => 0, 'empty' => array('0' => 'Instituição'), 'style' => 'width: 10em', 'class' => 'form-control')); ?>
                <?php // echo $this->Form->end();?>
            </td>
        </tr>
    </table>
</div>

<div align='center'>

    <?php ($periodo == 0 ? $periodo = "Todos" : $periodo = $periodo); ?>
    <h5>Estagiarios período: <?php echo $periodo; ?></h5>

    <?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->prev('< Anterior ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->next(' Posterior > ', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->last(' Último >> ', null, null, array('class' => 'disabled')); ?>

    <br/>

    <?php echo $this->Paginator->numbers(); ?>
</div>

<div class="table-responsive">
    <table class='table table-responsive table-hover'>
        <thead class="thead-light">
            <tr>
                <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                    <th><?php echo $this->Paginator->sort('Estagiario.registro', 'Registro'); ?></th>
                <?php endif; ?>
                <th><?php echo $this->Paginator->sort('Estudante.nome', 'Nome'); ?></th>
                <th><?php echo $this->Paginator->sort('Estudante.ajustecurricular2020', 'Ajuste 2020'); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.periodo', 'Periodo'); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.nivel', 'Nível'); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.turno', 'Turno'); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.tc', 'TC'); ?></th>
                <th><?php echo $this->Paginator->sort('Instituicao.instituicao', 'Instituição'); ?></th>
                <th><?php echo $this->Paginator->sort('Supervisor.nome', 'Supervisor'); ?></th>
                <th><?php echo $this->Paginator->sort('Professor.nome', 'Professor'); ?></th>
                <th><?php echo $this->Paginator->sort('Areaestagio.area', 'Área'); ?></th>
                <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                    <th><?php echo $this->Paginator->sort('Estagiario.nota', 'Nota'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.ch', 'CH'); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $aluno): ?>
                <tr>
                    <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                        <td style='text-align:center'><?php echo $this->Html->link($aluno['Estagiario']['registro'], "/Estudantes/view/registro:" . $aluno['Aluno']['registro']); ?></td>
                    <?php endif; ?>
                    <td style='text-align:left'><?php echo $aluno['Estudante']['nome']; ?></td>
                    <td style='text-align:left'><?php echo $aluno['Estagiario']['ajustecurricular2020']; ?></td>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['periodo']; ?></td>
                    <?php if ($aluno['Estagiario']['nivel'] == 9): ?>
                        <td style='text-align:center'><?php echo 'Não obrigatório'; ?></td>
                    <?php else: ?>
                        <td style='text-align:center'><?php echo $aluno['Estagiario']['nivel']; ?></td>
                    <?php endif; ?>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['turno']; ?></td>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['tc']; ?></td>
                    <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                        <td style='text-align:left'><?php echo $this->Html->link($aluno['Instituicao']['instituicao'], "/Instituicoes/view/" . $aluno['Estagiario']['instituicao_id']); ?></td>
                        <td style='text-align:left'><?php echo $this->Html->link($aluno['Supervisor']['nome'], "/Supervisores/view/" . $aluno['Estagiario']['supervisor_id']); ?></td>
                        <td style='text-align:left'><?php echo $this->Html->link($aluno['Professor']['nome'], "/Professores/view/" . $aluno['Estagiario']['docente_id']); ?></td>
                        <td style='text-align:left'><?php echo $this->Html->link($aluno['Areaestagio']['area'], "/Areaestagios/view/" . $aluno['Areaestagio']['id']); ?></td>
                    <?php else: ?>
                        <td style='text-align:left'><?php echo $aluno['Instituicao']['instituicao']; ?></td>
                        <td style='text-align:left'><?php echo $aluno['Supervisor']['nome']; ?></td>
                        <td style='text-align:left'><?php echo $aluno['Professor']['nome']; ?></td>
                        <td style='text-align:left'><?php echo $aluno['Areaestagio']['area']; ?></td>
                    <?php endif; ?>
                    <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                        <td style='text-align:center'><?php echo $aluno['Estagiario']['nota']; ?></td>
                        <td style='text-align:center'><?php echo $aluno['Estagiario']['ch']; ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
echo $this->Paginator->counter(array(
    'format' => "Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%"
));
?>
