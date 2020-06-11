<?= $this->element('submenu_areainstituicoes'); ?>    
    
<div class="container table-responsive">
    <h1>Áreas das instituições</h1>
    <table class="table table-striped table-hover table-responsive">
        <caption>Áress das instituições</caption>
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Área</th>
                <th>Quantidade de instituições</th>
            </tr>            
        </thead>
        <tbody>
            <?php foreach ($areas as $c_area): ?>

                <tr>
                    <td>
                        <?php echo $this->Html->link($c_area['Areainstituicao']['id'], '/Areainstituicoes/view/' . $c_area['Areainstituicao']['id']); ?>
                    </td>

                    <td>
                        <?php echo $this->Html->link($c_area['Areainstituicao']['area'], '/Areainstituicoes/view/' . $c_area['Areainstituicao']['id']); ?>
                    </td>

                    <td>
                        <?php echo $c_area['Areainstituicao']['quantidadearea']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>