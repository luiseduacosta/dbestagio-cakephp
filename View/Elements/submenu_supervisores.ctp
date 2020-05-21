<div class="submenusuperior">
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <?php
        echo $this->Html->link('Inserir', '/Supervisores/add/');
        echo " | ";
        echo $this->Html->link('Buscar', '/Supervisores/busca/');
        echo " || ";
        echo $this->Html->link('Repetidos', '/Supervisores/repetidos/');
        echo " | ";
        echo $this->Html->link('Sem alunos', '/Supervisores/semalunos/');
        echo " | ";
        echo $this->Html->link('Sem instituição', '/Supervisores/seminstituicao/');
        ?>
        <br />
    <?php else: ?>
        <?php
        echo $this->Html->link('Buscar', '/Supervisores/busca/');
        ?>
        <br />
    <?php endif; ?>
</div>
