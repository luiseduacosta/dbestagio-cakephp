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
        <?php echo $html->charset(); ?>
        <title>
            <?php __('ESS/UFRJ'); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php

        echo $html->meta('icon');

        echo $html->css('cake.generic');

        echo $scripts_for_layout;

        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1><?php echo $html->link(__('Coordenação de Estágio e Extensão', true),
                    'http://www.ess.ufrj.br/estagio'); ?></h1>
            </div>

            <div id='menu'>
                <?php echo $html->link("Login", "/Users/login/"); ?>
                <?php echo " | "; ?>
                <?php echo $html->link("Mural", "/Murals/"); ?>
                <?php echo " | "; ?> 
                <?php echo $html->link("Termo de compromisso", "/Inscricaos/termosolicita"); ?>
                <?php echo " | "; ?> 
                <?php echo $html->link("Estagiários", "/Estagiarios/index"); ?>
                <?php echo " | "; ?>
                <?php echo $html->link("Instituições", "/Instituicaos/index", array('escape'=>FALSE)); ?>
                <?php echo " | "; ?>
                <?php echo $html->link("Supervisores", "/Supervisors/index"); ?>
                <?php echo " | "; ?>
                <?php echo $html->link("Professores", "/Professors/index"); ?>
                <?php echo " | "; ?>
                <?php echo $html->link("Configurações", "/Configuracaos/view/1"); ?>
                <?php echo " | "; ?>
                <?php
                if ($this->Session->read('user')) {
                    echo "<p style='color:black'>" . $html->link($this->Session->read('user'), '/Alunos/perfil/' . $this->Session->read('numero')) . " | ";
                    echo $html->link('Sair', '/users/logout/') . "</p>";
                    }
                ?>
            </div>

            <div id="content">

                <?php echo $session->flash(); ?>

                <?php echo $content_for_layout; ?>

            </div>

            <div id="footer">
                <?php echo $html->link(
				$html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0")),
                		'http://www.cakephp.org/',
                		array('target' => '_blank', 'escape' => false)
                );
                ?>
            </div>

        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
