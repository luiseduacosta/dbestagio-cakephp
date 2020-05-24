<div class="submenusuperior">
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php
    echo $this->Html->link('Inserir','/Instituicoes/add/');
    echo " | ";
    echo $this->Html->link('Buscar','/Instituicoes/busca/');
    echo " || ";
    echo $this->Html->link('Área','/Areainstituicoes/index/');
    echo " | ";
    echo $this->Html->link('Natureza','/Instituicoes/natureza/');
    echo " | ";
    echo $this->Html->link('Lista','/Instituicoes/lista/');
    echo " | ";
    echo $this->Html->link('Outra lista','/Instituicoes/index1/');
    echo " | ";    
    echo $this->Html->link('Visitas','/Visitas/index/');
    ?>
<?php else: ?>
    <?php
    echo $this->Html->link('Buscar','/Instituicoes/busca/');
    echo " | ";
    echo $this->Html->link('Lista','/Instituicoes/lista/');
    ?>
<?php endif; ?>
</div>
