<?php ?>
<?= $this->element('submenu_professores'); ?>

<div class='card'>
    <div class='card-header'>
        <div class='row'>
            <div class='col-lg-2'>
                <p>Nome</p>
            </div>
            <div class='col-lg-6'>
                <p><?php echo $this->Html->link($professor['Professor']['nome'], '/Estagiarios/index/docente_id:' . $professor['Professor']['id']); ?></p>
            </div>
        </div>
    </div>
    <div class='card-body'>
        <div class='row'>    
            <div class='col-lg-2'>
                <p>SIAPE</p>
            </div>
            <div class='col-lg-6'>
                <p><?php echo $professor['Professor']['siape']; ?></p>
            </div>
        </div>

        <div class='row'>
            <div class='col-lg-2'>
                <p>Telefone</p>
            </div>
            <div class='col-lg-6'>
                <p><?php echo $professor['Professor']['telefone']; ?></p>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>
                <p>Celular</p>
            </div>
            <div class='col-lg-6'>
                <p><?php echo $professor['Professor']['celular']; ?></p>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>
                <p>Email</p>
            </div>
            <div class='col-lg-6'>
                <p><?php echo $professor['Professor']['email']; ?></p>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>
                <p>Currículo lattes</p>
            </div>
            <div class='col-lg-6'>
                <p>
                    <?php
                    if ($professor['Professor']['curriculolattes']) {
                        echo $this->Html->link('Lattes', 'http://lattes.cnpq.br/' . $professor['Professor']['curriculolattes']);
                    } else {
                        echo "Sem dados";
                    }
                    ?>
                </p>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>
                <p>Diretorio de Grupos de Pesquisa</p>
            </div>
            <div class='col-lg-6'>
                <p>
                    <?php
                    if ($professor['Professor']['pesquisadordgp']) {
                        echo $this->Html->link('Pesquisador', 'http://dgp.cnpq.br/buscaoperacional/detalhepesq.jsp?pesq=' . $professor['Professor']['pesquisadordgp']);
                    } else {
                        echo "Sem dados";
                    }
                    ?>
                </p>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>
                <p>Data de ingresso na ESS/UFRJ</p>
            </div>
            <div class='col-lg-6'>
                <p>
                    <?php
                    if ($professor['Professor']['dataingresso']) {
                        echo date('d-m-Y', strtotime($professor['Professor']['dataingresso']));
                    } else {
                        echo "S/d";
                    }
                    ?>
                </p>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>
                <p>Departamento</p>
            </div>
            <div class='col-lg-6'>
                <p><?php echo $professor['Professor']['departamento']; ?></p>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>
                <p>Motivo de egresso</p>
            </div>
            <div class='col-lg-6'>
                <p><?php echo $professor['Professor']['motivoegresso']; ?></p>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>
                <p>Observações</p>
            </div>
            <div class='col-lg-6'>
                <p><?php echo $professor['Professor']['observacoes']; ?></p>
            </div>
        </div>
    </div>
</div>

<nav class="nav nav-tabs">
    <?= $this->Html->link('Excluir', '/Professores/delete/' . $professor['Professor']['id'], ['class' => 'nav-item nav-link', 'Confirma?']); ?>
    <?= $this->Html->link('Editar', '/Professores/edit/' . $professor['Professor']['id'], ['class' => 'nav-item nav-link']); ?>
    <?= $this->Html->link('Listar', '/Professores/index/', ['class' => 'nav-item nav-link']); ?>
</nav>
