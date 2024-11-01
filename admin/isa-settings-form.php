<div class="wrap">
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<?php wp_nonce_field('wpcontaxe-update-isa'); ?>
<h2>Intelligent Search Ad</h2>
<table class="form-table">
	<tr class="form-field">
		<th scope="row"><?php _e('Intelligent Search Ad einbinden:') ?></th>
		<td class="helpicon-row"></td>
		<td><label for="enabled_true"><input type="radio" id="enabled_true" name="enabled" value="true" <?php checked(true, $options['isa_enabled']); ?> /> <?php _e('Ja') ?></label>&nbsp;&nbsp;&nbsp;<label for="enabled_false"><input type="radio" id="enabled_false" name="enabled" value="false" <?php checked(false, $options['isa_enabled']); ?> /> <?php _e('Nein') ?></label></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="channel"><?php _e('Channel:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_channel" alt=""/></td>
		<td><?php wpcontaxe_channel_input($options['isa_channel']) ?></td>
	</tr>
</table>
<p class="submit"><input type="submit" name="update_isa" class="button-primary" value="<?php _e('Einstellungen aktualisieren &raquo;')?>" /></p>
</form>

<h3>Vorschau (wird erst nach dem Speichern aktualisiert)</h3>
<p>Gib zur Demonstration des Werbeformats in das nachfolgende Eingabefeld einen beliebigen Begriff ein (mindestens 3 Zeichen).</p>
<input name="demo_input" class="ctsearchtool" type="text" id="demo_input" value="" style="width: 200px" />
<?php $GLOBALS['wpcontaxe']->showDemoISA(); ?>

<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_channel">
<h3>Channel</h3>
<p>Channel der bei der Einblendung des Intelligent Search Ads verwendet wird. Wenn du dieses Feld leer lässt wird der Channel aus den Allgemeinen Einstellungen verwendet.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_design">
<h3>Design-ID</h3>
<p>Falls du ein eigenes Design für das Intelligent Search Ad wünschst, erstelle dieses bitte bei CONTAXE und w&auml;hle es hier aus.</p>
</div>
</div>
