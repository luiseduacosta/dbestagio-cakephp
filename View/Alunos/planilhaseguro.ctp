<?php // pr($t_seguro);    ?>
<?php // pr($periodos);    ?>
<?php // pr($periodoselecionado);    ?>
<?php // die();    ?>

<?php
echo $this->Html->script("jquery", array('inline' => false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

var url = location.hostname;

var base_url = window.location.pathname.split("/");

$("#AlunoPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        if (url === "localhost") {
            window.location="/" + base_url[1] + "/alunos/planilhaseguro/periodo:"+periodo;
        } else {
            window.location="/alunos/planilhaseguro/periodo:"+periodo;
        }
})
});

', array("inline" => false));
?>

<div id="estagiario_seleciona" style="align-content: center;">
    <table  style="width:95%; border:0px;">
        <tr>
            <td>
                <?php echo $this->Form->create('Aluno', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('periodo', array('type' => 'select', 'options' => $periodos, 'selected' => $periodoselecionado, 'empty' => array($periodoselecionado => 'Período'))); ?>
                <?php // echo $this->Form->end(); ?>
            </td>
            <td>
        </tr>
    </table>
</div>

<table>
    <thead>
    <caption>Planilha para seguro de vida dos estudantes estagiários</caption>
    <tr>
        <th>Nome</th>
        <th>CPF</th>
        <th>Nascimento</th>
        <th>Sexo</th>
        <th>DRE</th>
        <th>Curso</th>
        <th>Nível</th>
        <th>Período</th>
        <th>Início</th>
        <th>Final</th>
        <th>Instituição</th>    
    </tr>
</thead>
<?php foreach ($t_seguro as $cada_aluno): ?>
    <?php // pr($cada_aluno); ?>
    <?php // die(); ?>
    <tr>
        <td>
            <?php echo $this->Html->link($cada_aluno['nome'], '/alunos/view/' . $cada_aluno['id']); ?>
        </td>    
        <td>
            <?php echo $cada_aluno['cpf']; ?>
        </td>    
        <td>
            <?php if (empty($cada_aluno['nascimento'])): ?>
                <?php echo "s/d"; ?>
            <?php else: ?>
                <?php echo date('d-m-Y', strtotime($cada_aluno['nascimento'])); ?>
            <?php endif; ?>
        </td>            
        <td>
            <?php echo $cada_aluno['sexo']; ?>
        </td>            
        <td>
            <?php echo $cada_aluno['registro']; ?>
        </td>            
        <td>
            <?php echo $cada_aluno['curso']; ?>
        </td>            
        <td>
            <?php echo $cada_aluno['nivel']; ?>
        </td>            
        <td>
            <?php echo $cada_aluno['periodo']; ?>
        </td>                    
        <td>
            <?php echo $cada_aluno['inicio']; ?>
        </td>            
        <td>
            <?php echo $cada_aluno['final']; ?>
        </td>            
        <td>
            <?php echo $cada_aluno['instituicao']; ?>
        </td>            
    </tr>
<?php endforeach; ?>
</table>
