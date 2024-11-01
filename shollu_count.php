<?php
$soptions=shollu_get_options();
$backlink=$soptions["backlink"];
$style=$soptions["style"];
$city = $soptions["location"];
$latitude = $soptions["latitude"];
$longitude = $soptions["longitude"];
$timezone = $soptions["timezone"];
switch ($soptions["method"]){
case 1://University of Islamic Sciences, Karachi
	$twilight = array(18,18);
	break;
case 2://islamic society of north america (isna)
	$twilight = array(15,15);
	break;
case 3://World Islamic League
	$twilight = array(18,17);
	break;
case 4://Egyptian General Organization of Surveying
	$twilight = array(19.5,17.5);
	break;
}
$dayofyear = date('z');
$beta = 2*M_PI*$dayofyear/365;
$height=1;
$absH = abs($height);
$signH = $height/$absH;
$mahzab = $soptions["madzhab"]-1;

function jam($num) { 
  $hour = floor($num); 
  $min = floor(($num-$hour)*60); 
  $sec = floor((($num-$hour)*3600)-($min*60));
  $hour = $hour<10?'0'.$hour:$hour; 
  $min = $min<10?'0'.$min:$min; 
  $sec = $sec<10?'0'.$sec:$sec; 
  $jam = $hour.':'.$min;//.':'.$sec; 
  return $jam;
} 

$D = 180/M_PI*(0.006918-0.399912*cos($beta)+0.070257*sin($beta)-0.006758*cos(2*$beta)+0.000907*sin(2*$beta)-0.002697*cos(3*$beta)+0.001480*sin(3*$beta));

$T = 229.18*(0.000075+0.001868*cos($beta)-0.032077*sin($beta)-0.014615*cos(2*$beta)-0.040849*sin(2*$beta));

$reflon = 15*$timezone;

$Z = 12+(($reflon-$longitude)/15)-($T/60);

$U = 180/(15*M_PI)*acos(((sin(((-0.8333-(0.0347*$signH*sqrt($absH)))*M_PI/180))-sin(($D*M_PI/180))*sin(($latitude*M_PI/180)))/cos(($D*M_PI/180))*cos(($latitude*M_PI/180))));


$Vd = (180/(15*M_PI))*acos((-sin($twilight[0]*(M_PI/180))-sin($D*(M_PI/180))*sin($latitude*(M_PI/180)))/(cos($D*(M_PI/180))*cos($latitude*(M_PI/180))));

$Vd0 = acos((-sin($twilight[0]*(M_PI/180))-sin($D*(M_PI/180))*sin($latitude*(M_PI/180)))/(cos($D*(M_PI/180))*cos($latitude*(M_PI/180))));

$Vn = (180/(15*M_PI))*acos((-sin($twilight[1]*(M_PI/180))-sin($D*(M_PI/180))*sin($latitude*(M_PI/180)))/(cos($D*(M_PI/180))*cos($latitude*(M_PI/180))));

$W = (180/(15*M_PI))*acos((sin(atan(1/($mahzab+1+tan(abs($latitude-$D)*(M_PI/180)))))-sin($D*(M_PI/180))*sin($latitude*(M_PI/180)))/(cos($D*(M_PI/180))*cos($latitude*(M_PI/180))));

$shubuh = jam($Z-$Vd);
$imsak = jam(((($Z-$Vd)*60)-10)/60);
$syuruq = jam($Z-$U);
$dhuhur = jam($Z);
$maghrib = jam($Z+$U); 
$ashar = jam($Z+$W);
$isya = jam($Z+$Vn);

include("shollu_css.php");
?>

<div align="center">
	<table class="sh_table<?php echo $style; ?>">
  <tr>
    <th colspan="3" align="center" class="sh_head" ><?php echo $city; ?><br/> <?php echo date("d F Y"); ?></th>
  </tr>
  <tr>
    <th width="65" >Imsak</th>
    <td align="center">:</td>
    <td width="65"><?php echo $imsak; ?></td>
  </tr>
  <tr>
    <th >Shubh</th>
    <td align="center">: </td>
    <td><?php echo $shubuh; ?></td>
  </tr>
  <tr>
    <th >Syuruq</th>
    <td align="center">: </td>
    <td><?php echo $syuruq; ?></td>
  </tr>
  <tr>
    <th >Dhuhr</th>
    <td align="center">: </td>
    <td><?php echo $dhuhur; ?></td>
  </tr>
  <tr>
    <th >Ashr</th>
    <td align="center">: </td>
    <td><?php echo $ashar; ?></td>
  </tr>
  <tr>
    <th >Maghrib</th>
    <td align="center">: </td>
    <td><?php echo $maghrib; ?></td>
  </tr>
  <tr>
    <th >Isya</th>
    <td align="center">: </td>
    <td><?php echo $isya; ?></td>
  </tr>
<?php
if ($backlink=='on') {
?>  
  <tr>
    <th colspan="3" align="center" class="sh_foot" >Shollu Plugin by <a href="http://fich.web.id" title="http://fich.web.id" alt="http://fich.web.id">fich.web.id</a></th>
  </tr>
<?php } ?>
</table>
</div>
