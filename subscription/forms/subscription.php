
<form method="POST" data-behaviour="yka-sendy-form" data-url="<?php _e($ajax_url);?>" content="text/html; charset=utf-8" >

	<div class="form-group">
    	<input type="name" name="name" class="form-control" placeholder="Name" required>
  	</div>
  	<div class="form-group">
    	<input type="email" name="email" class="form-control" placeholder="Email" required>
  	</div>

  	<select name="State" class="form-control">
	  <option >State/UT</option>
	  <?php
	  	$states = $this->get_states();
	  	foreach ($states as $state) {
	  		_e("<option>$state</option>");
	  	}
	  ?>
	</select>

  	<div class="form-group space-one">
  		<label>Preferred Language </label>

		<label class="radio-inline">
			<input type="radio" name="Preferredlanguage" value="english"> English
		</label>
		
		<label class="radio-inline">
			<input type="radio" name="Preferredlanguage" value="hindi"> Hindi
		</label>
  	</div>
	
	<div>
		<input type="hidden" name="list" value="<?php _e($args['id']);?>"/>
	</div>
	<div>
		<button type="submit" class="btn btn-primary sendy-sub-btn">Subscribe <i class="fa fa-refresh fa-spin" style="display:none"></i></button>
	</div>
	<div class="sendy-status space-one"></div>
</form>