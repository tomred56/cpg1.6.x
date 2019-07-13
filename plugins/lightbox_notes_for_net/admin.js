/*******************************************************
/*******************************************************
  Coppermine 1.5.x Plugin - LightBox (NotesFor.net)
  ******************************************************
  Copyright (c) 2009-2011 Joe Carver and Helori Lamberty
  ******************************************************
 
  *****************************************************/
  /*******************************************************
			Version 3.2 - 07 November 2011
  *******************************************************/
  
$(document).ready(function() {
	$('#plugin_lightbox_nfn_sizespeed').SpinButton({min: 0,max: 2000, step: 20});
	$('#plugin_lightbox_nfn_border').SpinButton({min: 1,max: 99});
	$('#plugin_lightbox_nfn_maxpics').SpinButton({min: 1,max: 3000});
	$('#plugin_lightbox_nfn_slidetime').SpinButton({min: 1000,max: 999990, step: 50});	
	$('#plugin_lightbox_nfn_imagefade').SpinButton({min: 0,max: 2000, step: 20});
	$('#plugin_lightbox_nfn_containerfade').SpinButton({min: 0,max: 2000, step: 20});	
	$('#plugin_lightbox_nfn_toptrim').SpinButton({min: 0,max: 90, step: 1});
	
});