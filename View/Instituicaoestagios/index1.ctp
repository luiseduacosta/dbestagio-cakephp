<?php
// pr($instituicoes);
// pr($q_paginas);
// pr($pagina);
// pr($direcao);
// pr($ordem);
// die();
?>

<script>

    $(document).ready(function () {

        var url = "<?= $this->Html->url(["controller" => "Instituicaoestagios", "action" => "index1/linhas:"]); ?>";

        $("#InstituicaoLinhas").change(function () {
            var linhas = $(this).val();
            url = url + linhas;
            /* alert(linhas); */
            $(location).attr('href', url);
        })
    })

</script>

<?php echo $this->element('submenu_instituicoes'); ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <div class='row'>
        <div class='col-3'>
            <?php echo $this->Form->create('Instituicaoestagio', array('controller' => 'Instituicaoestagio', 'url' => 'lista')); ?>
            <?php echo $this->Form->input('linhas', array('type' => 'select', 'label' => array('text' => 'Linhas por páginas ', 'style' => 'display: inline'), 'options' => array('15' => '15', '0' => 'Todos'), 'selected' => $linhas, 'empty' => array('15' => 'Selecione'), 'class' => 'form-control')); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
<?php endif; ?>

<br>

<div align="center">
    <?php
// Menu superior de Navegação //
    if ($linhas != 0):

        echo "  " . $this->Html->link('<< Início ', 'index1/ordem:' . $ordem . '/pagina:' . 1 . '/direcao:' . $direcao);

        $retrocederpagina = $pagina - 1;
        echo "  " . $this->Html->link('<- Retroceder |', 'index1/ordem:' . $ordem . '/pagina:' . $retrocederpagina . '/direcao:' . $direcao);

        $avancarpagina = $pagina + 1;
        if ($avancarpagina > $q_paginas) {
            $avancarpagina = 0;
        }
        echo "  " . $this->Html->link('| Avançar -> ', 'index1/ordem:' . $ordem . '/pagina:' . $avancarpagina . '/direcao:' . $direcao);

        echo "  " . $this->Html->link('Última >> ', 'index1/ordem:' . $ordem . '/pagina:' . $q_paginas . '/direcao:' . $direcao);

        echo "<br>";

        $i = 1;
        $j = 1;
        // echo $j . "<br>";
        for ($k = 0; $k < 10; $k++):
            echo " " . $this->Html->link(($pagina + $k), 'index1/ordem:' . $ordem . '/pagina:' . ($pagina + $k) . '/direcao:' . $direcao);
            if (($pagina + $k) >= $q_paginas) {
                break;
            }
        endfor;
    endif;
    ?>

</div>

<div class="table-responsive">
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
            <tr>
                <th>
                    <?php echo $this->Html->link('Id', 'index1/ordem:instituicao_id/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('Instituicao', 'index1/ordem:instituicao/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('CNPJ', 'index1/ordem:cnpj/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('E-mail', 'index1/ordem:email/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('Link', 'index1/ordem:url/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('Telefone', 'index1/ordem:telefone/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->html->link('Benefício', 'index1/ordem:beneficio/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->html->link('Avaliação', 'index1/ordem:avaliacao/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($instituicoes as $c_instituicao): ?>
                <?php // pr($c_instituicao);  ?>
                <tr>
                    <td><?php echo $this->Html->link($c_instituicao['instituicao_id'], '/Instituicaoestagios/view/' . $c_instituicao['instituicao_id']); ?></td>
                    <td><?php echo $this->Html->link($this->text->truncate($c_instituicao['instituicao'], 50), '/Instituicaoestagios/view/' . $c_instituicao['instituicao_id']); ?></td>
                    <td>
                        <?php
                        if ($c_instituicao['cnpj']):
                            echo $c_instituicao['cnpj'];
                        endif;
                        ?>
                    </td>
                    <td><?php
                        if ($c_instituicao['email']):
                            echo $this->text->truncate($c_instituicao['email'], 10);
                        endif;
                        ?>
                    </td>
                    <td><?php
                        if ($c_instituicao['url']):
                            echo $this->Html->link('Link', $c_instituicao['url']);
                        endif;
                        ?></td>
                    <td><?php echo $c_instituicao['telefone']; ?></td>
                    <td><?php echo $c_instituicao['beneficio']; ?></td>
                    <td><?php // echo $c_instituicao['avaliacao']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>