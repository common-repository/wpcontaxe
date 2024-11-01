<div class="wrap">
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" onsubmit="return wpcontaxe_highlighter_check();">
<input type="hidden" name="serialized" id="serialized_sortables"/>
<?php wp_nonce_field('wpcontaxe-update-highlighter'); ?>
<h2>InText-Werbung</h2>
<table class="form-table">
	<tr class="form-field">
		<th scope="row"><?php _e('InText-Werbung einbinden:') ?></th>
		<td class="helpicon-row"></td>
		<td><label for="enabled_true"><input type="radio" id="enabled_true" name="enabled" value="true" <?php checked(true, $options['highlighter_enabled']); ?> /> <?php _e('Ja') ?></label>&nbsp;&nbsp;&nbsp;<label for="enabled_false"><input type="radio" id="enabled_false" name="enabled" value="false" <?php checked(false, $options['highlighter_enabled']); ?> /> <?php _e('Nein') ?></label></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="channel"><?php _e('Channel:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_channel" alt=""/></td>
		<td><?php wpcontaxe_channel_input($options['highlighter_channel']) ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="style"><?php _e('Design:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_design" alt=""/></td>
		<td><?php wpcontaxe_intextstyle_input($options['highlighter_style']) ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="words"><?php _e('Anzahl Wörter:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_words" alt=""/></td>
		<td><input name="words" id="words" type="text" value="<?php echo attribute_escape($options['highlighter_words']); ?>" size="2" /> (1-10)</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="repeat"><?php _e('Wortwiederholungen:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_repeat" alt=""/></td>
		<td><input name="repeat" id="repeat" type="text" value="<?php echo attribute_escape($options['highlighter_repeat']); ?>" size="3" /> (1-100)</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="delay"><?php _e('Popup-Schließverzögerung:') ?></label></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_delay" alt=""/></td>
		<td><input name="delay" id="delay" type="text" value="<?php echo attribute_escape($options['highlighter_delay']); ?>" size="4" /> (500-4000)</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><?php _e('Aktive Regeln:') ?></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_active" alt=""/></td>
		<td>
<?php $GLOBALS['wpcontaxe']->printSortable('highlighter', true); ?>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Verfügbare Regeln:') ?></th>
		<td class="helpicon-row"><img src="<?php echo $GLOBALS['WPCONTAXE_HELP_IMAGE']?>" class="wpcontaxe_helpicon" id="helpicon_possible" alt=""/></td>
		<td>
<?php $GLOBALS['wpcontaxe']->printSortable('highlighter', false); ?>
<script type="text/javascript">
// <![CDATA[
	Sortable.create("rules_1",
	 {dropOnEmpty:true,handle:"handle",containment:["rules_1","rules_2"],constraint:false});
	Sortable.create("rules_2",
	 {dropOnEmpty:true,handle:"handle",containment:["rules_1","rules_2"],constraint:false});

	function wpcontaxe_highlighter_check() {
		$("serialized_sortables").value = Sortable.serialize("rules_2");
		return true;
	}

// ]]>
</script>
		</td>
	</tr>
</table>
<p class="submit"><input type="submit" name="update_highlighter" class="button-primary" value="<?php esc_attr_e('Einstellungen aktualisieren &raquo;')?>" /></p>
</form>

<h3>Vorschau (wird erst nach dem Speichern aktualisiert)</h3>
Dieser Text dient zur Demonstration von CONTAXE InText-Werbung. Dies ist die InText-Demonstration.
<?php $GLOBALS['wpcontaxe']->showDemoHighlighter(); ?>

<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_channel">
<h3>Channel</h3>
<p>Channel der bei der Einblendung von InText-Werbung verwendet wird. Wenn du dieses Feld leer lässt wird der Channel aus den Allgemeinen Einstellungen verwendet.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_design">
<h3>Design</h3>
<p>Falls du ein eigenes Design für InText-Werbung wünschst, erstelle dieses bitte bei CONTAXE und w&auml;hle es hier aus.</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_words">
<h3>Anzahl Wörter</h3>
<p>Maximale Anzahl unterschiedlicher W&ouml;rter, die bei InText-Werbung verlinkt werden d&uuml;rfen.</p>
<p>	<strong>Minimum:</strong> 1<br/>
	<strong>Maximum:</strong> 10</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_repeat">
<h3>Wortwiederholungen</h3>
<p>Max. Anzahl, wie oft ein einzelnes Wort f&uuml;r ein Highlight verwendet werden darf.</p>
<p>	<strong>Minimum:</strong> 1 (keine Wiederholung)<br/>
	<strong>Maximum:</strong> 100</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_delay">
<h3>Popup-Schließverzögerung</h3>
<p>Zeit in Millisekunden. Legt fest wie lange das InText-Popup geöffnet bleiben soll, nachdem der Besucher mit der Maus das Popup bzw. den Link verlassen hat.</p>
<p>	<strong>Minimum:</strong> 400 (0,4 Sekunden)<br/>
	<strong>Maximum:</strong> 5000 (5 Sekunden)</p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_active">
<h3>Aktive Regeln</h3>
<p>Regeln die die Sichtbarkeit von InText-Werbung steuern. Verfügbare Regeln hierher ziehen und ordnen. Wenn keine der Regeln zutrifft wird keine InText-Werbung eingeblendet.</p>
<p><em>Wenn keine Regeln gewählt werden, wird immer InText-Werbung eingeblendet.</em></p>
</div>
<div class="wpcontaxe_helpbox" style="display: none" id="helpbox_possible">
<h3>Verfügbare Regeln</h3>
<p>Alle verfügbaren Regeln um die Anzeige von InText-Werbung zu steuern.</p>
</div>
</div>
