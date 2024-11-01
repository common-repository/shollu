<?php 
wp_enqueue_script('jquery'); 
$plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
?> 
<script language="javascript">
var $j = jQuery.noConflict(); 

function calclon(){
var dlon  = Math.abs( Math.round($j("#lon-degree").val() * 1000000.));
if (dlon > (180 * 1000000) || dlon < 0 ) {
	alert(' Degrees Longitude must be in the range of 0 to 180. ');
	$j("#lon-degree").val('');
	return false;
}

var mlon  = Math.abs(Math.round($j("#lon-minute").val()  * 1000000.)/1000000);
mlon = Math.abs(Math.round(mlon * 1000000.));
if (mlon >= (60 * 1000000) ) {
	alert(' Minutes Longitude must be in the range of 0 to 59. ');
	$j("#lon-minute").val('');
	return false;
}

var slon  = Math.abs(Math.round($j("#lon-second").val()  * 1000000.)/1000000);
slon = Math.abs(Math.round(slon * 1000000.));
if (slon >= (59.99999999 * 1000000) ) {
	alert(' Seconds Longitude must be in the range of 0 to 59. ');
	$j("#lon-second").val('');
	return false;
}

var lon = Math.round(dlon + (mlon/60) + (slon/3600) ) * $j("#lon-sign").val()/1000000;
$j("#longitude").val(lon);
}

function calclat(){
var dlat  = Math.abs( Math.round($j("#lat-degree").val() * 1000000.));
if (dlat > (180 * 1000000) || dlat < 0 ) {
	alert(' Degrees Latitude must be in the range of 0 to 180. ');
	$j("#lat-degree").val('');
	return false;
}

var mlat  = Math.abs(Math.round($j("#lat-minute").val()  * 1000000.)/1000000);
mlat = Math.abs(Math.round(mlat * 1000000.));
if (mlat >= (60 * 1000000) ) {
	alert(' Minutes Latitude must be in the range of 0 to 59. ');
	$j("#lat-minute").val('');
	return false;
}

var slat  = Math.abs(Math.round($j("#lat-second").val()  * 1000000.)/1000000);
slat = Math.abs(Math.round(slat * 1000000.));
if (slat >= (59.99999999 * 1000000) ) {
	alert(' Seconds Latitude must be in the range of 0 to 59. ');
	$j("#lat-second").val('');
	return false;
}

var lat = Math.round(dlat + (mlat/60) + (slat/3600) ) * $j("#lat-sign").val()/1000000;
$j("#latitude").val(lat);
}
</script>

<div id="shollupage" class="wrap">
	<h2>WP Shollu Parameter Settings</h2>
<?php
if ($_POST["shollu_submit"]){
	$_POST["location"]=strip_tags(stripslashes($_POST['location']));
	update_option('shollu_location',$_POST["location"]);
	$_POST["longitude"]=strip_tags(stripslashes($_POST['longitude']));
	update_option('shollu_longitude',$_POST["longitude"]);
	$_POST["latitude"]=strip_tags(stripslashes($_POST['latitude']));
	update_option('shollu_latitude',$_POST["latitude"]);
	$_POST["timezone"]=strip_tags(stripslashes($_POST['timezone']));
	update_option('shollu_timezone',$_POST["timezone"]);
	$_POST["method"]=strip_tags(stripslashes($_POST['method']));
	update_option('shollu_method',$_POST["method"]);
	$_POST["madzhab"]=strip_tags(stripslashes($_POST['madzhab']));
	update_option('shollu_madzhab',$_POST["madzhab"]);
	echo '<br/><div id="message" class="updated fade" align="center"><p>Shollu Settings Updated!</p></div>';
}
$soptions = shollu_get_options();
?>	
<form action="" method="post" id="shollu-settings">
      <table width="100%" border="0" class="form-table">
        <tr>
          <th scope="row">Location</th>
          <td><input name="location" type="text" id="location" size="15" value="<?php echo $soptions["location"]; ?>"/> 
          your city name, e.g. : Surabaya</td>
        </tr>
        <tr>
          <th scope="row">Longitude</th> 
          <td><input name="longitude" type="text" id="longitude" size="15" value="<?php echo $soptions["longitude"]; ?>" /> 
		  <a href="javascript:;" onclick="calclon();"><img alt="Convert Degrees Minutes to Decimal Format" title="Convert Degrees Minutes to Decimal Format" src="<? echo $plugin_url; ?>/left.png" border="0" align="absmiddle" /></a> 
 <input title="Longitude Degrees" name="lon-degree" type="text" id="lon-degree" size="15" />
 &deg; 
  <input title="Longitude Minutes" name="lon-minute" type="text" id="lon-minute" size="15" />
  ' 
  <input title="Longitude Seconds" name="lon-second" type="text" id="lon-second" size="15" />
  &quot;
  <select name="lon-sign" id="lon-sign">
    <option value="-1">W</option>
    <option value="1">E</option>
  </select>
        <br/>  in Decimal format, not in Degrees Minute, e.g. : -7.98333 (not 7&deg; 59' S)</td>
        </tr>
        <tr>
          <th scope="row">Latitude</th>
          <td><input name="latitude" type="text" id="latitude" size="15" value="<?php echo $soptions["latitude"]; ?>" />
		  <a href="javascript:;" onclick="calclat();"><img title="Convert Degrees Minutes to Decimal Format" alt="Convert Degrees Minutes to Decimal Format" src="<? echo $plugin_url; ?>/left.png" border="0" align="absmiddle" /></a> 
  <input title="Latitude Degrees" name="lat-degree" type="text" id="lat-degree" size="15" />
&deg;
  <input title="Latitude Minutes" name="lat-minute" type="text" id="lat-minute" size="15" />
  ' 
  <input title="Latitude Second" name="lat-second" type="text" id="lat-second" size="15" />
  &quot; 
  <select name="lat-sign" id="lat-sign">
    <option value="-1">S</option>
    <option value="1">N</option>
            </select>
        <br/>  in Decimal format, not in Degrees Minute, e.g. : 112.75 (not 112&deg; 45' E)</td>
        </tr>
        <tr>
          <th scope="row">Time Zone</th>
          <td><select name="timezone" id="timezone">
<?php
		for ($i=-12;$i<=12;$i++) {
			echo '<option value="'.$i.'"';
			if ($soptions["timezone"]==$i) echo ' selected="selected "';
			echo '>'.$i.'</option>';
		}
?>
            </select> 
          still need explanation, huh? :P</td>
        </tr>
        <tr>
          <th scope="row">Method</th>
          <td><select name="method" id="method">
            <option <?php if ($soptions["method"]==1) echo 'selected="selected"'; ?> value="1">University of Islamic Sciences, Karachi</option>
            <option <?php if ($soptions["method"]==2) echo 'selected="selected"'; ?> value="2">Islamic Society of North America</option>
            <option <?php if ($soptions["method"]==3) echo 'selected="selected"'; ?> value="3">World Islamic League</option>
            <option <?php if ($soptions["method"]==4) echo 'selected="selected"'; ?> value="4">Egyptian General Organization of Surveying</option>
          </select>           
            conventions for the calculation of Shubh and Isya' *) select what you believe/follow</td>
        </tr>
        <tr>
          <th scope="row">Madzhab</th>
          <td><select name="madzhab" id="madzhab">
            <option <?php if ($soptions["madzhab"]==1) echo 'selected="selected"'; ?> value="1">Syafi'i</option>
            <option <?php if ($soptions["madzhab"]==2) echo 'selected="selected"'; ?> value="2">Hanafi</option>
          </select> 
          calculation of Ashr time according Syafi'i &amp; Hanafi **) select what you believe/follow</td>
        </tr>
      </table>
		<p>*) Several conventions for the calculation of Shubh (Fajr) and Isya' are already in use in various countries. Shubh and Isya' times are usually calculated using fixed twilight angles as discussed above but some countries also use a method involving adding/subtracting a fixed interval of time to sunset/sunrise respectively . Using the latter method, a time interval is subtracted from sunrise to obtain Shubh whilst the interval is added to sunset to obtain Isya'. The methods used by some Islamic organizations are are summarized in the following table:<br />
    </p>       
        <table width="400" border="1" cellpadding="1" cellspacing="0" bordercolor="#333333">
          <tr>
            <th align="left" bgcolor="#CCCCCC" scope="row">Organization</th>
            <td bgcolor="#CCCCCC">Fajr</td>
            <td bgcolor="#CCCCCC">Isya'</td>
          </tr>
          <tr>
            <th align="left" scope="row">University of Islamic Sciences, Karachi</th>
            <td>18&deg;</td>
            <td>18&deg;</td>
          </tr>
          <tr>
            <th align="left" scope="row">Islamic Society of North America (ISNA)</th>
            <td>15&deg;</td>
            <td>15&deg;</td>
          </tr>
          <tr>
            <th align="left" scope="row">World Islamic League</th>
            <td>18&deg;</td>
            <td>17&deg;</td>
          </tr>
          <tr>
            <th align="left" scope="row">Egyptian General Organization of Surveying</th>
            <td>19.5&deg;</td>
            <td>17.5&deg;</td>
          </tr>
        </table>
        <p><br />
        **) The timing of Ashr depends on the length of the shadow cast by an object. According to the Syafi'i Madzhab, Ashr begins when the length of the shadow of an object exceeds the length of the object. According to the Hanafi Madzhab, Ashr begins when the length of the shadow exceeds TWICE the length of the object. In both cases, the minimum length of shadow (which occurs when the sun passes the meridian) is subtracted from the length of the shadow before comparing it with the length of the object. </p>
<p class="submit">
			<input type="hidden" id="shollu_submit" name="shollu_submit" value="1" />
			<input name="Submit" value="Update Settings" type="submit" />
		</p>
		</form>
</div>
