<div class="submenusuperior">
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Lista','/visitas/index/');
    echo " | ";
    echo $this->Html->link('Instituições','/Instituicoes/lista/');
    ?>
<?php else: ?>
    <?php
    echo $this->Html->link('Lista','/Visitas/index/');
    echo " | ";
    echo $this->Html->link('Instituições','/Instituicoes/lista/');
    ?>
<?php endif; ?>
</div>
