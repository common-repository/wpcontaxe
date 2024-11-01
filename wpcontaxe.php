<?php
/*
Plugin Name: wpCONTAXE
Plugin URI: http://www.contaxe.com/de/texte/wpcontaxe/
Description: CONTAXE-Werbemittel in deinen Wordpress-Blog einbinden.
Version: 1.3.2
Author: CONTAXE AG
Author URI: http://www.contaxe.com
*/

/*
 * rule system greatly inspired by whoseesads from Ozh
 * http://planetozh.com/blog/my-projects/wordpress-plugin-who-sees-ads-control-adsense-display/
 * released under GPLv2
 */

require_once(dirname(__FILE__) . '/defines.php');

if (!class_exists('WPContaxe')) {

class WPContaxe {
	var $adminOptionsName	= 'wpcontaxe';
	var $options			= NULL;
	var $cntBanners			= 0;

	function activatePlugin() {
		$this->getAdminOptions();
	}

	function getAdminOptions() {
		if (isset($this->options)) return $this->options;

		$admin_options = array(
			'api_key'				=> '',
			'global_channel'		=> '',
			'global_adminssee'		=> 'demo',		// current_user_can('manage_options')
			'global_userssee'		=> 'ads',		// is_user_logged_in
			'global_visitorssee'	=> 'ads',		// else ...
			'global_regularvisits'	=> '3',			// regular visitor has X visits...
			'global_regulardays'	=> '10',		// ...in the last Y days.
			'highlighter_enabled'	=> false,
			'highlighter_channel'	=> '',			// c
			'highlighter_style'		=> '',			// s
			'highlighter_words'		=> 5,			// hw	1-10
			'highlighter_repeat'	=> 5,			// wr	1-100
			'highlighter_delay'		=> 2000,		// pct	500-4000
			'highlighter_charset'	=> 0,			// cs
			'highlighter_rules'		=> array(),
			'isa_enabled'			=> false,
			'isa_channel'			=> '',			// c
			'banners'				=> array(),		// banners
			'positions'				=> array(),		// positions
			'version'				=> 132,			// version of plugin
			'api_cache'				=> NULL,		// cached api data (fallback)
			'disable_ssl_verify'	=> false,		// disable certificate check when doing api calls
		);
		$options = get_option($this->adminOptionsName);
		if (!empty($options)) {
			foreach ($options as $key => $option) $admin_options[$key] = $option;
			if (empty($options['version'])) {
				foreach ($admin_options['banners'] as $key => $value) {
					if ($value['format'] != 15) continue;
					$admin_options['banners'][$key]['format'] = 50;
				}
			}
			if (empty($options['version']) || $options['version'] < 120) {
				if (isset($admin_options['ias_enabled'])) {
					$admin_options['isa_enabled'] = $admin_options['ias_enabled'];
					unset($admin_options['ias_enabled']);
				}
				if (isset($admin_options['ias_channel'])) {
					$admin_options['isa_channel'] = $admin_options['ias_channel'];
					unset($admin_options['ias_channel']);
				}
				foreach ($admin_options['banners'] as $key => $value) {
					if (!isset($admin_options['banners'][$key]['format'])) continue;
					if ($value['rnd'] && $value['opt'] < 3) $admin_options['banners'][$key]['opt'] = 3;
					$admin_options['banners'][$key]['rnd'] = $GLOBALS['WPCONTAXE_BANNER_OPTIMIZATION_MAP'][$value['opt']];
					unset($admin_options['banners'][$key]['opt']);
					if (isset($GLOBALS['WPCONTAXE_FORMAT_MAP'][$value['format']])) {
						$admin_options['banners'][$key] = array_merge($admin_options['banners'][$key], $GLOBALS['WPCONTAXE_FORMAT_MAP'][$value['format']]);
						unset($admin_options['banners'][$key]['format']);
					}
				}
				$admin_options['version'] = 120;
			}
			if (!empty($options['version']) && $options['version'] < 123) {
				unset($admin_options['widgets']);
				$admin_options['version'] = 123;
			}
			if (!empty($options['version']) && $options['version'] < 130) {
				$admin_options['api_key'] = '';
				$admin_options['api_cache'] = NULL;
				$admin_options['version'] = 130;
			}
			if (!empty($options['version']) && $options['version'] < 132) {
				$admin_options['disable_ssl_verify'] = false;
				$admin_options['version'] = 132;
			}
		}
		update_option($this->adminOptionsName, $admin_options);
		$this->options = $admin_options;
		return $this->options;
	}

	function registerAdminMenu() {
		global $plugin_page;
		if (is_plugin_page() && strpos($plugin_page, 'wpcontaxe') !== false) {
			wp_enqueue_script('scriptaculous');
		}
		add_menu_page('CONTAXE-Werbung', 'CONTAXE-Werbung', 9, __FILE__, array(&$this, 'adminGeneralSettings'));
		add_submenu_page(__FILE__, 'Allgemein', 'Allgemein', 9, __FILE__, array(&$this, 'adminGeneralSettings'));
		add_submenu_page(__FILE__, 'InText-Werbung', 'InText-Werbung', 9, 'wpcontaxe/admin/highlighter.php');
		add_submenu_page(__FILE__, 'Intelligent Search Ad', 'Intelligent Search Ad', 9, 'wpcontaxe/admin/isa.php');
		add_submenu_page(__FILE__, 'Banner', 'Banner', 9, 'wpcontaxe/admin/banner.php');
		add_submenu_page(__FILE__, 'Banner positionieren', 'Banner positionieren', 9, 'wpcontaxe/admin/positions.php');
	}

	function printAdminCSS() {
		global $plugin_page;
		if (!is_plugin_page() || strpos($plugin_page, 'wpcontaxe') === false) return;
		$GLOBALS['WPCONTAXE_HELP_IMAGE'] = get_bloginfo('url') . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/images/help.gif';
?>
<style type="text/css">
.wpcontaxe_sortable {
	border:1px solid #dfdfdf;
	margin:0;
	padding:5px;
}
.wpcontaxe_sortable:hover {
	border: 1px solid #ccc;
}
.wpcontaxe_sortable_1 {
	list-style-type:none;
}
.wpcontaxe_sortable_2 {
	list-style-type:decimal !important;
	list-style-type:none;
}
.wpcontaxe_sortable li tt {
	color:#777;
	font-style: italic;
}
.wpcontaxe_sortable li {
	border:1px solid #dfdfdf;
	padding:2px 10px;
	background:#fff;
	white-space:nowrap;
}
.wpcontaxe_sortable li:hover {
	background:#f5f5f5;
}
.wpcontaxe_handle {
	color: #000;
	font-size: 16px;
	font-weight: bolder;
	cursor: move;
}
.wpcontaxe_helpbox {
	position:absolute;
	right:50px;
	margin:15 5%;
	z-index:9999;
	font-size:11px;
	width:306px;
	padding:2px 10px 10px 20px;
	border:2px solid #ff3;
	background:#ffc;
}
.wpcontaxe_helpbox h3 {
	font-size: 120%;
}
.wpcontaxe_helpicon {
	cursor: pointer;
}

.form-field #channel-input, .form-field #place-input, .form-field #style-input, .form-field #words, .form-field #repeat, .form-field #delay, .form-field .position {
	width: 10em;
	text-align: right;
}

.form-field label input {
	width: 2em;
}

.form-table .helpicon-row {
	width: 20px;
	vertical-align: top;
}
</style>
<?php
	}

	function printAdminJS() {
		global $plugin_page;
		if (!is_plugin_page() || strpos($plugin_page, 'wpcontaxe') === false) return;
?>
<script type="text/javascript">
// <![CDATA[
	// Help display function
	function wpcontaxe_togglehelp(item,target) {
		if(!$(item)) return;
		$(item).onmouseover=function(e) {
			// for MSIE: get event, and hide <select> elements
			if (!e) {
				var e = window.event; 
				wpcontaxe_toggleselect('hide',target);
			}
			Effect.Appear($(target),{duration:0.2});
			$(target).style.top = (Event.pointerY(e)+20)+'px';
			//$(target).style.left = (Event.pointerX(e)+20)+'px';
		};
		$(item).onmouseout=function(e){
			if (!e) wpcontaxe_toggleselect('show');
			Effect.Fade($(target),{duration:0.1});
		};
	}
	
	function wpcontaxe_show_select_input(elem, target) {
		if (elem.value == -1) {
			Effect.Appear($(target),{duration:0.2});
		}
		else {
			Effect.Fade($(target),{duration:0.1});
		}
	}

	function wpcontaxe_onchange_place(elem, target) {
		wpcontaxe_show_select_input(elem, target)
		if (elem.value == '' || elem.value == 0) {
			elem.value = 0;
			Effect.multiple($$('.olddata'),Effect.Appear,{duration:0.5});
		}
		else {
			Effect.multiple($$('.olddata'),Effect.Fade,{duration:0.5});
		}
	}

	
	// Toggle visibility of <select> elements (for MSIE, grrr)
	var wpcontaxe_visibledrops = new Array();
	function wpcontaxe_toggleselect(action,helpdiv) {
		if (action == 'hide') {
			document.getElementsByClassName('wpcontaxe_select').each(function(item){
				// if element is visible (ie inside a visible <ul>) hide it and add it to our list
				wpcontaxe_visibledrops[wpcontaxe_visibledrops.length] = item;
				$(item).style.visibility = 'hidden';
			});
		} else {
			// show every item in our list
			wpcontaxe_visibledrops.each(function(item){
				$(item).style.visibility = 'visible';
			});
			// all elements now back to visible, empty our list
			wpcontaxe_visibledrops = new Array();
		}
	}
	// Help stuff init
	['api_key', 'channel','design','disable_ssl_verify','words','repeat','delay','place','params','name','active','possible'].each(function(item){
		wpcontaxe_togglehelp('helpicon_'+item,'helpbox_'+item);
	});

// ]]>
</script>
<?php
	}

	function adminGeneralSettings() {
		$options = $this->getAdminOptions();
		if (isset($_POST['update_general'])) {
			check_admin_referer('wpcontaxe-update-general');
			$options['api_key']				= $_POST['api_key'];
			$options['global_channel']		= $_POST['channel-select'] != -1 ? $_POST['channel-select'] : $_POST['channel-input'];
			$options['global_adminssee']	= $_POST['adminssee'];
			$options['global_userssee']		= $_POST['userssee'];
			$options['global_visitorssee']	= $_POST['visitorssee'];
			$options['global_regularvisits']= $_POST['regularvisits'];
			$options['global_regulardays']	= $_POST['regulardays'];
			$options['disable_ssl_verify']	= isset($_POST['disable_ssl_verify']);
			update_option($this->adminOptionsName, $options);
			$this->options = $options;
?>
<div id="contaxe-notice" class="updated fade-00ff00"><p>Einstellungen gespeichert.</p></div>
<?php
		}
		$this->getAPIData(false);
		include(dirname(__FILE__) . '/admin/general-settings-form.php');
	}

	function adminHighlighter() {
		$options = $this->getAdminOptions();
		if (isset($_POST['update_highlighter'])) {
			check_admin_referer('wpcontaxe-update-highlighter');
			$options['highlighter_enabled']	= $_POST['enabled'] == 'true';
			$options['highlighter_channel']	= $_POST['channel-select'] != -1 ? $_POST['channel-select'] : $_POST['channel-input'];
			$options['highlighter_style']	= $_POST['style-select'] != -1 ? $_POST['style-select'] : $_POST['style-input'];
			$options['highlighter_bigfont']	= $_POST['bigfont'] == 'true';
			$options['highlighter_rules']	= $this->parseRules();
			if (is_numeric($_POST['words']))	$options['highlighter_words']	= min(10,   max(1,   $_POST['words'] ));
			if (is_numeric($_POST['repeat']))	$options['highlighter_repeat']	= min(100,  max(1,   $_POST['repeat']));
			if (is_numeric($_POST['delay']))	$options['highlighter_delay']	= min(4000, max(500, $_POST['delay'] ));
			update_option($this->adminOptionsName, $options);
			$this->options = $options;
?>
<div id="contaxe-notice" class="updated fade-00ff00"><p>Einstellungen gespeichert.</p></div>
<?php
		}
		$this->getAPIData();
		include(dirname(__FILE__) . '/admin/highlighter-settings-form.php');
	}

	function adminISA() {
		$options = $this->getAdminOptions();
		if (isset($_POST['update_isa'])) {
			check_admin_referer('wpcontaxe-update-isa');
			$options['isa_enabled']	= $_POST['enabled'] == 'true';
			$options['isa_channel']	= $_POST['channel-select'] != -1 ? $_POST['channel-select'] : $_POST['channel-input'];
			update_option($this->adminOptionsName, $options);
			$this->options = $options;
?>
<div id="contaxe-notice" class="updated fade-00ff00"><p>Einstellungen gespeichert.</p></div>
<?php
		}
		$this->getAPIData();
		include(dirname(__FILE__) . '/admin/isa-settings-form.php');
	}

	function adminPositions() {
		$options = $this->getAdminOptions();
		if (isset($_POST['update_positions'])) {
			check_admin_referer('wpcontaxe-update-positions');
			foreach ($_POST['banner'] as $key => $value) {
				if (empty($value)) {
					unset($options['positions'][$key]);
					continue;
				}
				$options['positions'][$key] = array(
					'banner'	=> $value,
					'position'	=> isset($_POST['position'][$key]) ? $_POST['position'][$key] : 1
				);
			}
			update_option($this->adminOptionsName, $options);
			$this->options = $options;
?>
<div id="contaxe-notice" class="updated fade-00ff00"><p>Einstellungen gespeichert.</p></div>
<?php
		}
		$this->getAPIData();
		include(dirname(__FILE__) . '/admin/positions-form.php');
	}

	function adminBanner() {
		$options = $this->getAdminOptions();
		$this->getAPIData();
		if (!isset($_REQUEST['action'])) {
			include(dirname(__FILE__) . '/admin/list-banners.php');
			return;
		}
		switch ($_REQUEST['action']) {
			case 'add':
				if ($this->addBanner()) break;
				include(dirname(__FILE__) . '/admin/edit-banner.php');
				return;
			case 'edit':
//				if ($this->editBanner()) break;
				$this->editBanner();
				$options = $this->getAdminOptions();
				include(dirname(__FILE__) . '/admin/edit-banner.php');
				return;
			case 'delete':
				if ($this->deleteBanner()) break;
				include(dirname(__FILE__) . '/admin/delete-banner.php');
				return;
			default:
				echo 'Unbekannte Aktion.';
				return;
		}
		$options = $this->getAdminOptions();
		include(dirname(__FILE__) . '/admin/list-banners.php');
	}

	function addBanner() {
		$options = $this->getAdminOptions();
		if (!isset($_POST['action'])) return false;
		check_admin_referer('wpcontaxe-add_new');

		end($options['banners']);
		$id = key($options['banners']) + 1;
		$options['banners'][$id]	= array(
			'id'		=> $id,
			'name'		=> empty($_POST['name']) ? 'Unbenannt ' . $id: $_POST['name'],
			'channel'	=> $_POST['channel-select'] != -1 ? $_POST['channel-select'] : $_POST['channel-input'],
			'params'	=> $_POST['params'],
			'enabled'	=> $_POST['enabled'] == 'true',
			'style'		=> $_POST['style-select'] != -1 ? $_POST['style-select'] : $_POST['style-input'],
			'rules'		=> $this->parseRules(),
			'created'	=> current_time('mysql', 1),
			'modified'	=> current_time('mysql', 1),
		);
		update_option($this->adminOptionsName, $options);
		$this->options = $options;
		return true;
	}

	function editBanner() {
		$options = $this->getAdminOptions();
		if (!isset($_POST['action'])) return false;

		$id = $_REQUEST['id'];
		check_admin_referer('wpcontaxe-edit_' . $_POST['id']);
		$options['banners'][$id]['id']			= $id;
		$options['banners'][$id]['name']		= empty($_POST['name']) ? 'Unbenannt ' . $id: $_POST['name'];
		$options['banners'][$id]['channel']		= $_POST['channel-select'] != -1 ? $_POST['channel-select'] : $_POST['channel-input'];
		if (empty($_POST['place-select']) && isset($options['banners'][$id]['dimension'])) {
			$options['banners'][$id]['dimension']	= $_POST['dimension'];
			$options['banners'][$id]['rnd']			= $_POST['rnd'];
			$options['banners'][$id]['txt']			= isset($_POST['txt']);
			$options['banners'][$id]['imgtxt']		= isset($_POST['imgtxt']);
			$options['banners'][$id]['img']			= isset($_POST['img']);
			$options['banners'][$id]['flash']		= isset($_POST['flash']);
			unset($options['banners'][$id]['place']);
		}
		else {
			$options['banners'][$id]['place']		= $_POST['place-select'] != -1 ? $_POST['place-select'] : $_POST['place-input'];
			unset($options['banners'][$id]['dimension']);
			unset($options['banners'][$id]['rnd']);
			unset($options['banners'][$id]['txt']);
			unset($options['banners'][$id]['imgtxt']);
			unset($options['banners'][$id]['img']);
			unset($options['banners'][$id]['flash']);
		}
		$options['banners'][$id]['params']		= $_POST['params'];
		$options['banners'][$id]['enabled']		= isset($_POST['enabled']);
		$options['banners'][$id]['modified']	= current_time('mysql', 1);
		$options['banners'][$id]['enabled']		= $_POST['enabled'] == 'true';
		$options['banners'][$id]['style']		= $_POST['style-select'] != -1 ? $_POST['style-select'] : $_POST['style-input'];
		$options['banners'][$id]['rules']		= $this->parseRules();
		update_option($this->adminOptionsName, $options);
		$this->options = $options;
?>
<div id="contaxe-notice" class="updated fade-00ff00"><p>Banner gespeichert.</p></div>
<?php
		return true;
	}

	function deleteBanner() {
		$options = $this->getAdminOptions();
		if (!isset($_POST['action'])) return false;
		check_admin_referer('wpcontaxe-delete_' . $_POST['id']);
		$id = $_POST['id'];
		unset($options['banners'][$id]);
		update_option($this->adminOptionsName, $options);
		$this->options = $options;
		return true;
	}

	function parseRules() {
		if (empty($_POST['serialized'])) return array();
		parse_str($_POST['serialized'], $rules);
		$rules = array_shift($rules);

		$ret = array();
		foreach ($rules as $rule) {
			if ($rule != 'fallback' && !isset($_POST['rule_' . $rule . '_display'])) continue;
			$rule_info = array(
				'type'		=> $rule,
				'params'	=> NULL,
				'display'	=> ($_POST['rule_' . $rule . '_display'] == 1) 
			);
			switch ($rule) {
				case 'date'		:
						$date_before= isset($_POST['rule_date_before'])	? strtotime($_POST['rule_date_before']) : 0;
						$date_after	= isset($_POST['rule_date_after'])	? strtotime($_POST['rule_date_after'])	: 0;
						if ($date_before	== 0) $date_before	= mktime(0, 0, 0, date('n'), date('j'), date('Y'));
						if ($date_after		== 0) $date_after	= mktime(0, 0, 0, date('n') + 1, date('j'), date('Y'));
						$rule_info['params']				= array();
						$rule_info['params']['before']		= $date_before;
						$rule_info['params']['after']		= $date_after;

					break;
				case 'fallback'	:
						$rule_info['params']	= isset($_POST['rule_fallback'])	? $_POST['rule_fallback'] : '';
					break;
				case 'olderthan':
						$age					= isset($_POST['rule_olderthan'])	? (int) $_POST['rule_olderthan'] : 0;
						if ($age <= 0) $age		= 3;
						$rule_info['params']	= $age;
					break;
				case 'postdate'		:
						$date_before= isset($_POST['rule_postdate_before'])	? strtotime($_POST['rule_postdate_before']) : 0;
						$date_after	= isset($_POST['rule_postdate_after'])	? strtotime($_POST['rule_postdate_after'])	: 0;
						if ($date_before	== 0) $date_before	= mktime(0, 0, 0, date('n'), date('j'), date('Y'));
						if ($date_after		== 0) $date_after	= mktime(0, 0, 0, date('n') + 1, date('j'), date('Y'));
						$rule_info['params']				= array();
						$rule_info['params']['before']		= $date_before;
						$rule_info['params']['after']		= $date_after;

					break;
				case 'wordcount':
						$max					= isset($_POST['rule_wordcount'])	? (int) $_POST['rule_wordcount'] : 0;
						if ($max <= 0) $max		= 50;
						$rule_info['params']	= $max;
					break;
			}
			$ret[] = $rule_info;
		}
		return $ret;
	}

	function getMode($options) {
		switch (true) {
			case is_preview():							return 'demo';							break;
			case current_user_can('manage_options'):	return $options['global_adminssee'];	break;
			case is_user_logged_in():					return $options['global_userssee'];		break;
			default:									return $options['global_visitorssee'];	break;
		}
	}

	function checkRules($id) {
		$options = $this->getAdminOptions();
		if (empty($options['banners'][$id]['rules'])) return true;
		foreach ($options['banners'][$id]['rules'] as $rule) {
			if ($rule['type'] == 'fallback') {
				$code = $this->getBannerURL($rule['params']);
				if (!empty($code)) return $code;
				continue;
			}
			if ($this->testRule($rule['type'], $rule['params'])) {
				return $rule['display'];
			}
		}
		return false;
	}

	function checkHighlighterRules($multiple) {
		$options = $this->getAdminOptions();
		if (empty($options['highlighter_rules'])) return true;
		foreach ($options['highlighter_rules'] as $rule) {
			if ($rule['type'] == 'fallback') continue;
			if ($multiple) {
				switch ($rule['type']) {
					case 'olderthan':	return true;
					case 'postdate':	return true;
					case 'wordcount':	return true;
				}
			}
			if ($this->testRule($rule['type'], $rule['params'], $multiple)) {
				return $rule['display'];
			}
		}
		return false;
	}

	function ruleFromSearchEngine() {
		$search_engines = array('/search?', 'images.google.', 'web.info.com', 'search.', 'del.icio.us/search', 'soso.com', '/search/', '.yahoo.');
		foreach ($search_engines as $url) {
			if (strpos($_SERVER['HTTP_REFERER'], $url) !== false) return true;
		}
		return false;	
	}

	function ruleRegularVisitor() {
		$options = $this->getAdminOptions();
		return ($this->cntVisits >= $options['global_regularvisits']) && ((time() - $this->lastVisit) <= (86400 * $options['global_regulardays']));
	}

	function ruleDate($date) {
		$now = time();
		return ($now > $date['before'] && $now < ($date['after'] + (24 * 60 * 60)));
	}

	function ruleOlderThan($limit) {
		$age = floor( (time() - get_the_time('U')) / (24 * 60 * 60));
		return ($age > $limit);
	}

	function rulePostDate($date) {
		$time = get_the_time('U');
		return ($time > $date['before'] && $time < ($date['after'] + (24 * 60 * 60)));
	}

	function ruleWordCount($max) {
		$count = str_word_count(strip_tags(get_the_content()));
		return ($count > $max);
	}


	function testRule($rule, $params) {
		switch ($rule) {
			case 'any'				: return true;
			case 'date'				: return $this->ruleDate($params);
//			case 'fallback'			: XXX not handled at this point
			case 'fromsearchengine'	: return $this->ruleFromSearchEngine();
			case 'home'				: return is_home();
			case 'loggedin'			: return is_user_logged_in();
			case 'olderthan'		: return $this->ruleOlderThan($params);
			case 'postdate'			: return $this->rulePostDate($params);
			case 'regularvisitor'	: return $this->ruleRegularVisitor();
			case 'wordcount'		: return $this->ruleWordCount($params);
			default					: break;
		}
		return false;
	}

	function printSortable($id, $active) {
		$options	= $this->getAdminOptions();
		echo '<ul id="rules_' . ($active ? 2 : 1) . '" class="wpcontaxe_sortable wpcontaxe_sortable_1">';
		if (!$active) {
			foreach ($GLOBALS['WPCONTAXE_RULES'] as $rule) {
				if ($this->bannerHasRule($id, $rule)) continue;
				if ($id == 'highlighter' && $rule == 'fallback') continue; 
				echo $this->printSortableItem($id, $rule);
			}
		}
		else if (isset($options['banners'][$id]) && !empty($options['banners'][$id]['rules'])) {
			foreach ($options['banners'][$id]['rules'] as $rule_info) {
				echo $this->printSortableItem($id, $rule_info['type'], $rule_info['display'], $rule_info['params']);
			}
		}
		else if ($id == 'highlighter') {
			foreach ($options['highlighter_rules'] as $rule_info) {
				if ($rule_info['type'] == 'fallback') continue; 
				echo $this->printSortableItem($id, $rule_info['type'], $rule_info['display'], $rule_info['params']);
			}
		}
		echo '</ul>';
		
	}

	function bannerHasRule($id, $rule) {
		$options	= $this->getAdminOptions();
		if ($id == 'highlighter') {
			if (empty($options['highlighter_rules'])) return false;
			foreach ($options['highlighter_rules'] as $rule_info) {
				if ($rule_info['type'] == $rule) return true;
			}
			return false;
		}
		if (!isset($options['banners'][$id])) return false;
		if (empty($options['banners'][$id]['rules'])) return false;
		foreach ($options['banners'][$id]['rules'] as $rule_info) {
			if ($rule_info['type'] == $rule) return true;
		}
		return false;
	}

	function printSortableItem($id, $rule, $display = true, $params = NULL) {
		$options	= $this->getAdminOptions();
		$text		= '';
		$select = '
<select name="rule_' . $rule . '_display" id="rule_' . $rule . '_display" class="wpcontaxe_select">
		<option value="1"' . ($display	? ' selected="selected"': '') . '>anzeigen</option>
		<option value="0"' . (!$display	? ' selected="selected"': '') . '>nicht anzeigen</option>
</select>.';
		switch ($rule) {
			case 'any'				:
				$text	= '<tt>(Sonst) Immer</tt> ' . $select;
				break;
			case 'date'				:
				$before	= !empty($params['before'])	? $params['before']	: mktime(0, 0, 0, date('n'), date('j'), date('Y'));
				$after	= !empty($params['after'])	? $params['after']	: mktime(0, 0, 0, date('n') + 1, date('j'), date('Y'));
				$after	= strftime('%Y-%m-%d', $after);
				$before	= strftime('%Y-%m-%d', $before);
				$text	= '<tt>Wenn</tt> das Datum zwischen <input type="text" name="rule_' . $rule . '_before" value="' . attribute_escape($before) . '"  size="10" /> und <input type="text" name="rule_' . $rule . '_after" value="' . attribute_escape($after) . '" size="10" /> liegt, <tt>dann</tt>' . $select;
				break;
			case 'home'	:
				$text	= '<tt>Wenn</tt> die aktuelle Seite die Startseite ist, <tt>dann</tt>' . $select;
				break;
			case 'loggedin'			: 
				$text	= '<tt>Wenn</tt> der Benutzer eingeloggt ist, <tt>dann</tt>' . $select;
				break;
			case 'fallback'			:
				if (empty($id) || count($options['banners']) >= 2) {
					$list	= '<select name="rule_' . $rule . '" class="wpcontaxe_select">';
					foreach ($options['banners'] as $banner) {
						if ($banner['id'] == $id) continue;
						$list .= '<option value="' . attribute_escape($banner['id']) . '"' . ($params == $banner['id'] ? ' selected="selected"': '') . '>' . $banner['name'] . '</option>';
					}
					$list  .= '</select>';
				}
				else {
					$list = 'einen anderen Banner (noch keiner vorhanden)';
				}
				$text	= '<tt>Wenn</tt> die vorherigen Bedingungen fehlschlagen, <tt>dann</tt> versuche ' . $list . ' anzuzeigen.';
				break;
			case 'fromsearchengine'	: 
				$text	= '<tt>Wenn</tt> der Besucher von einer Suchmaschine kommt, <tt>dann</tt>' . $select;
				break;
			case 'regularvisitor'	:
				$text	= '<tt>Wenn</tt> der Besucher ein regelm&auml;&szlig;iger Leser ist, <tt>dann</tt>' . $select;
				break;
			case 'olderthan'		:
				$age	= (int) $params;
				if ($age <= 0) $age = 3;
				$text	= '<tt>Wenn</tt> der Beitrag &auml;lter als <input type="text" name="rule_' . $rule . '" value="' . $age . '" size="3"/> Tage ist, <tt>dann</tt>' . $select;
				break;
			case 'postdate'				:
				$before	= !empty($params['before'])	? $params['before']	: mktime(0, 0, 0, date('n'), date('j'), date('Y'));
				$after	= !empty($params['after'])	? $params['after']	: mktime(0, 0, 0, date('n') + 1, date('j'), date('Y'));
				$after	= strftime('%Y-%m-%d', $after);
				$before	= strftime('%Y-%m-%d', $before);
				$text	= '<tt>Wenn</tt> der Beitrag zwischen <input type="text" name="rule_' . $rule . '_before" value="' . attribute_escape($before) . '"  size="10" /> und <input type="text" name="rule_' . $rule . '_after" value="' . attribute_escape($after) . '" size="10" /> erstellt wurde, <tt>dann</tt>' . $select;
				break;
			case 'wordcount'		:
				$max	= (int) $params;
				if ($max <= 0) $max = 50;
				$text	= '<tt>Wenn</tt> der Beitrag mehr als <input type="text" name="rule_' . $rule . '" value="' . $max . '" size="3"/> W&ouml;rter enh&auml;lt, <tt>dann</tt>' . $select;
				break;
			default					: break;
		}
		return '<li id="rule_' . $rule . '"><span class="wpcontaxe_handle">&times;</span> ' . $text . '</li>';
	}

	function getBannerURL($id, $demo = false) {
		$options = $this->getAdminOptions();
		if (!$demo && ($mode = $this->getMode($options)) == 'nothing') return '';
		if ($demo) $mode = 'demo';

		if (!$demo && (!isset($options['banners'][$id]) || !$options['banners'][$id]['enabled'])) return '';

		$channel = isset($options['banners'][$id]['channel']) ? $options['banners'][$id]['channel'] : '';
		if (empty($channel)) $channel = $options['global_channel'];
		if (empty($channel)) return '';
		if (empty($options['banners'][$id]['dimension']) && empty($options['banners'][$id]['place'])) return '';

		if (!$demo)	{
			$ret = $this->checkRules($id);
			if ($ret === FALSE) return '';
			if ($ret !== TRUE) return $ret;
		}

		$url = 'http://www.contaxe.com/go/go.js?atp=bnr';
		if (!empty($options['banners'][$id]['place'])) {
			$url.= '&pi='. $options['banners'][$id]['place'];
		}
		else {
			$url.= '&adim='. $options['banners'][$id]['dimension'];
		}
		$url.= '&c='	. urlencode($channel);
		if (!empty($options['banners'][$id]['rnd']))	$url.= '&rnd='	. $options['banners'][$id]['rnd'];
		if (!empty($options['banners'][$id]['style']))	$url.= '&s='	. $options['banners'][$id]['style'];
		if ($mode == 'demo')							$url.= '&demo=1';
		if (!empty($options['banners'][$id]['params'])) $url.= $options['banners'][$id]['params'];
		if (!empty($options['banners'][$id]['txt']))	$url.= '&aftxt=1';
		if (!empty($options['banners'][$id]['imgtxt']))	$url.= '&afimgtxt=1';
		if (!empty($options['banners'][$id]['img']))	$url.= '&afimg=1';
		if (!empty($options['banners'][$id]['flash']))	$url.= '&afflash=1';
		return $url;
		
	}
	
	function getAdCode($url, $counts = true) {
		if (is_feed() || is_trackback() || is_404()) return '';
		if ($url == '') return '';
		if ($counts) {
			if ($this->cntBanners > 5) return '';
			$this->cntBanners++;
		}
		return '<script language="JavaScript1.1" type="text/javascript" src="' . wp_specialchars($url) . '"></script>';
	}

	function showBanner($id) {
		$options = $this->getAdminOptions();
		if (!isset($options['banners'][$id])) {
			foreach ($options['banners'] as $banner) {
				if ($banner['name'] == $id) {
					$id = $banner['id'];
					break;
				}
			}
		}
		if (!isset($options['banners'][$id])) {
			echo '<!--wpcontaxe: could not find banner-->';
			return;
		}
		$url = $this->getBannerURL($id);
		echo $this->getAdCode($url);
		
	}

	function showDemoBanner($id) {
		$url = $this->getBannerURL($id, true);
		echo $this->getAdCode($url, false);
	}


	function addHighlighter() {
		$options = $this->getAdminOptions();
		if (!$options['highlighter_enabled']) return;
		if (($mode = $this->getMode($options)) == 'nothing') return;

		$channel = $options['highlighter_channel'];
		if (empty($channel)) $channel = $options['global_channel'];
		if (empty($channel)) return;
	
		if (!$this->checkHighlighterRules(!(is_single() || is_page()))) return;

		$url = 'http://www.contaxe.com/go/go.js?atp=hlt';
		$url.= '&c='	. urlencode($channel);
		$url.= '&hw='	. urlencode($options['highlighter_words']);
		$url.= '&wr='	. urlencode($options['highlighter_repeat']);
		$url.= '&pct='	. urlencode($options['highlighter_delay']);
		if (!empty($options['highlighter_style']))	$url.= '&s=' . $options['highlighter_style'];
		if ($mode == 'demo') $url.= '&demo=1';
		echo $this->getAdCode($url, false);
	}

	function showDemoHighlighter() {
		$options = $this->getAdminOptions();
		$channel = $options['highlighter_channel'];
		if (empty($channel)) $channel = $options['global_channel'];
		if (empty($channel)) return;
	
		$url = 'http://www.contaxe.com/go/go.js?atp=hlt';
		$url.= '&c='	. urlencode($channel);
		$url.= '&hw='	. urlencode($options['highlighter_words']);
		$url.= '&wr='	. urlencode($options['highlighter_repeat']);
		$url.= '&pct='	. urlencode($options['highlighter_delay']);
		$url.= '&demo=1&demoword=InText-Demonstration';
		if (!empty($options['highlighter_style']))	$url.= '&s=' . $options['highlighter_style'];
		echo $this->getAdCode($url, false);
	}
	
	function addISA() {
		$options = $this->getAdminOptions();
		if (!$options['isa_enabled']) return;
		if (($mode = $this->getMode($options)) == 'nothing') return;

		$channel = $options['isa_channel'];
		if (empty($channel)) $channel = $options['global_channel'];
		if (empty($channel)) return;
	
		$url = 'http://www.contaxe.com/go/go.js?atp=isa';
		$url.= '&c=' . urlencode($channel);
		if ($mode == 'demo') $url.= '&demo=1';
		echo $this->getAdCode($url, false);
?>
<script language="JavaScript1.1" type="text/javascript">
    ContaxeSTHandlerInst.AddId('s');
</script>
<?php
	}

	function showDemoISA() {
		$options = $this->getAdminOptions();
		$channel = $options['isa_channel'];
		if (empty($channel)) $channel = $options['global_channel'];
		if (empty($channel)) return;
	
		$url = 'http://www.contaxe.com/go/go.js?atp=isa';
		$url.= '&c=' . urlencode($channel);
		$url.= '&demo=1';
		echo $this->getAdCode($url, false);
	}

	/*
	 * parts of the following code are borrowed from AdSense Manager 
	 * http://wordpress.org/extend/plugins/adsense-manager/
	 * by Martin Fitzpatrick (http://www.mutube.com/)
	 * released under GPLv2
	 */
	function addEditorButton() {
		$options = $this->getAdminOptions();
		if (
			!strpos($_SERVER['REQUEST_URI'], 'post.php')
		&&	!strpos($_SERVER['REQUEST_URI'], 'post-new.php')
		&&	!strpos($_SERVER['REQUEST_URI'], 'page.php')
		&&	!strpos($_SERVER['REQUEST_URI'], 'page-new.php')
		&&	!strpos($_SERVER['REQUEST_URI'], 'bookmarklet.php')
		) return;
?>
<script language="JavaScript" type="text/javascript">
<!--
jQuery(document).ready(function(){

QTags.ContaxeButton = function() {
	QTags.Button.call(this, 'contaxe', '', '', '', '');
};
QTags.ContaxeButton.prototype = new QTags.Button();
QTags.ContaxeButton.prototype.callback = function(e, c) {}

QTags.ContaxeButton.prototype.html = function(idPrefix) {
	var ed_contaxe = document.createElement("select");
		
	ed_contaxe.setAttribute("onchange", "add_contaxe(this)");

	ed_contaxe.setAttribute("class", "ed_button");
	ed_contaxe.setAttribute("title", "CONTAXE-Werbung einfügen");
	ed_contaxe.setAttribute("id", idPrefix + "contaxe");					

	opt_contaxe = document.createElement("option");
	opt_contaxe.value='';
	opt_contaxe.innerHTML='CONTAXE...';
	opt_contaxe.style.fontWeight='bold';
	ed_contaxe.appendChild(opt_contaxe);

<?php
		$other_options = array(
			'no_banners'	=> '    Keine Banner einfügen',
			'no_hl'			=> '    InText-Werbung deaktivieren',
			'no_ads'		=> '    Keine Werbung',
			''				=> 'Banner einfügen:'
		);
		foreach ($other_options as $key => $value) {
?>
var opt = document.createElement("option");
opt.value='<?php echo wp_specialchars($key); ?>';
opt.innerHTML='<?php echo $value; ?>';
ed_contaxe.appendChild(opt);
<?php 
		}

		if (sizeof($options['banners']) != 0) {
			foreach ($options['banners'] as $banner) {
?>
	var opt = document.createElement("option");
	opt.value='<?php echo wp_specialchars($banner['name']); ?>';
	opt.innerHTML='    <?php echo $banner['name']; ?>';
	ed_contaxe.appendChild(opt);
<?php
			}
		}
?>
	var ed_contaxe_div = document.createElement("select");
	ed_contaxe_div.appendChild(ed_contaxe);
	return ed_contaxe_div.innerHTML;
};

	edButtons[125] = new QTags.ContaxeButton();
});
				
function add_contaxe(element) {
	var contaxe_code = '';
	if (element.value == '') return;
	else if (element.value == 'no_ads')		{ contaxe_code = '<!--wpcontaxe_no_ads-->'; }
	else if (element.value == 'no_hl')		{ contaxe_code = '<!--wpcontaxe_no_hl-->'; }
	else if (element.value == 'no_banners')	{ contaxe_code = '<!--wpcontaxe_no_banners-->'; }
	else									{ contaxe_code = '<!--wpcontaxe#' + element.value + '-->';}
	edInsertContent('dummy', contaxe_code);
	return;
}
// -->
</script>
<?php
	}

	function placeAds($type, $content) {
		global $WPCONTAXE_POSITIONS, $wp_query;
		$options	= $this->getAdminOptions();
		$top_center = $top_left = $top_right = $middle_center = $middle_left = $middle_right = $bottom_center = '';
		foreach ($options['positions'] as $id => $pos) {
			$position = $WPCONTAXE_POSITIONS[$id];
			if ($position['type'] != $type) continue;
			if ($type == 'multiple') {
				if ($pos['position'] > 0) {
					if ($pos['position'] != $wp_query->current_post + 1) continue;
				}
				if ($pos['position'] < 0) {
					if ($wp_query->post_count + $pos['position'] != $wp_query->current_post) continue;
				}
			}
			if (($code = $this->getBannerURL($pos['banner'])) == '') continue;
			$code = $this->getAdCode($code);
			switch (true) {
				case $position['valign'] == 'top' && $position['align'] == 'center':
					$top_center	= '<p style="text-align: center;">'				. $code . '</p>'; break;
				case $position['valign'] == 'top' && $position['align'] == 'left':
					$top_left	= '<p style="float: left; margin: 4px;">'		. $code . '</p>'; break;
				case $position['valign'] == 'top' && $position['align'] == 'right':
					$top_right	= '<p style="float: right; margin: 4px;">'		. $code . '</p>'; break;
				case $position['valign'] == 'middle' && $position['align'] == 'center':
					$middle_center	= '<p style="text-align: center;">'			. $code . '</p>'; break;
				case $position['valign'] == 'middle' && $position['align'] == 'left':
					$middle_left	= '<p style="float: left; margin: 4px;">'	. $code . '</p>'; break;
				case $position['valign'] == 'middle' && $position['align'] == 'right':
					$middle_right	= '<p style="float: right; margin: 4px;">'	. $code . '</p>'; break;
				case $position['valign'] == 'bottom' && $position['align'] == 'center':
					$bottom_center	= '<p style="text-align: center;">'			. $code . '</p>'; break;
				default:
					break;
			}
		}
		$middle = $middle_center . $middle_left . $middle_right;
		$content = $this->injectIntoMiddle($content, $middle);
		return $top_center . $top_left . $top_right . $content . $bottom_center;
	}

	function callback_widget_text($content) {
		return $this->callback_content($content, FALSE);
	}

	function callback_content($content, $real = TRUE) {
		$options	= $this->getAdminOptions();
		$type		= '';
		if (strpos($content, '<!--wpcontaxe_no_ads-->') !== FALSE) {
			$content = str_replace('<!--wpcontaxe_no_ads-->', '<!--wpcontaxe: Werbung komplett deaktiviert-->', $content);
			return '<div class="chlforbidden">' . $content . '</div>';
		}
		while (preg_match('/<!--wpcontaxe#(.*?)-->/', $content, $match) == 1) {
			$name = $match[1];
			$code = '';
			foreach ($options['banners'] as $banner) {
				if (wp_specialchars($banner['name']) == $name) {
					$code = $this->getAdCode($this->getBannerURL($banner['id']));
					break;
				}
			}
			$content = str_replace('<!--wpcontaxe#' . $name . '-->', $code, $content);
		}
		if ($options['highlighter_enabled']) {
			if (strpos($content, '<!--wpcontaxe_no_hl-->') !== FALSE || ($real && !is_single() && !is_page() && !$this->checkHighlighterRules(false))) {
				$content = str_replace('<!--wpcontaxe_no_hl-->', '<!--wpcontaxe: InText-Werbung deaktiviert-->', $content);
				$content = '<div class="chlforbidden">' . $content . '</div>';
			}
		}
		if (strpos($content, '<!--wpcontaxe_no_banners-->') !== FALSE) {
			return str_replace('<!--wpcontaxe_no_banners-->', '<!--wpcontaxe: Keine Banner in diesem Beitrag-->', $content);
		}
		if (!$real) return $content;
		switch (true) {
			case is_single():
				return $this->placeAds('single',	$content);
			case is_page():
				return $this->placeAds('page',		$content);
			default:
				return $this->placeAds('multiple',	$content);
				break;
		}
	}

	function callback_wp_footer() {
		$this->addHighlighter();
		$this->addISA();
		$this->addEditorButton();
	}

	/*
	 * parts of the following function are borrowed from adman 
	 * http://wp.uberdose.com/2006/11/05/adman/
	 * Copyright (C) 2007 uberdose.com (adman AT uberdose DOT com)
	 * released under GPLv2
	 */
	function get_occurrences($content, $what) {
		$result = array();
		$pos = 0;
		while($pos !== false) {
			$pos = strpos($content, $what, $pos);
			if ($pos === false) {
				return $result;
			}
			$pos += strlen($what) + 1;
			array_push($result, $pos);
			if ($pos >= strlen($content)) {
				return $result;
			}
		}
		return $result;
	}

	/*
	 * parts of the following function are borrowed from adman 
	 * http://wp.uberdose.com/2006/11/05/adman/
	 * Copyright (C) 2007 uberdose.com (adman AT uberdose DOT com)
	 * released under GPLv2
	 */
	function injectIntoMiddle($content, $code) {
		if ($code == '') return $content;
		$middle = intval(strlen($content) / 2);
		$positions = $this->get_occurrences($content, '</p>');
		$positions = array_merge($positions, $this->get_occurrences($content, '</div>'));
		$positions = array_merge($positions, $this->get_occurrences($content, '</ul>'));
		$positions = array_merge($positions, $this->get_occurrences($content, '</ol>'));
		$positions = array_merge($positions, $this->get_occurrences($content, '</pre>'));
		$deviations = array();
		foreach ($positions as $pos) {
			$diff = abs($pos - $middle);
			$deviations[$diff] = $pos;
		}
		ksort($deviations);
		$final = array_shift($deviations);
		if ($final > 0) $content = substr($content, 0, $final - 1) . $code . substr($content, $final - 1);
		return $content;
	}


	function setCookie() {
		if (is_admin()) return;
		$cntvisits	= isset($_COOKIE['wpcontaxe_cntvisits']) ? $_COOKIE['wpcontaxe_cntvisits'] + 1	: 1;
		$lastvisit	= isset($_COOKIE['wpcontaxe_lastvisit']) ? $_COOKIE['wpcontaxe_lastvisit']		: 0;
		$time		= time();
		$url = parse_url(get_option('home'));
		$path = isset($url['path']) ? $url['path'] : '';
		setcookie('wpcontaxe_cntvisits', $cntvisits,	$time+60*60*24*365, $path . '/');
		setcookie('wpcontaxe_lastvisit', $time,			$time+60*60*24*365, $path . '/');
		$this->cntVisits = $cntvisits;
		$this->lastVisit = $lastvisit;
	}

	function getAPIData($cache = true) { 
		if ($cache && isset($this->api_data)) return $this->api_data;
		$options = $this->getAdminOptions();
		if (empty($options['api_key'])) {
?>
<div id="contaxe-error" class="updated">
	<p>
		<strong>Wichtig:</strong>
		Um wpCONTAXE nutzen zu können, musst du auf contaxe.com einen <a href="https://www.contaxe.com/de/wordpressplugin/">API-Key erzeugen</a> und hier in den allgemeinen Einstellungen eintragen.
	</p>
</div>
<?php
			return;
		}
		$url = 'https://www.contaxe.com/callable/json_api.php';
		$args = array(
			'body' => array(
				'api_key' => trim($options['api_key']),
				'actions' => array('getChannels', 'getInTextStyles', 'getPlaces', 'getTxtAdStyles')
			)
		);
		if ($options['disable_ssl_verify']) $args['sslverify'] = false;
		$response = wp_remote_post($url, $args);
		if (is_wp_error($response)) {
?>
<div id="contaxe-error" class="updated"><p><strong>API-Aufruf fehlgeschlagen (1):</strong> Sollte diese Meldung öfter auftauchen, überpr&uuml;fe ob du in den allgemeinen Einstellungen einen korrekten API-Key angegeben hast.</p>
<p><strong>Fehlermeldung:</strong> <?php echo $response->get_error_message(); ?></p></div>
<?php
			$this->api_data = $options['api_cache'];
			return;
		}
		if ($response['response']['code'] != 200) {
?>
<div id="contaxe-error" class="updated"><p><strong>API-Aufruf fehlgeschlagen (2):</strong> Sollte diese Meldung öfter auftauchen, überpr&uuml;fe ob du in den allgemeinen Einstellungen einen korrekten API-Key angegeben hast.</p></div>
<?php
			$this->api_data = $options['api_cache'];
			return;
		}
		$data = json_decode($response['body'], true);
		$this->api_data = array(
			'channels' 		=> $data['getChannels'],
			'intextstyles'	=> $data['getInTextStyles'],
			'places'		=> $data['getPlaces'],
			'txtadstyles'	=> $data['getTxtAdStyles'],
		);
		if (!wpcontaxe_array_compare($options['api_cache'], $this->api_data)) {
			$options['api_cache'] = $this->api_data;
			update_option($this->adminOptionsName, $options);
		}
	}
}

function wpcontaxe_array_compare($a1, $a2) { 
	if (!is_array($a1)) return false;
	if (!is_array($a2)) return false;
   
    foreach ($a1 as $key => $value) { 
        if (!array_key_exists($key, $a2)) return false;
		if (is_array($value)) { 
			$ret = wpcontaxe_array_compare($value, $a2[$key]); 
			if ($ret == false) return false;
			continue;
		}
		if ($value != $a2[$key]) return false; 
    } 
   
    return true;
} 

function wpcontaxe_banner_channel($banner) {
	global $wpcontaxe;
	$wpcontaxe->getAPIData();
	if (isset($wpcontaxe->api_data) && isset($banner['channel'])) {
		foreach ($wpcontaxe->api_data['channels'] as $channel) {
			if ($channel['id'] != $banner['channel']) continue;
			return $channel['title'];
		}
	}
	return $banner['channel'];
}
function wpcontaxe_banner_format($banner) {
	global $wpcontaxe;
	if (isset($banner['dimension'])) return $GLOBALS['WPCONTAXE_ADDIMENSIONS'][$banner['dimension']]['title'];
	$wpcontaxe->getAPIData();
	if (isset($wpcontaxe->api_data) && isset($banner['place'])) {
		foreach ($wpcontaxe->api_data['places'] as $website) {
			foreach ($website['places'] as $place) {
				if ($place['id'] != $banner['place']) continue;
				return sprintf('%s (%sx%s)', $place['dimension'], $place['width'], $place['height']);
			}
		}
	}
	return '-';
}

function wpcontaxe_banner($id) {
	$GLOBALS['wpcontaxe']->showBanner($id);
}

function wpcontaxe_channel_input($value, $global = false) {
	global $wpcontaxe;
		$selected = false;
?>
	<select id="channel" name="channel-select" class="wpcontaxe_select" onchange="wpcontaxe_show_select_input(this, 'channel-input')">
<?php if (isset($wpcontaxe->api_data)) : ?>
<?php if (!$global) : ?> 
	<?php if (empty($value)) : ?>
		<?php $selected = true; ?>
		<option value="0" selected="selected">Globale Einstellung verwenden</option>
	<?php else : ?>
		<option value="0">Globale Einstellung verwenden</option>
	<?php endif ?>
<?php else : ?> 
	<?php if (empty($value)) : ?>
		<?php $selected = true; ?>
		<option value="0" selected="selected">Keine Auswahl</option>
	<?php else : ?>
		<option value="0">Keine Auswahl</option>
	<?php endif ?>
<?php endif ?>
<?php foreach ($wpcontaxe->api_data['channels'] as $channel) : ?>
	<?php if ($value == $channel['id']) : ?>
		<?php $selected = true; ?>
		<option value="<?php echo esc_attr($channel['id'])?>" selected="selected"><?php echo esc_attr($channel['title'])?></option>
	<?php else : ?>
		<option value="<?php echo esc_attr($channel['id'])?>"><?php echo esc_attr($channel['title'])?></option>
	<?php endif ?>
<?php endforeach ?>
<?php endif ?>
	<option value="-1"<?php echo !$selected ? ' selected="selected"' : ''?>>Benutzerdefiniert (bitte ID angeben):</option>
</select>
<input name="channel-input" id="channel-input" type="text" value="<?php echo esc_attr($value); ?>" size="10" style="display: <?php echo $selected ? 'none' : 'inline'?>" />
<?php 
}

function wpcontaxe_place_input($value, $allow_oldstyle) {
	global $wpcontaxe;
	$selected = false;
?>
	<select id="place" name="place-select" class="wpcontaxe_select" onchange="<?php echo $allow_oldstyle ? 'wpcontaxe_onchange_place' : 'wpcontaxe_show_select_input'?>(this, 'place-input')">
<?php if (isset($wpcontaxe->api_data)) : ?>
<?php if ($allow_oldstyle) : ?> 
	<?php if (empty($value)) : ?>
		<?php $selected = true; ?>
		<option value="0" selected="selected">Keine (Alten Bannercode verwenden)</option>
	<?php else : ?>
		<option value="0">Keine (Alten Bannercode verwenden)</option>
	<?php endif ?>
<?php else : ?> 
	<?php if (empty($value)) : ?>
		<?php $selected = true; ?>
		<option value="0" selected="selected">Bitte ausw&auml;hlen</option>
	<?php else : ?>
		<option value="0">Bitte ausw&auml;hlen</option>
	<?php endif ?>
<?php endif ?>
<?php foreach ($wpcontaxe->api_data['places'] as $website) : ?>
	<option value=""><?php echo esc_attr(sprintf('Website: %s', $website['title']))?></option>
	<?php foreach ($website['places'] as $place) : ?>
		<?php if ($value == $place['id']) : ?>
			<?php $selected = true; ?>
			<option value="<?php echo esc_attr($place['id'])?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo esc_attr($place['title'])?></option>
		<?php else : ?>
			<option value="<?php echo esc_attr($place['id'])?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo esc_attr($place['title'])?></option>
		<?php endif ?>
	<?php endforeach ?>
<?php endforeach ?>
<?php endif ?>
	<option value="-1"<?php echo !$selected ? ' selected="selected"' : ''?>>Benutzerdefiniert (bitte ID angeben):</option>
</select>
<input name="place-input" id="place-input" type="text" value="<?php echo esc_attr($value); ?>" size="10" style="display: <?php echo $selected ? 'none' : 'inline'?>" />
<?php 
}

function wpcontaxe_intextstyle_input($value) {
	global $wpcontaxe;
	$selected = false;
?>
<select id="style" name="style-select" class="wpcontaxe_select" onchange="wpcontaxe_show_select_input(this, 'style-input')">
<?php if (isset($wpcontaxe->api_data)) : ?>
<?php foreach ($wpcontaxe->api_data['intextstyles'] as $style) : ?>
	<?php if ($value == $style['id']) : ?>
		<?php $selected = true; ?>
		<option value="<?php echo esc_attr($style['id'])?>" selected="selected"><?php echo esc_attr($style['name'])?></option>
	<?php else : ?>
		<option value="<?php echo esc_attr($style['id'])?>"><?php echo esc_attr($style['name'])?></option>
	<?php endif ?>
<?php endforeach ?>
	<?php endif ?>
	<option value="-1"<?php echo !$selected ? ' selected="selected"' : ''?>>Benutzerdefiniert (bitte ID angeben):</option>
</select>
<input name="style-input" id="style-input" type="text" value="<?php echo esc_attr($value); ?>" size="10" style="display: <?php echo $selected ? 'none' : 'inline'?>" />
<?php 
}

function wpcontaxe_txtadstyle_input($value, $allow_olddata) {
	global $wpcontaxe;
	$selected = false;
?>
<select id="style" name="style-select" class="wpcontaxe_select" onchange="wpcontaxe_show_select_input(this, 'style-input')">
<?php if (isset($wpcontaxe->api_data)) : ?>
<?php foreach ($wpcontaxe->api_data['txtadstyles'] as $style) : ?>
	<?php if ($style['id'] == 0) $style['name'] = $allow_olddata ? 'Standard' : 'Einstellung der Werbefläche übernehmen'; ?>
	<?php if ($value == $style['id']) : ?>
		<?php $selected = true; ?>
		<option value="<?php echo esc_attr($style['id'])?>" selected="selected"><?php echo esc_attr($style['name'])?></option>
	<?php else : ?>
		<option value="<?php echo esc_attr($style['id'])?>"><?php echo esc_attr($style['name'])?></option>
	<?php endif ?>
<?php endforeach ?>
<?php endif ?>
	<option value="-1"<?php echo !$selected ? ' selected="selected"' : ''?>>Benutzerdefiniert (bitte ID angeben):</option>
</select>
<input name="style-input" id="style-input" type="text" value="<?php echo esc_attr($value); ?>" size="10" style="display: <?php echo $selected ? 'none' : 'inline'?>" />
<?php 
}
}

class WPContaxe_Widget extends WP_Widget {

	function WPContaxe_Widget() {
		parent::WP_Widget('wpcontaxe_widget', 'CONTAXE-Anzeige', array('description' => 'Eine CONTAXE-Anzeige',  'class' => 'widget_wpcontaxe'));	
	}

	function form($instance) {
		global $wpcontaxe;
		$wpcontaxe->getAPIData();
		$options = $wpcontaxe->getAdminOptions();

		$default = array(
			'title'		=> 'Anzeige',
			'banner'	=> NULL
		);
		$instance = wp_parse_args( (array) $instance, $default );
		
		$title_field_id		= $this->get_field_id('title');
		$title_field_name	= $this->get_field_name('title');
		$banner_field_id	= $this->get_field_id('banner');
		$banner_field_name	= $this->get_field_name('banner');
?>
<p>
	<label for="<?php echo $title_field_id; ?>"><?php _e('Title:'); ?></label>
	<input class="widefat" id="<?php echo $title_field_id; ?>" name="<?php echo $title_field_name; ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
</p>

<p>
	<label for="<?php echo $banner_field_id; ?>"><?php _e('Banner:'); ?></label>
	<select class="widefat" id="<?php echo $banner_field_id; ?>" name="<?php echo $banner_field_name; ?>" class="wpcontaxe_select">
		<?php foreach ($options['banners'] as $banner) : ?>
			<option value="<?php echo $banner['id']; ?>"<?php if ($banner['id'] == $instance['banner']) : ?> selected="selected"<?php endif ?>>
			<?php echo $banner['id']; ?> - <?php echo attribute_escape($banner['name']) . (!$banner['enabled'] ? ' (deaktiviert)' : ''); ?>
			</option>
		<?php endforeach ?>
	</select>
</p>
<?php
	}


	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		global $wpcontaxe;
		if (($url = $wpcontaxe->getBannerURL($instance['banner'])) == '') return;
		$title = apply_filters('widget_title', $instance['title']);
?>
			<?php echo $before_widget; ?>
				<?php if ($title) : ?>
					<?php echo $before_title . wp_specialchars($instance['title']) . $after_title; ?>
				<?php endif ?>
				<p style="text-align: center; margin-top: 10px;"><?php echo $wpcontaxe->getAdCode($url); ?></p>
			<?php echo $after_widget; ?>
<?php
	}
}

$wpcontaxe = new WPContaxe();

register_activation_hook(__FILE__, array(&$wpcontaxe, 'activatePlugin'));

add_action('widgets_init', create_function('', 'return register_widget(\'WPContaxe_Widget\');'));
add_action('admin_menu',	array(&$wpcontaxe, 'registerAdminMenu'));
add_action('admin_head',	array(&$wpcontaxe, 'printAdminCSS'));
add_action('admin_footer',	array(&$wpcontaxe, 'printAdminJS'));
add_action('plugins_loaded',array(&$wpcontaxe, 'setCookie'));

add_action('wp_footer',		array(&$wpcontaxe, 'callback_wp_footer'), 100);
add_action('admin_footer',	array(&$wpcontaxe, 'addEditorButton'), 100);

add_filter('the_content',	array(&$wpcontaxe, 'callback_content'), 100);
add_filter('the_excerpt',	array(&$wpcontaxe, 'callback_content'), 100);
add_filter('widget_text',	array(&$wpcontaxe, 'callback_widget_text'), 1);

?>
