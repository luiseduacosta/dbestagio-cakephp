<?php // pr($areas);   ?>
<?php // die();   ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Html->link('Listar', '/Areaestagios/lista/'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Inserir', '/Areaestagios/add/'); ?>
    <br />
<?php endif; ?>

<h1>Áreas de orientação dos professores de OTP</h1>

<table>
    <tr>
        <th>Id</th>
        <th>Área de estágio</th>
        <th>Professor</th>
        <th>Estagiários</th>
    </tr>
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
                        <?php echo $this->Html->link($professores['professor'], '/Professors/view/' . $professores['professor_id']); ?>
                    </td>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>

    <?php endforeach; ?>

</table>
