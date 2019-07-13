<?php

// General appearance
$CONFIG['main_page_layout'] = 'breadcrumb/catlist/alblist';
$CONFIG['main_table_width'] = '100%';
$CONFIG['picture_table_width'] = '100%';
$CONFIG['debug_mode'] = 0;

// Category / Album list view
$CONFIG['albums_per_page'] *= $CONFIG['album_list_cols'];
$CONFIG['album_list_cols'] = 1;
$CONFIG['subcat_level'] = 1;
$CONFIG['first_level'] = 0;

// Thumbnail view
$CONFIG['thumbrows'] *= $CONFIG['thumbcols'];
$CONFIG['thumbcols'] = 1;
$CONFIG['max_tabs'] = 5;
$CONFIG['tabs_dropdown'] = 0;

// Image view
$CONFIG['display_film_strip'] = 0;
$CONFIG['display_pic_info'] = 0;

// HTML template for sys_menu
$template_sys_menu = <<<EOT
	<optgroup label="----------">
		{BUTTONS}
	</optgroup>
EOT;


// HTML template for template sys_menu buttons
$template_sys_menu_button = <<<EOT
	<!-- BEGIN {BLOCK_ID} -->
		<option value="{HREF_TGT}">{HREF_LNK}</option>
	<!-- END {BLOCK_ID} -->
EOT;


// HTML template for gallery admin menu
$template_gallery_admin_menu = <<<EOT
	<optgroup label="----------">
		<!-- BEGIN admin_approval -->
			<option value="editpics.php?mode=upload_approval">{UPL_APP_LNK}</option>
		<!-- END admin_approval -->
		<!-- BEGIN config -->
			<option value="admin.php">{ADMIN_LNK}</option>
		<!-- END config -->
		<!-- BEGIN catmgr -->
			<option value="catmgr.php">{CATEGORIES_LNK}</option>
		<!-- END catmgr -->
		<!-- BEGIN albmgr -->
			<option value="albmgr.php{CATL}">{ALBUMS_LNK}</option>
		<!-- END albmgr -->
		<!-- BEGIN picmgr -->
			<option value="picmgr.php">{PICTURES_LNK}</option>
		<!-- end picmgr -->
		<!-- BEGIN groupmgr -->
			<option value="groupmgr.php">{GROUPS_LNK}</option>
		<!-- END groupmgr -->
		<!-- BEGIN usermgr -->
			<option value="usermgr.php">{USERS_LNK}</option>
		<!-- END usermgr -->
		<!-- BEGIN banmgr -->
			<option value="banning.php">{BAN_LNK}</option>
		<!-- END banmgr -->
		<!-- BEGIN admin_profile -->
			<option value="profile.php?op=edit_profile">{MY_PROF_LNK}</option>
		<!-- END admin_profile -->
		<!-- BEGIN review_comments -->
			<option value="reviewcom.php">{COMMENTS_LNK}</option>
		<!-- END review_comments -->
		<!-- BEGIN log_ecards -->
			<option value="db_ecard.php">{DB_ECARD_LNK}</option>
		<!-- END log_ecards -->
		<!-- BEGIN batch_add -->
			<option value="searchnew.php">{SEARCHNEW_LNK}</option>
		<!-- END batch_add -->
		<!-- BEGIN admin_tools -->
			<option value="util.php?t={TIME_STAMP}#admin_tools">{UTIL_LNK}</option>
		<!-- END admin_tools -->
		<!-- BEGIN keyword_manager -->
			<option value="keywordmgr.php">{KEYWORDMGR_LNK}</option>
		<!-- END keyword_manager -->
		<!-- BEGIN exif_manager -->
			<option value="exifmgr.php">{EXIFMGR_LNK}</option>
		<!-- END exif_manager -->
		<!-- BEGIN plugin_manager -->
			<option value="pluginmgr.php">{PLUGINMGR_LNK}</option>
		<!-- END plugin_manager -->
		<!-- BEGIN bridge_manager -->
			<option value="bridgemgr.php">{BRIDGEMGR_LNK}</option>
		<!-- END bridge_manager -->
		<!-- BEGIN view_log_files -->
			<option value="viewlog.php">{VIEW_LOG_FILES_LNK}</option>
		<!-- END view_log_files -->
		<!-- BEGIN overall_stats -->
			<option value="stat_details.php?type=hits&amp;sort=sdate&amp;dir=&amp;sdate=1&amp;ip=1&amp;search_phrase=0&amp;referer=0&amp;browser=1&amp;os=1&amp;mode=fullscreen&amp;page=1&amp;amount=50">{OVERALL_STATS_LNK}</option>
		<!-- END overall_stats -->
		<!-- BEGIN check_versions -->
			<option value="versioncheck.php">{CHECK_VERSIONS_LNK}</option>
		<!-- END check_versions -->
		<!-- BEGIN update_database -->
			<option value="update.php">{UPDATE_DATABASE_LNK}</option>
		<!-- END update_database -->
		<!-- BEGIN php_info -->
			<option value="phpinfo.php">{PHPINFO_LNK}</option>
		<!-- END php_info -->
		<!-- BEGIN show_news -->
			<option value="mode.php?what=news&amp;referer=$REFERER">{SHOWNEWS_LNK}</option>
		<!-- END show_news -->
		<!-- BEGIN documentation -->
			<option value="{DOCUMENTATION_HREF}">{DOCUMENTATION_LNK}</option>
		<!-- END documentation -->
	</optgroup>
EOT;


// HTML template for user admin menu
$template_user_admin_menu = <<<EOT
	<optgroup label="----------">
		<option value="albmgr.php">{ALBMGR_LNK}</option>
		<option value="modifyalb.php">{MODIFYALB_LNK}</option>
		<option value="profile.php?op=edit_profile">{MY_PROF_LNK}</option>
		<option value="picmgr.php">{PICTURES_LNK}</option>
	</optgroup>
EOT;


function pageheader($section, $meta = '')
{
	global $CONFIG, $THEME_DIR;
	global $template_header, $lang_charset, $lang_text_dir;

	$custom_header = cpg_get_custom_include($CONFIG['custom_header_path']);

	$charset = ($CONFIG['charset'] == 'language file') ? $lang_charset : $CONFIG['charset'];

	header('P3P: CP="CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE"');
	header("Content-Type: text/html; charset=$charset");
	user_save_profile();

	$template_vars = array(
		'{LANG_DIR}' => $lang_text_dir,
		'{TITLE}' => theme_page_title($section),
		'{CHARSET}' => $charset,
		'{META}' => $meta,
		'{GAL_NAME}' => $CONFIG['gallery_name'],
		'{GAL_DESCRIPTION}' => $CONFIG['gallery_description'],
		'{SYS_MENU}' => theme_main_menu('sys_menu'),
		'{SUB_MENU}' => theme_main_menu('sub_menu'),
		'{ADMIN_MENU}' => theme_admin_mode_menu(),
		'{CUSTOM_HEADER}' => $custom_header,
		'{JAVASCRIPT}' => theme_javascript_head(),
		'{MESSAGE_BLOCK}' => theme_display_message_block(),
	);

	global $lang_create_tabs;
	$template_vars['{JUMP_TO_PAGE}'] = $lang_create_tabs['jump_to_page'];

	$template_vars = CPGPluginAPI::filter('theme_pageheader_params', $template_vars);
	echo template_eval($template_header, $template_vars);

	// Show various admin messages
	adminmessages();
}


/** modifications for adding comments */

$template_add_your_comment = <<<EOT
	<form method="post" name="post" id="post" onsubmit="return notDefaultUsername(this, '{DEFAULT_USERNAME}', '{DEFAULT_USERNAME_MESSAGE}');" action="db_input.php">
		<table align="center" width="{WIDTH}" cellspacing="1" cellpadding="0" class="maintable">
			<tr>
				<td width="100%" class="tableh2">{ADD_YOUR_COMMENT}{HELP_ICON}</td>
			</tr>
			<tr>
				<td colspan="1">
					<table width="100%" cellpadding="0" cellspacing="0">
<!-- BEGIN user_name_input -->
						<tr>
							<td class="tableb tableb_alternate">{NAME}</td>
							<td colspan="2" class="tableb tableb_alternate">
								<input type="text" class="textinput" name="msg_author" size="16" maxlength="20" value="" placeholder="{USER_NAME}" />
							</td>
						</tr>
<!-- END user_name_input -->
<!-- BEGIN input_box_smilies -->
						<tr>
							<td class="tableb tableb_alternate">{COMMENT}</td>
							<td width="100%" class="tableb tableb_alternate">
								<input type="text" class="textinput" id="message" name="msg_body" onselect="storeCaret_post(this);" onclick="storeCaret_post(this);" onkeyup="storeCaret_post(this);" maxlength="{MAX_COM_LENGTH}" style="width: 100%;" />
							</td>
<!-- END input_box_smilies -->
<!-- BEGIN input_box_no_smilies -->
						<tr>
							<td class="tableb tableb_alternate">{COMMENT}</td>
							<td width="100%" class="tableb tableb_alternate">
								<input type="text" class="textinput" id="message" name="msg_body"  maxlength="{MAX_COM_LENGTH}" style="width: 100%;" />
							</td>
<!-- END input_box_no_smilies -->
						</tr>
<!-- BEGIN comment_captcha -->
						<tr>
							<td class="tableb tableb_alternate">{CONFIRM}</td>
							<td class="tableb tableb_alternate">
								<input type="text" name="confirmCode" size="5" maxlength="5" class="textinput" />
								<img src="captcha.php" align="middle" border="0" alt="" />
							</td>
						</tr>
<!-- END comment_captcha -->
<!-- BEGIN submit -->
						<tr>
							<td colspan="2" class="tableb tableb_alternate">
							<input type="hidden" name="event" value="comment" />
							<input type="hidden" name="pid" value="{PIC_ID}" />
							<button type="submit" class="button" name="submit" value="{OK}">{OK_ICON}{OK}</button>
							<input type="hidden" name="form_token" value="{FORM_TOKEN}" />
							<input type="hidden" name="timestamp" value="{TIMESTAMP}" />
							</td>
						</tr>
<!-- END submit -->
					</table>
				</td>
			</tr>
<!-- BEGIN smilies -->
			<tr>
				<td width="100%" class="tableb tableb_alternate">{SMILIES}</td>
			</tr>
<!-- END smilies -->
<!-- BEGIN login_to_comment -->
			<tr>
				<td class="tableb tableb_alternate" colspan="2">{LOGIN_TO_COMMENT}</td>
			</tr>
<!-- END login_to_comment -->
		</table>
	</form>
EOT;

function theme_generate_smilies ($smilies, $form)
{
	global $THEME_DIR;
	$paths = array($THEME_DIR.'smiles/', 'images/smiles/');

	$html = '';

	foreach ($smilies as $smiley) {
		$smile_path = file_exists($paths[0].$smiley[1]) ? $paths[0] : $paths[1];
		$caption = $smiley[2] . ' ' . $smiley[0];
		if (file_exists($smile_path . $smiley[1]) == TRUE) {
			$html .= '<img src="' . $smile_path . $smiley[1] . '" alt="' . $caption . '" class="cmntsmly" title="' . $caption . '" onclick="javascript:emot' . $form . '(\'' . $smiley[0] . '\')" />';
		}
	}

	return $html;
}

