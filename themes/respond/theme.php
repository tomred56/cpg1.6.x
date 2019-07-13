<?php

$ThemeBanner = '
	<div class="row" style="position:relative">
		<div id="h5banner"><img src="'.$THEME_DIR.'images/banners/banner5.jpg" alt="" style="width:100%"></div>
		<div id="h5gal-name" class="col-xs-6">
			<a class="navbar-brand" href="index.php"><h2>{GAL_NAME}</h2></a>
		</div>
		<div id="h5gal-desc" class="col-xs-6 gal_desc">
			<span>{GAL_DESCRIPTION}</span>
		</div>
	</div>
';
$ThemeBanner2 = '
	<div class="row">
		<div id="h5gal-name2" class="cols-6">
			<a class="navbar-brand" href="index.php"><h2>{GAL_NAME}</h2></a>
		</div>
		<div id="h5gal-desc2" class="cols-6 gal_desc">
			<span>{GAL_DESCRIPTION}</span>
		</div>
	</div>
';
$BannerHomeOnly = true;

if (file_exists('config.php')) include 'config.php';

//define('THEME_HAS_MENU_ICONS',20);

if (false && !defined('ADMIN_PHP')) {
	// General appearance
	$CONFIG['main_page_layout'] = 'breadcrumb/catlist/alblist';
//	$CONFIG['main_table_width'] = '100%';
//	$CONFIG['debug_mode'] = 0;

	// Category/Album list view
//	$CONFIG['albums_per_page'] *= $CONFIG['album_list_cols'];
//	$CONFIG['album_list_cols'] = 1;
	$CONFIG['subcat_level'] = 1;
	$CONFIG['first_level'] = 0;

	// Thumbnail view
//	$CONFIG['max_tabs'] = 5;
//	$CONFIG['tabs_dropdown'] = 0;

	// Image view
	$CONFIG['display_film_strip'] = 0;
//	$CONFIG['display_pic_info'] = 0;

// inhibit icons
//	$CONFIG['enable_menu_icons'] = -1;
}

// special javascript setup for some pages
// sorting, touch/swipe and keyboard
if (defined('THUMBNAILS_PHP')) {
	$JS['vars']['h5r_sort'] = isset($USER['sort']) && $CONFIG['custom_sortorder_thumbs'] ? $USER['sort'] : $CONFIG['default_sort_order'];
	$JS['vars']['tk_nav'] = array('selm'=>'.alg-img-cels','belm'=>'#tt-beg','pelm'=>'#tt-prv','nelm'=>'#tt-nxt','eelm'=>'#tt-end');
}
if (defined('DISPLAYIMAGE_PHP')) {
	$JS['vars']['tk_nav'] = array('selm'=>'.display_media','belm'=>'#di-beg','pelm'=>'#di-prv','nelm'=>'#di-nxt','eelm'=>'#di-end');
}


// Theme language extras
$theme_lang_path = $THEME_DIR.'/lang/';
require $theme_lang_path.'english.php';
if ($CONFIG['lang'] != 'english' && file_exists($theme_lang_path."{$CONFIG['lang']}.php")) {
	require $theme_lang_path."{$CONFIG['lang']}.php";
}

/************************************************************/
/******************** SECTION TEMPLATES *********************/
/************************************************************/

// HTML template for sys_menu
$template_sys_menu = <<<EOT
	{BUTTONS}
EOT;
//	<ul class="nav navbar-nav">
//		{BUTTONS}
//	</ul>
//EOT;


// HTML template for template sys_menu buttons
$template_sys_menu_button = <<<EOT
	<!-- BEGIN {BLOCK_ID} -->
	<li><a href="{HREF_TGT}">{HREF_LNK}</a></li>
	<!-- END {BLOCK_ID} -->
EOT;


// HTML template for gallery admin menu
$template_gallery_admin_menu = <<<EOT
	<!-- BEGIN admin_approval -->
		<li><a href="editpics.php?mode=upload_approval">{UPL_APP_LNK}</a></li>
	<!-- END admin_approval -->
	<!-- BEGIN config -->
		<li><a href="admin.php">{ADMIN_LNK}</a></li>
	<!-- END config -->
	<!-- BEGIN catmgr -->
		<li><a href="catmgr.php">{CATEGORIES_LNK}</a></li>
	<!-- END catmgr -->
	<!-- BEGIN albmgr -->
		<li><a href="albmgr.php{CATL}">{ALBUMS_LNK}</a></li>
	<!-- END albmgr -->
	<!-- BEGIN picmgr -->
		<li><a href="picmgr.php">{PICTURES_LNK}</a></li>
	<!-- end picmgr -->
	<!-- BEGIN groupmgr -->
		<li><a href="groupmgr.php">{GROUPS_LNK}</a></li>
	<!-- END groupmgr -->
	<!-- BEGIN usermgr -->
		<li><a href="usermgr.php">{USERS_LNK}</a></li>
	<!-- END usermgr -->
	<!-- BEGIN banmgr -->
		<li><a href="banning.php">{BAN_LNK}</a></li>
	<!-- END banmgr -->
	<!-- BEGIN admin_profile -->
		<li><a href="profile.php?op=edit_profile">{MY_PROF_LNK}</a></li>
	<!-- END admin_profile -->
	<!-- BEGIN review_comments -->
		<li><a href="reviewcom.php">{COMMENTS_LNK}</a></li>
	<!-- END review_comments -->
	<!-- BEGIN log_ecards -->
		<li><a href="db_ecard.php">{DB_ECARD_LNK}</a></li>
	<!-- END log_ecards -->
	<!-- BEGIN batch_add -->
		<li><a href="searchnew.php">{SEARCHNEW_LNK}</a></li>
	<!-- END batch_add -->
	<!-- BEGIN admin_tools -->
		<li><a href="util.php?t={TIME_STAMP}#admin_tools">{UTIL_LNK}</a></li>
	<!-- END admin_tools -->
	<!-- BEGIN keyword_manager -->
		<li><a href="keywordmgr.php">{KEYWORDMGR_LNK}</a></li>
	<!-- END keyword_manager -->
	<!-- BEGIN exif_manager -->
		<li><a href="exifmgr.php">{EXIFMGR_LNK}</a></li>
	<!-- END exif_manager -->
	<!-- BEGIN plugin_manager -->
		<li><a href="pluginmgr.php">{PLUGINMGR_LNK}</a></li>
	<!-- END plugin_manager -->
	<!-- BEGIN bridge_manager -->
		<li><a href="bridgemgr.php">{BRIDGEMGR_LNK}</a></li>
	<!-- END bridge_manager -->
	<!-- BEGIN view_log_files -->
		<li><a href="viewlog.php">{VIEW_LOG_FILES_LNK}</a></li>
	<!-- END view_log_files -->
	<!-- BEGIN overall_stats -->
		<li><a href="stat_details.php?type=hits&amp;sort=sdate&amp;dir=&amp;sdate=1&amp;ip=1&amp;search_phrase=0&amp;referer=0&amp;browser=1&amp;os=1&amp;mode=fullscreen&amp;page=1&amp;amount=50">{OVERALL_STATS_LNK}</a></li>
	<!-- END overall_stats -->
	<!-- BEGIN check_versions -->
		<li><a href="versioncheck.php">{CHECK_VERSIONS_LNK}</a></li>
	<!-- END check_versions -->
	<!-- BEGIN update_database -->
		<li><a href="update.php">{UPDATE_DATABASE_LNK}</a></li>
	<!-- END update_database -->
	<!-- BEGIN php_info -->
		<li><a href="phpinfo.php">{PHPINFO_LNK}</a></li>
	<!-- END php_info -->
	<!-- BEGIN show_news -->
		<li><a href="mode.php?what=news&amp;referer=$REFERER">{SHOWNEWS_LNK}</a></li>
	<!-- END show_news -->
	<!-- BEGIN documentation -->
		<li><a href="{DOCUMENTATION_HREF}">{DOCUMENTATION_LNK}</a></li>
	<!-- END documentation -->
EOT;


// HTML template for user admin menu
$template_user_admin_menu = <<<EOT
	<li><a href="albmgr.php">{ALBMGR_LNK}</a></li>
	<li><a href="modifyalb.php">{MODIFYALB_LNK}</a></li>
	<li><a href="profile.php?op=edit_profile">{MY_PROF_LNK}</a></li>
	<li><a href="picmgr.php">{PICTURES_LNK}</a></li>
EOT;


// HTML template for the breadcrumb
$template_breadcrumb = <<<EOT
<!-- BEGIN breadcrumb -->
	<div class="crumbs">
		<span class="statlink">{BREADCRUMB}</span>
	</div>
<!-- END breadcrumb -->
<!-- BEGIN breadcrumb_user_gal -->
	<div class="crumbs">
		<div>
			<span class="statlink">{BREADCRUMB}</span>
			<span class="statlink">{STATISTICS}</span>
		</div>
	</div>
<!-- END breadcrumb_user_gal -->
EOT;


// HTML template for category list
$template_cat_list = <<<EOT
<!-- BEGIN header -->
	<div class="catl_row catl_row_h">
		<span class="catl_row_c1">{CATEGORY}</span>
		<span class="catl_row_c2">{ALBUMS}</span>
		<span class="catl_row_c3">{PICTURES}</span>
	</div>
<!-- END header -->
<!-- BEGIN catrow_noalb -->
	<div class="catrow_noalb">
		<div class="catl_row_c1">
			<span>{CAT_THUMB}</span>
			<span class="catlink">{CAT_TITLE}</span>
			<span>{CAT_DESC}</span>
		</div>
		<div class="catl_row_c2">0</div>
		<div class="catl_row_c3">0</div>
		<!-- <table><tr><td>{CAT_THUMB}</td><td><span class="catlink">{CAT_TITLE}</span>{CAT_DESC}</td></tr></table> -->
	</div>
<!-- END catrow_noalb -->
<!-- BEGIN catrow -->
	<div class="catl_row">
		<div class="catl_row_c1">
			<span>{CAT_THUMB}</span>
			<span class="catlink">{CAT_TITLE}</span>
			<span>{CAT_DESC}</span>
		</div>
		<div class="catl_row_c2">{ALB_COUNT}</div>
		<div class="catl_row_c3">{PIC_COUNT}</div>
	</div>
	<div>
		<div class="cat-albums">{CAT_ALBUMS}</div>
	</div>
<!-- END catrow -->
<!-- BEGIN footer -->
	<div class="cat-stats">
		<span class="statlink">{STATISTICS}</span>
	</div>
<!-- END footer -->
EOT;


// HTML template for the album list
$template_album_list = <<<EOT
<!-- BEGIN stat_row -->
	<div class="a-lst-stats"><span class="statlink">{STATISTICS}</span></div>
<!-- END stat_row -->
<!-- BEGIN header -->
	<div class="cat-alb-cels">
<!-- END header -->
<!-- BEGIN album_cell -->
	<div class="album-cell">
		<div class="row alb-cel-ttl">
			<div class="cols-9">
				<span class="alblink"><a href="{ALB_LINK_TGT}">{ALBUM_TITLE}</a></span>
			</div>
			{ADMIN_MENU}
		</div>
		<div class="row alb-cel-etc">
			<div class="a-thm-box">
				<a href="{ALB_LINK_TGT}" class="albums">{ALB_LINK_PIC}</a>
			</div>
			<div class="album_cell_inf">
				<p>{ALB_DESC}</p>
				<p class="album_stat">{ALB_INFOS}<br>{ALB_HITS}</p>
			</div>
		</div>
	</div>
<!-- END album_cell -->
<!-- BEGIN footer -->
	</div>
<!-- END footer -->
<!-- BEGIN tabs -->
	<div class="a-lst-tabs row">
		{TABS}
	</div>
<!-- END tabs -->
EOT;


// HTML template for the album list
$template_album_list_cat = <<<EOT
<!-- BEGIN c_stat_row -->
	<div class="ca-lst-stats"><span class="statlink">{STATISTICS}</span></div>
<!-- END c_stat_row -->
<!-- BEGIN c_header -->
	<div class="catl-alb-cels">
<!-- END c_header -->
<!-- BEGIN c_album_cell -->
	<div class="album-cell">
		<div class="row alb-cel-ttl">
			<div class="cols-9">
				<span class="alblink"><a href="{ALB_LINK_TGT}">{ALBUM_TITLE}</a></span>
			</div>
			{ADMIN_MENU}
		</div>
		<div class="row alb-cel-etc">
			<div class="a-thm-box">
				<a href="{ALB_LINK_TGT}" class="albums">{ALB_LINK_PIC}</a>
			</div>
			<div class="c_album_cell_inf">
				<p>{ALB_DESC}</p>
				<p class="album_stat">{ALB_INFOS}<br>{ALB_HITS}</p>
			</div>
		</div>
	</div>
<!-- END c_album_cell -->
<!-- BEGIN c_footer -->
	</div>
<!-- END c_footer -->
<!-- BEGIN c_tabs -->
	<div class="ca-lst-tabs row">
		{TABS}
	</div>
<!-- END c_tabs -->
EOT;


// HTML template for the ALBUM admin menu displayed in the album list
$template_album_admin_menu = <<<EOT
	<div class="buttonlist-cac cols-6">
		<ul>
			<li>
				<a href="delete.php?id={ALBUM_ID}&amp;what=album&amp;form_token={FORM_TOKEN}&amp;timestamp={TIMESTAMP}" onclick="return confirm('{CONFIRM_DELETE}');"><span>{DELETE}</span></a>
			</li>
			<li>
				<a href="modifyalb.php?album={ALBUM_ID}"><span>{MODIFY}</span></a>
			</li>
			<li>
				<a href="editpics.php?album={ALBUM_ID}"><span class="last">{EDIT_PICS}</span></a>
			</li>
		</ul>
	</div>
EOT;


// HTML template for thumbnail view title
$template_thumb_view_title_row = <<<EOT
	<div class="alb-img-blk row">
		<div class="statlink cols-8 left">
			<h2>{ALBUM_NAME}</h2>
		</div>
		<div class="cols-4 right">
	<!-- BEGIN admin_buttons -->
		<!--	<div class="buttonlist-aa"> -->
				<a href="modifyalb.php?album={ALBUM_ID}" title="{MODIFY_LNK}"><span>{MODIFY_ICO}</span></a>
				<a href="index.php?cat={CAT_ID}" title="{PARENT_CAT_LNK}"><span>{PARENT_CAT_ICO}</span></a>
				<a href="editpics.php?album={ALBUM_ID}" title="{EDIT_PICS_LNK}"><span>{EDIT_PICS_ICO}</span></a>
				<a href="albmgr.php?cat={CAT_ID}" title="{ALBUM_MGR_LNK}"><span class="last">{ALBUM_MGR_ICO}</span></a>
		<!--	</div> -->
	<!-- END admin_buttons -->
		<!--	<div class="sortorder_cell" id="sortorder_cello"> -->
				{SORT_UI}
		<!--	</div> -->
		</div>
	</div>
EOT;
$template_thumb_view_title_rowold = <<<EOT
	<div class="alb-img-blk row">
		<div class="statlink cols-8 left">
			<h2>{ALBUM_NAME}</h2>
		</div>
		<div class="cols-4 right">
	<!-- BEGIN admin_buttons -->
			<div class="buttonlist-a">
				<ul>
					<li><a href="modifyalb.php?album={ALBUM_ID}" title="{MODIFY_LNK}"><span>{MODIFY_ICO}</span></a></li>
					<li><a href="index.php?cat={CAT_ID}" title="{PARENT_CAT_LNK}"><span>{PARENT_CAT_ICO}</span></a></li>
					<li><a href="editpics.php?album={ALBUM_ID}" title="{EDIT_PICS_LNK}"><span>{EDIT_PICS_ICO}</span></a></li>
					<li><a href="albmgr.php?cat={CAT_ID}" title="{ALBUM_MGR_LNK}"><span class="last">{ALBUM_MGR_ICO}</span></a></li>
				</ul>
			</div>
	<!-- END admin_buttons -->
			<div class="sortorder_cell" id="sortorder_cello">
				{SORT_UI}
			</div>
		</div>
	</div>
EOT;


// HTML template for title row of the fav thumbnail view (album title + download)
$template_fav_thumb_view_title_row = <<<EOT
	<div class="alb-img-blk">
		<span class="statlink"><h2>{ALBUM_NAME}</h2></span>
		<span class="sortorder_options statlink"><a href="zipdownload.php">{DOWNLOAD_ZIP}</a></span>
	</div>
EOT;


// HTML template for the thumbnail view when there is no picture to show
$template_no_img_to_display = <<<EOT
	<div class="no-img-thms">
		<span class="cpg_user_message">{TEXT}</span>
	</div>
EOT;


// HTML template for thumbnails display
$template_thumbnail_view = <<<EOT
<!-- BEGIN header -->
	<div class="alb-img-cels">
<!-- END header -->
<!-- BEGIN thumb_cell -->
	<div class="r-thumbnail">
		<div class="thm-frame">
			<a href="{LINK_TGT}">
				<div class="r-thm-box {ORIENT}">{THUMB}</div>
			</a>
		</div>
		{CAPTION}
		{ADMIN_MENU}
	</div>
<!-- END thumb_cell -->
<!-- BEGIN footer -->
	</div>
<!-- END footer -->
<!-- BEGIN tabs -->
	<div class="r-thm-tabs row">
		{TABS}
	</div>
<!-- END tabs -->
EOT;


// HTML template for intermediate image display
$template_display_media = <<<EOT
	<div class="display_media">
		<div style="{SLIDESHOW_STYLE}">
			{IMAGE}
		</div>
	</div>
	<div class="media-etc">
		<div class="media-admin">
			{ADMIN_MENU}
		</div>
<!-- BEGIN img_desc -->
		<div class="media-desc">
<!-- BEGIN title -->
			<div class="media-title">
				<div class="pic_title">{TITLE}</div>
			</div>
<!-- END title -->
<!-- BEGIN caption -->
			<div class="media-caption">
				<div class="pic_caption">{CAPTION}</div>
			</div>
<!-- END caption -->
		</div>
<!-- END img_desc -->
	</div>
EOT;



// HTML template for the image navigation bar
$template_img_navbar = <<<EOT
	<div class="r-nav-bar row">
	  <div class="cols-4 left">
		<span class="inavmenu nav_thumb"><a href="{THUMB_TGT}" class="navmenu_pic" title="{THUMB_TITLE}"><img src="{LOCATION}images/navbar/thumbnails.png" alt="{THUMB_TITLE}" /></a></span>
<!-- BEGIN pic_info_button -->
		<!-- button will be added by displayimage.js -->
		<span id="pic_info_button" class="inavmenu nav_info"></span>
<!-- END pic_info_button -->
<!-- BEGIN slideshow_button -->
		<!-- button will be added by displayimage.js -->
		<span id="slideshow_button" class="inavmenu nav_slide"></span>
<!-- END slideshow_button -->
	  </div>
	  <div class="cols-4 center">
		<span class="inavmenu nav_file">{PIC_POS}</span>
<!-- BEGIN report_file_button -->
		<span class="inavmenu nav_reprt"><a href="{REPORT_TGT}" class="navmenu_pic" title="{REPORT_TITLE}" rel="nofollow"><img src="{LOCATION}images/navbar/report.png" alt="{REPORT_TITLE}" /></a></span>
<!-- END report_file_button -->
<!-- BEGIN ecard_button -->
		<span class="inavmenu nav_ecard"><a href="{ECARD_TGT}" class="navmenu_pic" title="{ECARD_TITLE}" rel="nofollow"><img src="{LOCATION}images/navbar/ecard.png" alt="{ECARD_TITLE}" /></a></span>
<!-- END ecard_button -->
	  </div>
	  <div class="cols-4 right">
<!-- BEGIN nav_start -->
		<span class="inavmenu nav_start"><a href="{START_TGT}" id="di-beg" class="navmenu_pic" title="{START_TITLE}"><img src="{LOCATION}images/navbar/{START_IMAGE}" alt="{START_TITLE}" /></a></span>
<!-- END nav_start -->
<!-- BEGIN nav_prev -->
		<span class="inavmenu nav_prev"><a href="{PREV_TGT}" id="di-prv" class="navmenu_pic" title="{PREV_TITLE}"><img src="{LOCATION}images/navbar/{PREV_IMAGE}" alt="{PREV_TITLE}" /></a></span>
<!-- END nav_prev -->
<!-- BEGIN nav_next -->
		<span class="inavmenu nav_next"><a href="{NEXT_TGT}" id="di-nxt" class="navmenu_pic" title="{NEXT_TITLE}"><img src="{LOCATION}images/navbar/{NEXT_IMAGE}" alt="{NEXT_TITLE}" /></a></span>
<!-- END nav_next -->
<!-- BEGIN nav_end -->
		<span class="inavmenu nav_end"><a href="{END_TGT}" id="di-end" class="navmenu_pic" title="{END_TITLE}"><img src="{LOCATION}images/navbar/{END_IMAGE}" alt="{END_TITLE}" /></a></span>
<!-- END nav_end -->
	  </div>
	</div>
EOT;


/*
// HTML template for the image navigation bar
$template_img_navbar = <<<EOT
<div class="r-nav-bar"><table><tr>
	<td class="navmenu navb"><a href="{THUMB_TGT}" class="navmenu_pic" title="{THUMB_TITLE}"><img src="{LOCATION}images/navbar/thumbnails.png" alt="{THUMB_TITLE}" /></a></td>
<!-- BEGIN pic_info_button -->
	<!-- button will be added by displayimage.js -->
	<td id="pic_info_button" class="navmenu navb navmenu_pic"></td>
<!-- END pic_info_button -->
<!-- BEGIN slideshow_button -->
	<!-- button will be added by displayimage.js -->
	<td id="slideshow_button" class="navmenu navb navmenu_pic"></td>
<!-- END slideshow_button -->
	<td class="navmenu">{PIC_POS}</td>
<!-- BEGIN report_file_button -->
	<td class="navmenu navb"><a href="{REPORT_TGT}" class="navmenu_pic" title="{REPORT_TITLE}" rel="nofollow"><img src="{LOCATION}images/navbar/report.png" alt="{REPORT_TITLE}" /></a></td>
<!-- END report_file_button -->
<!-- BEGIN ecard_button -->
	<td class="navmenu navb"><a href="{ECARD_TGT}" class="navmenu_pic" title="{ECARD_TITLE}" rel="nofollow"><img src="{LOCATION}images/navbar/ecard.png" alt="{ECARD_TITLE}" /></a></td>
<!-- END ecard_button -->
<!-- BEGIN nav_start -->
	<td class="navmenu navb"><a href="{START_TGT}" id="di-beg" class="navmenu_pic" title="{START_TITLE}"><img src="{LOCATION}images/navbar/{START_IMAGE}" alt="{START_TITLE}" /></a></td>
<!-- END nav_start -->
<!-- BEGIN nav_prev -->
	<td class="navmenu navb"><a href="{PREV_TGT}" id="di-prv" class="navmenu_pic" title="{PREV_TITLE}"><img src="{LOCATION}images/navbar/{PREV_IMAGE}" alt="{PREV_TITLE}" /></a></td>
<!-- END nav_prev -->
<!-- BEGIN nav_next -->
	<td class="navmenu navb"><a href="{NEXT_TGT}" id="di-nxt" class="navmenu_pic" title="{NEXT_TITLE}"><img src="{LOCATION}images/navbar/{NEXT_IMAGE}" alt="{NEXT_TITLE}" /></a></td>
<!-- END nav_next -->
<!-- BEGIN nav_end -->
	<td class="navmenu navb"><a href="{END_TGT}" id="di-end" class="navmenu_pic" title="{END_TITLE}"><img src="{LOCATION}images/navbar/{END_IMAGE}" alt="{END_TITLE}" /></a></td>
<!-- END nav_end -->
</tr></table></div>
EOT;
*/



// Template used for tabbed display
$template_tab_display = array(
	'left_text'			=> '<div class="cols-6 left"><span class="navmenu">{LEFT_TEXT}</span></div>',
	'tab_header'		=> '<div class="h5r-nav-tabs cols-6 right">',
	'tab_trailer'		=> '</div>',
	'active_tab'		=> '<span class="navmenu active_tab">%d</span>',
	'inactive_tab'		=> '<span class="navmenu inactive_tab"><a href="{LINK}">%d</a></span>',
	'nav_tab'			=> '<span class="navmenu nav_tab"><a href="{LINK}" id="%s">%s</a></span>',
	'nav_tab_nolink'	=> '<span class="navmenu nav_tab_nolink">%s</span>',
	'allpages_dropdown'	=> '<span class="navmenu allpages_dropdown">%s</span>',
	'page_gap'			=> '<span class="navmenu page_gap">-</span>',
	'tab_spacer'		=> '',
	'page_link'			=> '{LINK}',
);


$template_add_your_comment = <<<EOT
	<form method="post" name="post" id="post" onsubmit="return notDefaultUsername(this, '{DEFAULT_USERNAME}', '{DEFAULT_USERNAME_MESSAGE}');" action="db_input.php">
		<div class="containerer-fluid">
			<div class="row">
				<div class="cmnt-blk col-xs-12">{ADD_YOUR_COMMENT}{HELP_ICON}</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="containerer-fluid">
<!-- BEGIN user_name_input -->
						<div class="row">
							<div class="col-xs-2">
								{NAME}
							</div>
							<div class="col-xs-10">
								<input type="text" class="textinput" name="msg_author" size="10" maxlength="20" value="{USER_NAME}" onclick="if (this.value == '{DEFAULT_USERNAME}') this.value = '';" onkeyup="if (this.value == '{DEFAULT_USERNAME}') this.value = '';" />
							</div>
						</div>
<!-- END user_name_input -->
<!-- BEGIN input_box_smilies -->
						<div class="row">
							<div class="col-xs-2">
								{COMMENT}
							</div>
							<div class="col-xs-10">
								<input type="text" class="textinput" id="message" name="msg_body" onselect="storeCaret_post(this);" onclick="storeCaret_post(this);" onkeyup="storeCaret_post(this);" maxlength="{MAX_COM_LENGTH}" style="width: 100%;" />
							</div>
						</div>
<!-- END input_box_smilies -->
<!-- BEGIN input_box_no_smilies -->
						<div class="row">
							<div class="col-xs-2">
								{COMMENT}
							</div>
							<div class="col-xs-10">
								<input type="text" class="textinput" id="message" name="msg_body" maxlength="{MAX_COM_LENGTH}" style="width: 100%;" />
							</div>
						</div>
<!-- END input_box_no_smilies -->
<!-- BEGIN comment_captcha -->
						<div class="row">
							<div class="col-xs-2">
								{CONFIRM}
							</div>
							<div class="col-xs-10">
								<input type="text" name="confirmCode" size="5" maxlength="5" class="textinput" />
								<img src="captcha.php" alt="" />
							</div>
						</div>
<!-- END comment_captcha -->
<!-- BEGIN submit -->
						<div class="row">
							<div class="col-xs-12">
								<input type="hidden" name="event" value="comment" />
								<input type="hidden" name="pid" value="{PIC_ID}" />
								<button type="submit" class="button" name="submit" value="{OK}">{OK_ICON}{OK}</button>
								<input type="hidden" name="form_token" value="{FORM_TOKEN}" />
								<input type="hidden" name="timestamp" value="{TIMESTAMP}" />
							</div>
						</div>
<!-- END submit -->
					</div>
				</div>
			</div>
<!-- BEGIN smilies -->
			<div class="row">
				<div class="col-xs-12">{SMILIES}</div>
			</div>
<!-- END smilies -->
<!-- BEGIN login_to_comment -->
			<div class="row">
				<div class="col-xs-12">{LOGIN_TO_COMMENT}</div>
			</div>
<!-- END login_to_comment -->
		</div>
	</form>
EOT;


// HTML template for the image rating box
$template_image_rating = <<<EOT
<div class="img-votes">
	<div>
		<span id="voting_title"><strong>{TITLE}</strong> {VOTES}</span>
	</div>
	<div id="rating_stars">
		<span id="star_rating"></span>
	</div>
	<div class="noscript">
		<span><noscript>{JS_WARNING}</noscript></span>
	</div>
</div>
EOT;


// HTML template used by the cpg_die function
$template_cpg_die = <<<EOT
	<div class="cpg_message {CSS_CLASS}">
		<h2>{HEADER_TXT}</h2>
		<span class="cpg_user_message">{MESSAGE}</span>
		<br />
<!-- BEGIN file_line -->
		<br />
		{FILE_TXT}{FILE} - {LINE_TXT}{LINE}
<!-- END file_line -->
<!-- BEGIN output_buffer -->
		<br />
		<div align="left">
			{OUTPUT_BUFFER}
		</div>
<!-- END output_buffer -->
		<br />
	</div>
EOT;


// HTML template used by the msg_box function
$template_msg_box = <<<EOT
	<div class="cpg_message {CLASS}">
		<span class="cpg_user_message">{MESSAGE}</span>
<!-- BEGIN button -->
		<br />&nbsp;
		<br />
		<span class="admin_menu">
			<a href="{LINK}">{TEXT}</a>
		</span>
<!-- END button -->
	</div>
EOT;


/************************************************************/
/************** THEME FORMAT DISPLAY FUNCTIONS **************/
/************************************************************/

function h5dmp ($dat, $rtn=false)
{
	echo'<xmp>';var_dump($dat);echo'</xmp>';
	if ($rtn) return $dat;
}

/********************** format a "breadcrumb" */

function theme_display_breadcrumb ($breadcrumb, &$cat_data)
{
	global $template_breadcrumb, $lang_breadcrumb;

	if ($breadcrumb) {
		$template = template_extract_block($template_breadcrumb, 'breadcrumb');
		$params = array(
			'{BREADCRUMB}' => $breadcrumb,
		);
		echo template_eval($template, $params);
	}
}


/********************** format a category list */

function theme_display_cat_list ($breadcrumb, &$cat_data, $statistics)
{
	global $CONFIG, $template_cat_list, $lang_cat_list;
	if (count($cat_data) > 0) {
//		starttable('100%');
		$template = template_extract_block($template_cat_list, 'header');
		$params = array(
			'{CATEGORY}' => $lang_cat_list['category'],
			'{ALBUMS}' => $CONFIG['first_level'] ? '' : $lang_cat_list['albums'],
			'{PICTURES}' => $CONFIG['first_level'] ? '' : $lang_cat_list['pictures'],
		);
		echo template_eval($template, $params);
	}

	$template_noalb = template_extract_block($template_cat_list, 'catrow_noalb');
	$template = template_extract_block($template_cat_list, 'catrow');
	foreach ($cat_data as $category) {
		if (!isset($category['cat_thumb'])) { $category['cat_thumb'] = ''; }
		if (count($category) == 3) {
			$params = array(
				'{CAT_TITLE}' => $category[0],
				'{CAT_THUMB}' => $category['cat_thumb'],
				'{CAT_DESC}' => $category[1],
			);
			echo template_eval($template_noalb, $params);
		} elseif (isset($category['cat_albums']) && ($category['cat_albums'] != '')) {
			$params = array(
				'{CAT_TITLE}' => $category[0],
				'{CAT_THUMB}' => $category['cat_thumb'],
				'{CAT_DESC}' => $category[1],
				'{CAT_ALBUMS}' => $category['cat_albums'],
				'{ALB_COUNT}' => cpg_float2decimal($category[2]) .' '. ($CONFIG['first_level'] ? $lang_cat_list['albums'] : ''),
				'{PIC_COUNT}' => cpg_float2decimal($category[3]) .' '. ($CONFIG['first_level'] ? $lang_cat_list['pictures'] : ''),
			);
			echo template_eval($template, $params);
		} else {
			$params = array(
				'{CAT_TITLE}' => $category[0],
				'{CAT_THUMB}' => $category['cat_thumb'],
				'{CAT_DESC}' => $category[1],
				'{CAT_ALBUMS}' => '',
				'{ALB_COUNT}' => ($CONFIG['first_level'] ? $lang_cat_list['albums'] : '') . cpg_float2decimal($category[2]),
				'{PIC_COUNT}' => ($CONFIG['first_level'] ? $lang_cat_list['pictures'] : '') . cpg_float2decimal($category[3]),
			);
			echo template_eval($template, $params);
		}
	}

	if ($statistics && count($cat_data) > 0) {
		$template = template_extract_block($template_cat_list, 'footer');
		$params = array('{STATISTICS}' => $statistics);
		echo template_eval($template, $params);
	}
}


/********************** format an album list */

function theme_display_album_list (&$alb_list, $nbAlb, $cat, $page, $total_pages)
{
	global $CONFIG, $STATS_IN_ALB_LIST, $statistics, $template_tab_display, $template_album_list, $lang_album_list;

	$theme_alb_list_tab_tmpl = $template_tab_display;

	$theme_alb_list_tab_tmpl['left_text'] = strtr($theme_alb_list_tab_tmpl['left_text'], array('{LEFT_TEXT}' => $lang_album_list['album_on_page']));
	$theme_alb_list_tab_tmpl['page_link'] = strtr($theme_alb_list_tab_tmpl['page_link'], array('{LINK}' => 'index.php?cat=' . $cat . '&amp;page=%d'));

	$tabs = create_tabs($nbAlb, $page, $total_pages, $theme_alb_list_tab_tmpl);

	$album_cell = template_extract_block($template_album_list, 'album_cell');
	$tabs_row = template_extract_block($template_album_list, 'tabs');
	$stat_row = template_extract_block($template_album_list, 'stat_row');
	$header = template_extract_block($template_album_list, 'header');
	$footer = template_extract_block($template_album_list, 'footer');

	$columns = $CONFIG['album_list_cols'];
	$column_width = ceil(100 / $columns);
	$thumb_cell_width = $CONFIG['alb_list_thumb_size'] + 2;

	echo '<div class="album-list">';		//	starttable('100%');

	if ($STATS_IN_ALB_LIST) {
		$params = array('{STATISTICS}' => $statistics,
			'{COLUMNS}' => $columns,
			);
		echo template_eval($stat_row, $params);
	}

	echo $header;

	if (is_array($alb_list)) {
		require_once 'helper.class.php';
		foreach ($alb_list as $album) {		//h5dmp($album);
			if ((int)$album['pic_count']==0) {
				$album['thumb_pic'] = preg_replace('#width="\d+" height="\d+"#', 'width="100%"', $album['thumb_pic']);
			}
			$params = array(
				'{COL_WIDTH}' => $column_width,
				'{ALBUM_TITLE}' => $album['album_title'],
				'{THUMB_CELL_WIDTH}' => $thumb_cell_width,
				'{ALB_LINK_TGT}' => "thumbnails.php?album={$album['aid']}",
				'{ALB_LINK_PIC}' => $album['thumb_pic'],
				'{ADMIN_MENU}' => H5R_Help::alb_adm_mnu($album['album_adm_menu']),
				'{ALB_DESC}' => $album['album_desc'] ?: '&nbsp;',
				'{ALB_INFOS}' => $album['album_info'],
				'{ALB_HITS}' => $album['alb_hits'],
				);
			$params = CPGPluginAPI::filter('theme_album_params', $params);
			echo template_eval($album_cell, $params);
		}
	}

	echo $footer;
	// Tab display
	$params = array('{COLUMNS}' => $columns,
		'{TABS}' => $tabs,
		);
	echo template_eval($tabs_row, $params);

	echo '</div>';		//	endtable();
}


/********************** format an album list for first level category */

function theme_display_album_list_cat (&$alb_list, $nbAlb, $cat, $page, $total_pages)
{
	global $CONFIG, $STATS_IN_ALB_LIST, $statistics, $template_tab_display, $template_album_list_cat, $lang_album_list;
	if (!$CONFIG['first_level']) {
		return;
	}

	$theme_alb_list_tab_tmpl = $template_tab_display;

	$theme_alb_list_tab_tmpl['left_text'] = strtr($theme_alb_list_tab_tmpl['left_text'], array('{LEFT_TEXT}' => $lang_album_list['album_on_page']));
	$theme_alb_list_tab_tmpl['page_link'] = strtr($theme_alb_list_tab_tmpl['page_link'], array('{LINK}' => 'index.php?cat=' . $cat . '&amp;page=%d'));

	$tabs = create_tabs($nbAlb, $page, $total_pages, $theme_alb_list_tab_tmpl);

	$template_album_list_cat1 = $template_album_list_cat;
	$album_cell = template_extract_block($template_album_list_cat1, 'c_album_cell');
	$tabs_row = template_extract_block($template_album_list_cat1, 'c_tabs');
	$stat_row = template_extract_block($template_album_list_cat1, 'c_stat_row');
	$header = template_extract_block($template_album_list_cat1, 'c_header');
	$footer = template_extract_block($template_album_list_cat1, 'c_footer');

	$columns = $CONFIG['album_list_cols'];
	$column_width = ceil(100 / $columns);
	$thumb_cell_width = $CONFIG['alb_list_thumb_size'] + 2;

	if ($STATS_IN_ALB_LIST) {
		$params = array('{STATISTICS}' => $statistics,
			'{COLUMNS}' => $columns,
			);
		echo template_eval($stat_row, $params);
	}

	echo $header;

	if (is_array($alb_list)) {
		require_once 'helper.class.php';
		foreach ($alb_list as $album) {
			if ((int)$album['pic_count']==0) {
				$album['thumb_pic'] = preg_replace('#width="\d+" height="\d+"#', 'width="100%"', $album['thumb_pic']);
			}
			$params = array(
				'{COL_WIDTH}' => $column_width,
				'{ALBUM_TITLE}' => $album['album_title'],
				'{THUMB_CELL_WIDTH}' => $thumb_cell_width,
				'{ALB_LINK_TGT}' => "thumbnails.php?album={$album['aid']}",
				'{ALB_LINK_PIC}' => $album['thumb_pic'],
				'{ADMIN_MENU}' => H5R_Help::alb_adm_mnu($album['album_adm_menu']),
				'{ALB_DESC}' => $album['album_desc'] ?: '&nbsp;',
				'{ALB_INFOS}' => $album['album_info'],
				'{ALB_HITS}' => $album['alb_hits'],
				);

			echo template_eval($album_cell, $params);
		}
	}

	echo $footer;
	// Tab display
	$params = array('{COLUMNS}' => $columns,
		'{TABS}' => $tabs,
		);
	echo template_eval($tabs_row, $params);
}


/********************** format a view of thumbnails */

function theme_display_thumbnails (&$thumb_list, $nbThumb, $album_name, $aid, $cat, $page, $total_pages, $sort_options, $display_tabs, $mode = 'thumb', $date='')
{
	global $CONFIG, $USER, $CURRENT_ALBUM_DATA;
	global $template_thumb_view_title_row,$template_fav_thumb_view_title_row, $lang_thumb_view, $lang_common, $template_tab_display, $template_thumbnail_view, $lang_album_list, $lang_errors;

	$superCage = Inspekt::makeSuperCage();

	static $header = '';
	static $thumb_cell = '';
	static $footer = '';
	static $tabs = '';

	if ($header == '') {
		$thumb_cell = template_extract_block($template_thumbnail_view, 'thumb_cell');
		$tabs = template_extract_block($template_thumbnail_view, 'tabs');
		$header = template_extract_block($template_thumbnail_view, 'header');
		$footer = template_extract_block($template_thumbnail_view, 'footer');
	}

	$cat_link = is_numeric($aid) ? '' : '&amp;cat=' . $cat;
	$date_link = $date=='' ? '' : '&amp;date=' . $date;
	if ($superCage->get->getInt('uid')) {
		$uid_link = '&amp;uid=' . $superCage->get->getInt('uid');
	} else {
		$uid_link = '';
	}

	$album_types = array(
		'albums' => array('lastalb')
	);
	$album_types = CPGPluginAPI::filter('theme_thumbnails_album_types', $album_types);

	$theme_thumb_tab_tmpl = $template_tab_display;

	if ($mode == 'thumb') {
		$theme_thumb_tab_tmpl['left_text'] = strtr($theme_thumb_tab_tmpl['left_text'], array('{LEFT_TEXT}' => in_array($aid, $album_types['albums']) ? $lang_album_list['album_on_page'] : $lang_thumb_view['pic_on_page']));
		$theme_thumb_tab_tmpl['page_link'] = strtr($theme_thumb_tab_tmpl['page_link'], array('{LINK}' => 'thumbnails.php?album=' . $aid . $cat_link . $date_link . $uid_link . '&amp;page=%d'));
	} else {
		$theme_thumb_tab_tmpl['left_text'] = strtr($theme_thumb_tab_tmpl['left_text'], array('{LEFT_TEXT}' => $lang_thumb_view['user_on_page']));
		$theme_thumb_tab_tmpl['page_link'] = strtr($theme_thumb_tab_tmpl['page_link'], array('{LINK}' => 'index.php?cat=' . $cat . '&amp;page=%d'));
	}

	$thumbcols = $CONFIG['thumbcols'];
	$cell_width = floor((100 / $CONFIG['thumbcols']) * 100) / 100 . '%';

	$tabs_html = $display_tabs ? create_tabs($nbThumb, $page, $total_pages, $theme_thumb_tab_tmpl) : '';

	if (!GALLERY_ADMIN_MODE && stripos($template_thumb_view_title_row, 'admin_buttons') !== false) {
		template_extract_block($template_thumb_view_title_row, 'admin_buttons');
	}
	// The sort order options are not available for meta albums
	if ($sort_options) {
		require_once 'helper.class.php';
		if (GALLERY_ADMIN_MODE) {
			$param = array(
				'{ALBUM_ID}'		=> $aid,
				'{CAT_ID}'			=> ($cat > 0 ? $cat : $CURRENT_ALBUM_DATA['category']),
				'{MODIFY_LNK}'		=> $lang_common['album_properties'],
				'{MODIFY_ICO}'		=> cpg_fetch_icon('modifyalb', 1),
				'{PARENT_CAT_LNK}'	=> $lang_common['parent_category'],
				'{PARENT_CAT_ICO}'	=> cpg_fetch_icon('category', 1),
				'{EDIT_PICS_LNK}'	=> $lang_common['edit_files'],
				'{EDIT_PICS_ICO}'	=> cpg_fetch_icon('edit', 1),
				'{ALBUM_MGR_LNK}'	=> $lang_common['album_manager'],
				'{ALBUM_MGR_ICO}'	=> cpg_fetch_icon('alb_mgr', 1)
			);
		} else {
			$param = array();
		}
		$param['{ALBUM_NAME}'] = $album_name;

		$sort_code = isset($USER['sort']) && $CONFIG['custom_sortorder_thumbs'] ? $USER['sort'] : $CONFIG['default_sort_order'];
		$param['{SORT_UI}'] = H5R_Help::thm_sort_ui_sgl($sort_code);

		// Plugin Filter: allow plugin to modify or add tags to process
		$param = CPGPluginAPI::filter('theme_thumbnails_title', $param);
		$title = template_eval($template_thumb_view_title_row, $param);
	} elseif ($aid == 'favpics' && $CONFIG['enable_zipdownload'] > 0) { //Lots of stuff can be added here later
		$param = array(
			'{ALBUM_ID}'		=> $aid,
			'{ALBUM_NAME}'		=> $album_name,
			'{DOWNLOAD_ZIP}'	=> cpg_fetch_icon('zip', 2) . $lang_thumb_view['download_zip'],
		);
		// Plugin Filter: allow plugin to modify or add tags to process
		$param = CPGPluginAPI::filter('theme_thumbnails_title', $param);
		$title = template_eval($template_fav_thumb_view_title_row, $param);
	} else {
		$title = '<div class="alb-img-blk">'.$album_name.'</div>';
	}

	CPGPluginAPI::action('theme_thumbnails_wrapper_start', null);

	if ($mode == 'thumb') {
//		starttable('100%', $title, 5/*$thumbcols*/);
		echo $title;
	} else {
//		starttable('100%');
	}

	$header = CPGPluginAPI::filter('theme_thumbnails_header', $header);
	echo $header;

	require_once 'helper.class.php';

	$i = 0;
	global $thumb;	// make $thumb accessible to plugins
	foreach ($thumb_list as $thumb) {
		$thumb['image'] = H5R_Help::stripAttributes($thumb['image'], 'border');
		$i++;
		if ($mode == 'thumb') {
			if (in_array($aid, $album_types['albums'])) {
				$params = array(
					'{CELL_WIDTH}'	=> $cell_width,
					'{LINK_TGT}'	=> "thumbnails.php?album={$thumb['aid']}",
					'{THUMB}'		=> $thumb['image'],
					'{CAPTION}'		=> $thumb['caption'],
					'{ADMIN_MENU}'	=> $thumb['admin_menu'],
				);
			} else {
				// determine if thumbnail link targets should open in a pop-up
				if ($CONFIG['thumbnail_to_fullsize'] == 1) { // code for full-size pop-up
					if (!USER_ID && $CONFIG['allow_unlogged_access'] <= 2) {
						$target = 'javascript:;" onclick="alert(\''.sprintf($lang_errors['login_needed'],'','','','').'\');';
					} elseif (USER_ID && USER_ACCESS_LEVEL <= 2) {
						$target = 'javascript:;" onclick="alert(\''.sprintf($lang_errors['access_intermediate_only'],'','','','').'\');';
					} else {
						$target = 'javascript:;" onclick="MM_openBrWindow(\'displayimage.php?pid=' . $thumb['pid'] . '&fullsize=1\',\'' . uniqid(rand()) . '\',\'scrollbars=yes,toolbar=no,status=no,resizable=yes,width=' . ((int)$thumb['pwidth']+(int)$CONFIG['fullsize_padding_x']) . ',height=' . ((int)$thumb['pheight']+(int)$CONFIG['fullsize_padding_y']). '\');';
					}
				} elseif ($aid == 'random') {
					$target = "displayimage.php?pid={$thumb['pid']}$uid_link#top_display_media";
				} elseif ($aid == 'lastcom' || $aid == 'lastcomby') {
					$page = cpg_get_comment_page_number($thumb['msg_id']);
					$page = (is_numeric($page)) ? "&amp;page=$page" : '';
					$target = "displayimage.php?album=$aid$cat_link$date_link&amp;pid={$thumb['pid']}$uid_link&amp;msg_id={$thumb['msg_id']}$page#comment{$thumb['msg_id']}";
				} else {
					$target = "displayimage.php?album=$aid$cat_link$date_link&amp;pid={$thumb['pid']}$uid_link#top_display_media";
				}
				$params = array(
					'{CELL_WIDTH}'	=> $cell_width,
					'{LINK_TGT}'	=> $target,
					'{THUMB}'		=> $thumb['image'],
					'{CAPTION}'		=> $thumb['caption'],
					'{ADMIN_MENU}'	=> $thumb['admin_menu'],
				);
			}

		} else {	// mode != 'thumb'

			// Used for mode = 'user' from list_users() in index.php
			$params = array(
				'{CELL_WIDTH}'	=> $cell_width,
				'{LINK_TGT}'	=> "index.php?cat={$thumb['cat']}",
				'{THUMB}'		=> $thumb['image'],
				'{CAPTION}'		=> $thumb['caption'],
				'{ADMIN_MENU}'	=> '',
			);

		}

		$params['{ORIENT}'] = ($thumb['pwidth']>$thumb['pheight']?'landscap':($thumb['pwidth']<$thumb['pheight']?'portrait':'issquare'));

		// Plugin Filter: allow plugin to modify or add tags to process
		$params = CPGPluginAPI::filter('theme_display_thumbnails_params', $params);
		echo template_eval($thumb_cell, $params);
	} // foreach $thumb

	unset($thumb);	// unset $thumb to avoid conflicting with global

	$footer = CPGPluginAPI::filter('theme_thumbnails_footer', $footer);
	echo $footer;

	if ($display_tabs) {
		$params = array(
//			'{THUMB_COLS}'	=> $thumbcols,
			'{TABS}'		=> $tabs_html,
		);
		echo template_eval($tabs, $params);
	}

//	endtable();
	CPGPluginAPI::action('theme_thumbnails_wrapper_end', null);
}


/********************** for when there are no images (thumbnails) to display */

function theme_no_img_to_display ($album_name)
{
	global $lang_errors, $template_no_img_to_display;

	static $template = '';

	if ((!$template)) {
		$template = $template_no_img_to_display;
	}

	$params = array('{TEXT}' => $lang_errors['no_img_to_display']);
	echo '<div class="alb-img-blk">'.$album_name.'</div>';
	echo template_eval($template, $params);
}


/********************** compose the display of an image/media */

function theme_html_picture ()
{
	global $CONFIG, $CURRENT_PIC_DATA, $CURRENT_ALBUM_DATA, $USER, $LINEBREAK;
	global $album, $lang_date, $template_display_media;
	global $lang_display_image_php, $lang_picinfo, $lang_common, $lang_errors;

	$superCage = Inspekt::makeSuperCage();

	$pid = $CURRENT_PIC_DATA['pid'];
	$pic_title = '';

	if (!isset($USER['liv']) || !is_array($USER['liv'])) {
		$USER['liv'] = array();
	}
	// Add 1 to hit counter
	if ((!USER_IS_ADMIN && $CONFIG['count_admin_hits'] == 0 || $CONFIG['count_admin_hits'] == 1) && !in_array($pid, $USER['liv']) && $superCage->cookie->keyExists($CONFIG['cookie_name'] . '_data')) {
		add_hit($pid);
		if (count($USER['liv']) > 4) array_shift($USER['liv']);
		array_push($USER['liv'], $pid);
	}

	if ($CURRENT_PIC_DATA['title'] != '') {
		$pic_title .= $CURRENT_PIC_DATA['title'] . $LINEBREAK;
	}
	if ($CURRENT_PIC_DATA['caption'] != '') {
		$pic_title .= $CURRENT_PIC_DATA['caption'] . $LINEBREAK;
	}
	if ($CURRENT_PIC_DATA['keywords'] != '') {
		$pic_title .= $lang_common['keywords'] . ": " . $CURRENT_PIC_DATA['keywords'];
	}

	if (!$CURRENT_PIC_DATA['title'] && !$CURRENT_PIC_DATA['caption']) {
		template_extract_block($template_display_media, 'img_desc');
	} else {
		if (!$CURRENT_PIC_DATA['title']) {
			template_extract_block($template_display_media, 'title');
		}
		if (!$CURRENT_PIC_DATA['caption']) {
			template_extract_block($template_display_media, 'caption');
		}
	}

	$CURRENT_PIC_DATA['menu'] = html_picture_menu(); //((USER_ADMIN_MODE && $CURRENT_ALBUM_DATA['category'] == FIRST_USER_CAT + USER_ID) || ($CONFIG['users_can_edit_pics'] && $CURRENT_PIC_DATA['owner_id'] == USER_ID && USER_ID != 0) || GALLERY_ADMIN_MODE) ? html_picture_menu($pid) : '';

	$image_size = array();

	if ($CONFIG['make_intermediate'] && cpg_picture_dimension_exceeds_intermediate_limit($CURRENT_PIC_DATA['pwidth'], $CURRENT_PIC_DATA['pheight'])) {
		$picture_url = get_pic_url($CURRENT_PIC_DATA, 'normal');
	} else {
		$picture_url = get_pic_url($CURRENT_PIC_DATA, 'fullsize');
	}

	$pic_title = '';
	$mime_content = cpg_get_type($CURRENT_PIC_DATA['filename']);

	if ($mime_content['content']=='movie' || $mime_content['content']=='audio') {

		if ($CURRENT_PIC_DATA['pwidth']==0 || $CURRENT_PIC_DATA['pheight']==0) {
			$resize_method = $CONFIG['picture_use'] == "thumb" ? ($CONFIG['thumb_use'] == "ex" ? "any" : $CONFIG['thumb_use']) : $CONFIG['picture_use'];
			if ($resize_method == 'ht') {
				$pwidth = $CONFIG['picture_width']*4/3;
				$pheight = $CONFIG['picture_width'];
			} else {
				$pwidth = $CONFIG['picture_width'];
				$pheight = $CONFIG['picture_width']*3/4;
			}

			$CURRENT_PIC_DATA['pwidth']	 = $pwidth; // Default width

			// Set default height; if file is a movie
			if ($mime_content['content']=='movie') {
				$CURRENT_PIC_DATA['pheight'] = $pheight; // Default height
			}
		}

		$ctrl_offset['mov']=15;
		$ctrl_offset['wmv']=45;
		$ctrl_offset['swf']=0;
		$ctrl_offset['rm']=0;
		$ctrl_offset_default=45;
		$ctrl_height = (isset($ctrl_offset[$mime_content['extension']]))?($ctrl_offset[$mime_content['extension']]):$ctrl_offset_default;
		$image_size['whole']='width="'.$CURRENT_PIC_DATA['pwidth'].'" height="'.($CURRENT_PIC_DATA['pheight']+$ctrl_height).'"';
	}

	if ($mime_content['content']=='image') {
		list($image_size['width'], $image_size['height'], , $image_size['geom']) = cpg_getimagesize($picture_url);

		if ($CURRENT_PIC_DATA['mode'] != 'fullsize') {
			$winsizeX = $CURRENT_PIC_DATA['pwidth'] + $CONFIG['fullsize_padding_x'];	//the +'s are the mysterious FF and IE paddings
			$winsizeY = $CURRENT_PIC_DATA['pheight'] + $CONFIG['fullsize_padding_y'];	//the +'s are the mysterious FF and IE paddings
			if ($CONFIG['transparent_overlay'] == 1) {
//				$pic_html = "<table><tr><td background=\"" . $picture_url . "\" width=\"{$image_size['width']}\" height=\"{$image_size['height']}\" class=\"image\">";
				$style = 'background-image:url(\''.$picture_url.'\');width:'.$image_size['width'].'px;height:'.$image_size['height'].'px;';
				$pic_html = "<div style=\"$style\" class=\"i-image\">";
				$pic_html_href_close = '</a>' . $LINEBREAK;
				if (!USER_ID && $CONFIG['allow_unlogged_access'] <= 2) {
					if ($CONFIG['allow_user_registration'] == 0) {
						$pic_html_href_close = '';
					} else {
						$pic_html .= '<a href="javascript:;" onclick="alert(\''.sprintf($lang_errors['login_needed'],'','','','').'\');">';
					}
				} elseif (USER_ID && USER_ACCESS_LEVEL <= 2) {
					$pic_html .= '<a href="javascript:;" onclick="alert(\''.sprintf($lang_errors['access_intermediate_only'],'','','','').'\');">';
				} else {
					$pic_html .= "<a href=\"javascript:;\" onclick=\"MM_openBrWindow('displayimage.php?pid=$pid&amp;fullsize=1','" . uniqid(rand()) . "','scrollbars=no,toolbar=no,status=no,resizable=yes,width=$winsizeX,height=$winsizeY')\">";
				}
				$pic_title = $lang_display_image_php['view_fs'] . $LINEBREAK . '==============' . $LINEBREAK . $pic_title;
				$pic_html .= "<img src=\"images/image.gif?id=".floor(rand()*1000+rand())."\" width=\"{$image_size['width']}\" height=\"{$image_size['height']}\" alt=\"{$lang_display_image_php['view_fs']}\" /><br />";
//				$pic_html .= $pic_html_href_close . '</td></tr></table>';
				$pic_html .= $pic_html_href_close . '</div>';
				//PLUGIN FILTER
				$pic_html = CPGPluginAPI::filter('html_image_reduced_overlay', $pic_html);
			} else {
				$pic_html_href_close = '</a>' . $LINEBREAK;
				if (!USER_ID && $CONFIG['allow_unlogged_access'] <= 2) {
					if ($CONFIG['allow_user_registration'] == 0) {
						$pic_html = $pic_html_href_close = '';
					} else {
						$pic_html = '<a href="javascript:;" onclick="alert(\''.sprintf($lang_errors['login_needed'],'','','','').'\');">';
					}
				} elseif (USER_ID && USER_ACCESS_LEVEL <= 2) {
					$pic_html = '<a href="javascript:;" onclick="alert(\''.sprintf($lang_errors['access_intermediate_only'],'','','','').'\');">';
				} else {
					$pic_html = "<a href=\"javascript:;\" onclick=\"MM_openBrWindow('displayimage.php?pid=$pid&amp;fullsize=1','" . uniqid(rand()) . "','scrollbars=no,toolbar=no,status=no,resizable=yes,width=$winsizeX,height=$winsizeY')\">";
				}
				$pic_title = $lang_display_image_php['view_fs'] . $LINEBREAK . '==============' . $LINEBREAK . $pic_title;
				$pic_html .= "<img src=\"" . $picture_url . "\" {$image_size['geom']} class=\"image\" alt=\"{$lang_display_image_php['view_fs']}\" /><br />";
				$pic_html .= $pic_html_href_close;
				//PLUGIN FILTER
				$pic_html = CPGPluginAPI::filter('html_image_reduced', $pic_html);
			}
		} else {
			if ($CONFIG['transparent_overlay'] == 1) {
				$pic_html = "<table><tr><td background=\"" . $picture_url . "\" width=\"{$CURRENT_PIC_DATA['pwidth']}\" height=\"{$CURRENT_PIC_DATA['pheight']}\" class=\"image\">";
				$pic_html .= "<img src=\"images/image.gif?id=".floor(rand()*1000+rand())."\" width={$CURRENT_PIC_DATA['pwidth']} height={$CURRENT_PIC_DATA['pheight']} alt=\"\" /><br />" . $LINEBREAK;
				$pic_html .= "</td></tr></table>";
				//PLUGIN FILTER
				$pic_html = CPGPluginAPI::filter('html_image_overlay', $pic_html);
			} else {
				$pic_html = "<img src=\"" . $picture_url . "\" {$image_size['geom']} class=\"image\" alt=\"\" /><br />" . $LINEBREAK;
				//PLUGIN FILTER
				$pic_html = CPGPluginAPI::filter('html_image', $pic_html);
			}
		}
	} elseif ($mime_content['content']=='document') {
		$pic_thumb_url = get_pic_url($CURRENT_PIC_DATA,'thumb');
		$pic_html = "<a href=\"{$picture_url}\" target=\"_blank\" class=\"document_link\"><img src=\"".$pic_thumb_url."\" class=\"image\" /></a><br />" . $LINEBREAK;
		//PLUGIN FILTER
		$pic_html = CPGPluginAPI::filter('html_document', $pic_html);
	} else {
		$autostart = ($CONFIG['media_autostart']) ? ('true'):('false');
		$autoplay = '" autostart="'.$autostart.'" autoplay="'.$autostart.'" ';

		if ($mime_content['player'] == 'HTMLA') {
			$pic_html = '<audio controls="true" src="' . $picture_url . $autoplay . '></audio>';
		} elseif ($mime_content['player'] == 'HTMLV') {
			$pic_html = '<div class="video"><video controls="true" src="' . $picture_url . $autoplay . 'style="max-width:100%"></video></div>';
		} else {

			$players['WMP'] = array('id' => 'MediaPlayer',
				//'clsid' => 'classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95" ',
				'clsid' => '',
				'codebase' => 'codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" ',
				'mime' => 'type="application/x-mplayer2" ',
				);
			$players['DIVX'] = array('id' => 'DivX',
				'clsid' => 'classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616"',
				'codebase' => 'codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab"',
				'mime' => 'type="video/divx"'
				);
			$players['RMP'] = array('id' => 'RealPlayer',
				'clsid' => 'classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" ',
				'codebase' => '',
				'mime' => 'type="audio/x-pn-realaudio-plugin" '
				);
			$players['QT']	= array('id' => 'QuickTime',
				'clsid' => 'classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" ',
				'codebase' => 'codebase="http://www.apple.com/qtactivex/qtplugin.cab" ',
				'mime' => 'type="video/x-quicktime" '
				);
			$players['SWF'] = array('id' => 'SWFlash',
				//'clsid' => ' classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ',
				'clsid' => '',
				'codebase' => '',
				'mime' => 'type="application/x-shockwave-flash" ',
				'data' => 'data="'.$picture_url.'" '
				);
			$players['UNK'] = array('id' => 'DefaultPlayer',
				'clsid' => '',
				'codebase' => '',
				'mime' => ''
				);

			$player = $players[$mime_content['player']];

			if (!$player) {
				$player = 'UNK';
			}

			$pic_html = '<object id="'.$player['id'].'" '.$player['data'].$player['clsid'].$player['codebase'].$player['mime'].$image_size['whole'].'>';
			$pic_html .= "<param name=\"autostart\" value=\"$autostart\" /><param name=\"src\" value=\"". $picture_url . "\" />";
			$pic_html .= '</object><br />' . $LINEBREAK;
		}

		//PLUGIN FILTER
		$pic_html = CPGPluginAPI::filter('html_other_media', $pic_html);
	}

	$CURRENT_PIC_DATA['html'] = $pic_html;
	$CURRENT_PIC_DATA['header'] = '';
	$CURRENT_PIC_DATA['footer'] = '';

	$CURRENT_PIC_DATA = CPGPluginAPI::filter('file_data',$CURRENT_PIC_DATA);

	$params = array('{CELL_HEIGHT}' => '100',
		'{IMAGE}' => $CURRENT_PIC_DATA['header'].$CURRENT_PIC_DATA['html'].$CURRENT_PIC_DATA['footer'],
		'{ADMIN_MENU}' => $CURRENT_PIC_DATA['menu'],
		'{TITLE}' => bb_decode($CURRENT_PIC_DATA['title']),
		'{CAPTION}' => bb_decode($CURRENT_PIC_DATA['caption']),
		'{SLIDESHOW_STYLE}' => ''
		);

	return template_eval($template_display_media, $params);
}


/********************** display an (intermediate) image */

function theme_display_image ($nav_menu, $picture, $votes, $pic_info, $comments, $film_strip)
{
	global $CONFIG, $LINEBREAK, $superCage;

	require_once 'helper.class.php';

	echo '<a id="top_display_media"></a>'; // set the navbar-anchor
//	starttable();
	echo $nav_menu;
//	endtable();

//	starttable();
	echo H5R_Help::stripAttributes($picture, 'border');
//	endtable();
	if ($CONFIG['display_film_strip'] == 1) {
		echo $film_strip;
	}

	echo $votes;

//	$picinfo = $superCage->cookie->keyExists('picinfo') ? $superCage->cookie->getAlpha('picinfo') : ($CONFIG['display_pic_info'] ? 'block' : 'none');
//	echo $LINEBREAK . '<div id="picinfo" style="display: '.str_replace('.gif','.png',$picinfo).';">' . $LINEBREAK;
//	starttable();
//	echo $pic_info;
//	endtable();
//	echo '</div>' . $LINEBREAK;

	echo '<a id="comments_top"></a>';
	echo '<div id="comments">' . $LINEBREAK;
//	echo $comments;
	echo '</div>' . $LINEBREAK;

}


/********************** function for creating tabs showing multiple pages */

function theme_create_tabs ($items, $curr_page, $total_pages, $template)
{
	// Tabs do not take into account $lang_text_dir for RTL languages
	global $CONFIG, $lang_create_tabs;

	// Gallery Configuration setting for maximum number of tabs to display
	$maxTab = $CONFIG['max_tabs'];

	if ($total_pages == '') {
		$total_pages = $curr_page;
	}

	if (array_key_exists('page_link',$template)) {
		// Pass through links to tabs with links
		$template['nav_tab'] = strtr($template['nav_tab'], array('{LINK}' => $template['page_link']));
		$template['inactive_tab'] = strtr($template['inactive_tab'], array('{LINK}' => $template['page_link']));
	}

	// Left text, usually shows statistics
	$tabs = sprintf($template['left_text'], $items, $total_pages);
	if (($total_pages == 1)) {
		return $tabs;
	}

	// Header for tabs
	$tabs .= $template['tab_header'];

	if ($CONFIG['tabs_dropdown']) {
		// Dropdown list for all pages
		preg_match('/cat=([\d]+)/', $template['page_link'], $matches);
		$catn = isset($matches[1]) ? $matches[1] : '';
		$tabs_dropdown_js = <<<EOT
		<span id="tabs_dropdown_span{$catn}"></span>
		<script><!--
			$('#tabs_dropdown_span{$catn}').html('{$lang_create_tabs['jump_to_page']} <select id="tabs_dropdown_select{$catn}" onchange="if (this.options[this.selectedIndex].value != -1) { window.location.href = this.options[this.selectedIndex].value; }"><\/select>');
			for (page = 1; page <= $total_pages; page++) {
				var page_link = '{$template['page_link']}';
				var selected = '';
				if (page == $curr_page) {
					selected = ' selected="selected"';
				}
				$('#tabs_dropdown_select{$catn}').append('<option value="' + page_link.replace( /%d/, page ) + '"' + selected + '>' + page + '<\/option>');
			}
	 --></script>
EOT;
		$tabs .= sprintf($template['allpages_dropdown'], $tabs_dropdown_js);
	}

	// Calculate which pages to show on tabs, limited by the maximum number of tabs (set on Gallery Configuration panel)
	if ($total_pages > $maxTab) {
		$start = max(2, $curr_page - floor(($maxTab - 2) / 2));
		$start = min($start, $total_pages - $maxTab + 2);
		$end = $start + $maxTab - 3;
	} else {
		$start = 2;
		$end = $total_pages - 1;
	}

	// Previous page tab
	if ($curr_page != ($start - 1)) {
		$tabs .= sprintf($template['nav_tab'], $curr_page-1, 'tt-prv', cpg_fetch_icon('tab_left', 0, $lang_create_tabs['previous']));
		// add link for keyboard nav alt left arrow
		$tabs .= '<a href="' . sprintf($template['page_link'],1) . '" id="tt-beg" style="display:none"></a>';
	} else {
		// A previous tab with link is not needed.
		// If you want to show a disabled previous tab,
		//	 create an image 'left_inactive.png', put it into themes/YOUR_THEME/images/icons/,
		//	 then uncomment the line below.
		// $tabs .= sprintf($template['nav_tab_nolink'], cpg_fetch_icon('left_inactive',0,$lang_create_tabs['previous']));
	}

	// Page 1 tab
	if ($curr_page == 1) {
		$tabs .= sprintf($template['active_tab'], 1);
	} else {
		$tabs .= sprintf($template['inactive_tab'], 1, 1);
	}

	// Gap between page 1 and middle block of tabs
	if ($start > 2) {
		$tabs .= $template['page_gap'];
	}
	$page_gap = ($template['page_gap'] != '');

	// Middle block of tabs
	for ($page = $start ; $page <= $end; $page++) {
		if (!$page_gap || ($page_gap && ($page != $start))) {
			$tabs .= $template['tab_spacer'];
		}
		if ($page == $curr_page) {
			$tabs .= sprintf($template['active_tab'], $page);
		} else {
			$tabs .= sprintf($template['inactive_tab'], $page, $page);
		}
	}

	// Gap between middle block of tabs and last page
	if ($end < $total_pages - 1) {
		$tabs .= $template['page_gap'];
	}

	// Last page tab
	if (!$page_gap) {
		$tabs .= $template['tab_spacer'];
	}
	if ($total_pages > 1) {
		if ($curr_page == $total_pages) {
			$tabs .= sprintf($template['active_tab'], $total_pages);
		} else {
			$tabs .= sprintf($template['inactive_tab'], $total_pages, $total_pages);
		}
	}

	// Next page tab
	if ($curr_page != $total_pages) {
		$tabs .= sprintf($template['nav_tab'], $curr_page + 1, 'tt-nxt', cpg_fetch_icon('tab_right', 0, $lang_create_tabs['next']));
		// add link for keyboard nav alt right arrow
		$tabs .= '<a href="' . sprintf($template['page_link'],$total_pages) . '" id="tt-end" style="display:none"></a>';
	} else {
		// A next tab with link is not needed.
		// If you want to show a disabled next tab,
		//	 create an image 'right_inactive.png', put it into themes/YOUR_THEME/images/icons/,
		//	 then uncomment the line below.
		// $tabs .= sprintf($template['nav_tab_nolink'], cpg_fetch_icon('right_inactive',0,$lang_create_tabs['next']));
	}

	// Trailer for tabs
	$tabs .= $template['tab_trailer'];

	return $tabs;
}


function theme_drop_menu ($title, $menu)
{
	if (!$menu) return '';
	return <<<EOT
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{$title}</a>
		<ul class="dropdown-menu" role="menu">{$menu}</ul>
	</li>
EOT;
}


// Function for the JavaScript inside the <head>-section
function theme_javascript_head ()
{
	global $JS, $THEME_DIR, $LINEBREAK;

	$return = '';

	// Check if we have any variables being set using set_js_vars function
	if (!empty($JS['vars'])) {
		// Convert the $JS['vars'] array to json object string
		$json_vars = json_encode($JS['vars']);
		// Output the json object
		$return .= <<<EOT
<script>
	var js_vars = $json_vars;
</script>

EOT;
	}

	// Check if we have any js includes
	if (!empty($JS['includes'])) {
		// Bring the jquery core library to the very top of the list
		if (in_array(CPG_JQUERY_VERSION, $JS['includes']) == TRUE) {
			$key = array_search(CPG_JQUERY_VERSION, $JS['includes']);
			unset($JS['includes'][$key]);
	//		// don't use the default CPG jQuery version
			array_unshift($JS['includes'], CPG_JQUERY_VERSION);
		}
		$JS['includes'] = CPGPluginAPI::filter('javascript_includes',$JS['includes']);
		// Include all the files which were set using js_include() function
		require_once 'helper.class.php';
		foreach ($JS['includes'] as $js_file) {
			// use an updated elastic
			if ($js_file == 'js/jquery.elastic.js') $js_file = $THEME_DIR . 'js/elastic.min.js';
			// clean up undesired attributes
			$return .= H5R_Help::stripAttributes(js_include($js_file, true), 'type') . $LINEBREAK;
		}
	}

	return $return;
}


function pageheader ($section, $meta = '')
{
	global $CONFIG, $THEME_DIR, $ThemeBanner, $ThemeBanner2, $BannerHomeOnly, $cat, $template_header, $lang_charset, $lang_text_dir, $lang_main_menu;

	$theme_lang_path = $THEME_DIR.'/lang/';
	require $theme_lang_path.'english.php';
	if ($CONFIG['lang'] != 'english' && file_exists($theme_lang_path."{$CONFIG['lang']}.php")) {
		require $theme_lang_path."{$CONFIG['lang']}.php";
	}

	$custom_header = cpg_get_custom_include($CONFIG['custom_header_path']);

	$charset = ($CONFIG['charset'] == 'language file') ? $lang_charset : $CONFIG['charset'];

	header("Content-Type: text/html; charset=$charset");
	user_save_profile();

	$stylcss = file_exists($THEME_DIR.'custom.css') ? 'custom.css' : 'style.css';

	switch ($CONFIG['thumb_use']) {
		case 'any':
		case 'ht':
		case 'wd':
			$tw = $th = round($CONFIG['thumb_width'] * 0.75);
			break;
		case 'ex':
			$tw = $CONFIG['thumb_width'];
			$th = $CONFIG['thumb_height'];
	}
	$ats = round($CONFIG['alb_list_thumb_size'] * 0.75);
	$acs = $ats * 3;
	// insert some dynmaic CSS
	$dcss = <<<EOT
	.r-thm-box {
		width: {$tw}px;
		height: {$th}px;
	}
	.r-thumbnail span {
		max-width: {$tw}px;
	}
	.a-thm-box {
		width: {$ats}px;
		height: {$ats}px;
	}
	.album-cell {
		width: {$acs}px;
	}
EOT;

	// CSS overrides for some particular pages
	if (defined('EDITPICS_PHP')) {
		$dcss .= <<<EOT
	textarea, .listbox {
		width: 100%;
	}
	.listbox {
		max-width: fit-content;
	}
	textarea {
		/*height: 5em;*/
		font-size: inherit;
	}
	td.tableb {
		padding: 6px 4px;
		white-space: normal !important;
	}
	input[name="filename"] {
		width:100%;
	}
	@media (max-width: 767px) {
		.image {
			width: {$CONFIG['alb_list_thumb_size']}px;
		}
	}
EOT;
	}

	$fullb = !$BannerHomeOnly || ($cat==0);
	$template_vars = array(
		'{LANG_DIR}' => $lang_text_dir,
		'{TITLE}' => theme_page_title($section),
		'{CHARSET}' => $charset,
		'{META}' => $meta,
		'{BANNER}' => $fullb ? $ThemeBanner : $ThemeBanner2,
		'{GAL_NAME}' => $CONFIG['gallery_name'],
		'{GAL_DESCRIPTION}' => $CONFIG['gallery_description'],
		'{SYS_MENU}' => theme_main_menu('sys_menu'),
		'{SUB_MENU}' => theme_drop_menu($lang_main_menu['views_dropdown'] ,theme_main_menu('sub_menu')),
		'{ADMIN_MENU}' => theme_drop_menu($lang_main_menu['admin_dropdown'] ,theme_admin_mode_menu()),
		'{CUSTOM_HEADER}' => $custom_header,
		'{JAVASCRIPT}' => theme_javascript_head(),
		'{MESSAGE_BLOCK}' => theme_display_message_block(),
		'{STYLE_CSS}' => $stylcss,
		'{DYN_CSS}' => '<style>' . $dcss . '</style>',
		'{H5R_VER}' => '0.8'
	);

	$template_vars = CPGPluginAPI::filter('theme_pageheader_params', $template_vars);
	echo template_eval($template_header, $template_vars);

	// Show various admin messages
	adminmessages();
}

// Function for the credits-section
function theme_credits ()
{
	$return = <<<EOT
<div class="footer credits">Powered by <a href="http://coppermine-gallery.net/" title="Coppermine Photo Gallery" rel="external">Coppermine Photo Gallery</a></div>
EOT;
	return $return;
}

//EOF
