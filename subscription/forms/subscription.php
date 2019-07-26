
<form method="POST"  data-behaviour="yka-sendy-form" data-url="<?php _e($ajax_url);?>" content="text/html; charset=utf-8" data-token="<?php _e($nonce);?>" >

	<div class="form-group">
    	<input type="name" name="name" class="form-control" placeholder="Name" required>
  	</div>
  	<div class="form-group">
    	<input type="email" name="email" class="form-control" placeholder="Email" required>
  	</div>

  <?php if( $args['cf'] ): ?>

  	<select name="state" class="form-control">
	  <option value="">State/UT</option>
	  <?php
	  	$states = $this->get_states();
	  	foreach ($states as $state) {
	  		_e("<option>$state</option>");
	  	}
	  ?>
	</select>

  	<div class="form-group space-one">
  		<label>Preferred Language </label>
		<div>
			<label class="checkbox-inline">
				<input type="checkbox" name="language[]" value="english"> English
			</label>
			
			<label class="checkbox-inline">
				<input type="checkbox" name="language[]" value="hindi"> Hindi
			</label>
		</div>
  	</div>

  <?php endif;?>
	
	<div>
		<input type="hidden" name="list" value="<?php _e($args['id']);?>"/>
		<input type="hidden" name="cf" value="<?php $args['cf']? _e('true'): _e('false');?>" />
	</div>
	<div>
		<button type="submit" class="btn btn-primary sendy-sub-btn">Subscribe <i class="fa fa-refresh fa-spin" style="display:none"></i></button>
	</div>
	<div class="sendy-status space-one"></div>
</form>