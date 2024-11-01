<div class="wrap">
<form method="post" action="">
<?php wp_nonce_field('wpcontaxe-update-positions'); ?>
<h2>Banner positionieren</h2>
<p>Hier kannst du Banner direkt in Beiträge oder Seiten integrieren.</p>
<p>Ausserdem kannst du Banner mit Hilfe von <a href="widgets.php">Widgets in der Sidebar positionieren</a> oder sie manuell direkt in Templates integrieren:<br/>
<pre><?php echo wp_specialchars('<?php wpcontaxe_banner(\'Bannername\'); ?>'); ?> <i>oder</i> <?php echo wp_specialchars('<?php wpcontaxe_banner(Banner-ID); ?>'); ?></pre>
<p class="submit"><input type="submit" name="update_positions" class="button-primary" value="<?php _e('Einstellungen aktualisieren &raquo;')?>" /></p>
<table class="form-table">
<?php $lasttype = NULL; ?>
<?php foreach ($GLOBALS['WPCONTAXE_POSITIONS'] as $id => $position) : ?>
<?php if ($lasttype != $position['type']) : $lasttype = $position['type'] ?>
	<tr><th colspan="2"><h3><?php echo $GLOBALS['WPCONTAXE_POSITION_TYPES'][$position['type']]['title']; ?></h3></th></tr>
<?php endif ?>
	<tr class="form-field">
		<th scope="row"><label for="banner<?php echo $id; ?>"><?php echo $position['title']; ?>:</label></th>
		<td><select id="banner<?php echo $id; ?>" name="banner[<?php echo $id; ?>]" class="wpcontaxe_select">
<?php	
		echo '<option value=""' . (empty($options['positions'][$id]['banner']) ? ' selected="selected"' : '' ) . ">Kein Banner</option>\n"; 
		foreach ($options['banners'] as $banner) {
			echo '<option value="' . $banner['id'] . '"' . (isset($options['positions'][$id]['banner']) && $options['positions'][$id]['banner'] == $banner['id'] ? ' selected="selected"' : '' ) . '>' . $banner['id']  . ' - ' . esc_attr($banner['name']) . (!$banner['enabled'] ? ' (deaktiviert)' : '') . "</option>\n";
		}
?>
			</select>
		</td>
	</tr>
<?php if ($position['type'] == 'multiple') : ?>
	<tr class="form-field">
		<th scope="row"><label for="position<?php echo $id; ?>"><?php _e('Zeige in Beitrag Nummer'); ?>:</label></th>
		<td><input name="position[<?php echo $id; ?>]" id="position<?php echo $id; ?>" class="position" type="text" value="<?php echo esc_attr(isset($options['positions'][$id]['position'])? $options['positions'][$id]['position'] : ''); ?>" size="10" />&nbsp;&nbsp; <?php _e('(1 - erster Beitrag, 2 - zweiter Beitrag, -1 - letzter Beitrag, -2 - vorletzter Beitrag, ...)'); ?></td>
	</tr>
<?php endif ?>
<?php endforeach ?>
</table>

<p class="submit"><input type="submit" name="update_positions" class="button-primary" value="<?php _e('Einstellungen aktualisieren &raquo;')?>" /></p>
</form>
</div>
