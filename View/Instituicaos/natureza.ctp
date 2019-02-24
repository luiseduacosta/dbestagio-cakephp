
<?php
echo "<table>";
echo "<caption>Natureza das instituições</caption>";
echo "<tr>";
echo "<th>Natureza</th>";
echo "<th>Quantidade de instituições</th>";
echo "</tr>";
for ($i = 0; $i < sizeof($natureza); $i++):
    echo '<tr>';
    echo '<td>' . $this->Html->link($natureza[$i]['Instituicao']['natureza'], '/instituicaos/lista/natureza:' . $natureza[$i]['Instituicao']['natureza'] . '/linhas:0') . '</td>';
    echo '<td>' . $natureza[$i]['0']['qnatureza'] . '</td>';
    echo '</tr>';
endfor;
echo "</table>";
?>