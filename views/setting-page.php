<div class="wrap">
	<h1> My Setting</h1>
	<p class="description">Đây là trang hiện thị của ZendVN MP Admin.</p>
	<form method="post" action="options.php" id="zendvn-mp-form-setting" enctype="multipart/form-data">
		<?php echo settings_fields('haitrang_mp_options'); ?>
		<?php echo do_settings_sections( $this->_menuSlug ); ?>
		<?php echo submit_button(); ?>
	</form>
</div>