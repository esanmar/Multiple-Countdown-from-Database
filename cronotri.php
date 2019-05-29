<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=UTF-8">
<!--<meta http-equiv="Content-Type"  content="text/html charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">-->
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
 
		<!--<meta http-equiv="refresh" content="60">-->
		
		<title>Tres Cantos</title>
		<link rel="stylesheet" type="text/css" href="./print.css">
		
	  <script type="text/javascript" src="CountDown/CountDownJS.js"></script>

		<script src="sorttable.js"></script>

    </head>
<body>

<script type="text/javascript">
if (location.href.indexOf('reload')==-1)
{
   location.href=location.href+'?reload';
 
}
</script>
	

<table width="100%">
<tr>

<?php

$fechahoy = getdate();
    
    
$ano = $fechahoy[year];
$mes = $fechahoy[mon];
$hoy = $fechahoy[mday];

$hora = date('H');
$turno = 15;
$sql = "";
//echo "hora: " . $hora;

if ($hora < $turno) {
	$sql    = "SELECT id, nombre, paquete, placa, horaini, horafin, color FROM cronotc WHERE  visible='1' and placa like '%Placa%' and (nombre like '%09%' or nombre like '%tri%') and horaini < " . $turno;
} else {
	$sql    = "SELECT id, nombre, paquete, placa, horaini, horafin, color FROM cronotc WHERE  visible='1' and placa like '%Placa%' and (nombre like '%09%' or nombre like '%tri%') and horaini >= " . $turno;
	
}

/*
echo " sql " . $sql;

echo "A?: " . $ano;
echo "MES: " . $mes;
echo "HOY: " . $hoy;
*/

$cont = 0;


$horafins = "";


// connect to MYSQL
$link = mysql_connect('172.16.0.24', 'root', 'soft5');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

if (! mysql_select_db('cronotc') ) {
    die ('Can\'t use foo : ' . mysql_error());
}

$result = mysql_query($sql, $link);

if (!$result) {   echo 'MySQL Error: ' . mysql_error();    exit;}

$cont = 0;

while ($row = mysql_fetch_assoc($result)) {
    $nombre = $row['nombre'];
    $paquete = $row['paquete'];
    $placa = $row['placa'];
    $horaini = $row['horaini'];
    $horafin = $row['horafin'];
    $color = $row['color'];
    
    $cont = $cont + 1;

$horafins  = strtok($horafin, ':');
$min = strtok(':');
			

if ( $cont == 1 or $cont == 9) {
?>
<td valign="top">
	<table cellspacing="0" align="center">
	<!--<table width="50%" cellspacing="0" align="center">-->
	<tr>
		<th align="center"><span class="faltan"> NOMBRE </span></th>
		<th align="center"><span class="faltan"> PLACA </span></th>
		<th align="center" valign="top"><span class="faltan"> FIN </span></th>
	</tr>
<?php
}
?>
						<tr>
							<td align="center"><span class="nombre"><?php echo $nombre;?></span></td>
							<td align="center"><span  style="text-Shadow: 0px 1px 2px black; font-size: 30px; font-weight: bold; color: #ffffff; background-color: <?php echo $color;?>"> <?php echo $placa;?></span></td>
							<td align="center">
								<script>
										countDown<?php echo $cont;?> = new CountDownObject(<?php echo $cont;?>); //add countdown as object
										countDown<?php echo $cont;?>.TIME_ZONE = +1, // your time zone (-12 ... +14)
										countDown<?php echo $cont;?>.SET_YOUR_SEC = 10,
										countDown<?php echo $cont;?>.SET_YOUR_MIN = <?php echo $min; ?>,
										countDown<?php echo $cont;?>.SET_YOUR_HOUR = <?php echo $horafins; ?>,
										countDown<?php echo $cont;?>.SET_YOUR_DAY = <?php echo $hoy; ?>,
										countDown<?php echo $cont;?>.SET_YOUR_MONTH = <?php echo $mes; ?>,
										countDown<?php echo $cont;?>.SET_YOUR_YEAR = <?php echo $ano; ?>,
										countDown<?php echo $cont;?>.NUM_OF_ELEMENTS = 6, // number of flip-elements(from 1 to 9)
										countDown<?php echo $cont;?>.TIME_ANIMATION = 50, // time of flip animation in milliseconds(from 50 to 950)
										countDown<?php echo $cont;?>.TEXT_COLOR = "#d6dfe6", // text color under flip elements(seconds, minutes and etc.)
										countDown<?php echo $cont;?>.IS_DYNAMIC_COLOR = false, // back color will vary(true or false)
										countDown<?php echo $cont;?>.CANVAS_NAME = "CountDownCanvas";  //canvas name in html-code
										countDown<?php echo $cont;?>.Start(); //start countdown
							</script>
							</td>
							</tr>
<?php
if ($cont == 8) {
?>
</table>
</td>
<?php
		}		 
}	
?>			

</td>
</tr>
</table>	




</div>
</body>
</html>