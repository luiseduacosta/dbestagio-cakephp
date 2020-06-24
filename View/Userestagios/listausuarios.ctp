<?php // pr($listausuarios);        ?>
<?php // pr($direcao);        ?>
<?php // pr($linhas);        ?>
<?php // pr($ordem);        ?>
<?php // pr($q_paginas);       ?>
<?php // pr($pagina);       ?>

<script>
    $(document).ready(function () {

        var url = "<?= $this->Html->url(['controller' => 'Userestagios', 'action' => 'listausuarios/linhas:']) ?>";
        /* alert(url); */
        $("#UserestagioLinhas").change(function () {
            var linhas = $(this).val();
            /* alert(linhas); */
            window.location = url + linhas;
        });
    });
</script>

<?= $this->element('submenu_administracao'); ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>

    <?php echo $this->Form->create('Userestagio', array('controller' => 'Userestagios', 'url' => 'listausuarios')); ?>
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

<div class='table-responsive'>
    <table class="table table-hover table-responsive">
        <thead class='thead-light'>
            <tr>
                <th>Excluir</th>
                <th>Editar</th>
                <th><?php echo $this->Html->link('Número', 'listausuarios/ordem:numero/direcao:' . $direcao); ?></th>
                <th><?php echo $this->Html->link('Nome', 'listausuarios/ordem:nome/direcao:' . $direcao); ?></th>
                <th><?php echo $this->Html->link('Email', 'listausuarios/ordem:email/direcao:' . $direcao); ?></th>
                <th><?php echo $this->Html->link('Categoria', 'listausuarios/ordem:categoria/direcao:' . $direcao); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listausuarios as $usuario): ?>

                <tr>
                    <td>
                        <?php
                        if ($usuario['numero'] != 0):
                            echo $this->Html->link('X', '/Userestagios/delete/' . $usuario['numero'], NULL, 'Tem certeza?');
                        endif;
                        ?>
                    </td>

                    <td>
                        <?php
                        if ($usuario['numero'] != 0):
                            echo $this->Html->link('Editar', '/Userestagios/view/' . $usuario['numero']);
                        endif;
                        ?>
                    </td>

                    <td>
                        <?php if ($usuario['aluno_tipo'] == 0): ?>
                            <?php echo $this->Html->link($usuario['numero'], '/Estudantes/view/' . $usuario['aluno_id']); ?>
                        <?php elseif ($usuario['aluno_tipo'] == 1): ?>
                            <?php echo $this->Html->link($usuario['numero'], '/Estudantes/view/' . $usuario['aluno_id']); ?>
                        <?php elseif ($usuario['aluno_tipo'] == 2): ?>
                            <?php echo $usuario['numero']; ?>
                        <?php elseif ($usuario['aluno_tipo'] == 3): ?>
                            <?php echo $this->Html->link($usuario['numero'], '/Professors/view/' . $usuario['aluno_id']); ?>
                        <?php elseif ($usuario['aluno_tipo'] == 4): ?>
                            <?php echo $this->Html->link($usuario['numero'], '/Supervisors/view/' . $usuario['aluno_id']); ?>
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
        </tbody>
        <tfoot></tfoot>
    </table>
</div>
