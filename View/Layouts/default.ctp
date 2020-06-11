<?php
/* SVN FILE: $Id$ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php __('ESS/UFRJ'); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        // echo $this->Html->css('cake.generic');
        // echo $this->Html->css('meus_estilos');
        // echo $this->Html->script(['https://code.jquery.com/jquery-3.5.1.min.js']);
        // echo $this->Js->writeBuffer();
        // echo $scripts_for_layout;
        ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <div class="navbar navbar-expand-sm justify-content-center">
                    <?= $this->Html->link('Coordenação de Estágio & Extensão - ESS - UFRJ', '/http://mural.ess.ufrj.br'); ?>
                </div>

                <div class='container'>
                    <ul class="navbar navbar-header nav-tabs justify-content-end bg-secondary">
                        <li class="nav-item">
                            <?php echo $this->Html->link("ESS", "http://www.ess.ufrj.br", ['class' => 'nav-link']); ?>
                        </li>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Login", ['controller' => 'Userestagios', 'action' => 'login'], ['class' => 'nav-link']); ?>
                        </li>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Mural", ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'nav-link']); ?>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Documentação</a>
                            <div class="dropdown-menu">
                                <?php echo $this->Html->link("Termo de compromisso", "/Inscricoes/termosolicita", ['class' => 'dropdown-item']); ?>
                                <?php echo $this->Html->link("Avaliação discente", "/Alunos/avaliacaosolicita", ['class' => 'dropdown-item']); ?>
                                <?php echo $this->Html->link("Folha de atividades", "/Alunos/folhadeatividades", ['class' => 'dropdown-item']); ?>
                            </div>                    
                        </li>                    

                        <?php if ($this->Session->read('categoria')): ?>
                            <li class="nav-item">
                                <?php echo $this->Html->link("Estagiários", "/Estagiarios/index", ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link("Instituições", "/Instituicoes/lista", ['escape' => FALSE, 'class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link("Supervisores", "/Supervisores/index/ordem:nome", ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">
                                <?php echo $this->Html->link("Professores", "/Professores/index", ['class' => 'nav-link']); ?>
                            </li>
                        <?php endif; ?>

                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administração</a>    
                                <div class="dropdown-menu">
                                    <?php echo $this->Html->link('Configuração', '/configuracaos/view/1', ['class' => 'dropdown-item']); ?>
                                    <?php echo $this->Html->link('Usuários', '/Userestagios/listausuarios/', ['class' => 'dropdown-item']); ?>
                                    <?php echo $this->Html->link('Planilha seguro', '/alunos/planilhaseguro/', ['class' => 'dropdown-item']); ?>
                                    <?php echo $this->Html->link('Planilha CRESS', '/alunos/planilhacress/', ['class' => 'dropdown-item']); ?>
                                    <?php echo $this->Html->link('Carga horária', '/alunos/cargahoraria/', ['class' => 'dropdown-item']); ?>
                                </div>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess', ['class' => 'nav-link']); ?>
                        </li>
                        <li class="nav-item">
                            <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link']); ?>
                        </li>

                        <?php if ($this->Session->read('user')): ?>
                            <?php echo "<span style='color: white; font-weight: bold; text-transform: capitalize'>" . $this->Session->read('categoria') . "</span>" . ": "; ?>

                            <?php
                            switch ($this->Session->read('menu_aluno')) {
                                case 'estagiario':
                                    echo "<span style='color: white; font-weight: bold'>" . $this->Html->link($this->Session->read('user'), "/Estudantes/view/" . $this->Session->read('numero')) . "</span>" . " ";
                                    break;
                                case 'alunonovo':
                                    echo "<span style='color: white; font-weight: bold'>" . $this->Html->link($this->Session->read('user'), "/Estudantes/view/" . $this->Session->read('numero')) . "</span>" . " ";
                                    break;
                                case 'semcadastro':
                                    echo "<span style='color: white; font-weight: bold'>" . $this->Session->read('user') . "</span>" . " ";
                                    break;
                            }
                            if ($this->Session->read('menu_supervisor_id'))
                                echo "<span style='color: white; font-weight: bold'>" . $this->Html->link($this->Session->read('user'), "/Supervisores/view/" . $this->Session->read('menu_supervisor_id')) . "</span>" . " ";
                            ?>
                            <li class="nav-item">
                                <?php echo $this->Html->link('Sair', '/Userestagios/logout/', ['class' => 'nav-link']); ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div id="content">

                <?php echo $this->Session->flash(); ?>

                <?php echo $content_for_layout; ?>

            </div>

            <div id="footer">
                <?php
                echo $this->Html->link(
                        $this->Html->image('cake.power.gif', array('alt' => __("CakePHP: the rapid development php framework", true), 'border' => "0")), 'http://www.cakephp.org/', array('target' => '_blank', 'escape' => false)
                );
                ?>
            </div>

        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
