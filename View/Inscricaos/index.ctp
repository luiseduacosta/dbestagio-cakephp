<?php
echo $this->Html->script("jquery", array('inline' => false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

var url = location.hostname;

var base_url = window.location.pathname.split("/");

$("#InscricaoPeriodo").change(function() {
	var periodo = $(this).val();
        /* alert(periodo); */
        if (url === "localhost") {
            window.location="/" + base_url[1] + "/inscricaos/index/periodo:"+periodo;
        } else {
            window.location="/inscricaos/index/periodo:"+periodo;
        }
    })
})

', array("inline" => false)
);
?>

<?php echo $this->Html->link('Listar mural', '/murals/index'); ?>

<hr />

<h1>
    Estudantes inscritos para estágio 
    <?php
    if (isset($periodo))
        echo " " . $periodo;
    ?>
</h1>

<?php
if (isset($instituicao)):
    ?>
    <h1><?php echo $this->Html->link($instituicao . ': ', '/murals/view/' . $mural_id);
    echo " Vagas: " . $vagas ?></h1>
    <?php echo $this->Html->link($instituicao . ': ', '/estagiarios/index/id_instituicao:' . $id_instituicao . '/periodo:' . $periodo);
    ;
    echo " Estagiarios: " . $estagiarios; ?>
    <?php
endif;
?>

<?php echo $this->Form->create('Inscricao', array('controller' => 'Inscricaos', 'url'=>'index')); ?>
<?php echo $this->Form->input('periodo', array('type'=>'select', 'label'=>array('text'=>'Período ', 'style'=>'display: inline'), 'options'=> $todososperiodos, 'default'=>$periodo, 'empty'=>'Selecione')); ?>
<?php echo $this->Form->end(); ?>

<?php
if (isset($inscritos)):
    ?>
    <table>
        <thead>
            <tr>
    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <th><a href="?ordem=id">Id</a></th>
                    <th><a href="?ordem=registro">DRE</a></th>
                    <th><a href="?ordem=estagiario">Estágio?</a></th>
                    <th><a href="?ordem=nome">Estudante</a></th>
                    <th><a href="?ordem=nascimento">Nascimento</a></th>
                    <th><a href="?ordem=telefone">Telefone</a></th>
                    <th><a href="?ordem=celular">Celular</a></th>
                    <th><a href="?ordem=email">Email</a></th>
    <?php else: ?>
                    <th><a href="?ordem=nome">Estudante</a></th>
            <?php endif; ?>
            </tr>
        </thead>
        <tbody>
                <?php
                foreach ($inscritos as $c_inscrito):
                    // pr($c_inscrito);
                    // die();
                    ?>
                <tr>

                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                        <td><?php // echo $this->Html->link($c_inscrito['id_inscricao'], '/inscricaos/view/' . $c_inscrito['id_inscricao']); ?></td>
                        <td><?php echo $c_inscrito['registro']; ?></td>
                        <td><?php echo $c_inscrito['estagiario']; ?></td>
                        <?php endif; ?>

                    <td>
                        <?php
                        if ($c_inscrito['estagiario'] === 0) {
                            if ($this->Session->read('categoria') === 'administrador') {
                                echo $this->Html->link($c_inscrito['nome'], '/Alunonovos/view/' . $c_inscrito['id']);
                            } else {
                                echo $c_inscrito['nome'];
                            }
                        } else {
                            if ($this->Session->read('categoria') === 'administrador') {
                                echo $this->Html->link($c_inscrito['nome'], '/Alunos/view/' . $c_inscrito['id']);
                            } else {
                                echo $c_inscrito['nome'];
                            }
                        }
                        ?>
                    </td>

                    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                        <td><?php echo $c_inscrito['nascimento']; ?></td>
                        <td><?php echo $c_inscrito['telefone']; ?></td>
                        <td><?php echo $c_inscrito['celular']; ?></td>
                        <td><?php echo $c_inscrito['email']; ?></td>
                    <?php endif; ?>    
                </tr>
    <?php endforeach; ?>
        </tbody>
    </table>

<?php
endif;
?>
