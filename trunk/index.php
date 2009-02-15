<?php
/* 
	$Id$ 
  
  	my-munin - a customizeable dashboard for your munin installation (my-munin.org)
	Copyright (C) 2009 Christian Becker (christian@my-munin.org)
	
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

include("inc/config.php");
include("inc/functions.php");
global $smarty;

function getSelectedProfile() {
	if (is_numeric($_COOKIE["profileID"]))
	{
		return $_COOKIE["profileID"];
	} else {
		return 1;
	}
}

$selectedProfile = getSelectedProfile();
$config["urlseparator"] = "/";
$config["graphseparator"] = "-";
$config["graphextension"] = ".png";


$smarty->assign("title", "MyMunin - Overview");
$smarty->assign("config", $config);
$smarty->assign("availableProfiles", getAvailableProfiles());
$smarty->assign("selectedProfile", getProfile( $selectedProfile ));
$smarty->assign("graphs", getGraphs( $selectedProfile ));

$smarty->display("index.tpl");

