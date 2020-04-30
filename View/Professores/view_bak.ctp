<?php

// Folha de estilos
$this->Html->css("abas", null, array("inline"=>false));

// Javascript com jquery
echo $this->Html->script("jquery", array('inline'=>false));
echo $this->Html->scriptBlock('

$(document).ready(function() {

        // abas
        // oculta todas as abas
        $("div.conteudoaba").hide();
        // mostra somente  a primeira aba
        $("div.conteudoaba:first").show();
        // seta a primeira aba como selecionada (na lista de abas)
        $("#abas a:first").addClass("selected");

        // quando clicar no link de uma aba
        $("#abas a").click(function(){
            // oculta todas as abas
            $("div.conteudoaba").hide();
            // tira a seleção da aba atual
            $("#abas a").removeClass("selected");

            // adiciona a classe selected na selecionada atualmente
            $(this).addClass("selected");
            // mostra a aba clicada
            $($(this).attr("href")).show();
            // pra nao ir para o link
            return false;

  })
});

', array("inline"=>false));

?>

<div align="center">
<?php echo $this->Html->link('Retroceder', array('action'=>'view', $registro_prev)) . " "; ?> |
<?php echo $this->Html->link('Avançar'   , array('action'=>'view', $registro_next)); ?>
</div>

<ul id="abas">
    <li><a href="#aba1">Dados</a></li>
    <li><a href="#aba2">Lattes</a></li>
</ul>

<div id="aba1" class="conteudoaba">
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
		echo $this->Html->link('Lattes', 'http://lattes.cnpq.br/' . $professor['Professor']['curriculolattes']); 
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
		echo $this->Html->link('Pesquisador', 'http://dgp.cnpq.br/buscaoperacional/detalhepesq.jsp?pesq='.$professor['Professor']['pesquisadordgp']);
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

</div>

<div id="aba2" class="conteudoaba">

    <table width="80%">
        <tr>

            <td>
<?php
$ch = curl_init();
// informar URL e outras funções ao CURL

curl_setopt($ch, CURLOPT_URL, $professor['Professor']['curriculolattes']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FILETIME, true);
// acessar a URL
$output = curl_exec($ch);
// Imprimir as informações
// echo '<pre>';
// print_r (curl_getinfo($ch));
// print_r($output);
// echo strip_tags($output);
// echo '</pre>';

$doc = new DOMDocument();
$doc->loadHTML($output);
$doc->preserveWhiteSpace = false;
$xpath = new DOMXPath($doc);

echo "<h1>" . $professor['Professor']['nome'] . "</h1>";

echo "<strong>Apresentação</strong>" . "<br>";
$apresentacao = $xpath->query("/html/body/div[@id='pagina']/div[1]/div[2]/table");

foreach ($apresentacao as $c_apresentacao) {
	echo $c_apresentacao->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Formação</strong>" . "<br>";
$formacao = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[2]/div/table[@class='IndicProdTabela']");

foreach ($formacao as $c_formacao) {
	echo $c_formacao->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Atuação profissional</strong>" . "<br>";
$atuacao = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[3]/div/table[@class='IndicProdTabela']/tbody/tr");
foreach ($atuacao as $c_atuacao) {
	echo $c_atuacao->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Linhas de pesquisa</strong>" . "<br>";
$linhas = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[4]/div/table[@class='IndicProdTabela']");
foreach ($linhas as $c_linhas) {
	echo $c_linhas->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Projetos de pesquisa</strong>" . "<br>";
$projetos = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[5]/div/table[@class='IndicProdTabela']");
foreach ($projetos as $c_projetos) {
	echo $c_projetos->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Área de atuação</strong>" . "<br>";
$area = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[6]/div/table[@class='IndicProdTabela']");
foreach ($area as $c_area) {
	echo $c_area->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Idiomas</strong>" . "<br>";
$idiomas = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[7]/div/table[@class='IndicProdTabela']");
foreach ($idiomas as $c_idiomas) {
	echo $c_idiomas->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Produção bibliográfica</strong>" . "<br>";
$bibliografica = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[9]/div/table[@class='IndicProdTabela']");
foreach ($bibliografica as $c_bibliografica) {
	echo $c_bibliografica->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Participação em bancas</strong>" . "<br>";
$bancas = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[10]/div/table[@class='IndicProdTabela']");
foreach ($bancas as $c_bancas) {
	echo $c_bancas->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Eventos</strong>" . "<br>";
$eventos = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[11]/div/table[@class='IndicProdTabela']");
foreach ($eventos as $c_eventos) {
	echo $c_eventos->nodeValue;
	echo "<br /><br />";
}

echo "<strong>Orientações</strong>" . "<br>";
$orientacoes = $xpath->query("/html/body/div[@id='pagina']/div[3]/div[12]/div/table[@class='IndicProdTabela']");
foreach ($orientacoes as $c_orientacoes) {
	echo $c_orientacoes->nodeValue;
	echo "<br /><br />";
}

?>
            </td>
        </tr>
    </table>
</div>