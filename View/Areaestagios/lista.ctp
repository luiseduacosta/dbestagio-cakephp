<?php /* pr($areas); */ ?>
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <div class='container'>
        <nav class="nav nav-tabs">
            <?php echo $this->Html->link('Áreas por professor', '/Areaestagios/index/', ['class' => 'nav-link']); ?>
            <?php echo $this->Html->link('Inserir', '/Areaestagios/add/', ['class' => 'nav-link']); ?>
        </nav>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-auto">    
        <h5>Áreas de orientação dos/as professores/as de OTP</h5>
        <?php echo $this->Paginator->first('<< Primeiro ', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->prev('< Anterior ', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->next(' Posterior > ', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->last(' Último >> ', null, null, array('class' => 'disabled')); ?>

        <br/>

        <?php echo $this->Paginator->numbers(); ?>
    </div>
</div>


<div class="row justify-content-center">
    <div class="col-auto">    
        <div class='container table-responsive'>
            <table class="container table table-striped table-hover table-responsive">
                <thead class="thead-light">
                    <tr>
                        <th><?= $this->Paginator->sort('Areaestagio.id', 'Id') ?></th>
                        <th><?= $this->Paginator->sort('Areaestagio.area', 'Área') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($areas as $c_area): ?>

                        <tr>
                            <td>
                                <?php echo $this->Html->link($c_area['Areaestagio']['id'], '/Areaestagios/view/' . $c_area['Areaestagio']['id']); ?>
                            </td>
                            <td>
                                <?php echo $this->Html->link($c_area['Areaestagio']['area'], '/Estagiarios/index/areaestagio_id:' . $c_area['Areaestagio']['id']); ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>
<?=
$this->Paginator->counter(array(
    'format' => "Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%"
));
?>