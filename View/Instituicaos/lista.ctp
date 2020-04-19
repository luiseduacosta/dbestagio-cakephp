<?php

// pr($instituicoes);
// pr($q_paginas);
// pr($pagina);
// pr($direcao);
// pr($ordem);
// die();
?>

<?php
echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

var url = location.hostname;
var base_url = window.location.pathname.split("/");

$("#InstituicaoLinhas").change(function() {
	var linhas = $(this).val();
        /* alert(linhas); */
        if (url === "localhost") {
            window.location="/" + base_url[1] + "/instituicaos/lista/linhas:" +linhas;
        } else {
            window.location="/instituicaos/lista/linhas:" +linhas;
        }
})

})

', array("inline"=>false)

);
?>

<?php echo $this->element('submenu_instituicoes'); ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>

    <?php echo $this->Form->create('Instituicao', array('controller' => 'Instituicao', 'url'=>'lista')); ?>
    <?php echo $this->Form->input('linhas', array('type'=>'select', 'label'=>array('text'=>'Linhas por páginas ', 'style'=>'display: inline'), 'options'=> array('15' => '15', '0' => 'Todos'), 'selected' => $linhas, 'empty'=> array('15' => 'Selecione'))); ?>
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
    for ($k=0; $k < 10; $k++):
        echo " " . $this->Html->link(($pagina + $k), 'lista/ordem:' . $ordem . '/pagina:' . ($pagina + $k) . '/direcao:' . $direcao);
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
            <th>
                <?php echo $this->Html->link('Id', 'lista/ordem:instituicao_id/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
            </th>
            <th>
                <?php echo $this->Html->link('Instituicao', 'lista/ordem:instituicao/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
            </th>
            <th>
                <?php echo $this->Html->link('Expira', 'lista/ordem:expira/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
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
        <?php // pr($c_instituicao); ?>
        <tr>
            <td><?php echo $this->Html->link($c_instituicao['instituicao_id'], '/Instituicaos/view/' . $c_instituicao['instituicao_id']); ?></td>
            <td><?php echo $this->Html->link($c_instituicao['instituicao'], '/Instituicaos/view/' . $c_instituicao['instituicao_id']); ?></td>
            <td>
                <?php 
                    if ($c_instituicao['expira']):
                        echo date('d-m-Y', strtotime($c_instituicao['expira'])); 
                    endif;
                ?>
            </td>
            <td><?php 
            if ($c_instituicao['visita']):
                echo $this->Html->link(date('d-m-Y', strtotime($c_instituicao['visita'])), '/visitas/view/' . $c_instituicao['visita_id']);
            endif;
            ?>
            </td>
            <td><?php echo $this->Html->link($c_instituicao['ultimoperiodo'], '/estagiarios/index/instituicao_id:' . $c_instituicao['instituicao_id']); ?></td>
            <td><?php echo $c_instituicao['estagiarios']; ?></td>
            <td><?php echo $c_instituicao['supervisores']; ?></td>
            <td><?php echo $c_instituicao['area']; ?></td>
            <td><?php echo $c_instituicao['natureza']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
