<?php // pr($areas);      ?>
<?php // die();      ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <nav class="nav nav-tabs">
        <?php echo $this->Html->link('Listar', '/Areaestagios/lista/', ['class' => 'nav-item nav-link']); ?>
        <?php echo $this->Html->link('Inserir', '/Areaestagios/add/', ['class' => 'nav-item nav-link']); ?>
    </nav>
<?php endif; ?>

<h5>Áreas de orientação dos professores da OTP</h5>
<div class='cointainer table-responsive'>
    <table class="table table-striped table-hover table-responsive">
        <caption style="caption-side: top;">Áreas de orientação dos professores da OTP</caption>
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Área de estágio</th>
                <th>Professor</th>
                <th>Estagiários</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areas as $c_area): ?>
                <?php // pr($c_area['docente']); ?>
                <tr>
                    <td>
                        <?php echo $this->Html->link($c_area['areaestagio_id'], '/Areaestagios/view/' . $c_area['areaestagio_id']); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($c_area['areaestagio'], '/Areaestagios/view/' . $c_area['areaestagio_id']); ?>
                    </td>
                    <td></td>
                    <td>
                        <?php echo $c_area['q_estagiarios']; ?>
                    </td>
                </tr>
                <?php if (isset($c_area['docente'])): ?>
                    <?php foreach ($c_area['docente'] as $professores): ?>
                        <tr>
                            <?php // pr($professores); ?>
                            <td></td>
                            <td></td>
                            <td>
                                <?php echo $this->Html->link($professores['professor'], '/Professores/view/' . $professores['professor_id']); ?>
                            </td>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>