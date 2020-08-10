<?php ?>

<?= $this->element('submenu_instituicoes'); ?>
<div class='row justify-content-center'>
    <div class='col-auto'>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-responsive">
                <caption>Natureza das instituições</caption>
                <thead class="thead-light">
                    <tr>
                        <th>Natureza</th>
                        <th>Quantidade de instituições</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < sizeof($natureza); $i++): ?>
                        <tr>
                            <td><?= $this->Html->link($natureza[$i]['Instituicaoestagio']['natureza'], '/Instituicaoestagios/lista/natureza:' . $natureza[$i]['Instituicaoestagio']['natureza'] . '/linhas:0') ?></td>
                            <?php if ($natureza[$i]['Instituicaoestagio']['natureza']): ?>
                                <td style='text-align: center'><?= $natureza[$i]['0']['qnatureza'] ?></td>
                            <?php else: ?>
                                <td style='text-align: center'><?= $this->Html->link($natureza[$i]['0']['qnatureza'], '/Instituicaoestagios/lista/natureza:null' . '/linhas:0') ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>