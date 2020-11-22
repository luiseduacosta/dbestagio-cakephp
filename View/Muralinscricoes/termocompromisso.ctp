<?php
// pr($supervisores);
?>

<?php
$this->Js->get('#MuralinscricaoInstituicaoId')->event('change',
        $this->Js->request(array(
            'controller' => 'Instituicaoestagio',
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

<?php echo $this->Html->link('Solicita termo', '/Muralinscricoes/termosolicita'); ?>
<h5>Solicitação de Termo de Compromisso para cursar estágio no período
    <?php echo $periodo; ?></h5>

<div class="card text-black bg-light">
    <div class="card-header">
        <?= "Nome: " . $aluno . "<br>"; ?>
    </div>
    <div class="card-body">
        <?= "Registro (DRE): " . $registro . "<br>"; ?>
        <?= "Nível de estágio: " . $nivel . "<br>"; ?>
        <?= "Período: " . $periodo . "<br>"; ?>
        <?= "Turno: " . $turno . "<br>"; ?> 
    </div>
</div>

<?php
echo $this->Form->create('Muralinscricao', array('url' => 'termocadastra/registro:' . $registro));

echo $this->Form->input('registro', array('type' => 'hidden', 'label' => 'Registro', 'value' => $registro));

echo $this->Form->input('aluno_nome', array('type' => 'hidden', 'value' => $aluno));

echo $this->Form->input('nivel', array('type' => 'hidden', 'value' => $nivel));

echo $this->Form->input('periodo', array('type' => 'hidden', 'value' => $periodo));

echo $this->Form->input('turno', array('type' => 'hidden', 'value' => $turno, 'default' => 'I'));

echo $this->Form->input('docente_id', array('type' => 'hidden', 'label' => 'Professor', 'value' => $professor_atual));
?>
<fieldset class='form-group'>
    <div class="form-group row">
        <div class="col-form-label col-sm-4">Ajuste curricular 2020</div>
        <div class='col-sm-8'>
            <div class ='form-check'>
                <?= $this->Form->input('Estagiario.ajustecurricular2020', array('div' => 'col-sm-12', 'type' => 'radio', 'legend' => FALSE, 'label' => ['class' => 'form-check-label col-sm-4'], 'options' => array('0' => 'Não', '1' => 'Sim'), 'default' => '0', 'class' => 'form-check-input')); ?>
            </div>
            <small class="form-text text-muted">
                NÃO quer dizer 4 níveis de estágio de 120 horas cada. SIM quer dizer 3 níveis de estágio de 135 horas cada. A mudança começou com os estudantes ingressos a partir de 2019.
            </small>
        </div>
    </div>    
</fieldset>

<?php
echo $this->Form->input('instituicaoestagio_id', array('type' => 'select', 'label' => 'Instituição (É obrigatório selecionar a instituição)', 'options' => $instituicoes, 'selected' => $instituicao_atual, 'empty' => ['0' => 'Selecione instituição'], 'class' => 'form-control'));

echo $this->Form->input('supervisor_id', array('type' => 'select', 'label' => 'Supervisor (Se não souber quem é o supervisor deixe sem selecionar")', 'options' => $supervisores, 'selected' => $supervisor_atual, 'empty' => ['0' => 'Selecione supervisor'], 'class' => 'form-control'));

echo "<br>";

echo $this->Form->submit('Confirmar', ['class' => 'btn btn-success']);

echo $this->Form->end();
?>
