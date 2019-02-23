<div class="submenusuperior">
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Inserir', '/Professors/add/');
    echo " | ";
    // echo $this->Html->link('Buscar (não implementado)', '/Professors/busca/');
    echo " | ";
    echo $this->Html->link('Áreas', '/Areas/index/');
    echo " | ";
    echo $this->Html->link('Pauta', '/Professors/pauta/');
    ?>
<?php else: ?>
    <?php
    // echo $this->Html->link('Buscar (não implementado)', '/Professors/busca/');
    echo " | ";
    echo $this->Html->link('Áreas', '/Areas/index/');
    echo " | ";
    echo $this->Html->link('Pauta', '/Professors/pauta/');    
    ?>
<?php endif; ?>    
</div>
