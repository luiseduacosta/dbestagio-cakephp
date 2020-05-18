<?php

$texto = "
<h1>" .$instituicao[0]['Mural']['instituicao'] ."</h1>
<h1>Estudantes inscritos para seleçõ de estágio</h1>
";

$texto .= "
<table>
<theader>
<tr>
<th>DRE</th>
<th>Nome</th>
<th>Telefone</th>
<th>Celular</th>
<th>Email</th>
</tr>
</theader>
<tbody>
";
foreach ($inscritos as $c_inscritos) {

$texto .= "
<tr>
<td>" .$c_inscritos['id_aluno']. "</td>
<td>" .$c_inscritos['nome'] ."</td>
<td>" .$c_inscritos['telefone'] ."</td>
<td>" .$c_inscritos['celular'] ."</td>
<td>" .$c_inscritos['email'] ."</td>
</tr>
";
}

$texto .= "
</tbody>
</table>
";

echo $texto;

?>
