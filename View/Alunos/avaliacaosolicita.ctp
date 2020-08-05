<?= $this->element('submenu_alunos'); ?>

<div class="card">
    <div class='card-header'>
        <h5>Digite o seu número de DRE para solicitar o formulário de avaliação discente</h5>
    </div>
    <div class="card-body">
        <p>No processo de solicitação do formulário de avaliação discente será pedido para verificar e, se for necessário, completar a informação sobre o supervisor de campo. Os dados demandados são: Nome, Cress, telefone ou celular e e-mail. Todos os campos são obrigatórios.</p>
        <p>Caso deseje mudar a instituição cadastrada como campo de estágio deve fazer uma nova solicitação do <?php echo $this->Html->link('termo de compromisso', '/Inscricoes/termosoliciata/'); ?>, selecionando a instituição e o supervisor. Feito isso, pode solicitar o formulário de avalição discente.</p>

    </div>
</div>
<br>
<div class='row-form'>
    <div class='col'>
        <?php
        echo $this->Form->create("Aluno", ['inputDefaults' => [
                'div' => ['class' => 'form-group row'],
                'label' => ['class' => 'col-lg-3 col-form-label'],
                'between' => '<div class = "col-lg-9">',
                'after' => '</div>',
                'class' => 'form-control']
        ]);

        echo $this->Form->input('registro', ['label' => ['text' => 'Registro (DRE)'], 'size' => '9', 'maxlength' => '9', 'default' => $this->Session->read('numero'), 'class' => 'form-control']);
        echo $this->Form->input('Confirma', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-success position-static']);
        echo $this->Form->end();
        ?>
    </div>
</div>