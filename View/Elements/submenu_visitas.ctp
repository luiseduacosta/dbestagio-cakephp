<div class="submenusuperior">
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Lista','/visitas/index/');
    ?>
<?php else: ?>
    <?php
    echo $this->Html->link('Lista','/visitas/index/');
    ?>
<?php endif; ?>
</div>
