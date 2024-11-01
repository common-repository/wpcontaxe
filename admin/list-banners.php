<div class="wrap">
<h2>Banner</h2>
<table class="widefat">
	<thead>
	<tr>
		<th scope="col"><div style="text-align: center">ID</div></th>
		<th scope="col">Name</th>
		<th scope="col">Format</th>
		<th scope="col">Channel</th>
<!--
		<th scope="col">Erzeugt</th>
		<th scope="col">Aktualisiert</th>
		<th scope="col">Code zum manuellen Einbetten</th>
-->
		<th scope="col">Aktiv</th>
		<th scope="col" colspan="2">Aktion</th>
	</tr>
	</thead>
	<tbody>
<?php
	$class = '';
	foreach ($options['banners'] as $banner) { 
	$class = ( ' class="alternate"' == $class ) ? '' : ' class="alternate"';
?>
	<tr<?php echo $class; ?>>
		<td><?php echo $banner['id']; ?></td>
		<td><?php echo wp_specialchars($banner['name']); ?></td>
		<td><?php echo wp_specialchars(wpcontaxe_banner_format($banner)); ?></td>
		<td><?php echo wp_specialchars((empty($banner['channel']) ? 'Standard' : wpcontaxe_banner_channel($banner))); ?></td>
<!--
		<td><?php echo mysql2date(__('Y-m-d g:i a'), $banner['created']); ?></td>
		<td><?php echo mysql2date(__('Y-m-d g:i a'), $banner['modified']); ?></td>
		<td><?php echo wp_specialchars('<!--wpcontaxe#' . wp_specialchars($banner['name']) . '-->'); ?></td>
-->
		<td><?php echo $banner['enabled'] ? 'Ja' : 'Nein'; ?></td>
		<td><a href="admin.php?page=wpcontaxe/admin/banner.php&amp;action=edit&amp;id=<?php echo $banner['id']; ?>" class="edit">Bearbeiten</a></td>
		<td><a href="admin.php?page=wpcontaxe/admin/banner.php&amp;action=delete&amp;id=<?php echo $banner['id']; ?>" class="delete">L&ouml;schen</a></td>
	</tr>
<?php } ?>
	</tbody>
</table>

<h3><a href="admin.php?page=wpcontaxe/admin/banner.php&amp;action=add">Neuen Banner erstellen &raquo;</a></h3>

</div>
