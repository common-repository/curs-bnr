<?php
/*
Plugin Name: Curs Bnr
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Preia zilnic cursul BNR si-l afiseaza pe blog.
Version: 1.0
Author: Bogdan Bocioaca
Author URI: http://lanebuni.ro
*/

/*  Copyright 2009 Bogdan Bocioaca  (email : bogdan.bocioaca@yahoo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


function curs_bnr(){
$parser = xml_parser_create();
xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
$data = implode("",file('http://www.bnro.ro/nbrfxrates.xml'));
xml_parse_into_struct($parser,$data,&$d_ar,&$i_ar) or print_error();

$valuta1='EUR';
$valuta2='USD';
$valuta3='CHF';
$valuta4='GBP';
$valuta5='XAU';
$val_valuta1='';
$val_valuta2='';
$val_valuta3='';
$val_valuta4='';
$val_valuta5='';
$data_curs='';
$nr_valute=count($i_ar['Rate']);
for ($i = 0; $i <$nr_valute ; $i++) {
  
  if ($valuta1==strtoupper(trim($d_ar[$i_ar['Rate'][$i]]['attributes']['currency']))) {
      $val_valuta1=$d_ar[$i_ar['Rate'][$i]]['value'];
  }
  if ($valuta2==strtoupper(trim($d_ar[$i_ar['Rate'][$i]]['attributes']['currency']))) {
      $val_valuta2=$d_ar[$i_ar['Rate'][$i]]['value'];
  }
  if ($valuta3==strtoupper(trim($d_ar[$i_ar['Rate'][$i]]['attributes']['currency']))) {
      $val_valuta3=$d_ar[$i_ar['Rate'][$i]]['value'];
  }  
  if ($valuta4==strtoupper(trim($d_ar[$i_ar['Rate'][$i]]['attributes']['currency']))) {
      $val_valuta4=$d_ar[$i_ar['Rate'][$i]]['value'];
  }  
    if ($valuta5==strtoupper(trim($d_ar[$i_ar['Rate'][$i]]['attributes']['currency']))) {
      $val_valuta5=$d_ar[$i_ar['Rate'][$i]]['value'];
  }  

}
$data_curs=$d_ar[$i_ar['Cube'][0]]['attributes']['date'];

$diferentaEURUSD=0;
if ($val_valuta2!=0) $diferentaEURUSD=round($val_valuta1/$val_valuta2,4);

$str_info_valute='';
$str_info_valute=$str_info_valute.'Data curs: '.$data_curs.'<br><br>';
$str_info_valute=$str_info_valute.'<b>'.$valuta1.'</b> : '.$val_valuta1.'<br>';
$str_info_valute=$str_info_valute.'<b>'.$valuta2.'</b> : '.$val_valuta2.'<br>';
$str_info_valute=$str_info_valute.'<b>'.$valuta3.'</b> : '.$val_valuta3.'<br>';
$str_info_valute=$str_info_valute.'<b>'.$valuta4.'</b> : '.$val_valuta4.'<br>';
$str_info_valute=$str_info_valute.'<b>'.$valuta5.'</b> : '.$val_valuta5.'<br><br>';
$str_info_valute=$str_info_valute.'<b>Diferenta EUR/USD</b> : '.$diferentaEURUSD.'<br>';

echo '<div class="rightMenuItem">';
echo '<h2>Curs Valutar</h2>';
echo '<p class="normal">'.$str_info_valute.'</p>';
echo '<p class="normal">&nbsp;</p>';
echo '</div>';	

xml_parser_free($parser);
}
/* ----------------------------------------- */
function print_error() {
    global $parser;
    die(sprintf("XML Error: %s at line %d",
        xml_error_string($xml_get_error_code($parser)),
        xml_get_current_line_number($parser)
    ));
}     

?>