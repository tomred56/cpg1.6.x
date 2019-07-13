<?php

abstract class H5R_Help
{
	// manipulate the album admin menu to our liking
	public static function alb_adm_mnu ($menu)
	{
		global $CONFIG;
		if ($CONFIG['enable_menu_icons']==0) return $menu;
		$mnu = $menu;
		$mnu = trim(strip_tags($mnu, '<a><img>'));
		$mtch = [];
		preg_match_all('|<a.+/a>|', $mnu, $mtch);
		$rtn = '';
		foreach ($mtch[0] as $lnk) {
			$rtn .= str_replace(strip_tags($lnk), '', $lnk);
		}
		return '<div class="buttonlist-cac cols-3 right">' . $rtn. '</div>';
	}

	public static function thm_sort_ui ($sort_code)
	{
		global $THEME_DIR, $lang_common, $lang_thumb_view;
		$sb = substr($sort_code, 0, 1);
		$so = substr($sort_code, 1, 1) == 'a' ? 'd' : 'a';
		$sbtxt = array(
			't' => $lang_common['title'],
			'n' => $lang_thumb_view['name'],
			'd' => $lang_thumb_view['date'],
			'p' => $lang_thumb_view['position']
			);
		$rtn = '<select class="thm-srt-by" onchange="sort_sel_val(this)">';
		foreach ($sbtxt as $b => $t) {
			$rtn .= '<option value="' . $b . '"' . ($b == $sb ? ' selected="selected"' : '') . '>'.$t.'</option>';
		}
		$rtn .= '</select>';
		$rtn .= '&nbsp;&nbsp;<img class="thm-srt-ord" src="'.$THEME_DIR.'images/alpha-asc.png" onclick="sort_sel_dir(this)" data-dir="'.$so.'">';
		return $rtn;
	}

	public static function thm_sort_ui_sgl ($sort_code)
	{
		global $THEME_DIR, $lang_common, $lang_thumb_view;
		$sbtxt = array(
			'ta' => '&#8648; ' . $lang_common['title'],
			'td' => '&#8650; ' . $lang_common['title'],
			'na' => '&#8648; ' . $lang_thumb_view['name'],
			'nd' => '&#8650; ' . $lang_thumb_view['name'],
			'da' => '&#8648; ' . $lang_thumb_view['date'],
			'dd' => '&#8650; ' . $lang_thumb_view['date'],
			'pa' => '&#8648; ' . $lang_thumb_view['position'],
			'pd' => '&#8650; ' . $lang_thumb_view['position']
			);
		$rtn = '<select class="thm-srt-by" onchange="sort_sel_sbd(this)">';
		foreach ($sbtxt as $b => $t) {
			$rtn .= '<option value="' . $b . '"' . ($b == $sort_code ? ' selected="selected"' : '') . '>'.$t.'</option>';
		}
		$rtn .= '</select>';
		return $rtn;
	}

	public static function stripAttributes ($str, $attrs)
	{
		if (!is_array($attrs)) $attrs = array($attrs);
		foreach ($attrs as $attr) {
			$str = preg_replace('# '.$attr.'="[^=]+"#', '', $str);
		}
		return $str;
	}

}
