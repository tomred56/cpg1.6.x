<?php
/*************************
  Coppermine Photo Gallery
  ************************
  Copyright (c) 2003-2016 Coppermine Dev Team
  v1.0 originally written by Gregory Demar

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 3
  as published by the Free Software Foundation.

  ********************************************
  Coppermine version: 1.6.03
  $HeadURL$
**********************************************/

/**
* This file gets included in index.php if you set the option on the configuration panel: "content of the main page".
* It can be used to display any content from any program, it is to be edited according to one's tastes.
*/

if (!defined('IN_COPPERMINE')) {
    die('Not in Coppermine...');
}
	
       $result = cpg_db_query("SELECT user4 FROM {$CONFIG['TABLE_PICTURES']} AS p WHERE keywords like '%Jewellery%' and user4 <> '' ");
	   $count = ['F' => 1, 'J' => 1];
	   foreach ($result->fetchAssoc() as $row) {
		   $key = substr($row['user4'],0,1);
		   $val = intval(substr($row['user4'],1));
		   $count[$key] = max($count[$key],$val + 1);
	   }
       $result = cpg_db_query("SELECT pid,title,user3,user4 FROM {$CONFIG['TABLE_PICTURES']} AS p WHERE keywords like '%Jewellery%'");
       $message = array();
	   $msgcnt = 0;
		starttable("100%", $lang_index_php['welcome']);
		/*
		echo <<<EOT
			<tr>
				<td class="tableb">
					Here is text in the "anycontent" block.<br />
					Edit the file "anycontent.php" in your Coppermine folder to change what is shown here.<br />
					To show this block on your gallery, go to the configuration panel under "Album List View", then "content of the main page".
				</td>
			</tr>

		EOT;
		*/
	    while ( ($row = $result->fetchAssoc()) ) {
		   $wpid =$row['pid'];
		   $wtitle =$row['title'];
		   $wuser3 = $row['user3'];
		   $wuser4 =$row['user4'];
		   if ($wuser3 == '' or substr($wuser3,0,1) =='/') {
			   echo "Picture $wpid $wtitle has no owner: $wuser3. Reference cannot be set: $wuser4";
			   continue;
		   }
		   elseif (!array_key_exists(strtoupper(substr($wuser3,0,1)),$count) {
			   $count[strtoupper(substr($wuser3,0,1))] = 1;
		   }
		   $basetitle = str_ireplace("'","\\'",trim(rtrim(trim($wtitle), ' 0123456789')));
		   $testtitle = '%' . $basetitle . '%';
		   $who = substr($wuser3,0,1);
		   $testwho = $who . '%';
		   if ($wuser4 == '') {
			 $exists = cpg_db_query("SELECT user4 FROM {$CONFIG['TABLE_PICTURES']} AS p WHERE keywords like '%Jewellery%' and title like '$testtitle' and user3 like '$testwho' and user4 <> '' LIMIT 1 ");
			 if ($exists->numRows() > 0) {
				 $existing = $exists->fetchAssoc();
				 $unique = $existing['user4'];
			 }
			 else {
				 $number = substr('0000' . $count[$who], -4);
				 $unique = $who . $number;
				 $count[substr($who)] += 1;
			 }
			 $dups = cpg_db_query("UPDATE {$CONFIG['TABLE_PICTURES']} AS p set user4 = '$unique' WHERE keywords like '%Jewellery%' and title like '$testtitle' and user3 like '$testwho'");
//				 echo  $dups->numRows() . ' rows changed for ' . $testtitle . '<br />';
//				 foreach (array_keys($row) as $key) {
//					 $val = $row[$key];
//				    echo " $key  $val <br />";
//				 }
			 $title =$row['title'];
			 $user3 = $row['user3'];
			 echo " $title $user3 $testtitle $unique <br />";
			 $exists->free();
		   }
		}
		reset($result);
		endtable();
       $result->free();



//EOF