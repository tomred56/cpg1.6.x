<?php
/*******************************************************
  Coppermine 1.5.x Plugin - LightBox (NotesFor.net)
  ******************************************************
  Copyright (c) 2009-2011 Joe Carver and Helori Lamberty
  ******************************************************
 
  *****************************************************/
  /*******************************************************
			Version 3.2 - 07 November 2011
  *******************************************************/
  
if (!defined('IN_COPPERMINE')) { 
    die('Not in Coppermine...');
}

// Define the default language array (English)
require_once ("./plugins/lightbox_notes_for_net/lang/english.php");
// submit your lang file for this plugin on the coppermine forums
// plugin will try to use the configured language if it is available.
if (file_exists("./plugins/lightbox_notes_for_net/lang/{$CONFIG['lang']}.php")) {
    require_once ("./plugins/lightbox_notes_for_net/lang/{$CONFIG['lang']}.php");
} 

// Determine the help file link
if (file_exists("./plugins/lightbox_notes_for_net/docs/{$CONFIG['lang']}.htm")) {
    $documentation_file = $CONFIG['lang'];
} else {
    $documentation_file = 'english';
}

$lightbox_notes_for_net_icon_array['ok'] = cpg_fetch_icon('ok', 0);
$lightbox_notes_for_net_icon_array['announcement'] = cpg_fetch_icon('announcement', 1);
$lightbox_notes_for_net_icon_array['documentation'] = cpg_fetch_icon('documentation', 1);
$lightbox_notes_for_net_icon_array['configure'] = cpg_fetch_icon('config', 1)
?>