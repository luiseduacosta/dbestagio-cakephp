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
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 10);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
// $pdf->setLanguageArray($l);
// set font
// $pdf->SetFont('helvetica', '', 8);
$pdf->SetFont('dejavusans', '', 10, '', true);

// add a page
$pdf->AddPage();

if (empty($supervisor_nome))
    $supervisor_nome = "______________________________________";

setlocale (LC_TIME, 'pt_BR');
$dia = strftime('%e', time());
$mes = utf8_encode(strftime('%B', time()));
$ano = strftime('%Y', time());

$termoinicio = utf8_encode(strftime('%e de %B de %Y', strtotime($termoinicio)));
$termofinal = utf8_encode(strftime('%e de %B de %Y', strtotime($termofinal)));

$html = <<<EOD
        
<h1 style="text-align:center">
<img src="img/logoess_horizontal.svg" alt="minerva ufrj" width="200px" height="50px"><br />
Coordenação de Estágio<br />
TERMO DE COMPROMISSO
</h1>

<p style="text-align:justify">
O presente TERMO DE COMPROMISSO DE ESTÁGIO que entre si assinam a Coordenação de Estágio da Escola de Serviço Social/UFRJ, o (a) Estudante $aluno_nome, a  instituição $instituicao_nome e o (a) Supervisor (a) de Campo $supervisor_nome, visa estabelecer condições gerais que regulam a realização de ESTÁGIO OBRIGATÓRIO REMOTO. Ficam estabelecidas entre as partes as seguintes condições básicas para a realização do estágio no período da Pandemia ocasionada pela propagação decorrente do novo Coronavírus (SARS-CoV-2).
</p>

<p style="text-align:justify">
Art. 01. As atividades a serem desenvolvidas pelo (a) estagiário (a), deverão ser compatíveis com o curso de Serviço Social e norteadas pelos princípios preconizados na Política de Estágio (ABEPSS), tais como: a indissociabilidade entre as dimensões teórico-metodológica, ético-política e técnico-operativa; articulação entre Formação e Exercício Profissional; indissociabilidade entre estágio e supervisão acadêmica e de campo; articulação entre Universidade e Sociedade; unidade teoria e prática e articulação entre ensino, pesquisa e extensão.<br>
Art. 02. As atividades desenvolvidas no campo de estágio deverão ter compatibilidade com as previstas no termo de compromisso.<br>
Art. 03. O plano de atividades do estagiário, elaborado em acordo dos estudantes, a parte concedente do estágio e a instituição de ensino, será incorporado ao termo de compromisso por meio de aditivos à medida que for avaliado, progressivamente, o desenho do estudante.<br>
Art. 04. A quebra deste contrato, deverá ser precedida de apresentação de solicitação formal à Coordenação de Estágio, com no mínimo 1 mês de antes do término do período letivo em curso. Contendo parecer do supervisor(a) de campo e do supervisor(a) acadêmico.<br>
Art. 05. Em caso de demissão do supervisor(a), ocorrência de férias ou licença deste profissional ao longo do período letivo, outro assistente social deverá ser imediatamente indicado para supervisão técnica do estagiário.
</p>

<h2>Da ESS</h2>
<p style="text-align:justify">
Art. 06. De acordo com a orientação geral da Universidade Federal do Rio de Janeiro, no que concerne a estágios, e o currículo da Escola de Serviço Social, implantado em 2001:
<blockquote>§1º O estágio na UFRJ, em conformidade com o artigo 3º da resolução CEG nº 12/2018, deverá ter carga horária máxima de 20(vinte) horas por semana, podendo-se estender a 24 (vinte e quatro) horas nos casos de cursos da área da saúde;</blockquote>
<blockquote>§2º Estágios com carga horária máxima superior ao previsto no §1º deste artigo poderão ser autorizados, pelo Conselho de Ensino de Graduação, conforme previsão na Política de Estágio, dentro do limite legal de 30(trinta) horas, em caráter excepcional.</blockquote>
Art. 07. Será indicado pelos Departamentos da ESS, um docente para acompanhamento acadêmico e orientação do Estagiário por meio da disciplina de Orientação ao Trabalho Acadêmico.<br>
Art. 08. A Escola de Serviço Social fornecerá à Instituição informações e declarações solicitadas, consideradas necessárias ao bom andamento do estágio curricular.   
</p>

<h2>DA PARTE CONCEDENTE</h2>
<p style="text-align:justify">
Art. 09. O estágio será realizado no âmbito da unidade concedente onde deve existir um Assistente Social responsável pelo projeto desenvolvido pelo Serviço Social. As atividades de estágio serão realizadas em horário compatível com as atividades acadêmicas do estagiário e com as normas vigentes no âmbito da unidade concedente.<br>
Art. 10. A Coordenação de Estágio/ESS deve ser informada com prazo de 01 (um) mês de antecedência o afastamento do supervisor(a) do campo de estágio e a indicação do seu substituto.<br>
Art. 11. Ofertar  Instalações que tenham condições de proporcionar ao estagiário atividades de aprendizagem social, profissional e cultural.
</p>

<h2>DO (A) SUPERVISOR(A) DE CAMPO</h2>
<p style="text-align:justify">
Art. 12. É de responsabilidade do Assistente Social supervisor(a) o acompanhamento, orientação e avaliação do estudante no campo de estágio, em conformidade com o plano de estágio, elaborado em consonância com o projeto pedagógico e com programas institucionais vinculados aos campos de estágio; garantindo diálogo permanente com o (a) supervisor (a) acadêmico (a), no processo de supervisão.<br>
Art. 13. Ao  término de cada mês, o (a) supervisor(a) atestará à unidade de ensino, em formulário próprio, a carga horária cumprida pelo estagiário.<br>
Art. 14. No final de cada período letivo, o (a) supervisor(a) encaminhará, ao professor(a) da disciplina de Orientação e Treinamento Profissional, avaliação do processo vivenciado pelo aluno durante o período, Instrumento este utilizado pelo professor(a) na avaliação final do aluno.
</p>

<h2>DO (A) ESTAGIÁRIO (A)</h2>
<p style="text-align:justify">
Art. 15. Cabe ao estagiário cumprir o horário acordado com a unidade para o desempenho das atividades definidas no Plano de Estágio, observando os princípios éticos que rege o Serviço Social. São considerados motivos justos ao não cumprimento da programação, as obrigações acadêmicas do estagiário que devem ser comunicadas, ao supervisor(a), em tempo hábil.<br>
Art. 16. O(a) aluno(a) se compromete a cuidar e manter sigilo em relação à documentação, da unidade campo de estágio, mesmo após o seu desligamento.<br>
Art. 17. O(a) aluno(a) deverá cumprir com responsabilidade e assiduidade os compromissos assumidos junto ao acampo de estágio, independente do calendário e férias acadêmicas.<br>
Art. 18. Aplica-se ao estagiário a legislação relacionada à saúde no trabalho, sendo sua implementação de responsabilidade da parte concedente do estágio.<br>
Art. 19. É assegurado ao estagiário (a) , sempre que o estágio tenha duração igual ou superior a 1 (um) ano, período de recesso de 30 (trinta) dias, a ser gozado preferencialmente durante suas férias escolares.
</p>

<h2>Das Orientações Gerais</h2>   
Art. 20. O presente Termo de Compromisso terá validade de $termoinicio a $termofinal, correspondente ao nível $nivel de Estágio. Sua interrupção antes do período previsto acarretará prejuízo para o aluno na sua avaliação acadêmica.<br>
Art. 21. Os casos omissos serão encaminhados à Coordenação de Estágio para serem dirimidos.
</p>

<p></p>
<p></p>
<p></p>

<p style="text-align:right">Rio de Janeiro, $dia de $mes de $ano.</p>

<p></p>
<p></p>
<p></p>

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

$pdf->writeHTML($html, true, 0, true, 0);
$pdf->lastPage();

// Close and output PDF document
$pdf->Output('termo_compromisso.pdf', 'I');
?>
