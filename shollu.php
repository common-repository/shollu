<?php
/*
Plugin Name: Shollu
Plugin Script: shollu.php
Plugin URI: http://fich.web.id/2008/11/09/shollu-wordpress-plugin/
Description: Plugin to show shollu (pray) times based on your location
Version: 0.1
License: GPL
Author: fich
Author URI: http://fich.web.id

=== RELEASE NOTES ===
2008-11-09 - v1.0 - first version
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Online: http://www.gnu.org/licenses/gpl.txt
*/


function shollu_add_options() {
add_option('shollu_w_title', 'Shollu Options');
add_option('shollu_w_link', 'Shollu Options');
add_option('shollu_location', 'Shollu Options');
add_option('shollu_longitude', 'Shollu Options');
add_option('shollu_latitude', 'Shollu Options');
add_option('shollu_timezone', 'Shollu Options');
add_option('shollu_method', 'Shollu Options');
add_option('shollu_madzhab', 'Shollu Options');
add_option('shollu_style', 'Shollu Options');
}

shollu_add_options();

function shollu_get_options() {
$sholluoptions["title"]=get_option('shollu_w_title');
$sholluoptions["backlink"]=get_option('shollu_w_link');
$sholluoptions["location"]=get_option('shollu_location');
$sholluoptions["longitude"]=get_option('shollu_longitude');
$sholluoptions["latitude"]=get_option('shollu_latitude');
$sholluoptions["timezone"]=get_option('shollu_timezone');
$sholluoptions["method"]=get_option('shollu_method');
$sholluoptions["madzhab"]=get_option('shollu_madzhab');
$sholluoptions["style"]=get_option('shollu_style');
if (empty($sholluoptions["title"])) {
	$sholluoptions["title"]="Shollu Times";
	update_option('shollu_w_title',$sholluoptions["title"]);
}
if (empty($sholluoptions["backlink"])) {
	$sholluoptions["backlink"]="1";
	update_option('shollu_w_link',$sholluoptions["backlink"]);
}
if (empty($sholluoptions["location"])) {
	$sholluoptions["location"]="Surabaya";
	update_option('shollu_location',$sholluoptions["location"]);
}
if (empty($sholluoptions["longitude"])) {
	$sholluoptions["longitude"]="112.7508";
	update_option('shollu_longitude',$sholluoptions["longitude"]);
}
if (empty($sholluoptions["latitude"])) {
	$sholluoptions["latitude"]="-7.2492";
	update_option('shollu_latitude',$sholluoptions["latitude"]);
}
if (empty($sholluoptions["timezone"])) {
	$sholluoptions["timezone"]="7";
	update_option('shollu_timezone',$sholluoptions["timezone"]);
}
if (empty($sholluoptions["method"])) {
	$sholluoptions["method"]="3";
	update_option('shollu_method',$sholluoptions["method"]);
}
if (empty($sholluoptions["madzhab"])) {
	$sholluoptions["madzhab"]="2";
	update_option('shollu_madzhab',$sholluoptions["madzhab"]);
}
if (empty($sholluoptions["style"])) {
	$sholluoptions["style"]="0";
	update_option('shollu_style',$sholluoptions["style"]);
}
return $sholluoptions;
}


function shollu_showhtml($args) {
	$title=get_option('shollu_w_title');
	if (empty($title)) $title='Shollu Times';
	extract($args);
	echo $before_widget;
	echo $before_title.$title.$after_title;	
	include('shollu_count.php');
	echo $after_widget;
}

function shollu_admin(){
	include("shollu_admin.php");
}

function shollu_widget_control(){
	$soptions = shollu_get_options();
	$title=$soptions["title"];
	$backlink=$soptions["backlink"];
	$style=$soptions["style"];
	if ( $_POST["shollu_submit"] ) {
		$title=strip_tags( stripslashes( $_POST["shollu_widget_title"] ) );
		update_option('shollu_w_title', $title);
		$backlink=strip_tags(stripslashes($_POST['shollu_widget_link']));
		update_option('shollu_w_link', $backlink);
		$style=strip_tags(stripslashes($_POST['shollu_widget_style']));
		update_option('shollu_style', $style);

	}
	
	
?>
	<p>
	<label for="shollu_widget_title">Title:<br/><input class="widefat"  size="20" name="shollu_widget_title" type="text" value="<?php echo $title; ?>" />		
	</label><br /><br/>
	<label for="shollu_widget_style">Style:<br/>
	<select name="shollu_widget_style" id="shollu_widget_style">
            <option <?php if ($soptions["style"]==0) echo 'selected="selected"'; ?> value="0">Black</option>
            <option <?php if ($soptions["style"]==1) echo 'selected="selected"'; ?> value="1">White</option>
			<option <?php if ($soptions["style"]==2) echo 'selected="selected"'; ?> value="2">Blue</option>
			<option <?php if ($soptions["style"]==3) echo 'selected="selected"'; ?> value="3">Green</option>
          </select>
	</label><br /><br/>
	<input name="shollu_widget_link" type="checkbox" <?php echo ($backlink=='on')?'checked="checked"':''; ?> /> Show backlink<br/>
	</p>
	<input type="hidden" id="shollu_submit" name="shollu_submit" value="1" />
<?php
}

function admin_actions(){
    add_options_page("Shollu Settings", "Shollu Settings", 1,"Shollu", "shollu_admin");
}

function shollu_init()
{
  register_sidebar_widget(__('Shollu Widget'), 'shollu_showhtml');
  register_widget_control('Shollu Widget', 'shollu_widget_control');
}
add_action('admin_menu', 'admin_actions');
add_action("plugins_loaded", "shollu_init");
?>