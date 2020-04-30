<div class="submenusuperior">
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Inserir', '/Professores/add/');
    echo " | ";
    // echo $this->Html->link('Buscar (não implementado)', '/Professores/busca/');
    echo " | ";
    echo $this->Html->link('Áreas', '/Areaestagios/index/');
    echo " | ";
    echo $this->Html->link('Pauta', '/Professores/pauta/');
    ?>
<?php else: ?>
    <?php
    // echo $this->Html->link('Buscar (não implementado)', '/Professores/busca/');
    echo " | ";
    echo $this->Html->link('Áreas', '/Areaestagios/index/');
    echo " | ";
    echo $this->Html->link('Pauta', '/Professores/pauta/');
    ?>
<?php endif; ?>
</div>
