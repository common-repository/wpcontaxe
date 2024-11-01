<?php


if ($_REQUEST['action'] == 'add') {
	$title	= __('Banner hinzuf&uuml;gen');
	$button	= __('Banner hinzuf&uuml;gen');
	$action	= 'add';
	$banner	= array(
		'id'		=> NULL,
		'name'		=> '',
		'channel'	=> '',
		'place'		=> NULL,
		'params'	=> '',
		'enabled'	=> true,
		'style'		=> NULL
	);
}
else if ($_REQUEST['action'] == 'edit') {
	$title	= __('Banner bearbeiten');
	$button	= __('Banner bearbeiten');
	$action	= 'edit';
	$banner = $options['banners'][$_REQUEST['id']];
}

$allow_oldstyle = false;
if (isset($banner['dimension'])) $allow_oldstyle = true;

if (isset($_POST['action'])) {
	$banner['name']		= $_POST['name'];
	$banner['channel']	= $_POST['channel-select'] != -1 ? $_POST['channel-select'] : $_POST['channel-input'];
	$banner['place']	= $_POST['place-select'] != -1 ? $_POST['place-select'] : $_POST['place-input'];
	if (isset($banner['dimension']) && empty($_POST['place-select'])) {
		$banner['dimension']= $_POST['dimension'];
		$banner['rnd']		= $_POST['rnd'];
		$banner['txt']		= isset($_POST['txt']);
		$banner['imgtxt']	= isset($_POST['imgtxt']);
		$banner['img']		= isset($_POST['img']);
		$banner['flash']	= isset($_POST['flash']);
	}
	$banner['params']	= $_POST['params'];
	$banner['enabled']	= $_POST['enabled'] == 'true';
	$banner['style']	= $_POST['style-select'] != -1 ? $_POST['style-select'] : $_POST['style-input'];
}

?>
<script language="javascript" type="text/javascript">
// <![CDATA[
var mt_dimensions = {
<?php foreach ($GLOBALS['WPCONTAXE_ADDIMENSIONS'] as $key => $value) : ?>
	'<?php echo $key?>': {
		'txt': <?php echo $value['txt']?>,
		'imgtxt': <?php echo $value['imgtxt']?>,
		'img': <?php echo $value['img']?>,
		'flash': <?php echo $value['flash']?> 
	},
<?php endforeach ?>
};
function toggle_cb(name, value) {
	if(!$(name) || !$(name + '_label')) return;
	if (value == 1) {
		$(name).enable();
		$(name + '_label').setStyle({color: '#000'});
	}
	else {
		$(name).disable();
		$(name + '_label').setStyle({color: '#999'});
	}
} 
function dimension_handler(element) {
	var dimension = element.value;
	toggle_cb('mediatype_txt',		mt_dimensions[dimension]['txt']);
	toggle_cb('mediatype_imgtxt',	mt_dimensions[dimension]['imgtxt']);
	toggle_cb('mediatype_img',		mt_dimensions[dimension]['img']);
	toggle_cb('mediatype_flash',	mt_dimensions[dimension]['flash']);
}
// ]]>
</script>
<div class="wrap">
<h2><?php echo $title; ?></h2>
<form name="addbanner" id="addbanner" method="post" action="admin.php?page=wpcontaxe/admin/banner.php" onsubmit="return wpcontaxe_edit_banner_check();">
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="id" value="<?php echo $banner['id']; ?>" />
<input type="hidden" name="serialized" id="serialized_sortables"/>
<?php wp_nonce_field('wpcontaxe-' . $action . '_' . (isset($banner['id']) ? $banner['id'] : 'new')); ?>
<table class="form-table">
	<tr class="form-field">
		<th scope="row"><label for="name"><?php _e('Name:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_name" alt=""/></td>
		<td><input name="name" id="name" type="text" value="<?php echo attribute_escape($banner['name']); ?>" size="50" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="channel"><?php _e('Channel:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_channel" alt=""/></td>
		<td><?php wpcontaxe_channel_input($banner['channel']) ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="place"><?php _e('Werbefläche:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_place" alt=""/></td>
		<td><?php wpcontaxe_place_input($banner['place'], $allow_oldstyle) ?></td>
	</tr>
<?php if ($allow_oldstyle) : ?>
	<tr class="form-field olddata">
		<th scope="row"><label for="dimension"><?php _e('Format:') ?></label></th>
		<td class="helpicon-row"></td>
		<td><select id="dimension" name="dimension" class="wpcontaxe_select" onchange="dimension_handler(this)" onkeyup="dimension_handler(this)">
<?php
		foreach ($GLOBALS['WPCONTAXE_ADDIMENSIONS'] as $key => $value) {
			echo '<option value="' . $key . '"' . ($key == $banner['dimension'] ? ' selected="selected"' : '' ) . '>' . $value['title'] . "</option>\n";
		}
?>
			</select>
		</td>
	</tr>
	<tr class="form-field olddata">
		<th scope="row"><label for="mediatype"><?php _e('Art der Werbung:') ?></label></th>
		<td class="helpicon-row"></td>
		<td>
			<label id="mediatype_txt_label" for="mediatype_txt"><input type="checkbox" id="mediatype_txt" name="txt" value="1" <?php checked(true, $banner['txt']); ?> /> Textbanner</label><br/>
			<label id="mediatype_imgtxt_label" for="mediatype_imgtxt"><input type="checkbox" id="mediatype_imgtxt" name="imgtxt" value="1" <?php checked(true, $banner['imgtxt']); ?> /> Textbanner mit Bild</label><br/>
			<label id="mediatype_img_label" for="mediatype_img"><input type="checkbox" id="mediatype_img" name="img" value="1" <?php checked(true, $banner['img']); ?> /> Grafikbanner</label><br/>
			<label id="mediatype_flash_label" for="mediatype_flash"><input type="checkbox" id="mediatype_flash" name="flash" value="1" <?php checked(true, $banner['flash']); ?> /> Flashbanner</label><br/>
		</td>
	</tr>
	<tr class="form-field olddata">
		<th scope="row"><label for="opt"><?php _e('Banneroptimierung:') ?></label></th>
		<td class="helpicon-row"></td>
		<td>
<?php foreach ($GLOBALS['WPCONTAXE_BANNER_OPTIMIZATION'] as $key => $value) : ?>
			<label for="rnd<?php echo $key?>"><input type="radio" id="rnd<?php echo $key?>" name="rnd" value="<?php echo $key?>" <?php checked($key, (int)$banner['rnd']); ?> /> <?php echo $value?></label><br/>
<?php endforeach ?>
		</td>
	</tr>
<?php endif ?>
	<tr class="form-field">
		<th scope="row"><label for="style"><?php _e('Design:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_design" alt=""/></td>
		<td><?php wpcontaxe_txtadstyle_input($banner['style'], $allow_oldstyle) ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="params"><?php _e('Erweiterte Parameter:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_params" alt=""/></td>
		<td><input name="params" id="params" type="text" value="<?php echo attribute_escape($banner['params']); ?>" size="50" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><?php _e('Aktiv:') ?></th>
		<td class="helpicon-row"></td>
		<td><label for="enabled_true"><input type="radio" id="enabled_true" name="enabled" value="true" <?php checked(true, $banner['enabled']); ?> /> <?php _e('Ja') ?></label>&nbsp;&nbsp;&nbsp;<label for="enabled_false"><input type="radio" id="enabled_false" name="enabled" value="false" <?php checked(false, $banner['enabled']); ?> /> <?php _e('Nein') ?></label></td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Aktive Regeln:') ?></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_active" alt=""/></td>
		<td>
<?php $GLOBALS['wpcontaxe']->printSortable($banner['id'], true); ?>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Verfügbare Regeln:') ?></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_possible" alt=""/></td>
		<td>
<?php $GLOBALS['wpcontaxe']->printSortable($banner['id'], false); ?>
<script type="text/javascript">
// <![CDATA[
	Sortable.create("rules_1",
	 {dropOnEmpty:true,handle:"handle",containment:["rules_1","rules_2"],constraint:false});
	Sortable.create("rules_2",
	 {dropOnEmpty:true,handle:"handle",containment:["rules_1","rules_2"],constraint:false});

	function wpcontaxe_edit_banner_check() {
		$("serialized_sortables").value = Sortable.serialize("rules_2");
		return true;
	}

// ]]>
</script>
		</td>
	</tr>
</table>
<p class="submit"><input type="submit" name="editBanner" class="button-primary" value="<?php echo $button; ?>" /></p>
</form>

<h3><a href="admin.php?page=wpcontaxe/admin/banner.php">&laquo; Zur&uuml;ck</a></h3>

<h3>Vorschau (wird erst nach dem Speichern aktualisiert)</h3>
<?php $GLOBALS['wpcontaxe']->showDemoBanner($banner['id']); ?>

<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_name">
<h3>Name</h3>
<p>Frei w&auml;hlbarer Name.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_channel">
<h3>Channel</h3>
<p>Channel der bei der Einblendung des Banners verwendet wird.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_place">
<h3>Werbefläche</h3>
<p>Werbeflächen kannst du in deinem CONTAXE-Account anlegen. Sie legen unter anderem fest, welches Bannerformat verwendet wird und welche Werbeformen (Text, Bild, ...) erlaubt sind.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_params">
<h3>Erweiterte Parameter</h3>
<p>Für erfahrene Anwender.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_design">
<h3>Design</h3>
<p>Nur bei Textbannern: Falls du ein eigenes Design für den Banner wünschst, erstelle dieses bitte bei CONTAXE und w&auml;hle es hier aus.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_active">
<h3>Aktive Regeln</h3>
<p>Regeln die die Sichtbarkeit des Banners steuern. Verfügbare Regeln hierher ziehen und ordnen. Wenn keine der Regeln zutrifft wird der Banner nicht eingeblendet.</p>
<p><em>Wenn keine Regeln gewählt werden, wird der Banner immer eingeblendet.</em></p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_possible">
<h3>Verfügbare Regeln</h3>
<p>Alle verfügbaren Regeln um die Sichtbarkeit des Banners zu steuern.</p>
</div>
</div>
<script language="javascript" type="text/javascript">
	dimension_handler($('dimension'));
</script>
