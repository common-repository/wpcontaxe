<div class="wrap">
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<?php wp_nonce_field('wpcontaxe-update-general'); ?>
<h2>Allgemeine Einstellungen</h2>
<table class="form-table">
	<tr class="form-field form-required">
		<th scope="row"><label for="api_key"><a href="https://www.contaxe.com/de/wordpressplugin/" target="_blank"><?php _e('API-Key:') ?></a></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_api_key" alt=""/></td>
		<td><input name="api_key" id="api_key" type="text" value="<?php echo esc_attr($options['api_key']); ?>" size="10" /></td>
	</tr>
	<tr class="form-field form-required">
		<th scope="row"></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_disable_ssl_verify" alt=""/></td>
		<td><label for="disable_ssl_verify"><input type="checkbox" id="disable_ssl_verify" name="disable_ssl_verify" value="1" <?php checked(true, $options['disable_ssl_verify']); ?> /> Prüfung des SSL-Zertifikats bei API-Aufrufen deaktivieren</label></td>
	</tr>
	<tr class="form-field form-required">
		<th scope="row"><label for="channel"><?php _e('Channel:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_channel" alt=""/></td>
		<td><?php wpcontaxe_channel_input($options['global_channel'], true) ?></td>
	</tr>
</table>
<p>Ein regelmäßiger Besucher ist ein Besucher der innerhalb von <input name="regulardays" id="regulardays" type="text" value="<?php echo attribute_escape($options['global_regulardays']); ?>" size="3" /> Tagen  <input name="regularvisits" id="regularvisits" type="text" value="<?php echo attribute_escape($options['global_regularvisits']); ?>" size="3" /> Seiten angesehen hat.</p>
<h3>Sichtbarkeit</h3>
<table class="form-table">
	<tr>
		<th scope="row"><?php _e('Administratoren sehen:') ?></th>
		<td>
			<label for="adminssee_ads"><input type="radio" id="adminssee_ads" name="adminssee" value="ads" <?php checked('ads', $options['global_adminssee']); ?> /> <?php _e('Echte Werbung') ?></label><br/>
			<label for="adminssee_demo"><input type="radio" id="adminssee_demo" name="adminssee" value="demo" <?php checked('demo', $options['global_adminssee']); ?> /> <?php _e('Demo-Werbung <i>(Schutz vor Eigenklicks)</i>') ?></label><br/>
			<label for="adminssee_nothing"><input type="radio" id="adminssee_nothing" name="adminssee" value="nothing" <?php checked('nothing', $options['global_adminssee']); ?> /> <?php _e('Keine Werbung') ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Eingeloggte Benutzer sehen:') ?></th>
		<td>
			<label for="userssee_ads"><input type="radio" id="userssee_ads" name="userssee" value="ads" <?php checked('ads', $options['global_userssee']); ?> /> <?php _e('Echte Werbung') ?></label><br/>
			<label for="userssee_demo"><input type="radio" id="userssee_demo" name="userssee" value="demo" <?php checked('demo', $options['global_userssee']); ?> /> <?php _e('Demo-Werbung') ?></label><br/>
			<label for="userssee_nothing"><input type="radio" id="userssee_nothing" name="userssee" value="nothing" <?php checked('nothing', $options['global_userssee']); ?> /> <?php _e('Keine Werbung') ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Besucher sehen:') ?></th>
		<td>
			<label for="visitorssee_ads"><input type="radio" id="visitorssee_ads" name="visitorssee" value="ads" <?php checked('ads', $options['global_visitorssee']); ?> /> <?php _e('Echte Werbung') ?></label><br/>
			<label for="visitorssee_demo"><input type="radio" id="visitorssee_demo" name="visitorssee" value="demo" <?php checked('demo', $options['global_visitorssee']); ?> /> <?php _e('Demo-Werbung') ?></label><br/>
			<label for="visitorssee_nothing"><input type="radio" id="visitorssee_nothing" name="visitorssee" value="nothing" <?php checked('nothing', $options['global_visitorssee']); ?> /> <?php _e('Keine Werbung') ?></label>
		</td>
	</tr>
</table>
<p class="submit"><input type="submit" name="update_general" class="button-primary" value="<?php esc_attr_e('Einstellungen aktualisieren &raquo;')?>" /></p>
</form>

<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_api_key">
<h3>API-Key</h3>
<p>Um wpCONTAXE nutzen zu können, musst du auf contaxe.com unter <em>Channels &raquo; Werbemittel einbinden &raquo; WordPress-Plugin</em> einen API-Key erzeugen und diesen hier eintragen.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_disable_ssl_verify">
<h3>Prüfung des SSL-Zertifikats bei API-Aufrufen deaktivieren</h3>
<p>Deaktiviert die Prüfung des SSL-Zertifikats von contaxe.com bei API-Aufrufen. Dies kann nötig sein, falls dein Webserver unser Zertifikat fälschlicherweise als ungültig ansieht und die API-Aufrufe deshalb fehlschlagen.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_channel">
<h3>Channel</h3>
<p>Channel der standardmäßig bei der Anzeigeneinblendung verwendet wird. Dieser kann auf Wunsch für einzelne Werbemittel überschrieben werden.</p>
</div>
</div>
