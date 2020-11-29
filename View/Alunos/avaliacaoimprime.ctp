<?php

App::import("Vendor", "tcpdf/tcpdf");

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Escola de Serviço Social');
$pdf->SetTitle('Coordenação de Estágio');
$pdf->SetSubject('Avaliação discente');
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
$pdf->SetFont('helvetica', '', 8);

setlocale (LC_TIME, 'pt_BR');
$dia = strftime('%e', mktime());
$mes = utf8_encode(strftime('%B', mktime()));
$ano = strftime('%Y', mktime());

$data = $dia . " de " . $mes . " de " . $ano . ".";

if (empty($telefone)) $telefone = "s/d";
if (empty($celular)) $celular = "s/d";

// add a page
$pdf->AddPage();

$texto = <<<EOD

<h2 style="text-align:center">
<img src="img/logoess_horizontal.svg" alt="minerva ufrj" width="200px" height="50px"><br />
Coordenação de Estágio<br />
Avaliação final do supervisor de campo do desempenho discente
</h2>

<div style="text-align:justify">
<p style="line-height:100%">
Nome do Aluno(a): $estudante<br>
Supervisor(a) de Campo: $supervisor 
CRESS: $cress <br />
E-mail: $email 
Telefone: $telefone Celular: $celular<br />
Campo de Estágio: $instituicao<br />
Endereço Institucional: $endereco_inst<br />
Período de realização do estágio: $periodo<br />
Nível de Estágio: $nivel<br />
Supervisor(a) Acadêmico(a): $professor</p>

<p>
<b>Leia atentamente cada item e marque um X na posição que melhor descreva os resultados alcançados com a inserção do(a) aluno(a) no campo de estágio.</b>
</p>        

<table border="1">
                <tr style="font-size:10px; float:left; height:25px; vertical-align:middle;">
                    <td style="width: 72%">
                        Inserção e desenvolvimento do(a) Aluno(a) no Espaço Sócio institucional/ocupacional
                    </td>
                    <td style="width: 7%">
                        Ruim 
                    </td>
                    <td style="width: 7%">
                        Regular 
                    </td>
                    <td style="width: 7%">
                        Bom 
                    </td>
                    <td style="width: 8%">
                        Excelente
                    </td>
                </tr>
        
                <tr style="font-size:10px; height: 25px">
                    <td>
                        1 - ASSIDUIDADE: É freqüênte, ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr style="font-size:10px;">
                    <td>
                        2 - PONTUALIDADE: cumpre horário estabelecido no Plano de Estágio.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr style="font-size:10px;">
                    <td>
                        3 - COMPROMISSO: com as ações e estratégias previstas no Plano de Estágio
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr style="font-size:10px;">
                    <td>
                        4 - Na relação com o(a) usuário(a): compromisso ético-político no atendimento direto ao usuário(a).
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr style="font-size:10px;">
                    <td>
                        5 - Na relação com outro(a)s profissionais: Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe multiprofissional.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr style="font-size:10px;">
                    <td>
                        6 - CRITICIDADE E INICATIVA: Capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr style="font-size:10px;">
                    <td>
                        7- Apreensão do referencial teórico-metodológico, ético-político e investigativo e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr style="font-size:10px;">
                    <td>
                        8 - Avaliação do desempenho do(a) estagiário(a) na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc.
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

</table>
<p style="line-height: 1">
9) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?
<br style="line-height: 100%;">
(   ) sim   (   ) não. Fundamente se achar necessário: 
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
10) O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas  condições de trabalho do campo de estágio?
<br>
(   ) sim   (   ) não. Justifique a resposta se achar necessário. 
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
11) Quanto à integração Universidade / campo de estágio: Há discussão conjunta do trabalho entre os 3 segmentos: aluno(a), professor(a) e supervisor(a)?
<br>
(   ) sim   (   ) não. Justifique a resposta se achar necessário. 
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
Se a resposta foi não. Como poderia ser desenvolvida _________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
12) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?
<br>
(   ) sim   (   ) não. Quais?
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
Sugestões e observações:
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
__________________________________________________________________________________________________________________
<br>
<br>
</p>

<br>
<br>
<span style="text-align: right">Rio de Janeiro, $data</span>
</p>
</div>

<table>
<tr>
<td>Coordenação de Estágio e Extensão</td>
<td>$estudante <br> (DRE: $registro)</td>
<td>$supervisor <br> (CRESS 7ª Região: $cress)</td>
</tr>

</table>
EOD;

$pdf->writeHTML($texto, true, false, false, false, '');
$pdf->lastPage();

// Close and output PDF document
$pdf->Output('avaliacao_estudante.pdf', 'I');

?>
