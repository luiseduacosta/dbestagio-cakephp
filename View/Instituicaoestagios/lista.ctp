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

        var url = "<?= $this->Html->url(["controller" => "Instituicaoestagios", "action" => "lista/linhas:"]); ?>";

        $("#InstituicaoLinhas").change(function () {
            var linhas = $(this).val();
            url = url + linhas;
            /* alert(linhas); */
            $(location).attr('href', url);
        })
    })

</script>

<?= $this->element('submenu_instituicoes'); ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <div class='row'>
        <div class='col-3'>
            <?php echo $this->Form->create('Instituicaoestagio', array('controller' => 'Instituicaoestagio', 'url' => 'lista')); ?>
            <?php echo $this->Form->input('linhas', array('type' => 'select', 'label' => array('text' => 'Linhas por páginas ', 'style' => 'display: inline'), 'options' => array('15' => '15', '0' => 'Todos'), 'selected' => $linhas, 'empty' => array('15' => 'Selecione'), 'class' => 'form-control')); ?>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>

<br>

<div align="center">
    <?php
// Menu superior de Navegação //
    if ($linhas != 0):

        echo "  " . $this->Html->link('<< Início ', 'lista/ordem:' . $ordem . '/pagina:' . 1 . '/direcao:' . $direcao);

        $retrocederpagina = $pagina - 1;
        echo "  " . $this->Html->link('<- Retroceder |', 'lista/ordem:' . $ordem . '/pagina:' . $retrocederpagina . '/direcao:' . $direcao);

        $avancarpagina = $pagina + 1;
        if ($avancarpagina > $q_paginas) {
            $avancarpagina = 0;
        }
        echo "  " . $this->Html->link('| Avançar -> ', 'lista/ordem:' . $ordem . '/pagina:' . $avancarpagina . '/direcao:' . $direcao);

        echo "  " . $this->Html->link('Última >> ', 'lista/ordem:' . $ordem . '/pagina:' . $q_paginas . '/direcao:' . $direcao);

        echo "<br>";

        $i = 1;
        $j = 1;
        // echo $j . "<br>";
        for ($k = 0; $k < 10; $k++):
            echo " " . $this->Html->link(($pagina + $k), 'lista/ordem:' . $ordem . '/pagina:' . ($pagina + $k) . '/direcao:' . $direcao);
            if (($pagina + $k) >= $q_paginas) {
                break;
            }
        endfor;
    endif;
    ?>

</div>

<div class="table-responsive">
    <table class="table table-striped table-hover table-responsive">
        <caption>Lista das instituições</caption>
        <thead class="thead-light">
            <tr>
                <th>
                    <?php echo $this->Html->link('Id', 'lista/ordem:instituicao_id/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('Instituicao', 'lista/ordem:instituicao/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('Convênio', 'lista/ordem:expira/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('Visita', 'lista/ordem:visita/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('Último estágio', 'lista/ordem:ultimoperiodo/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->Html->link('Estagiários', 'lista/ordem:estagiarios/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->html->link('Supervisores', 'lista/ordem:supervisores/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->html->link('Área', 'lista/ordem:area/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>
                <th>
                    <?php echo $this->html->link('Natureza', 'lista/ordem:natureza/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                </th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($instituicoes as $c_instituicao): ?>
                <?php // pr($c_instituicao);  ?>
                <tr>
                    <td><?php echo $this->Html->link($c_instituicao['instituicao_id'], '/Instituicaoestagios/view/' . $c_instituicao['instituicao_id']); ?></td>
                    <td><?php echo $this->Html->link($c_instituicao['instituicao'], '/Instituicaoestagios/view/' . $c_instituicao['instituicao_id']); ?></td>
                    <td>
                        <?php
                        if ($c_instituicao['expira']):
                            echo date('d-m-Y', strtotime($c_instituicao['expira']));
                        endif;
                        ?>
                    </td>
                    <td><?php
                        if ($c_instituicao['visita']):
                            echo $this->Html->link(date('d-m-Y', strtotime($c_instituicao['visita'])), '/Visitas/view/' . $c_instituicao['visita_id']);
                        endif;
                        ?>
                    </td>
                    <td><?php echo $this->Html->link($c_instituicao['ultimoperiodo'], '/Estagiarios/index/instituicao_id:' . $c_instituicao['instituicao_id']); ?></td>
                    <td><?php echo $c_instituicao['estagiarios']; ?></td>
                    <td><?php echo $c_instituicao['supervisores']; ?></td>
                    <td><?php echo $c_instituicao['area']; ?></td>
                    <td><?php echo $c_instituicao['natureza']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
