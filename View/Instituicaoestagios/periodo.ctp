<?php
// pr($instituicoes);
// die();
?>

<script>
    $(document).ready(function () {

        var url = '<?= $this->Html->url(["controller" => "Instituicaoestagio", "action" => "periodo/periodo:"]) ?>';
        var semperiodo = '<?= $this->Html->url(["controller" => "Instituicaoestagios", "action" => "index"]) ?>';

        $("#InstituicaoestagioPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            if (periodo == 0) {
                window.location = semperiodo;
            } else {
                /* alert(url); */
                window.location = url + periodo;
            }
        })
    })
</script>

<?php echo $this->element('submenu_instituicoes'); ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <div class='row'>
        <div class="col-3">
            <?php echo $this->Form->create('Instituicaoestagio'); ?>
            <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => array('text' => 'Período ', 'style' => 'display: inline'), 'options' => $todososperiodos, 'default' => $periodo, 'empty' => ['0' => 'Selecione'], 'class' => 'form-control')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>

<?php endif; ?>
<br>
<div class='row justify-content-center'>
    <div class="col-auto">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-responsive">
                <thead class="thead-light">
                    <tr>
                        <th>
                            <?= $this->Html->link('Id', '/Instituicaoestagios/periodo/periodo:' . $periodo . '/ordem:instituicao_id'); ?>
                        </th>
                        <th>
                            <?= $this->Html->link('Instituição', '/Instituicaoestagios/periodo/periodo:' . $periodo . '/ordem:instituicao'); ?>
                        </th>
                        <th>
                            <?= $this->Html->link('Expira', '/Instituicaoestagios/periodo/periodo:' . $periodo . '/ordem:expira'); ?>
                        </th>
                        <th>
                            <?= $this->Html->link('Último estágio', '/Instituicaoestagios/periodo/periodo:' . $periodo . '/ordem:ultimoestagio'); ?>
                        </th>
                        <th>
                            <?= $this->Html->link('Estagiários', '/Instituicaoestagios/periodo/periodo:' . $periodo . '/ordem:q_estagiarios'); ?>
                        </th>
                        <th>
                            <?= $this->Html->link('Supervisores', '/Instituicaoestagios/periodo/periodo:' . $periodo . '/ordem:q_supervisores'); ?>
                        </th>
                        <th>
                            <?= $this->Html->link('Publicações no mural', '/Instituicaoestagios/periodo/periodo:' . $periodo . '/ordem:q_murales'); ?>
                        </th>
                        <th>
                            <?= $this->Html->link('Área', '/Instituicaoestagios/periodo/periodo:' . $periodo . '/ordem:areainstituicao'); ?>
                        </th>
                        <th>
                            <?= $this->Html->link('Natureza', '/Instituicaoestagios/periodo/periodo:' . $periodo . '/ordem:natureza'); ?>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($instituicoes as $c_instituicao): ?>
                        <?php // pr($c_instituicao) ?>

                        <tr>
                            <td><?php echo $this->Html->link($c_instituicao['instituicao_id'], '/Instituicaoestagios/view/' . $c_instituicao['instituicao_id']); ?></td>
                            <td><?php echo $this->Html->link($c_instituicao['instituicao'], '/Instituicaoestagios/view/' . $c_instituicao['instituicao_id']); ?></td>
                            <td><?php
                                if ($c_instituicao['expira']):
                                    echo date('d-m-Y', strtotime($c_instituicao['expira']));
                                endif;
                                ?>
                            </td>
                            <td><?php
                                if (isset($c_instituicao['ultimoestagio'])):
                                    echo $c_instituicao['ultimoestagio'];
                                endif;
                                ?>
                            </td>
                            <td><?php echo $c_instituicao['q_estagiarios']; ?></td>
                            <td><?php echo $c_instituicao['q_supervisores']; ?></td>
                            <td><?php echo $this->Html->link($c_instituicao['q_murales'], '/Muralestagios/view/' . $c_instituicao['ultimomural_id']); ?></td>
                            <td><?php echo $c_instituicao['areainstituicao']; ?></td>
                            <td><?php echo $c_instituicao['natureza']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>