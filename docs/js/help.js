/*************************
  Coppermine Photo Gallery
  ************************
  Copyright (c) 2003-2017 Coppermine Dev Team
  v1.0 originally written by Gregory Demar

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 3
  as published by the Free Software Foundation.

  ********************************************
  Coppermine version: 1.5.46
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.5.x/docs/js/help.js $
  $Revision: 8873 $

  $Date: 2017-02-15 13:54:29 +0100 (Mi, 15 Feb 2017) $
**********************************************/

$(document).ready(function()
{
	$('#toc').replaceWith('');
	$('#docheader').replaceWith('');
	$('#doc_footer').replaceWith('');
});

$(function() {
    $(".cpg_zebra tr:even").addClass("tableb");
	$(".cpg_zebra tr:odd").addClass("tableb_alternate");
});