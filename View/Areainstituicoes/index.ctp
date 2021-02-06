<?= $this->element('submenu_areainstituicoes'); ?>    

<div class="row justify-content-center">
    <div class="col-auto">
        <div class="container table-responsive">
            <h5 style="text-align: center">Áreas das instituições</h5>
            <table class="table table-striped table-hover table-responsive">
                <caption style="caption-side: top;">Áress das instituições</caption>
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

                            <td style="text-align: center">
                                <?php echo $c_area['Areainstituicao']['quantidadearea']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>