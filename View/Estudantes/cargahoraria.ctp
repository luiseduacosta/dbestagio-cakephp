<?php //pr($cargahorariatotal);      ?>

<?= $this->element('submenu_estudantes'); ?>

<div class ="row justify-content-center">
    <div class="col-auto">


        <table class='table table-responsive table-hover'>
            <caption style="caption-side: top;">Carga horária total por cada estudante</caption>
            <thead class='thead-light'>
                <tr>
                    <th>Id</th>
                    <th><?php echo $this->Html->link("Registro", '/Estudantes/cargahoraria/ordem:' . 'registro'); ?></th>
                    <th><?php echo $this->Html->link("Nome", '/Estudantes/cargahoraria/ordem:' . 'nome'); ?></th>
                    <th><?php echo $this->Html->link("Semestres", '/Estudantes/cargahoraria/ordem:' . 'q_semestres'); ?></th>
                    <th><?php echo $this->Html->link("Último período", '/Estudantes/cargahoraria/ordem:' . 'ultimoperiodo'); ?></th>
                    <th><?php echo $this->Html->link("Total", '/Estudantes/cargahoraria/ordem:' . 'ch_total'); ?></th>
                    <th></th>
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
                            <?php echo $this->Html->link($c_cargahorariatotal['nome'], '/Estudantes/view/registro:' . $c_cargahorariatotal['registro']); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $c_cargahorariatotal['q_semestres']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $c_cargahorariatotal['ultimoperiodo']; ?>
                        </td>
                        <td style="text-align: center">
                            <?= $c_cargahorariatotal['ch_total']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
</div>