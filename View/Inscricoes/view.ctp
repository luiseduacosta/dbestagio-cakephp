<?php
// pr($inscricao);
?>
<?php echo $this->Html->link('Listar', '/Inscricoes/index/' . $inscricao[0]['Inscricao']['mural_estagio_id']); ?>

<h5>Inscrição para seleção de estágio</h5>

<div class="row">
    <div class="col">
        <p>Registro</p>
    </div>
    <div class="col">
        <p><?php echo $inscricao[0]['Inscricao']['aluno_id']; ?></p>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>Nome</p>
    </div>
    <div class="col">
        <p>
            <?= strtoupper($inscricao[0]['Estudante']['nome']); ?>
        </p>
    </div>
</div>


<div class="row">
    <div class="col">
        <p>Instituição</p>
    </div>
    <div class="col">
        <p><?= $inscricao[0]['Muralestagio']['instituicao']; ?></p>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>Data</p>
    </div>
    <div class="col">
        <p><?= (date('d-m-Y', strtotime($inscricao[0]['Inscricao']['data']))); ?></p>
    </div>
</div>

<div class="row">
    <div class="col">
        <p>Período</p>
    </div>
    <div class="col">
        <p><?= $inscricao[0]['Inscricao']['periodo']; ?></p>
    </div>
</div>

<hr>

<?php if ($this->Session->read('id_categoria') === '1'): ?>
    <?= $this->Html->link('Excluir', '/Inscricoes/delete/' . $inscricao[0]['Inscricao']['id'], NULL, 'Tem certeza?'); ?>
<?php endif; ?>