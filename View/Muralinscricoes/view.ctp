<?php
// pr($inscricao);
?>
<nav class="nav nav-tabs">
<?php echo $this->Html->link('Listar', '/Muralinscricoes/index/' . $inscricao['Muralinscricao']['muralestagio_id'], ['class' => 'nav-item nav-link']); ?>
</nav>

<h5>Inscrição para seleção de estágio</h5>

<div class="row">
    <div class="col">
        <p>Registro</p>
    </div>
    <div class="col">
        <p><?php echo $inscricao['Muralinscricao']['registro']; ?></p>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>Nome</p>
    </div>
    <div class="col">
        <p>
            <?= strtoupper($estudante['Estudante']['nome']); ?>
        </p>
    </div>
</div>


<div class="row">
    <div class="col">
        <p>Instituição</p>
    </div>
    <div class="col">
        <p><?= $this->Html->link($muralestagio['Muralestagio']['instituicao'], '/Muralinscricoes/index/' . $inscricao['Muralinscricao']['muralestagio_id']); ?></p>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>Data</p>
    </div>
    <div class="col">
        <p><?= (date('d-m-Y', strtotime($inscricao['Muralinscricao']['data']))); ?></p>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>Período</p>
    </div>
    <div class="col">
        <p><?= $inscricao['Muralinscricao']['periodo']; ?></p>
    </div>
</div>

<hr>

<?php if ($this->Session->read('id_categoria') === '1'): ?>
    <nav class='nav nav-tabs'>
        <?= $this->Html->link('Excluir', '/Muralinscricoes/delete/' . $inscricao['Muralinscricao']['id'], ['class' => 'nav-item nav-link', 'Tem certeza?']); ?>
    </nav>
<?php endif; ?>