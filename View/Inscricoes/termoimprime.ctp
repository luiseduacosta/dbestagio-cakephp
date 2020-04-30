<?php

App::import("Vendor", "tcpdf/tcpdf");

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

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
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage();

if (empty($supervisor_nome)) $supervisor_nome = "______________________________________";

$texto = "

<h2 style='text-align:center'>Escola de Serviço Social</h2>
<h2 style='text-align:center'>Coordenação de Estágio & Extensão</h2>
<h1>TERMO DE COMPROMISSO</h1>

<div style='text-align:justify'>
<p align='justify' style='text-align:justify'>
O presente TERMO DE COMPROMISSO DE ESTÁGIO que entre si assinam Coordenação de Estágio & Extensão da Escola de Serviço Social/UFRJ/Estudante " . strtoupper($aluno_nome) . ", instituição " . strtoupper($instituicao_nome) . " e Supervisor(a) AS. " . strtoupper($supervisor_nome) . ", visa estabelecer condições gerais que regulam a realização de ESTAGIO CURRICULAR. Atividade obrigatória para a conclusão da Graduação em Serviço Social. Ficam estabelecidas entre as partes as seguintes condições básicas para a realização do estágio:</p>
";

$texto .= "
<p>
Art. 01. As atividades a serem desenvolvidas pelo estagiário, deverão ser compatíveis com o curso de Serviço Social, envolvem observação, estudos, elaboração de projetos e realização de leituras e atividades práticas.<br>
Art. 02. A permanência em cada campo de estágio deverá ser de no mínimo dois semestres letivos consecutivos. A quebra deste contrato, deverá ser precedida de apresentação de solicitação formal à Coordenação de Estágio, com no mínimo 1 mês de antes do término do período letivo em curso. Contendo parecer da supervisora e do professor de OTP.<br>
Art. 03. Em caso de demissão do supervisor, ou a ocorrência de férias deste profissional ao longo do período letivo, outro assistente social deverá ser imediatamente indicado para supervisão técnica do estagiário.
</p>
";

$texto .= "
<h2>Da ESS</h2>
<p>
Art. 04. De acordo com a orientação geral da Universidade do Rio de Janeiro, no que concerne à estágios, e o currículo da Escola de Serviço Social, implantado em 2001. O estágio será realizado por um período de, no mínimo 120 horas/semestre, não podendo ultrapassar 20h semanais.<br>
Art. 05. Será indicado pelos Departamentos da ESS, um professor para acompanhamento acadêmico referente a área temática da instituição que o aluno realizará o seu estágio.<br>
Art. 06. A Escola de Serviço Social fornecerá à Instituição informações e declarações solicitadas, consideradas necessárias ao bom andamento do estágio curricular.
</p>
";

$texto .= "
<h2>Da Instituição</h2>
<p>
Art. 07. O estágio será realizado no âmbito da unidade concedente onde deve existir um Assistente Social responsável pelo projeto desenvolvido pelo Serviço Social. As atividades de estágio serão realizadas em horário compatível com as atividades escolares do estagiário e com as normas vigentes no âmbito da unidade concedente.<br>
Art. 08. A Coordenação de Estágio/ESS deve ser informada com prazo de 01 (um) mês de antecedência o afastamento do supervisor do campo de estágio e a indicação do seu substituto.
</p>
";

$texto .= "
<h2>Do Supervisor</h2>
<p>
Art. 09. É de responsabilidade do Assistente Social supervisor o acompanhamento e supervisão sistemática do processo vivenciado pelo aluno durante o período de estágio.<br>
Art. 10. No final de cada mês o supervisor atestará à unidade de ensino, em formulário próprio, a carga horária cumprida pelo estagiário.<br>
Art. 11. No final de cada período letivo o supervisor encaminhará, ao professor da disciplina de Orientação e Treinamento Profissional, avaliação do processo vivenciado pelo aluno durante o semestre. Instrumento este utilizado pelo professor na avaliação final do aluno.
</p>
";

$texto .= "
<h2>Do Aluno</h2>
<p>
Art. 12. Cabe ao estagiário cumprir o horário acordado com a unidade para o desempenho das atividades definidas no Plano de Estágio, observando os princípios éticos que rege o Serviço Social. São considerados motivos justos ao não cumprimento da programação, as obrigações escolares do estagiário que devem ser comunicadas, ao supervisor, em tempo hábil.<br>
Art. 13. 0 aluno se compromete a cuidar e manter sigilo em relação à documentação, da unidade campo de estágio, mesmo após o seu desligamento.<br>
Art. 14. O aluno deverá cumprir com responsabilidade e assiduidade os compromisso assumidos junto ao acampo de estágio, independente do calendário e férias acadêmicas.<br>
Art. 15. O período de permanência do aluno no campo de estágio se dará de acordo com o contrato formal ou informal assumido com o supervisor.<br>
Art. 16. O presente Termo de Compromisso terá validade de " . date('d-m-Y', strtotime($termoinicio)) . " a " .  date('d-m-Y', strtotime($termofinal)) .", correspondente ao Estagio " . $nivel .". Sua interrupção antes do período previsto, acarretará prejuízo para o aluno na sua avaliação acadêmica.<br>
Art. 17. Os casos omissos serão encaminhados à Coordenação de Estágio para serem dirimidos.
<br>
<br>
Rio de Janeiro, " . date('d') . " do mês " . date('m') . " de " . date('Y') . ".
</p>
</div>
";

$texto .= "
<table>
<tr>
<td>Coordenação de Estágio e Extensão</td>
<td>" . strtoupper($aluno_nome) ."</td>
<td>" . strtoupper($supervisor_nome) ."</td>
</tr>

<tr>
<td></td>
<td>DRE: ". $registro ."</td>
<td>CRESS 7ª Região: " . $supervisor_cress . "</td>
</tr>
</table>
";

$pdf->writeHTML($texto, true, 0, true, 0);
$pdf->lastPage();

// Close and output PDF document
$pdf->Output('termo_compromisso.pdf', 'I');

?>
