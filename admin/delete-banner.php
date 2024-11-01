<?php
	$banner = $options['banners'][$_REQUEST['id']];
?>
<div class="wrap">
<h2>Banner l&ouml;schen</h2>
<form name="deletebanner" id="deletebanner" method="post" action="admin.php?page=wpcontaxe/admin/banner.php">
<input type="hidden" name="action" value="delete" />
<input type="hidden" name="id" value="<?php echo $banner['id']; ?>" />
<?php wp_nonce_field('wpcontaxe-delete_' . $banner['id']); ?>
<p>Bist du sicher, dass du den Banner <?php echo $banner['id']; ?> - <?php echo wp_specialchars($banner['name']); ?> l&ouml;schen willst?
<p class="submit"><input type="submit" name="deleteBanner" value="Banner l&ouml;schen" /></p>
</form>

<h3><a href="admin.php?page=wpcontaxe/admin/banner.php">&laquo; Zur&uuml;ck</a></h3>
</div>
