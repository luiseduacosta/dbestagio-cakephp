
<?php if (!empty($orfaos)): ?>

    <div class="centraliza container table-responsive">
        
        <p>Estudantes sem inscrições no mural</p>
        
        <table class="table table-striped table-hover table-responsive">
            <caption>Estudantes sem instrição no mural</caption>
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Registro</th>
                    <th>Nome</th>
                    <th>Celular</th>
                    <th>E-mail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orfaos as $c_orfaos): ?>

                    <tr>

                        <td>
                            <?php echo $c_orfaos['Estudante']['id']; ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Estudante']['registro']; ?>
                        </td>

                        <td>
                            <?php echo $this->Html->link($c_orfaos['Estudante']['nome'], '/Estudantes/view/' . $c_orfaos['Estudante']['id']); ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Estudante']['celular']; ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Estudante']['email']; ?>
                        </td>

                    </tr>

                <?php endforeach; ?>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
<?php else: ?>

    <p>Não há alunos novos sem inscrições no mural: <?php echo $this->Html->link('voltar', '/Murals/index/'); ?></p>

<?php endif; ?>
