<?php // pr($t_seguro);           ?>
<?php // pr($periodos);           ?>
<?php // pr($periodoselecionado);           ?>
<?php // die();           ?>

<script>
    $(document).ready(function () {

        var url = "<?= $this->Html->url(["controller" => "Estudantes", "action" => "planilhaseguro/periodo:"]); ?>";

        $("#EstudantePeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = url + periodo;
        })
    })
</script>

<?= $this->element('submenu_administracao'); ?>

<div class='justify-content-center'>
    <?php echo $this->Form->create('Estudante', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
    <?php echo $this->Form->input('periodo', array('type' => 'select', 'options' => $periodos, 'selected' => $periodoselecionado, 'empty' => array($periodoselecionado => 'Período'))); ?>
    <?php // echo $this->Form->end(); ?>
</div>

<div class='row justify-content-center'>
    <div class='col-auto'>


        <div class='table-responsive'>
            <table  class="table table-hover table-responsive">
                <caption style="caption-side:top;">Planilha para seguro de vida dos estudantes estagiários</caption>        
                <thead class="thead-light">

                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Nascimento</th>
                        <th>Sexo</th>
                        <th>DRE</th>
                        <th>Curso</th>
                        <th>Nível</th>
                        <th>Período</th>
                        <th>Início</th>
                        <th>Final</th>
                        <th>Instituição</th>    
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($t_seguro as $cada_aluno): ?>
                        <?php // pr($cada_aluno); ?>
                        <?php // die(); ?>
                        <tr>
                            <td>
                                <?php echo $this->Html->link($cada_aluno['nome'], '/Estudantes/view/registro:' . $cada_aluno['registro']); ?>
                            </td>    
                            <td>
                                <?php echo $cada_aluno['cpf']; ?>
                            </td>    
                            <td>
                                <?php if (empty($cada_aluno['nascimento'])): ?>
                                    <?php echo "s/d"; ?>
                                <?php else: ?>
                                    <?php echo date('d-m-Y', strtotime($cada_aluno['nascimento'])); ?>
                                <?php endif; ?>
                            </td>            
                            <td>
                                <?php echo $cada_aluno['sexo']; ?>
                            </td>            
                            <td>
                                <?php echo $cada_aluno['registro']; ?>
                            </td>            
                            <td>
                                <?php echo $cada_aluno['curso']; ?>
                            </td>            
                            <td>
                                <?php echo $cada_aluno['nivel']; ?>
                            </td>            
                            <td>
                                <?php echo $cada_aluno['periodo']; ?>
                            </td>                    
                            <td>
                                <?php echo $cada_aluno['inicio']; ?>
                            </td>            
                            <td>
                                <?php echo $cada_aluno['final']; ?>
                            </td>            
                            <td>
                                <?php echo $cada_aluno['instituicao']; ?>
                            </td>            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>