<?php

App::import("Vendor", "tcpdf/tcpdf");

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Escola de Serviço Social');
$pdf->SetTitle('Coordenação de Estágio e Extensão');
$pdf->SetSubject('Folha de atividades');
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
$pdf->SetFont('helvetica', '', 12);

setlocale (LC_ALL, 'pt_BR');
$dia = strftime('%e', mktime());
$mes = strftime('%B', mktime());
$ano = strftime('%Y', mktime());

$data = $dia . " de " . $mes . " de " . $ano . ".";

if (empty($telefone))
    $telefone = "s/d";
if (empty($celular))
    $celular = "s/d";

// add a page
$pdf->AddPage();

$texto = <<<EOD

<h2 style="text-align:center; font-size: 96%; line-height:95%">
<img src="img/logoess_horizontal.svg" alt="minerva ufrj" width="200px" height="50px"><br />
Folha de ativiades do(a) estagiário(a)<br> 
Mês: __________ Ano: __________
</h2>

<div style="text-align:justify; font-size: 92%">
<p style="line-height:100%">
Nome do(a) estudante: $estudante DRE: $registro<br>
Período de realização do estágio: $periodo<br>
Nível de estágio: $nivel<br>
Supervisor de campo: $supervisor 
CRESS: $cress 
Celular: $celular<br>
Campo de estágio: $instituicao<br>
Supervisor(a) acadêmico(a): $professor<br>
</div>

<br>
    
<table border="1" cellspacing = "0" cellpadding = "1">
                <tr style="width:110%">
                    <td style="width: 5%; text-align: center">
                        Dia
                    </td>
                    <td style="width: 15%; text-align: center">
                        Horário 
                    </td>
                    <td style="width: 80%; text-align: center">
                        Resumo das atividades 
                    </td>
                </tr>
        
        
                <tr>
                    <td>1
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>2
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>3
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>4
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>5
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>6
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>7
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>8
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td>9
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>10
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>11
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>12
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>13
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>14
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>15
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>16
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>17
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>18
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>19
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>20
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>21
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>22
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>23
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>24
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>25
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>26
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>27
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>28
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>29
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>30
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>31
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
        
</table>
        
<br>
<br>
    
<table>        
<tr>
<td align='left'>
Total de horas: __________ 
</td>
<td align='right'>
Rio de Janeiro, $data
</td>
</tr>
</table>

<br>
<br>

<table>

<tr>
    <td>Supervisor(a): _______________________ </td>
    <td>Estagiário(a): _________________________</td>
</tr>
<tr>    
   <td align='center'>$supervisor</td>
   <td align='center'>$estudante</td> 
 </tr>
<tr>
   <td align='center'>CRESS 7ª Região: $cress</td>
   <td align='center'>DRE: $registro</td>    
</tr>

</table>

EOD;

$pdf->writeHTML($texto, true, false, false, false, '');
$pdf->lastPage();

// Close and output PDF document
$pdf->Output('folhadeatividades.pdf', 'I');
?>
