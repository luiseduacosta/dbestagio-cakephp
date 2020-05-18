<?php ?>

<div align="center">
<?php echo $this->Html->link('Retroceder', array('action' => 'view', $registro_prev)) . " "; ?> |
    <?php echo $this->Html->link('Avançar', array('action' => 'view', $registro_next)); ?>
</div>

<table>

    <tr>
        <td>SIAPE</td>
        <td><?php echo $professor['Professor']['siape']; ?></td>
    </tr>

    <tr>
        <td width='25%'>Nome</td>
        <td width='75%'><?php echo $this->Html->link($professor['Professor']['nome'], '/Estagiarios/index/docente_id:' . $professor['Professor']['id']); ?></td>
    </tr>


    <tr>
        <td>Telefone</td>
        <td><?php echo $professor['Professor']['telefone']; ?></td>
    </tr>

    <tr>
        <td>Celular</td>
        <td><?php echo $professor['Professor']['celular']; ?></td>
    </tr>

    <tr>
        <td>Email</td>
        <td><?php echo $professor['Professor']['email']; ?></td>
    </tr>

    <tr>
        <td>Currículo lattes</td>
        <td>
<?php
if ($professor['Professor']['curriculolattes']) {
    echo $this->Html->link('Lattes', 'http://lattes.cnpq.br/'. $professor['Professor']['curriculolattes']);
} else {
    echo "Sem dados";
}
?>
        </td>
    </tr>
    <tr>
        <td>Diretorio de Grupos de Pesquisa</td>
        <td>
<?php
if ($professor['Professor']['pesquisadordgp']) {
    echo $this->Html->link('Pesquisador', 'http://dgp.cnpq.br/buscaoperacional/detalhepesq.jsp?pesq=' . $professor['Professor']['pesquisadordgp']);
} else {
    echo "Sem dados";
}
?>
        </td>
    </tr>

    <tr>
        <td>Data de ingresso na ESS/UFRJ</td>
        <td>
<?php
if ($professor['Professor']['dataingresso']) {
    echo date('d-m-Y', strtotime($professor['Professor']['dataingresso']));
} else {
    echo "S/d";
}
?>
        </td>
    </tr>

    <tr>
        <td>Departamento</td>
        <td><?php echo $professor['Professor']['departamento']; ?></td>
    </tr>

    <tr>
        <td>Motivo de egresso</td>
        <td><?php echo $professor['Professor']['motivoegresso']; ?></td>
    </tr>

    <tr>
        <td>Observações</td>
        <td><?php echo $professor['Professor']['observacoes']; ?></td>
    </tr>

</table>

<?php
echo $this->Html->link('Excluir', '/Professores/delete/' . $professor['Professor']['id'], NULL, 'Confirma?');
echo " | ";
echo $this->Html->link('Editar', '/Professores/edit/' . $professor['Professor']['id']);
echo " | ";
echo $this->Html->link('Inserir', '/Professores/add/');
echo " | ";
echo $this->Html->link('Listar', '/Professores/index/');
?>
