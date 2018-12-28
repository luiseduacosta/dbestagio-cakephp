<?php

App::import("Vendor", "tcpdf/tcpdf");

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
// $pdf = new XTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Escola de Serviço Social');
$pdf->SetTitle('Coordenação de Estágio e Extensão');
$pdf->SetSubject('Termo de compromisso');
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

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
// $pdf->setLanguageArray($l);

// set font
$pdf->SetFont('helvetica', '', 12);

// Tiro o cabecalho
$pdf->setPrintHeader(false);

// add a page
$pdf->AddPage();

$pdf->Image("/usr/local/htdocs/html/mural/webroot/img/minerva_transparente.png", 90, 20, 20, 20);

$pdf->SetY(40);
$cabecalho1 = $pdf->GetStringWidth("UNIVERSIDADE FEDERAL DO RIO DE JANEIRO");
$pdf->SetX((210-$cabecalho1)/2);
$pdf->Cell(0, 0, "UNIVERSIDADE FEDERAL DO RIO DE JANEIRO");
$pdf->Ln(5);

$cabecalho2 = $pdf->GetStringWidth("CENTRO DE FILOSOFIA E CIÊNCIAS SOCIAIS");
$pdf->SetX((210-$cabecalho2)/2);
$pdf->Cell(0, 0, "CENTRO DE FILOSOFIA E CIÊNCIAS SOCIAIS");
$pdf->Ln(5);

$cabecalho3 = $pdf->GetStringWidth("ESCOLA DE SERVIÇO SOCIAL");
$pdf->SetX((210-$cabecalho3)/2);
$pdf->Cell(0, 0, "ESCOLA DE SERVIÇO SOCIAL");
$pdf->Ln(5);

$cabecalho4 = $pdf->GetStringWidth("Coordenação de Estágio e Extensão");
$pdf->SetX((210-$cabecalho4)/2);
$pdf->Cell(0, 0, "Coordenação de Estágio e Extensão");
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'B', 14);
$titulo = $pdf->GetStringWidth("Oferta de vagas de estágio");
$pdf->SetX((210-$titulo)/2);
$pdf->Cell(0, 0, "Oferta de vagas de estágio");
$pdf->Ln(10);

$pdf->SetFont('helvetica', '', 12);
$pdf->SetX(20);
$pdf->Cell(0, 0, 'Instituição: ');
$pdf->SetX(56);
$pdf->MultiCell(140, 5, $mural[0]['Mural']['instituicao'], 0, 'L');

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Vagas: ');
$pdf->SetX(56);
$pdf->Cell(0, 0, $mural[0]['Mural']['vagas']);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Beneficios: ');
$pdf->SetX(56);
$pdf->Cell(0, 0, $mural[0]['Mural']['beneficios']);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Final de semana: ');
$pdf->SetX(56);
switch ($mural[0]['Mural']['final_de_semana']) {
	case 0: $final_de_semana = 'Não'; break;
	case 1: $final_de_semana = 'Sim'; break;
	case 3: $final_de_semana = 'Parcialmente'; break;	
}
$pdf->Cell(0, 0, $final_de_semana);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Carga horária: ');
$pdf->SetX(56);
$pdf->Cell(0, 0, $mural[0]['Mural']['cargaHoraria']);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Requisitos: ');
$pdf->SetX(56);
$pdf->MultiCell(140, 5, $mural[0]['Mural']['requisitos'], 0, 'L');
$Y = $pdf->GetY();

$pdf->SetXY(20, $Y);
$pdf->Cell(0, 0, 'Área: ');
$pdf->SetX(56);
$pdf->Cell(0, 0, $mural[0]['Area']['area']);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Professor: ');
$pdf->SetX(56);
$pdf->Cell(0, 0, $mural[0]['Professor']['nome']);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Horário: ');
$pdf->SetX(56);
switch ($mural[0]['Mural']['horario']) {
	case 'D': $horario = 'Diurno'; break;
	case 'N': $horario = 'Noturno'; break;
	case 'A': $horario = 'Ambos'; break;
}
$pdf->Cell(0, 0, $horario);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Inscrição até: ');
$pdf->SetX(56);
$pdf->Cell(0, 0, date('d-m-Y', strtotime($mural[0]['Mural']['dataInscricao'])));
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Data seleção: ');
$pdf->SetX(56);
$pdf->Cell(0, 0, date('d-m-Y', strtotime($mural[0]['Mural']['dataSelecao'])) . " Horário " . $mural[0]['Mural']['horarioSelecao']);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Local da seleção: ');
$pdf->SetX(56);
$pdf->Cell(0, 0, $mural[0]['Mural']['localSelecao']);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Forma de seleção: ');
$pdf->SetX(56);
switch ($mural[0]['Mural']['formaSelecao']) {
	case 0: $formaselecao = 'Entrevista'; break;
	case 1: $formaselecao = 'CR'; break;
	case 2: $formaselecao = 'Prova'; break;
	case 3: $formaselecao = 'Outra'; break; 
}
$pdf->Cell(0, 0, $formaselecao);
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->Cell(0, 0, 'Contato: ');
$pdf->SetX(56);
$pdf->Cell(0, 0, $mural[0]['Mural']['contato']);
$pdf->Ln(5);

$linhas = $pdf->GetNumLines($mural[0]['Mural']['outras']);
if ($linhas > 20) {
	$pdf->setPrintHeader(false);
	$pdf->AddPage();
}
$pdf->SetX(20);
$pdf->Cell(0, 0, 'Observações: ');
$pdf->Ln(5);

$pdf->SetX(20);
$pdf->MultiCell(180, 0, $mural[0]['Mural']['outras'], 1, 'L');

//Close and output PDF document
$pdf->Output('cartaz.pdf', 'I'); 

?>
