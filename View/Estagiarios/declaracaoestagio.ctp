<?php

App::import("Vendor", "tcpdf/tcpdf");

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Escola de Serviço Social');
$pdf->SetTitle('Coordenação de Estágio e Extensão');
$pdf->SetSubject('Declaração de estágio');
$pdf->SetKeywords('Estagio curricular, Serviço Social');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
// $pdf->setLanguageArray($l);
// set font
// $pdf->SetFont('helvetica', '', 8);
$pdf->SetFont('dejavusans', '', 12, '', true);

// add a page
$pdf->AddPage();

// pr($estagiorealizado);
$estudante = trim($estagiorealizado['Estudante']['nome']);
$cpf = $estagiorealizado['Estudante']['cpf'];
$identidade = $estagiorealizado['Estudante']['identidade'];
$orgao = strtoupper($estagiorealizado['Estudante']['orgao']);
$registro = $estagiorealizado['Estudante']['registro'];
$instituicao = trim($estagiorealizado['Instituicao']['instituicao']);
$supervisora = trim($estagiorealizado['Supervisor']['nome']);
$regiao = $estagiorealizado['Supervisor']['regiao'] . 'ª';
$cress = $estagiorealizado['Supervisor']['cress'];
$periodo = $estagiorealizado['Estagiario']['periodo'];
$carga_horaria = $estagiorealizado['Estagiario']['ch'];
$nivel = $estagiorealizado['Estagiario']['nivel'];
// die();

if (empty($supervisora))
    $supervisora = "______________________________________";
if (empty($carga_horaria) or $carga_horaria === 0)
    $carga_horaria = "_____";

$dia = strftime('%e', strtotime(date('d')));
$mes = strftime('%B', strtotime(date('M')));
$ano = strftime('%Y', strtotime(date('Y')));

$html = <<<EOD

<h1 style="text-align:center">
<img src="img/logoess_horizontal.svg" alt="minerva ufrj" width="200px" height="50px"><br />
Coordenação de Estágio<br />
Declaração de Estágio Curricular
</h1>
<br />
<br />
<p style="text-align:justify; line-height: 2.5;">
Declaramos que o/a estudante <b>$estudante</b> inscrito(a) no CPF sob o nº $cpf e no RG nº $identidade expedido por $orgao, matriculado(a) no Curso de Serviço Socail da Universidade Federal do Rio de Janeiro com o número $registro, estagiou na instituição <b>$instituicao</b>, com a supervisão profissional do/a Assistente Social <b>$supervisora</b> registrada no CRESS $regiao região com o número $cress, no semestre de $periodo, com uma carga horária de $carga_horaria horas.
<p>

<p style="text-align:justify">
As atividades desenvolvidas correspondem ao nível $nivel do currículum vigente na Escola de Serviço Social da UFRJ.
</p>
<br />
<br />
<p style="text-align:right">Rio de Janeiro, $dia de $mes de $ano.</p>
</p>

<br style='line-height: 10.0'; />

<table>
<tr>
<td style="font-size: 12px; text-align:left">Coordenação de Estágio</td>
<td style="font-size: 12px; text-align:center">$estudante</td>
<td style="font-size: 12px; text-align:center">$supervisora</td>
</tr>

<tr>
<td></td>
<td style="font-size: 12px; text-align:center">DRE: $registro</td>
<td style="font-size: 12px; text-align:center">CRESS $cress da $regiao Região</td>
</tr>
</table>
EOD;

$pdf->writeHTML($html, true, 0, true, 0);
$pdf->lastPage();

// Close and output PDF document
$pdf->Output('declaracao_de_estagio.pdf', 'I');
?>
