<div class="submenusuperior">
<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <nav class="nav nav-tabs">
        <?php echo $this->Html->link('Configurações', '/Configuracaos/view/1', ['class' => 'nav-link']); ?>
        <?php echo $this->Html->link('Usuários', '/Userestagios/listausuarios/', ['class' => 'nav-link']); ?>
        <?php echo $this->Html->link('Planilha seguro', '/alunos/planilhaseguro/', ['class' => 'nav-link']); ?>
        <?php echo $this->Html->link('Planilha CRESS', '/alunos/planilhacress/', ['class' => 'nav-link']); ?>
        <?php echo $this->Html->link('Carga horária', '/alunos/cargahoraria/', ['class' => 'nav-link']); ?>
    </nav>
<?php endif; ?>
</div>
