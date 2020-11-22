<?php
// pr($usuario);
// pr($aluno);
// pr($alunonovo);
// pr($professor);
// pr($supervisor);
?>
<div class="row justify-content-center">
    <div class="col-auto">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-responsive">
                <thead class="thead-light">
                <th>Tabela</th>
                <th>Nome</th>
                <th>Número</th>
                <th>E-mail</th>
                </thead>

                <?php if (isset($alunonovo) && !(empty($alunonovo))): ?>

                    <tr>
                        <td>Estudante</td>
                        <td><?php echo $alunonovo['Estudante']['nome']; ?></td>
                        <td><?php echo $alunonovo['Estudante']['registro']; ?></td>
                        <td><?php echo $alunonovo['Estudante']['email']; ?></td>
                    </tr>

                <?php elseif (isset($professor) && !(empty($professor))): ?>

                    <tr>
                        <td>Professor</td>
                        <td><?php echo $professor['Professor']['nome']; ?></td>
                        <td><?php echo $professor['Professor']['siape']; ?></td>
                        <td><?php echo $professor['Professor']['email']; ?></td>
                    </tr>

                <?php elseif (isset($supervisor) && !(empty($supervisor))): ?>

                    <tr>
                        <td>Supervisor</td>
                        <td><?php echo $supervisor['Supervisor']['nome']; ?></td>
                        <td><?php echo $supervisor['Supervisor']['cress']; ?></td>
                        <td><?php echo $supervisor['Supervisor']['email']; ?></td>
                    </tr>

                <?php endif; ?>

                <tr>
                    <td>Usuário</td>
                    <td></td>
                    <td><?php echo $this->Html->link($usuario['Userestagio']['numero'], '/Userestagios/edit/' . $usuario['Userestagio']['id']); ?></td>
                    <td><?php echo $usuario['Userestagio']['email']; ?></td>
                </tr>

            </table>
        </div>
    </div>
</div>