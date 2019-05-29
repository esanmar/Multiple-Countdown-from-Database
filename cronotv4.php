<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=UTF-8">
<!--<meta http-equiv="Content-Type"  content="text/html charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">-->
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
		
		<title>Tres Cantos</title>
		<link rel="stylesheet" type="text/css" href="./print.css">
		
	  <script type="text/javascript" src="CountDown/CountDownJS.js"></script>

		<script src="sorttable.js"></script>
		

		
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
$horafins = "";
//echo "hora: " . $hora;

if ($hora < $turno) {
	$sql    = "SELECT id, nombre, paquete, placa, horaini, horafin, color FROM cronotc WHERE  visible='1' and placa like '%Placa%' and (nombre like '%14 C%' or nombre like '%hu%') and horaini < " . $turno;
} else {
	$sql    = "SELECT id, nombre, paquete, placa, horaini, horafin, color FROM cronotc WHERE  visible='1' and placa like '%Placa%' and (nombre like '%14 C%' or nombre like '%hu%') and horaini >= " . $turno;
	
}
//echo " sql3 " . $sql;
// connect to MYSQL
$conn = mysqli_connect("*", "*", "*", "*");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result = mysqli_query($conn, $sql);
// Muestra Husillos, 2.14 C . Si no tiene datos saca LEX

if ( $result->num_rows === 0)
{
		if ($hora < $turno) {
			$sql2    = "SELECT id, nombre, paquete, placa, horaini, horafin, color FROM cronotc WHERE  visible='1' and placa like '%LEX%' and  nombre like '%LEX%' and horaini < " . $turno;
		} else {
			$sql2    = "SELECT id, nombre, paquete, placa, horaini, horafin, color FROM cronotc WHERE  visible='1' and placa like '%LEX%' and  nombre like '%LEX%' and horaini >= " . $turno;
			
		}
		//echo " sql2 " . $sql2;
		$result = mysqli_query($conn, $sql2);
}	
		
$cont = 0;

while ($row =  $result->fetch_assoc()) {
	
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
							<td align="center"><span  style="text-Shadow: 0px 1px 2px black; font-size: 70px; font-weight: bold; color: #ffffff; background-color: <?php echo $color;?>"> <?php echo $placa;?></span></td>
							<td align="center" width="410">
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
mysqli_free_result($result);
mysqli_close($conn);
?>			

</td>
</tr>
</table>	




</div>
</body>
</html>