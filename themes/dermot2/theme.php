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

define('THEME_HAS_PROGRESS_GRAPHICS', 1);

// HTML template for template sys_menu spacer
$template_sys_menu_spacer = '<img src="'.$THEME_DIR.'images/orange_carret.gif"  width="8" height="8" border="0" alt="" />';


/******************************************************************************
** Section <<<$template_thumbnail_view>>> - START
******************************************************************************/

// HTML template for thumbnails display
$template_thumbnail_view = <<<EOT

<!-- BEGIN header -->
        <tr>
<!-- END header -->
<!-- BEGIN thumb_cell -->
        <td valign="top" class="thumbnails" width ="{CELL_WIDTH}" align="center">
                <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                                <td align="center">
                                        <a href="{LINK_TGT}">{THUMB}<br /></a>
                                        {CAPTION}
                                        {ADMIN_MENU}
                                </td>
                        </tr>
                </table>
        </td>
<!-- END thumb_cell -->
<!-- BEGIN empty_cell -->
                <td valign="top" class="thumbnails" align="center">&nbsp;</td>
<!-- END empty_cell -->
<!-- BEGIN row_separator -->
        </tr>
        <tr>
<!-- END row_separator -->
<!-- BEGIN footer -->
        </tr>
<!-- END footer -->
<!-- BEGIN tabs -->
        <tr>
                <td colspan="{THUMB_COLS}" style="padding: 0px;">
                        <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                       {TABS}
                                </tr>
                        </table>
                </td>
        </tr>
<!-- END tabs -->
<!-- BEGIN spacer -->
        <img src="images/spacer.gif" width="1" height="7" border="" alt="" /><br />
<!-- END spacer -->

EOT;
/******************************************************************************
** Section <<<$template_thumbnail_view>>> - END
******************************************************************************/



/******************************************************************************
** Section <<<theme_display_thumbnails>>> - START
******************************************************************************/
function theme_display_thumbnails(&$thumb_list, $nbThumb, $album_name, $aid, $cat, $page, $total_pages, $sort_options, $display_tabs, $mode = 'thumb', $date='')
{
    global $CONFIG, $CURRENT_ALBUM_DATA;
    global $template_thumb_view_title_row,$template_fav_thumb_view_title_row, $lang_thumb_view, $lang_common, $template_tab_display, $template_thumbnail_view, $lang_album_list, $lang_errors;

    $superCage = Inspekt::makeSuperCage();

    static $header = '';
    static $thumb_cell = '';
    static $empty_cell = '';
    static $row_separator = '';
    static $footer = '';
    static $tabs = '';
    static $spacer = '';

    if ($header == '') {
        $thumb_cell = template_extract_block($template_thumbnail_view, 'thumb_cell');
        $tabs = template_extract_block($template_thumbnail_view, 'tabs');
        $header = template_extract_block($template_thumbnail_view, 'header');
        $empty_cell = template_extract_block($template_thumbnail_view, 'empty_cell');
        $row_separator = template_extract_block($template_thumbnail_view, 'row_separator');
        $footer = template_extract_block($template_thumbnail_view, 'footer');
        $spacer = template_extract_block($template_thumbnail_view, 'spacer');
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
    $cell_width = ceil(100 / $CONFIG['thumbcols']) . '%';

    $tabs_html = $display_tabs ? create_tabs($nbThumb, $page, $total_pages, $theme_thumb_tab_tmpl) : '';

    if (!GALLERY_ADMIN_MODE && stripos($template_thumb_view_title_row, 'admin_buttons') !== false) {
        template_extract_block($template_thumb_view_title_row, 'admin_buttons');
    }
    // The sort order options are not available for meta albums
    if ($sort_options) {
        if (GALLERY_ADMIN_MODE) {
            $param = array(
                '{ALBUM_ID}'   => $aid,
                '{CAT_ID}'     => ($cat > 0 ? $cat : $CURRENT_ALBUM_DATA['category']),
                '{MODIFY_LNK}'     => $lang_common['album_properties'],
                '{MODIFY_ICO}'     => cpg_fetch_icon('modifyalb', 1),
                '{PARENT_CAT_LNK}' => $lang_common['parent_category'],
                '{PARENT_CAT_ICO}' => cpg_fetch_icon('category', 1),
                '{EDIT_PICS_LNK}'  => $lang_common['edit_files'],
                '{EDIT_PICS_ICO}'  => cpg_fetch_icon('edit', 1),
                '{ALBUM_MGR_LNK}'  => $lang_common['album_manager'],
                '{ALBUM_MGR_ICO}'  => cpg_fetch_icon('alb_mgr', 1),
            );
        } else {
            $param = array();
        }
        $param['{ALBUM_NAME}'] = $album_name;
        // Plugin Filter: allow plugin to modify or add tags to process
        $param = CPGPluginAPI::filter('theme_thumbnails_title', $param);
        $title = template_eval($template_thumb_view_title_row, $param);
    } elseif ($aid == 'favpics' && $CONFIG['enable_zipdownload'] > 0) { //Lots of stuff can be added here later
        $param = array(
            '{ALBUM_ID}'   => $aid,
            '{ALBUM_NAME}' => $album_name,
            '{DOWNLOAD_ZIP}' => cpg_fetch_icon ('zip', 2) . $lang_thumb_view['download_zip'],
        );
        // Plugin Filter: allow plugin to modify or add tags to process
        $param = CPGPluginAPI::filter('theme_thumbnails_title', $param);
        $title = template_eval($template_fav_thumb_view_title_row, $param);
    } else {
        $title = $album_name;
    }

    CPGPluginAPI::action('theme_thumbnails_wrapper_start', null);

    if ($mode == 'thumb') {
        starttable('100%', $title, $thumbcols);
    } else {
        starttable('100%');
    }

    $header = CPGPluginAPI::filter('theme_thumbnails_header', $header);
    echo $header;

    $i = 0;
    global $thumb;  // make $thumb accessible to plugins
    foreach($thumb_list as $thumb) {
       
        $i++;
        if ($mode == 'thumb') {
            if (in_array($aid, $album_types['albums'])) {
                $params = array(
                    '{CELL_WIDTH}' => $cell_width,
                    '{LINK_TGT}'   => "thumbnails.php?album={$thumb['aid']}",
                    '{THUMB}'      => $thumb['image'],
                    '{CAPTION}'    => $thumb['caption'],
                    '{ADMIN_MENU}' => $thumb['admin_menu'],
                );
            } else {
                // determine if thumbnail link targets should open in a pop-up
                if ($CONFIG['thumbnail_to_fullsize'] == 1) { // code for full-size pop-up
                    if (!USER_ID && $CONFIG['allow_unlogged_access'] <= 2) {
                       $target = 'javascript:;" onclick="alert(\''.sprintf($lang_errors['login_needed'],'','','','').'\');';
                    } elseif (USER_ID && USER_ACCESS_LEVEL <= 2) {
                        $target = 'javascript:;" onclick="alert(\''.sprintf($lang_errors['access_intermediate_only'],'','','','').'\');';
                    } else {
                       $target = 'javascript:;" onclick="MM_openBrWindow(\'displayimage.php?pid=' . $thumb['pid'] . '&fullsize=1\',\'' . uniqid(rand()) . '\',\'scrollbars=yes,toolbar=no,status=no,resizable=yes,width=' . ((int)$thumb['pwidth']+(int)$CONFIG['fullsize_padding_x']) .  ',height=' .   ((int)$thumb['pheight']+(int)$CONFIG['fullsize_padding_y']). '\');';
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
                    '{CELL_WIDTH}' => $cell_width,
                    '{LINK_TGT}'   => $target,
                    '{THUMB}'      => $thumb['image'],
                    '{CAPTION}'    => $thumb['caption'],
                    '{ADMIN_MENU}' => $thumb['admin_menu'],
                );
            }

        } else {  // mode != 'thumb'

            // Used for mode = 'user' from list_users() in index.php
            $params = array(
                '{CELL_WIDTH}' => $cell_width,
                '{LINK_TGT}'   => "index.php?cat={$thumb['cat']}",
                '{THUMB}'      => $thumb['image'],
                '{CAPTION}'    => $thumb['caption'],
                '{ADMIN_MENU}' => '',
            );

        }

        // Plugin Filter: allow plugin to modify or add tags to process
        $params = CPGPluginAPI::filter('theme_display_thumbnails_params', $params);
        echo template_eval($thumb_cell, $params);

        if ((($i % $thumbcols) == 0) && ($i < count($thumb_list))) {
            echo $row_separator;
        }
    } // foreach $thumb

    unset($thumb);  // unset $thumb to avoid conflicting with global

    for (;($i % $thumbcols); $i++) {
        echo $empty_cell;
    }
    $footer = CPGPluginAPI::filter('theme_thumbnails_footer', $footer);
    echo $footer;

    if ($display_tabs) {
        $params = array(
            '{THUMB_COLS}' => $thumbcols,
            '{TABS}'       => $tabs_html,
        );
        echo template_eval($tabs, $params);
    }

    endtable();
    CPGPluginAPI::action('theme_thumbnails_wrapper_end', null);
    echo $spacer;
}
/******************************************************************************
** Section <<<theme_display_thumbnails>>> - END
******************************************************************************/


/******************************************************************************
** Section <<<$template_display_media>>> - START
******************************************************************************/
// HTML template for intermediate image display
$template_display_media = <<<EOT
        <tr>
            <td align="center" class="display_media" nowrap="nowrap">
                <table width="100%" cellspacing="2" cellpadding="0">
                    <tr>
                        <td align="center" width="60%" style="{SLIDESHOW_STYLE}">
                            {IMAGE} 
                        </td>
                        <td valign="top" align="left" width="40%" height="100%">
<!-- BEGIN img_desc -->
                            <div height="100%" class="flex_box">
<!-- BEGIN title -->
								<div style="flex-grow: 1 order: 1">
										<h1 align="center">{TITLE} 
										</h1> <br />
									
								</div>
<!-- END title -->
<!-- BEGIN caption -->
								<div style="flex-grow: 7 order: 2">
										<h2>{CAPTION}
										</h2><br />
								</div>
								<div style="flex-grow: 7 order: 2">
										<h2>{OWNER}
										</h2><br />
										<h2>{INSURANCE}
										</h2><br />
										<h2>{LOCATION}
										</h2><br />
								</div>
								<div style="flex-grow: 1 order: 3">
										<h3> {THUMBS} 
										</h3>
                                </div>
<!-- END caption -->
								<div style="flex-grow: 1 order: 4 " >
                                        <h3 >{ADMIN_MENU}</h3>
								</div>
<!-- END img_desc -->
							</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

EOT;

/******************************************************************************
** Section <<<$template_display_media>>> - END
******************************************************************************/




/******************************************************************************
** Section <<<theme_html_picture>>> - START
******************************************************************************/
// Displays a picture
function theme_html_picture()
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

            $CURRENT_PIC_DATA['pwidth']  = $pwidth; // Default width

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
        list($image_size['width'], $image_size['height'], , $image_size['geom']) = cpg_getimagesize(urldecode($picture_url));

        if ($CURRENT_PIC_DATA['mode'] != 'fullsize') {
            $winsizeX = $CURRENT_PIC_DATA['pwidth'] + $CONFIG['fullsize_padding_x'];  //the +'s are the mysterious FF and IE paddings
            $winsizeY = $CURRENT_PIC_DATA['pheight'] + $CONFIG['fullsize_padding_y']; //the +'s are the mysterious FF and IE paddings
            if ($CONFIG['transparent_overlay'] == 1) {
                $pic_html = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td background=\"" . $picture_url . "\" width=\"{$image_size['width']}\" height=\"{$image_size['height']}\" class=\"image\">";
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
                    $pic_html .= "<a href=\"javascript:;\" onclick=\"MM_openBrWindow('displayimage.php?pid=$pid&amp;fullsize=1','" . uniqid(rand()) . "','scrollbars=yes,toolbar=no,status=no,resizable=yes,width=$winsizeX,height=$winsizeY')\">";
                }
                $pic_title = $lang_display_image_php['view_fs'] . $LINEBREAK . '==============' . $LINEBREAK . $pic_title;
                $pic_html .= "<img src=\"images/image.gif?id=".floor(rand()*1000+rand())."\" width=\"{$image_size['width']}\" height=\"{$image_size['height']}\"  border=\"0\" alt=\"{$lang_display_image_php['view_fs']}\" /><br />";
                $pic_html .= $pic_html_href_close . '</td></tr></table>';
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
                    $pic_html = "<a href=\"javascript:;\" onclick=\"MM_openBrWindow('displayimage.php?pid=$pid&amp;fullsize=1','" . uniqid(rand()) . "','scrollbars=yes,toolbar=no,status=no,resizable=yes,width=$winsizeX,height=$winsizeY')\">";
                }
                $pic_title = $lang_display_image_php['view_fs'] . $LINEBREAK . '==============' . $LINEBREAK . $pic_title;
                $pic_html .= "<img src=\"" . $picture_url . "\" {$image_size['geom']} class=\"image\" border=\"0\" alt=\"{$lang_display_image_php['view_fs']}\" /><br />";
                $pic_html .= $pic_html_href_close;
                //PLUGIN FILTER
                $pic_html = CPGPluginAPI::filter('html_image_reduced', $pic_html);
            }
        } else {
            if ($CONFIG['transparent_overlay'] == 1) {
                $pic_html = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td background=\"" . $picture_url . "\" width=\"{$CURRENT_PIC_DATA['pwidth']}\" height=\"{$CURRENT_PIC_DATA['pheight']}\" class=\"image\">";
                $pic_html .= "<img src=\"images/image.gif?id=".floor(rand()*1000+rand())."\" width={$CURRENT_PIC_DATA['pwidth']} height={$CURRENT_PIC_DATA['pheight']} border=\"0\" alt=\"\" /><br />" . $LINEBREAK;
                $pic_html .= "</td></tr></table>";
                //PLUGIN FILTER
                $pic_html = CPGPluginAPI::filter('html_image_overlay', $pic_html);
            } else {
                $pic_html = "<img src=\"" . $picture_url . "\" {$image_size['geom']} class=\"image\" border=\"0\" alt=\"\" /><br />" . $LINEBREAK;
                //PLUGIN FILTER
                $pic_html = CPGPluginAPI::filter('html_image', $pic_html);
            }
        }
    } elseif ($mime_content['content']=='document') {
        $pic_thumb_url = get_pic_url($CURRENT_PIC_DATA,'thumb');
        $pic_html = "<a href=\"{$picture_url}\" target=\"_blank\" class=\"document_link\"><img src=\"".$pic_thumb_url."\" border=\"0\" class=\"image\" /></a><br />" . $LINEBREAK;
        //PLUGIN FILTER
        $pic_html = CPGPluginAPI::filter('html_document', $pic_html);
    } else {
        $autostart = ($CONFIG['media_autostart']) ? ('true'):('false');

        if ($mime_content['player'] == 'HTMLA') {
            $pic_html  = '<audio controls="true" src="' . $picture_url . '" autostart="' . $autostart . '"></audio>';
        } elseif ($mime_content['player'] == 'HTMLV') {
            $pic_html  = '<video controls="true" src="' . $picture_url . '" autostart="' . $autostart . '"' . $image_size['whole'] . '></video>';
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
            $players['QT']  = array('id' => 'QuickTime',
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

            $pic_html  = '<object id="'.$player['id'].'" '.$player['data'].$player['clsid'].$player['codebase'].$player['mime'].$image_size['whole'].'>';
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

    $cap = $CURRENT_PIC_DATA['caption'];
    $thumbs='';
	$title = $CURRENT_PIC_DATA['title'];
    $caption = bb_decode($cap);
    $owner = '';
    $insurance = '';
    $location = '';

    if ($CURRENT_PIC_DATA['user1'] <> '') {
        $location = '[b]Location:[/b] ' . $CURRENT_PIC_DATA['user1'] . " <br />" ;
    }
    if ($CURRENT_PIC_DATA['user2'] <> '') {
        $insurance = '[b]Insurance:[/b] ' . $CURRENT_PIC_DATA['user2'] . " <br />" ;
    }
    if ($CURRENT_PIC_DATA['user3']  <> '') {
		$people = explode('/',$CURRENT_PIC_DATA['user3'],2);
        $owner .= '[b]Belongs to:[/b] ' . $people[0] ;
		if (count($people) > 1) {
			$owner .= '&emsp;&&emsp;[b]Liked by:[/b] ' . $people[1] . " <br />";
		}
    }
	
	if ($CURRENT_PIC_DATA['user4'] <> '') {
		$pid = $CURRENT_PIC_DATA['pid'];
	    $id = $CURRENT_PIC_DATA['user4'];
		$title = "($id)&emsp;$title";
       $result = cpg_db_query("SELECT pid,title,filepath,filename,pwidth,pheight FROM {$CONFIG['TABLE_PICTURES']} AS p WHERE user4 = '$id' and pid <> $pid $FORBIDDEN_SET LIMIT 10");

       if ($result->numRows() == 0) {
		   $thumbs = 'No other pictures found';
	   }
	   else{
		   while ( ($row = $result->fetchAssoc()) ) {

			 $url = "displayimage.php?pid=" . $row['pid'];
			 $img = $CONFIG['ecards_more_pic_target'] . $CONFIG['fullpath'] . $row['filepath'] . $CONFIG['thumb_pfx'] . $row['filename'];
			 $width = $row['pwidth'];
			 $height = $row['pheight'];
			 $id =uniqid(rand());
			 $thumb= "<a href=\"javascript:;\" onclick=\"MM_openBrWindow('$url&amp;fullsize=1','$id','scrollbars=yes,toolbar=no,status=no,resizable=yes,width=$width,height=$height')\"><img src=\"$img\" class=\"image\" border=\"0\" alt=\"Click to view full size image\" /></a>";         
			 $thumbs .= $thumb;
		   }
			$result->free();
	   }
	}
	else {
		$thumbs = 'Reference field must be entered to locate other pictures.';
    }

    $params = array('{CELL_HEIGHT}' => '100',
        '{IMAGE}' => $CURRENT_PIC_DATA['header'].$CURRENT_PIC_DATA['html'].$CURRENT_PIC_DATA['footer'],
        '{ADMIN_MENU}' => $CURRENT_PIC_DATA['menu'],
        '{TITLE}' => bb_decode($title),
        '{CAPTION}' => $caption,
        '{OWNER}' => bb_decode($owner),
        '{INSURANCE}' => bb_decode($insurance),
        '{LOCATION}' => bb_decode($location),
        '{THUMBS}' => $thumbs
        );

    return template_eval($template_display_media, $params);
}
/******************************************************************************
** Section <<<theme_html_picture>>> - END
******************************************************************************/

//EOF