<?php
// pr($cress);
// die();
// pr($periodos);
// pr($periodoatual);
?>

<script>
    $(document).ready(function () {

        var url = "<?= $this->Html->url(['controller' => 'Estudantes', 'action' => 'planilhacress/periodo:']); ?>";

        $("#EstudantePeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = url + periodo;
        })
    });
</script>

<?= $this->element('submenu_administracao'); ?>

<?php echo $this->Form->create('Estudante'); ?>
<div class='form-group row'>
    <?php echo $this->Form->label('periodo', 'Período', ['class' => 'form-label-control col-sm-1']); ?>
    <div class='col-sm-2'>
        <?php echo $this->Form->input('periodo', array('label' => false, 'type' => 'select', 'options' => $periodos, 'selected' => $periodoatual, 'empty' => array($periodoatual => 'Período'), 'class' => 'form-control')); ?>
    </div>
    <?php // echo $this->Form->end(); ?>
</div>

<div class ='row justify-content-center'>
    <div class ='col-auto'>

        <div class='table-responsive'>
            <table class='table table-hover table-responsive'>
                <caption style="caption-side: top;">Escola de Serviço Social da UFRJ. Planilha de estagiários para o CRESS 7ª Região</caption>
                <thead class="thead-light">
                    <tr>
                        <th><?= $this->Html->link('Estudante', '/Estudantes/planilhacress/periodo:' . $periodoatual . '/ordem:estudante'); ?></th>
                        <th><?= $this->Html->link('Instituição', '/Estudantes/planilhacress/periodo:' . $periodoatual . '/ordem:instituicao'); ?></th>
                        <th><?= $this->Html->link('Endereço', '/Estudantes/planilhacress/periodo:' . $periodoatual . '/ordem:endereco'); ?></th>
                        <th><?= $this->Html->link('CEP', '/Estudantes/planilhacress/periodo:' . $periodoatual . '/ordem:cep'); ?></th>
                        <th><?= $this->Html->link('Bairro', '/Estudantes/planilhacress/periodo:' . $periodoatual . '/ordem:bairro'); ?></th>
                        <th><?= $this->Html->link('Supervisor', '/Estudantes/planilhacress/periodo:' . $periodoatual . '/ordem:supervisor'); ?></th>
                        <th><?= $this->Html->link('CRESS', '/Estudantes/planilhacress/periodo:' . $periodoatual . '/ordem:cress'); ?></th>
                        <th><?= $this->Html->link('Professor/a', '/Estudantes/planilhacress/periodo:' . $periodoatual . '/ordem:professor'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cress as $c_cress): ?>
                        <?php // pr($c_cress); ?>
                        <tr>
                            <td><?php echo $this->Html->link($c_cress['estudante'], '/Estudantes/view/registro:' . $c_cress['registro']); ?></td>
                            <td><?php echo $this->Html->link($c_cress['instituicao'], '/Instituicoes/view/' . $c_cress['instituicao_id']); ?></td>
                            <td><?php echo $c_cress['endereco']; ?></td>
                            <td><?php echo $c_cress['cep']; ?></td>
                            <td><?php echo $c_cress['bairro']; ?></td>
                            <td><?php echo $c_cress['supervisor']; ?></td>
                            <td><?php echo $c_cress['cress']; ?></td>
                            <td><?php echo $c_cress['professor']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>