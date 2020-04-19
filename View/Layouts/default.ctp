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

        echo $this->Html->css('cake.generic');
        echo $this->Html->css('abas');
        echo $this->Html->script('jquery'); // Include jQuery library
        
        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1><?php echo $this->Html->link(__('Coordenação de Estágio & Extensão - ESS - UFRJ', true), 'http://mural.ess.ufrj.br') ;?>
                </h1>
            </div>

            <div id='menu'>
                <?php echo $this->Html->link("ESS", "http://www.ess.ufrj.br"); ?>
                <?php echo " | "; ?>
                <?php echo $this->Html->link("Login", array('controller'=> 'users', 'action'=> 'login', 'full_base'=>true)); ?>
                <?php echo " | "; ?>
                <?php echo $this->Html->link("Mural", "/murals/"); ?>
                <?php echo " | "; ?> 

                <?php if ($this->Session->read('categoria')): ?>
                    <?php echo $this->Html->link("Estagiários", "/estagiarios/index"); ?>
                    <?php echo " | "; ?>
                    <?php echo $this->Html->link("Termo de compromisso", "/inscricaos/termosolicita"); ?>
                    <?php echo " | "; ?>
                    <?php echo $this->Html->link("Avaliação discente", "/alunos/avaliacaosolicita"); ?>
                    <?php echo " | "; ?>
                    <?php echo $this->Html->tag('blink', $this->Html->link("Folha de atividades", "/alunos/folhadeatividades")); ?>
                    <?php echo " | "; ?>                

                    <?php echo $this->Html->link("Instituições", "/instituicaos/lista", array('escape' => FALSE)); ?>
                    <?php echo " | "; ?>
                    <?php echo $this->Html->link("Supervisores", "/supervisors/index"); ?>
                    <?php echo " | "; ?>
                    <?php echo $this->Html->link("Professores", "/professors/index"); ?>
                    <?php echo " | "; ?>

                <?php endif; ?> 
                
                <?php // echo $this->Html->link('Manual', 'http://www.ess.ufrj.br'); ?>
                <?php // echo " | "; ?>
		<?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess'); ?>
		<?php echo " | "; ?>
                <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br'); ?>
                
                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                    <?php echo " | "; ?>
                    <?php echo $this->Html->link("Administração", "/configuracaos/view/1"); ?>
                <?php endif; ?>

                <br/>

                <?php if ($this->Session->read('user')): ?>
                    <?php echo "<span style='color: white; font-weight: bold; text-transform: capitalize'>" . $this->Session->read('categoria') . "</span>" . ": "; ?>

                    <?php
                    switch ($this->Session->read('menu_aluno')) {
                        case 'estagiario':
                            echo "<span style='color: white; font-weight: bold'>" . $this->Html->link($this->Session->read('user'), "/alunos/view/" . $this->Session->read('menu_id_aluno')) . "</span>" . " ";
                            break;
                        case 'alunonovo':
                            echo "<span style='color: white; font-weight: bold'>" . $this->Html->link($this->Session->read('user'), "/alunonovos/view/" . $this->Session->read('menu_id_aluno')) . "</span>" . " ";
                            break;
                        case 'semcadastro':
                            echo "<span style='color: white; font-weight: bold'>" . $this->Session->read('user') . "</span>" . " ";
                            break;
                    }
                    if ($this->Session->read('menu_supervisor_id'))
                        echo "<span style='color: white; font-weight: bold'>" . $this->Html->link($this->Session->read('user'), "/supervisors/view/" . $this->Session->read('menu_supervisor_id')) . "</span>" . " ";
                    ?>

                    <?php echo $this->Html->link('Sair', '/users/logout/'); ?>
                <?php endif; ?>

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
