<?php if (!empty($orfaos)): ?>
<div class='row justify-content-center'>
    <div class='col-auto'>
    <div class='container table-responsive'>
        <p>Estudantes sem estágio</p>
        <table class='table table-striped table-hover table-responsive'>
            <caption>Estudantes sem estágio</caption>
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Registro</th>
                    <th>Nome</th>
                    <th>Celular</th>
                    <th>E-mail</th>
                    <th>Período</th>
                </tr>
            </thead>    
            <tbody>
                <?php foreach ($orfaos as $c_orfaos): ?>

                    <tr>

                        <td>
                            <?php echo $c_orfaos['Aluno']['id']; ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Aluno']['registro']; ?>
                        </td>

                        <td>
                            <?php echo $this->Html->link($c_orfaos['Aluno']['nome'], '/Estudantes/view/' . $c_orfaos['Aluno']['registro']); ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Aluno']['celular']; ?>
                        </td>    

                        <td>
                            <?php echo $c_orfaos['Aluno']['email']; ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Estagiario']['periodo']; ?>
                        </td>

                    </tr>

                <?php endforeach; ?>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
    </div>
</div>
<?php else: ?>

    <p>Não há alunos sem estágio: <?php echo $this->Html->link('retornar', '/estagiarios/index'); ?></p>

<?php endif; ?>
