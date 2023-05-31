<style>
	[data-behaviour="yka-sendy-form"] .checkbox-inline {
		margin-left: 10px;
		min-width: 80px;
	}

	[data-behaviour="yka-sendy-form"] .space-top {
		margin-top: 15px;
	}

	[data-behaviour="yka-sendy-form"] .space-bottom {
		margin-bottom: 15px;
	}

	[data-behaviour="yka-sendy-form"] .form-language {
		text-transform: capitalize;
	}
</style>
<form method="POST" data-behaviour="yka-sendy-form" action="<?php _e($ajax_url); ?>" content="text/html; charset=utf-8" data-token="<?php _e($nonce); ?>">

	<?php

	$html = "";
	$builder = ELEMENT_BUILDER::get_instance();

	foreach ($fields as $field) {
		$html .= $builder->get_form_element($field);
	}

	echo $html;
	?>

	<div>
		<input type="hidden" name="token" value="<?php _e($nonce); ?>" />
		<input type="checkbox" name="honey_on" value="1" class="invisible" />
		<input type="hidden" name="list" value="<?php _e($args['id']); ?>" />
		<input type="hidden" name="fields" value="<?php _e(implode(',', array_map('trim', explode(',', $args['fields'])))); ?>" />
	</div>
	<div>
		<button type="submit" class="border rounded px-4 py-1">Subscribe <i class="fa fa-refresh fa-spin" style="display:none"></i></button>
	</div>
	<div id="sendy-status"></div>
</form>