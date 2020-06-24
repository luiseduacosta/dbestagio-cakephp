<?php
// pr($supervisores);
?>

<?php
$this->Js->get('#InscricaoInstituicaoId')->event('change',
        $this->Js->request(array(
            'controller' => 'Instituicoes',
            'action' => 'seleciona_supervisor'
                ), array(
            'update' => '#InscricaoSupervisorId',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
);
?>

<?php echo $this->Html->link('Solicita termo', '/Inscricoes/termosolicita'); ?>
<h5>Solicitação de Termo de Compromisso para cursar estágio no período
    <?php echo $periodo; ?></h5>

<div class="card">
    <div class="card-header">
        <?= "Nome: " . $aluno . "<br>"; ?>
    </div>
    <div class="card-body">
        <?= "Registro (DRE): " . $id . "<br>"; ?>
        <?= "Nível de estágio: " . $nivel . "<br>"; ?>
        <?= "Período: " . $periodo . "<br>"; ?>
        <?= "Turno: " . $turno . "<br>"; ?> 
    </div>
</div>

<?php
echo $this->Form->create('Inscricao', array('url' => 'termocadastra/' . $id));

echo $this->Form->input('aluno_id', array('type' => 'hidden', 'label' => 'Registro', 'value' => $id));

echo $this->Form->input('aluno_nome', array('type' => 'hidden', 'value' => $aluno));

echo $this->Form->input('nivel', array('type' => 'hidden', 'value' => $nivel));

echo $this->Form->input('periodo', array('type' => 'hidden', 'value' => $periodo));

echo $this->Form->input('turno', array('type' => 'hidden', 'value' => $turno, 'default' => 'I'));

echo $this->Form->input('docente_id', array('type' => 'hidden', 'label' => 'Professor', 'value' => $professor_atual));

echo $this->Form->input('instituicao_id', array('type' => 'select', 'label' => 'Instituição (É obrigatório selecionar a instituição)', 'options' => $instituicoes, 'selected' => $instituicao_atual, 'empty' => ['0' => 'Selecione instituição'], 'class' => 'form-control'));

echo $this->Form->input('supervisor_id', array('type' => 'select', 'label' => 'Supervisor (Se não souber quem é o supervisor deixe sem selecionar")', 'options' => $supervisores, 'selected' => $supervisor_atual, 'empty' => ['0' => 'Selecione supervisor'], 'class' => 'form-control'));

echo "<br>";

echo $this->Form->submit('Confirmar', ['class' => 'btn btn-primary']);

echo $this->Form->end();
?>
