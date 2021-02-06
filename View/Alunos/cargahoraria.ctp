<?php //pr($cargahorariatotal);     ?>

<?= $this->element('submenu_administracao'); ?>

<div class ="row justify-content-center">
    <div class="col-auto">


        <table class='table table-responsive table-hover'>
            <caption style="caption-side: top;">Carga horária total por cada estudante</caption>
            <thead class='thead-light'>
                <tr>
                    <th>Id</th>
                    <th><?php echo $this->Html->link("Registro", '/Alunos/cargahoraria/ordem:' . 'registro'); ?></th>
                    <th><?php echo $this->Html->link("Semestres", '/Alunos/cargahoraria/ordem:' . 'q_semestres'); ?></th>
                    <th>Nível</th>
                    <th>Período</th>
                    <th>CH 1</th>
                    <th>Nível</th>
                    <th>Período</th>
                    <th>CH 2</th>
                    <th>Nível</th>        
                    <th>Período</th>
                    <th>CH 3</th>
                    <th>Nível</th>        
                    <th>Período</th>
                    <th>CH 4</th>
                    <th><?php echo $this->Html->link("Total", '/Alunos/cargahoraria/ordem:' . 'ch_total'); ?></th>        
                </tr>
            </thead>
            <?php $i = 1; ?>    
            <tbody>
                <?php foreach ($cargahorariatotal as $c_cargahorariatotal): ?>
                    <tr>

                        <td>
                            <?php echo $i++; ?>
                        </td>    

                        <td>
                            <?php echo $this->Html->link($c_cargahorariatotal['registro'], '/Estudantes/view/registro:' . $c_cargahorariatotal['registro']); ?>
                        </td>

                        <td>
                            <?php echo $c_cargahorariatotal['q_semestres']; ?>
                        </td>

                        <?php foreach ($c_cargahorariatotal as $cada_cargahorariatotal): ?>
                            <?php // pr($cada_cargahorariatotal); ?>
                            <?php if (is_array($cada_cargahorariatotal)): ?>

                                <td>
                                    <?php echo $cada_cargahorariatotal['nivel']; ?>
                                </td>

                                <td>
                                    <?php echo $cada_cargahorariatotal['periodo']; ?>
                                </td>
                                <td>
                                    <?php echo $cada_cargahorariatotal['ch']; ?>
                                </td>

                            <?php endif; ?>
                        <?php endforeach; ?>

                        <td>
                            <?php echo "Total: "; ?>
                        </td>

                        <td>
                            <?php echo $c_cargahorariatotal['ch_total']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
</div>