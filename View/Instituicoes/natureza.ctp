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
                            <td><?= $this->Html->link($natureza[$i]['Instituicao']['natureza'], '/Instituicoes/lista/natureza:' . $natureza[$i]['Instituicao']['natureza'] . '/linhas:0') ?></td>
                            <?php if ($natureza[$i]['Instituicao']['natureza']): ?>
                                <td style='text-align: center'><?= $natureza[$i]['0']['qnatureza'] ?></td>
                            <?php else: ?>
                                <td style='text-align: center'><?= $this->Html->link($natureza[$i]['0']['qnatureza'], '/Instituicoes/lista/natureza:null' . '/linhas:0') ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>