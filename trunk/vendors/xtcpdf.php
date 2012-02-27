<?php

App::import('Vendor','tcpdf/tcpdf'); 

class XTCPDF  extends TCPDF { 

    var $xheadertext  = 'Coordenação de Estágio e Extensão'; 
    var $xheadercolor = array(0,0,280); 
    var $xfootertext  = 'Coordenação de Estágio e Extensão - ESS/UFRJ'; 
    var $xheaderlogo = PDF_HEADER_LOGO;
    var $xfooterfont  = PDF_FONT_NAME_MAIN ; 
    var $xfooterfontsize = 8 ; 

    /** 
    * Overwrites the default header 
    * set the text in the view using 
    *    $fpdf->xheadertext = 'YOUR ORGANIZATION'; 
    * set the fill color in the view using 
    *    $fpdf->xheadercolor = array(0,0,100); (r, g, b) 
    * set the font in the view using 
    *    $fpdf->setHeaderFont(array('YourFont','',fontsize)); 
    */ 
    function Header() { 

        list($r, $b, $g) = $this->xheadercolor; 
        $this->setY(10); // shouldn't be needed due to page margin, but helas, otherwise it's at the page top
        $this->SetFillColor($r, $b, $g); 
        $this->SetTextColor(0 , 0, 0); 
        $this->SetFont($this->xfooterfont, '', 14); 
        $this->setHeaderData($this->xheaderlogo, 30, "ESS", "Estágio");
        $this->Cell(0, 25, '', 0, 1, 'C', 1); 
        $this->Text(50,12, "UNIVERSIDADE FEDERAL DO RIO DE JANEIRO"); 
        $this->Text(50,17, "Centro de Filosofia e Ciências Sociais"); 
        $this->Text(50,22, "ESCOLA DE SERVIÇO SOCIAL");
        $this->Text(50,27, $this->xheadertext ); 
        
    } 

    /** 
    * Overwrites the default footer 
    * set the text in the view using 
    * $fpdf->xfootertext = 'Copyright Â© %d YOUR ORGANIZATION. All rights reserved.'; 
    */ 
    function Footer() { 
        $year = date('Y'); 
        $footertext = sprintf($this->xfootertext, $year); 
        $this->SetY(-20); 
        $this->SetTextColor(0, 0, 0); 
        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize); 
        $this->Cell(0,8, $footertext,'T',1,'C'); 
    } 
}
 
?>