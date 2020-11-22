<?php
// pr($mural);
?>
<script>

    $(document).ready(function () {

        var url = "<?= $this->Html->url(['controller' => 'Muralestagios', 'action' => 'index/periodo:']); ?>";
        $("#MuralestagioPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = url + periodo;
        })
    })

</script>

<?= $this->element('submenu_muralestagios'); ?>

<?php if (($this->Session->read('id_categoria') === '1') || ($this->Session->read('id_categoria') === '4')): ?>
    <nav class="nav nav-pills">

        <?php if ($this->Session->read('id_categoria') === '1'): ?>
            <?php echo $this->Form->create('Muralestagio', array('url' => 'index')); ?>
            <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => array('text' => 'Mural de estágios da ESS/UFRJ ', 'style' => 'display: inline'), 'options' => $todos_periodos, 'default' => $periodo)); ?>
            <?php echo $this->Form->end(); ?>
        <?php endif; ?>
    </div>
    </nav>
    <p>Há <?php echo $total_vagas; ?> vagas de estágio e <?php echo $total_alunos; ?> estudantes buscando estágio (<?php echo $alunos_novos; ?> pela primeira vez e <?php echo $alunos_estagiarios; ?> que mudam de estágio)</p>
<?php endif; ?>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <h5>Mural de estágios da ESS/UFRJ. Período: <?php echo $periodo; ?></h5>
    </div>
</div>

<hr />

<?php $totalvagas = NULL; ?>
<?php $totalinscricoes = NULL; ?>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <caption>Vagas de estágio</caption>
                <thead class="thead-light">
                    <tr>
                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <th scope="col">Id</th>
                        <?php endif; ?>
                        <th style="width: 25%">Instituição</th>
                        <th scope="col">Vagas</th>
                        <th scope="col">Atual</th>
                        <th scope="col">Inscritos</th>
                        <th style="width: 25%">Benefícios</th>
                        <th scope="col">Encerramento</th>
                        <th scope="col">Seleção</th>
                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <th scope="col">Email enviado</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mural as $data): ?>
                        <?php // pr($data); ?>
                        <tr>
                            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                                <th scope="col"><?php echo $this->Html->link($data['id'], '/Muralestagios/view/' . $data['id']); ?></th>
                            <?php endif; ?>
                            <td><?php echo $this->Html->link($data['instituicao'], '/Muralestagios/view/' . $data['id']); ?></td>
                            <td style="text-align: center"><?php echo $data['vagas']; ?></td>
                            <?php if ($this->Session->read('id_categoria') === '1' || $this->Session->read('id_categoria') === '3' || $this->Session->read('id_categoria') === '4'): ?>
                                <td style="text-align: center">
                                    <?php if ($data['estagiarios'] != 0): ?>
                                        <?php echo $this->Html->link($data['estagiarios'], '/Estagiarios/index/instituicao_id:' . $data['instituicao_id'] . '/periodo:' . $periodo); ?>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center">
                                    <?php if ($data['inscritos'] != 0): ?>
                                        <?php echo $this->Html->link($data['inscritos'], '/Muralinscricoes/index/' . $data['id']); ?>
                                    <?php endif; ?>
                                </td>
                            <?php else: ?>
                                <td style="text-align: center"><?php echo $data['estagiarios']; ?></td>
                                <td style="text-align: center"><?php echo $data['inscritos']; ?></td>
                            <?php endif; ?>

                            <td><?php echo $data['beneficios']; ?></td>

                            <td>
                                <?php
                                if (empty($data['datainscricao'])) {
                                    echo "Sem data";
                                } else {
                                    echo date('d-m-Y', strtotime($data['datainscricao']));
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                if (empty($data['dataselecao'])) {
                                    echo "Sem data";
                                } else {
                                    echo date('d-m-Y', strtotime($data['dataselecao']));
                                    echo $data['horarioselecao'] ? " Horário: " . $data['horarioselecao'] : NULL;
                                }
                                ?>
                            </td>
                            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                                <td>
                                    <?php
                                    if (empty($data['emailenviado'])) {
                                        echo "Sem data";
                                    } else {
                                        echo date('d-m-Y', strtotime($data['emailenviado']));
                                    }
                                    ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td style="text-align: center">Total: </td>
                        <td style="text-align: center"><?php echo $total_estagiarios; ?></td>
                        <td style="text-align: center"><?php echo $total_vagas; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>