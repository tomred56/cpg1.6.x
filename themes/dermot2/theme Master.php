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
$template_sys_menu_spacer = '<img src="'.$THEME_DIR.'images/orange_carret.gif" width="8" height="8" border="0" alt="" />';

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

    $detail_info = bb_decode($CURRENT_PIC_DATA['caption']);

    if ($CURRENT_PIC_DATA['user1'] <> '') {
        $detail_info .=  '<BR />Location: '.$CURRENT_PIC_DATA['user1'] ;
    }
    if ($CURRENT_PIC_DATA['user2'] <> '') {
        $detail_info .= '<BR />Insurance: '.$CURRENT_PIC_DATA['user2'] ;
    }
    if ($CURRENT_PIC_DATA['user3']  <> '') {
        $detail_info .= '<BR />Belongs to: '.$CURRENT_PIC_DATA['user3'] ;
    }
    if ($CURRENT_PIC_DATA['user4']  <> '') {
        $detail_info .= '&emsp;&&emsp;Liked by: '.$CURRENT_PIC_DATA['user4'];
    }

    $params = array('{CELL_HEIGHT}' => '100',
        '{IMAGE}' => $CURRENT_PIC_DATA['header'].$CURRENT_PIC_DATA['html'].$CURRENT_PIC_DATA['footer'],
        '{ADMIN_MENU}' => $CURRENT_PIC_DATA['menu'],
        '{TITLE}' => bb_decode($CURRENT_PIC_DATA['title']),
        '{CAPTION}' => $detail_info
        );

    return template_eval($template_display_media, $params);
}
/******************************************************************************
** Section <<<theme_html_picture>>> - END
******************************************************************************/

//EOF