<?php

// pr($listausuarios);   ?>
<?php // pr($direcao);   ?>
<?php // pr($linhas);   ?>
<?php // pr($ordem);   ?>
<?php // pr($q_paginas);  ?>
<?php // pr($pagina);  ?>

<?php
echo $this->Html->script("jquery", array('inline' => false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

var url = location.hostname;
var base_url = window.location.pathname.split("/");

$("#UserLinhas").change(function() {
	var linhas = $(this).val();
        /* alert(linhas); */
        if (url === "localhost") {
            window.location="/" + base_url[1] + "/users/listausuarios/linhas:" +linhas;
        } else {
            window.location="/users/listausuarios/linhas:" +linhas;
        }
})

})

', array("inline" => false)
);
?>

<?php echo $this->Html->link('Configurações', '/configuracaos/view/1'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Usuários', '/users/listausuarios/'); ?>
<?php echo " | "; ?>
<?php // echo $this->Html->link('Permissões','/aros/indexaros/'); ?>


<?php if ($this->Session->read('categoria') === 'administrador'): ?>

    <?php echo $this->Form->create('User', array('controller' => 'Users', 'url' => 'listausuarios')); ?>
    <?php echo $this->Form->input('linhas', array('type' => 'select', 'label' => array('text' => 'Linhas por páginas ', 'style' => 'display: inline'), 'options' => array('15' => '15', '0' => 'Todos'), 'selected' => $linhas, 'empty' => array('15' => 'Selecione'))); ?>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>

<div align="center">
    <?php
// Menu superior de Navegação //
    if ($linhas != 0):

        echo "  " . $this->Html->link('<< Início ', 'listausuarios/ordem:' . $ordem . '/pagina:' . 1 . '/q_paginas:' . $q_paginas);

        $retrocederpagina = $pagina - 1;
        echo "  " . $this->Html->link('<- Retroceder |', 'listausuarios/ordem:' . $ordem . '/pagina:' . $retrocederpagina . '/q_paginas:' . $q_paginas);

        $avancarpagina = $pagina + 1;
        if ($avancarpagina > $q_paginas) {
            $pagina = 0;
        } else {
            echo "  " . $this->Html->link('| Avançar -> ', 'listausuarios/ordem:' . $ordem . '/pagina:' . $avancarpagina . '/q_paginas:' . $q_paginas);
        }
        echo "  " . $this->Html->link('Última >> ', 'listausuarios/ordem:' . $ordem . '/pagina:' . $q_paginas . '/q_paginas:' . $q_paginas);

        echo "<br>";

        $i = 1;
        $j = 1;
        // echo $j . "<br>";
        for ($k = 0; $k < 10; $k++):
            echo " " . $this->Html->link(($pagina + $k), 'listausuarios/ordem:' . $ordem . '/pagina:' . ($pagina + $k));
            if (($pagina + $k) >= $q_paginas) {
                break;
            }
        endfor;
    endif;
    ?>
</div>

<table>
    <thead>
        <tr>
            <th>Excluir</th>
            <th>Editar</th>
            <th><?php echo $this->Html->link('Número', 'listausuarios/ordem:numero/direcao:' . $direcao); ?></th>
            <th><?php echo $this->Html->link('Nome', 'listausuarios/ordem:nome/direcao:' . $direcao); ?></th>        
            <th><?php echo $this->Html->link('Email', 'listausuarios/ordem:email/direcao:' . $direcao); ?></th>
            <th><?php echo $this->Html->link('Categoria', 'listausuarios/ordem:categoria/direcao:' . $direcao); ?></th>
        </tr>
    </thead>

    <?php foreach ($listausuarios as $usuario): ?>

    <tr>
        <td>
                <?php
                if ($usuario['numero'] != 0):
                    echo $this->Html->link('X', '/users/delete/' . $usuario['numero'], NULL, 'Tem certeza?');
                endif;
                ?>
        </td>

        <td>
                <?php
                if ($usuario['numero'] != 0):
                    echo $this->Html->link('Editar', '/users/view/' . $usuario['numero']);
                endif;
                ?>
        </td>

        <td>
                <?php if ($usuario['aluno_tipo'] == 0): ?>
                    <?php echo $this->Html->link($usuario['numero'], '/alunos/view/' . $usuario['aluno_id']); ?>
                <?php elseif ($usuario['aluno_tipo'] == 1): ?>
                    <?php echo $this->Html->link($usuario['numero'], '/alunonovos/view/' . $usuario['aluno_id']); ?>
                <?php elseif ($usuario['aluno_tipo'] == 2): ?>
                    <?php echo $usuario['numero']; ?>
                <?php elseif ($usuario['aluno_tipo'] == 3): ?>
                    <?php echo $this->Html->link($usuario['numero'], '/professors/view/' . $usuario['aluno_id']); ?>
                <?php elseif ($usuario['aluno_tipo'] == 4): ?>
                    <?php echo $this->Html->link($usuario['numero'], '/supervisors/view/' . $usuario['aluno_id']); ?>
                <?php endif; ?>
        </td>
        <td>
                <?php echo $usuario['nome']; ?>
        </td>    
        <td>
                <?php echo $usuario['email']; ?>
        </td>
        <td>
                <?php echo $usuario['categoria']; ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>
