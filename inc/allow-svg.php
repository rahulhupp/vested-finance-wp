<?php
	function allow_svg_uploads($mimes) {
		if (current_user_can('administrator')) {
			$mimes['svg'] = 'image/svg+xml';
		}
		return $mimes;
	}
	add_filter('upload_mimes', 'allow_svg_uploads');	
?>