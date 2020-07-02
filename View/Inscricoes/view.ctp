<?php
// pr($inscricao);
?>
<nav class="nav nav-tabs">
<?php echo $this->Html->link('Listar', '/Inscricoes/index/' . $inscricao['Inscricao']['mural_estagio_id'], ['class' => 'nav-item nav-link']); ?>
</nav>

<h5>Inscrição para seleção de estágio</h5>

<div class="row">
    <div class="col">
        <p>Registro</p>
    </div>
    <div class="col">
        <p><?php echo $inscricao['Inscricao']['registro']; ?></p>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>Nome</p>
    </div>
    <div class="col">
        <p>
            <?= strtoupper($inscricao['Estudante']['nome']); ?>
        </p>
    </div>
</div>


<div class="row">
    <div class="col">
        <p>Instituição</p>
    </div>
    <div class="col">
        <p><?= $inscricao['Muralestagio']['instituicao']; ?></p>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>Data</p>
    </div>
    <div class="col">
        <p><?= (date('d-m-Y', strtotime($inscricao['Inscricao']['data']))); ?></p>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>Período</p>
    </div>
    <div class="col">
        <p><?= $inscricao['Inscricao']['periodo']; ?></p>
    </div>
</div>

<hr>

<?php if ($this->Session->read('id_categoria') === '1'): ?>
    <nav class='nav nav-tabs'>
        <?= $this->Html->link('Excluir', '/Inscricoes/delete/' . $inscricao['Inscricao']['id'], ['class' => 'nav-item nav-link', 'Tem certeza?']); ?>
        <?= $this->Html->link('Editar', '/Inscricoes/edit/' . $inscricao['Inscricao']['id'], ['class' => 'nav-item nav-link']); ?>
    </nav>
<?php endif; ?>