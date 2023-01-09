<?php
/*
 * Plugin Name: ETF Sparplaner
 * Plugin URI: https://gordondigital.com/
 * Description: Just a ETF Calculator. Shortcode: [etfcp-page] GET Daten Uebermittlung
 * Version: 1.0.9
 * Author: Gordon Digital
 * Author URI: https://gordondigital.com/
 * License: GPLv2 or later
 * Text Domain: etf-sparplaner
 */

/*
 * Präfix
 * etfcp
 *
 * Quellcode aus build-Form-B und build_form_c_b
 *
 */
 
if (! function_exists('etfcp_addScriptsAndStiles')) {
    
    function etfcp_addScriptsAndStiles()
    {
        wp_register_script('my_jquery_js', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
        wp_register_script('my_raphael_js', '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
        wp_register_script('my_morris_js', '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js');
        wp_register_style('my_morris_css', '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css');
        wp_register_script('showhide', plugin_dir_url(__FILE__) . "/include/" . "showhide.js");
        
        wp_enqueue_script('my_jquery_js');
        wp_enqueue_script('my_raphael_js');
        wp_enqueue_script('my_morris_js');
        wp_enqueue_style('my_morris_css');
        wp_enqueue_script('showhide');
    }
}

add_action('wp_enqueue_scripts', 'etfcp_addScriptsAndStiles');
if (! function_exists('etfcp_build_form')) {
    
    // Definiert die Angabemaske
    function etfcp_build_form($periods)
    {
        // building default form
        $per = 10;
        $form_visibility=''; // Trigger ob eine Berechnung bereits stattfand
        
        if (array_key_exists('UserAction', $_GET) && (! empty($_GET['UserAction']))){
            $form_visibility = 'style="display: none"';
        }
        else{
            $form_visibility ='style="display: block"';
        }
        ?>
<h2>ETF Sparplan Simulator</h2>

<?php 
/* Blendet die Kapitalkurve ein
 */
if (array_key_exists('UserAction', $_GET) && (! empty($_GET['UserAction']))){
    echo '<div id="graph" style="height: 350px; width: 800px;"></div>';
}
?>

<form action="" method="get">
	<div id="form_0" <?php echo $form_visibility;  ?>>
	
	<input type="hidden" name="UserAction" value="1">
	<label>Sparsumme/Monat </label> <input class="sparsumme"
		name="sparsumme_1" value="100" type="number" min="1"></input> <label>ETF/Index
	</label> <select class="index" name="index_1">
		<option value="dax">Dax</option>
		<option value="sp500">S&P500</option>
		<option value="mcsi">MCSI World</option>
		<option value="nsdq">NASDAQ</option>
	</select> <label>Start</label> <select class="start_monat"
		name="start_monat_1">
		<option value="01" selected>Januar</option>
		<option value="02">Februar</option>
		<option value="03">M&auml;rz</option>
		<option value="04">April</option>
		<option value="05">Mai</option>
		<option value="06">Juni</option>
		<option value="07">Juli</option>
		<option value="08">August</option>
		<option value="09">September</option>
		<option value="10">Oktober</option>
		<option value="11">November</option>
		<option value="12">Dezember</option>
	</select> <select class="start_jahr" name="start_jahr_1">
		<option value="2019">2019</option>
		<option value="2018">2018</option>
		<option value="2017">2017</option>
		<option value="2016">2016</option>
		<option value="2015">2015</option>
		<option value="2014">2014</option>
		<option value="2013">2013</option>
		<option value="2012">2012</option>
		<option value="2011">2011</option>
		<option value="2010">2010</option>
		<option value="2009">2009</option>
		<option value="2008">2008</option>
		<option value="2007">2007</option>
		<option value="2006">2006</option>
		<option value="2005">2005</option>
		<option value="2004">2004</option>
		<option value="2003">2003</option>
		<option value="2002">2002</option>
		<option value="2001">2001</option>
		<option value="2000">2000</option>
		<option value="1999">1999</option>
		<option value="1998">1998</option>
		<option value="1997">1997</option>
		<option value="1996">1996</option>
		<option value="1995">1995</option>
		<option value="1994">1994</option>
		<option value="1993">1993</option>
		<option value="1992">1992</option>
		<option value="1991">1991</option>
		<option value="1990">1990</option>
		<option value="1989">1989</option>
		<option value="1988">1988</option>
		<option value="1987">1987</option>
		<option value="1986">1986</option>
		<option value="1985">1985</option>
		<option value="1984">1984</option>
		<option value="1983">1983</option>
		<option value="1982">1982</option>
		<option value="1981">1981</option>
		<option value="1980">1980</option>
		<option value="1979">1979</option>
		<option value="1978">1978</option>
		<option value="1977">1977</option>
		<option value="1976">1976</option>
		<option value="1975">1975</option>
		<option value="1974">1974</option>
		<option value="1973">1973</option>
		<option value="1972">1972</option>
		<option value="1971">1971</option>
		<option value="1970" selected>1970</option>
	</select>
	
	 <label>Neue Sparperiode</label> <input type="checkbox"
		class="neue_sparperiode" name="neue_sparperiode"
		onclick="show_elements('additional_form_1')"> <br>
	</div>
	<?php

        for ($i = 1; $i < $per; $i ++) {

            echo '<div id="additional_form_' . $i . '" style="display:none" >';
            echo '<h3>Extra Sparperiode ' . $i . '</h3>';
            ?>
	<label>Sparsumme/Monat </label> <input class="sparsumme"
		name="sparsumme_<?php echo $i+1;?>" type="number" min="1"></input> <label>ETF/Index
	</label> <select class="index" name="index_<?php echo $i+1;?>">
		<option value="dax">Dax</option>
		<option value="sp500">S&P500</option>
		<option value="mcsi">MCSI World</option>
		<option value="nsdq">NASDAQ</option>
	</select> <label><br>Anfang</label> <select class="start_monat"
		name="start_monat_<?php echo $i+1;?>">
		<option value="01" selected>Januar</option>
		<option value="02">Februar</option>
		<option value="03">M&auml;rz</option>
		<option value="04">April</option>
		<option value="05">Mai</option>
		<option value="06">Juni</option>
		<option value="07">Juli</option>
		<option value="08">August</option>
		<option value="09">September</option>
		<option value="10">Oktober</option>
		<option value="11">November</option>
		<option value="12">Dezember</option>
	</select> <select class="start_jahr"
		name="start_jahr_<?php echo $i+1;?>">
		<option value="2019">2019</option>
		<option value="2018">2018</option>
		<option value="2017">2017</option>
		<option value="2016">2016</option>
		<option value="2015">2015</option>
		<option value="2014">2014</option>
		<option value="2013">2013</option>
		<option value="2012">2012</option>
		<option value="2011">2011</option>
		<option value="2010">2010</option>
		<option value="2009">2009</option>
		<option value="2008">2008</option>
		<option value="2007">2007</option>
		<option value="2006">2006</option>
		<option value="2005">2005</option>
		<option value="2004">2004</option>
		<option value="2003">2003</option>
		<option value="2002">2002</option>
		<option value="2001">2001</option>
		<option value="2000">2000</option>
		<option value="1999">1999</option>
		<option value="1998">1998</option>
		<option value="1997">1997</option>
		<option value="1996">1996</option>
		<option value="1995">1995</option>
		<option value="1994">1994</option>
		<option value="1993">1993</option>
		<option value="1992">1992</option>
		<option value="1991">1991</option>
		<option value="1990">1990</option>
		<option value="1989">1989</option>
		<option value="1988">1988</option>
		<option value="1987">1987</option>
		<option value="1986">1986</option>
		<option value="1985">1985</option>
		<option value="1984">1984</option>
		<option value="1983">1983</option>
		<option value="1982">1982</option>
		<option value="1981">1981</option>
		<option value="1980">1980</option>
		<option value="1979">1979</option>
		<option value="1978">1978</option>
		<option value="1977">1977</option>
		<option value="1976">1976</option>
		<option value="1975">1975</option>
		<option value="1974">1974</option>
		<option value="1973">1973</option>
		<option value="1972">1972</option>
		<option value="1971">1971</option>
		<option value="1970" selected>1970</option>
	</select> 
	
 
	<br> <label>Neue Sparperiode</label> <input type="checkbox"
		class="neue_sparperiode" name="neue_sparperiode_<?php echo $i+1;?>"
		onclick="show_elements('additional_form_<?php echo $i+1;?>')"> <br>
	<br>

	</div>
	
	
<?php } 
    echo '<button id = "button_0" ' . $form_visibility. '>Simulation starten</button></form>'; ?>

	
	<?php

// echo '<button>Simulation starten</button></form>';

        // echo '<div id="graph" style="height: 350px; width: 900px;"></div>';
    } // End function build_form
} // End ! function_exists

$periode = 10;
if (! function_exists('etfcp_file_finder')) {
    
    function etfcp_file_finder($name)
    {
        $file;
        
        if ($name == "dax") {
            $file = plugin_dir_url(__FILE__) . "/include/" . "DAX30Final.csv";
            //echo "<h2>Sparplan " . "DAX" . "</h2>";
        } elseif ($name == "sp500") {
            $file = plugin_dir_url(__FILE__) . "/include/" . "SP500TRFinal.csv";
            //echo "<h2>Sparplan " . "S&P 500" . "</h2>";
        } elseif ($name == "mcsi") {
            $file = plugin_dir_url(__FILE__) . "/include/" . "MCSIWorldFinal.csv";
            //echo "<h2>Sparplan " . "MCSI World Large and Midcap" . "</h2>";
        } elseif ($name == "nsdq") {
            $file = plugin_dir_url(__FILE__) . "/include/" . "NASDAQ100Final.csv";
            //echo "<h2>Sparplan " . "Nasdaq" . "</h2>";
        }
        return $file;
    } // End Function etfcp_file_finder
} // End ! function_exists

if (! function_exists('etfcp_index_name')) {
    
    function etfcp_index_name($name)
    {
        $index_name;
        
        if ($name == "dax") {
            $index_name = "DAX";
            //echo "<h2>Sparplan " . "DAX" . "</h2>";
        } elseif ($name == "sp500") {
            $index_name = "S&P 500";
            //echo "<h2>Sparplan " . "S&P 500" . "</h2>";
        } elseif ($name == "mcsi") {
            $index_name = "MCSI World";
            //echo "<h2>Sparplan " . "MCSI World Large and Midcap" . "</h2>";
        } elseif ($name == "nsdq") {
            $index_name = "NASDAQ";
            //echo "<h2>Sparplan " . "Nasdaq" . "</h2>";
        }
        return $index_name;
    } // End Function etfcp_file_finder
} // End ! function_exists




if (! function_exists('etfcp_berechnen')) {
    
    function etfcp_berechnen($per)
    {
        
        // Alles findet in if not empty statt
        $periode = 10;
        $index = "";
        $sparsumme = 1;
        $startdatum = 0;
        $enddatum = 0;
        $kapital = 0;
        $counter = 0;
        $endergebnis = 0;
        $start_jahr = 0;
        $start_monat = 0;
        $end_jahr = 0;
        $end_monat = 0;
        $total_return = 0;
        $equityline = array();
        $equityednline = array();
        // $equityline[] = array('1970-01-01', 0.00);
        
        // Equityline Array dynamisch bilden
        for ($ja = 1970; $ja < 2021; $ja ++) {
            
            for ($mo = 1; $mo < 10; $mo ++) {
                
                $equityline[] = array(
                    $ja . '-0' . $mo . '-01',
                    0.00
                );
            }
            for ($mox = 10; $mox < 13; $mox ++) {
                
                $equityline[] = array(
                    $ja . '-' . $mox . '-01',
                    0.00
                );
            }
        }
        echo '<br>';
        // check ob alle VAriabeln Ã¼bermittelt wurden
        for ($i = 1; $i <= $periode; $i ++) {
            
            //echo '<b>Kontrollnummer: '.$i.'</b><br>';// KONTROLLE 
            // $_GET
            if (array_key_exists('sparsumme_' . $i, $_GET) && (! empty($_GET['sparsumme_' . $i]))) {
                
                // Nur wenn eine Sparsumme angegeben wird, wird auch die Sparperiode berechnet
                // Daten aus dem Formular werden ausgelesen und validiert
                $index = filter_var($_GET['index_' . $i], FILTER_SANITIZE_STRING ) ; // war $index = $_GET['index_' . $i];
                $sparsumme = filter_var($_GET['sparsumme_' . $i], FILTER_SANITIZE_NUMBER_INT) ; // $sparsumme = $_GET['sparsumme_' . $i];
                $start_jahr = filter_var($_GET['start_jahr_' . $i], FILTER_SANITIZE_NUMBER_INT) ; // $start_jahr = $_GET['start_jahr_' . $i];
                $start_monat = filter_var($_GET['start_monat_' . $i], FILTER_SANITIZE_NUMBER_INT); // $start_monat = $_GET['start_monat_' . $i];
                $end_jahr = "2020";// filter_var($_GET['end_jahr_' . $i], FILTER_SANITIZE_NUMBER_INT); // $end_jahr = $_GET['end_jahr_' . $i];
                $end_monat = "01";//filter_var($_GET['end_monat_' . $i], FILTER_SANITIZE_NUMBER_INT); // $end_monat = $_GET['end_monat_' . $i];
                
                // Variable $es um mit Euro/Cent zu arbeiten
                $es = $sparsumme * 100; // Cent statt Euro
                $anfangsdatum = $start_jahr . "-" . $start_monat . "-01";
                $enddatum = $end_jahr . "-" . $end_monat . "-01";
                
                $k = 'kapital' . $index; // Name der Array mit der Kapitalkurve des Sparplans
                $$k = array();
                
                // Zeitformat
                
                $anfangsdatum_unix = strtotime($anfangsdatum);
                $enddatum_unix = strtotime($enddatum);
                
                // Sparplanbezogene Variabeln
                
                $kapital = 0;
                $counter = 0;
                $endergebnis = 0;
                
                // BEschreibund des gewaehlten Sparplans
                echo '<b>Sparperiode ' . $i . ' - ' . $sparsumme;
                echo ' Euro monatlich auf Basis ' . etfcp_index_name($index) . ' ab dem 01.' . $start_monat. '.' . $start_jahr .'.</b> ';
                
                // Hier wird Kapitelentwicklung berechnet
                
                $file = etfcp_file_finder($index);
                
                $csv = array_map('str_getcsv', file($file)); 
                array_walk($csv, function (&$a) use ($csv) {
                    $a = array_combine($csv[0], $a);
                });
                    
                    $array_size = sizeof($csv);
                                   
                    
                    for ($y = ($array_size - 1); $y > 0; $y --) {
                        
                        if (strtotime($csv[$y]["timestamp"]) >= $anfangsdatum_unix && strtotime($csv[$y]["timestamp"]) <= $enddatum_unix) {
                            
                            $kapital = $kapital + $es / $csv[$y]["close"];                            
                            $counter = $counter + 1;
                                                       
                            $zeit = $csv[$y]["timestamp"];
                            $wert = $kapital * $csv[$y]["close"];
                                                        
                            $endergebnis = $kapital * $csv[1]["close"] / 100;
                            
                            for ($eq = 0; $eq < sizeof($equityline); $eq ++) {                               
                                
                                if ((date('Y', strtotime($equityline[$eq][0])) == date('Y', strtotime($zeit))) && (date('m', strtotime($equityline[$eq][0])) == date('m', strtotime($zeit)))) {
                                    $equityline[$eq][1] = $equityline[$eq][1] + $wert / 100;
                                    break;
                                }
                                
                                
                            }
                        }
                    }
                    
                    if ($counter > 0) {
                        $total_return = $total_return + 0 + (($kapital * $csv[1]["close"] / 100));
                        echo "<b>Ergebnis (Euro): " . number_format(($kapital * $csv[1]["close"] / 100), 2, ',', '.').'</b>';
                        echo "<div class='erweiterte_statistik' style='display:none'>  Eingezahltes Kapital (Euro): " . number_format((($sparsumme * $counter)), 2, ',', '.') . "; Zeitraum (Monate): " . number_format(($counter), 2, ',', '.')  ;
                        echo " ; Wachstum absolut (Euro): " . number_format((($endergebnis - ($sparsumme * $counter))), 2, ',', '.') . " ; Wachstum prozentuell: " . number_format(((($endergebnis / ($sparsumme * $counter) * 100) - 100)), 2, ',', '.') . "%</div>";
                        echo '<br>';
                    } else {
                        
                        echo "Bitte, Anfang- und Enddatum richtig einstellen";
                    }
            } // End if array_key exist
            
            
            $endgroesse = sizeof($equityline);
            
            for ($eqx = 0; $eqx < $endgroesse; $eqx ++) {
                if ($equityline[$eqx][1] > 0) {
                    $equityednline[] = $equityline[$eqx];
                }
            }
            
        }
        if($total_return >0){
            echo '<h2>Sparkapital: '.number_format(($total_return),2, ",", "." ).' Euro</h2><br>';
            ?><label>Neue Simulation starten</label> <input type="checkbox" id ="button_1" onclick="show_elements('form_0','button_0')"></input>
            
            
            <?php ;
            
            
        }
        // etfcp_build_form($periode);
        // Hier Javascript einbinden
        
        
        ?>
	<script type="text/javascript">
$(document).ready(function(){
 
   var graph = null;
   <?php echo 'var zedda = '.sizeof($equityline);?>
 
      graph = Morris.Area({
      element: 'graph',
      data: [

          <?php
          for ($gr = 0; $gr < sizeof($equityline); $gr ++) {
            // sizeof($equityednline)
            // echo 'Schleife';
            /*
             * Überprüfung ob der Wert > 0 ist
             */
              
              if($equityline[$gr][1] >0){ 
                  

            ?>
              { key: '<?php echo ($equityline[$gr][0]);   ?>', value: <?php echo $equityline[$gr][1] ?> }, 
              
         <?php }} ?>
                  
         
      ],
      xkey: 'key',
      ykeys: ['value'],
      ymax: 'auto',
      labels: ['Sparsumme'],
      hideHover: true,
      fillOpacity: 0.1,
      pointSize: 0,
      lineWidth: 1
   });
 
});
</script>
	
	
	<?php
        // Hier kommt das Ender der Function
    }
} // End if ! function_exists
if (! function_exists('etfcp_build_page')) {
    
    function etfcp_build_page($per)
    {
        $input = $per;
        
        etfcp_build_form($input);
        etfcp_berechnen($input);
    }
}
// etfcp_build_page($periode);

add_shortcode("etfcp-page", "etfcp_build_page", $periode);
