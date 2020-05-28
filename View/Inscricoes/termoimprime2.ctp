<?php

//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */
// Include the main TCPDF library (search for installation path).
// require_once('tcpdf_include.php');
App::import("Vendor", "tcpdf/tcpdf");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Escola de Serviço Social');
$pdf->SetTitle('Coordenação de Estágio e Extensão');
$pdf->SetSubject('Termo de compromisso');
$pdf->SetKeywords('Estagio curricular, Serviço Social');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/bra.php')) {
    require_once(dirname(__FILE__) . '/lang/bra.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 8, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
// $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

if (empty($supervisor_nome))
    $supervisor_nome = "______________________________________";
$dia = date('d');
$mes = date('M');
$ano = date('Y');
$termoinicio = date('d-M-Y', strtotime($termoinicio));
$termofinal = date('d-M-Y', strtotime($termofinal));

// Set some content to print
$html = <<<EOD

<table>
       <tr>
        <td style="width:25%"><img src="logo.jpg" alt="some text" width=60 height=40></td>
        <td style="width: 50%">
<h1>Escola de Serviço Social<br />
Coordenação de Estágio<br />
TERMO DE COMPROMISSO</h1>
        </td>
        <td style="width:25%"></td>
   </tr>
</table>

<div style="text-align:justify">
<p>
O presente TERMO DE COMPROMISSO DE ESTÁGIO que entre si assinam Coordenação de Estágio & Extensão da Escola de Serviço Social/UFRJ/Estudante $aluno_nome, instituição $instituicao_nome e Supervisor(a) AS $supervisor_nome, visa estabelecer condições gerais que regulam a realização de ESTAGIO CURRICULAR. Atividade obrigatória para a conclusão da Graduação em Serviço Social. Ficam estabelecidas entre as partes as seguintes condições básicas para a realização do estágio:
</p>

<p>
Art. 01. As atividades a serem desenvolvidas pelo estagiário, deverão ser compatíveis com o curso de Serviço Social, envolvem observação, estudos, elaboração de projetos e realização de leituras e atividades práticas.<br>
Art. 02. A permanência em cada campo de estágio deverá ser de no mínimo dois semestres letivos consecutivos. A quebra deste contrato, deverá ser precedida de apresentação de solicitação formal à Coordenação de Estágio, com no mínimo 1 mês de antes do término do período letivo em curso. Contendo parecer da supervisora e do professor de OTP.<br>
Art. 03. Em caso de demissão do supervisor, ou a ocorrência de férias deste profissional ao longo do período letivo, outro assistente social deverá ser imediatamente indicado para supervisão técnica do estagiário.
</p>

<h2>Da ESS</h2>
<p>
Art. 04. De acordo com a orientação geral da Universidade do Rio de Janeiro, no que concerne à estágios, e o currículo da Escola de Serviço Social, implantado em 2001. O estágio será realizado por um período de, no mínimo 120 horas/semestre, não podendo ultrapassar 20h semanais.<br>
Art. 05. Será indicado pelos Departamentos da ESS, um professor para acompanhamento acadêmico referente a área temática da instituição que o aluno realizará o seu estágio.<br>
Art. 06. A Escola de Serviço Social fornecerá à Instituição informações e declarações solicitadas, consideradas necessárias ao bom andamento do estágio curricular.
</p>

<h2>Da Instituição</h2>
<p>
Art. 07. O estágio será realizado no âmbito da unidade concedente onde deve existir um Assistente Social responsável pelo projeto desenvolvido pelo Serviço Social. As atividades de estágio serão realizadas em horário compatível com as atividades escolares do estagiário e com as normas vigentes no âmbito da unidade concedente.<br>
Art. 08. A Coordenação de Estágio/ESS deve ser informada com prazo de 01 (um) mês de antecedência o afastamento do supervisor do campo de estágio e a indicação do seu substituto.
</p>

<h2>Do Supervisor</h2>
<p>
Art. 09. É de responsabilidade do Assistente Social supervisor o acompanhamento e supervisão sistemática do processo vivenciado pelo aluno durante o período de estágio.<br>
Art. 10. No final de cada mês o supervisor atestará à unidade de ensino, em formulário próprio, a carga horária cumprida pelo estagiário.<br>
Art. 11. No final de cada período letivo o supervisor encaminhará, ao professor da disciplina de Orientação e Treinamento Profissional, avaliação do processo vivenciado pelo aluno durante o semestre. Instrumento este utilizado pelo professor na avaliação final do aluno.
</p>

<h2>Do Aluno</h2>
<p>
Art. 12. Cabe ao estagiário cumprir o horário acordado com a unidade para o desempenho das atividades definidas no Plano de Estágio, observando os princípios éticos que rege o Serviço Social. São considerados motivos justos ao não cumprimento da programação, as obrigações escolares do estagiário que devem ser comunicadas, ao supervisor, em tempo hábil.<br>
Art. 13. 0 aluno se compromete a cuidar e manter sigilo em relação à documentação, da unidade campo de estágio, mesmo após o seu desligamento.<br>
Art. 14. O aluno deverá cumprir com responsabilidade e assiduidade os compromisso assumidos junto ao acampo de estágio, independente do calendário e férias acadêmicas.<br>
Art. 15. O período de permanência do aluno no campo de estágio se dará de acordo com o contrato formal ou informal assumido com o supervisor.<br>
Art. 16. O presente Termo de Compromisso terá validade de $termoinicio a $termofinal, correspondente ao Estagio $nivel. Sua interrupção antes do período previsto, acarretará prejuízo para o aluno na sua avaliação acadêmica.<br>
Art. 17. Os casos omissos serão encaminhados à Coordenação de Estágio para serem dirimidos.
<br>
<br>
Rio de Janeiro, $dia do mês $mes de $ano.
</p>
</div>

<table>
<tr>
<td>Coordenação de Estágio e Extensão</td>
<td>$aluno_nome</td>
<td>$supervisor_nome</td>
</tr>

<tr>
<td></td>
<td>DRE: $registro</td>
<td>CRESS 7ª Região: $supervisor_cress</td>
</tr>
</table>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('termo_compromisso.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
