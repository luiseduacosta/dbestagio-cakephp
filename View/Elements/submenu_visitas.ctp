<div class="submenusuperior">
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Lista','/visitas/index/');
    echo " | ";
    echo $this->Html->link('Instituições','/instituicaos/lista/');    
    ?>
<?php else: ?>
    <?php
    echo $this->Html->link('Lista','/visitas/index/');
    echo " | ";    
    echo $this->Html->link('Instituições','/instituicaos/lista/');        
    ?>
<?php endif; ?>
</div>
