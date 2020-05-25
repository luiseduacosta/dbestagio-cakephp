<?php ?>

<?= $this->element('submenu_instituicoes'); ?>

<table>
    <caption>Natureza das instituições</caption>
    <tr>
        <th>Natureza</th>
        <th>Quantidade de instituições</th>
    </tr>
    <?php for ($i = 0; $i < sizeof($natureza); $i++): ?>
        <tr>
            <td><?= $this->Html->link($natureza[$i]['Instituicao']['natureza'], '/Instituicoes/lista/natureza:' . $natureza[$i]['Instituicao']['natureza'] . '/linhas:0') ?></td>
            <?php if ($natureza[$i]['Instituicao']['natureza']): ?>
                <td><?= $natureza[$i]['0']['qnatureza'] ?></td>
            <?php else: ?>
                <td><?= $this->Html->link($natureza[$i]['0']['qnatureza'], '/Instituicoes/lista/natureza:null' . '/linhas:0') ?></td>
            <?php endif; ?>
        </tr>
    <?php endfor; ?>
</table>
