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
<h1>Solicitação de Termo de Compromisso para cursar estágio no período
    <?php echo $periodo; ?></h1>

<?php
echo $this->Form->create('Inscricao', array('url' => 'termocadastra/' . $id));

echo $this->Form->input('aluno_id', array('type' => 'hidden', 'label' => 'Registro', 'value' => $id));
echo "Registro (DRE): " . $id . "<br>";

echo $this->Form->input('aluno_nome', array('type' => 'hidden', 'value' => $aluno));
echo "Nome: " . $aluno . "<br>";

echo $this->Form->input('nivel', array('type' => 'hidden', 'value' => $nivel));
echo "Nível de estágio: " . $nivel . "<br>";

echo $this->Form->input('periodo', array('type' => 'hidden', 'value' => $periodo));
echo "Período: " . $periodo . "<br>";

echo $this->Form->input('turno', array('type' => 'hidden', 'value' => $turno, 'default' => 'I'));

echo $this->Form->input('docente_id', array('type' => 'hidden', 'label' => 'Professor', 'value' => $professor_atual));

echo $this->Form->input('instituicao_id', array('type' => 'select', 'label' => 'Instituição (É obrigatório selecionar a instituição)', 'options' => $instituicoes, 'selected' => $instituicao_atual, 'empty' => ['0' => 'Selecione instituição']));

echo $this->Form->input('supervisor_id', array('type' => 'select', 'label' => 'Supervisor (Se não souber quem é o supervisor deixe sem selecionar")', 'options' => $supervisores, 'selected' => $supervisor_atual, 'empty' => ['0' => 'Selecione supervisor']));

echo $this->Form->end('Confirmar');
?>
