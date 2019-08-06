<?php 

/*
 This class serves as proxy for sendy custom fields support in subscription form.
 Usage of this class requires updating it's methods whenever new custom fields are created in sendy dashboard and requires to be displayed on form.
*/

class ELEMENT_BUILDER extends YKA_SENDY_BASE {

	// returned value is used to pass fields slug into js through form hidden field
	public function get_fields_slug_string( $fields ) {
		
		$str = "";
		foreach ($fields as $field ) {
			$str .= trim($field);
			$str .= ','; 
		}

		return rtrim($str, ',');
	}
	
	
	// return form elements in subscription form
	public function get_form_element( $field ) {
		
		switch ( trim($field) ) {
			case 'name':
				return $this->get_name();  

			case 'email':
				return $this->get_email(); 

			case 'state':
				return $this->get_state(); 

			case 'language':
				return $this->get_language();

			case 'gender':
				return $this->get_gender();

			case 'editor':
				return $this->get_editor();

			case 'beats':
				return $this->get_beats();

			case 'city':
				return $this->get_city();	 
			
			default:
				return "Field didn't Match!!";
				break;
		}	
	}


	public function get_name() { ?>
		<div class="form-group">
    		<input type="text" name="name" class="form-control" placeholder="Name" required>
  		</div> <?php		
	}

	public function get_email() { ?>
		<div class="form-group">
	    	<input type="email" name="email" class="form-control" placeholder="Email" required>
	  	</div> <?php
	}

	public function get_state() { ?>
		<select name="state" class="form-control space-top" data-location="<?php _e(admin_url( 'admin-ajax.php' ) . '?action=yka_sendy_user_location');?>">
		  <option value="">State/UT</option>
		  <?php
		  	$states = $this->get_states_option();
		  	foreach ($states as $state) {
		  		_e("<option>$state</option>");
		  	}
		  ?>
		</select> <?php
		
	}

	public function get_city() { ?>
		<div data-behaviour="sendy-city">
			<select name="city" class="form-control space-top" >
			  	<option value="">City</option>
			</select>
		</div> <?php
	}

	
	public function get_language() { ?>
		<div class="form-group space-top">
	  		<label>Preferred Language </label>
			<div>
				<label class="checkbox-inline">
					<input type="checkbox" name="language[]" value="english"> English
				</label>
				
				<label class="checkbox-inline">
					<input type="checkbox" name="language[]" value="hindi"> Hindi
				</label>
			</div>
	  	</div> <?php	
	}

	
	public function get_gender() { ?>
		<select name="gender" class="form-control">
		  <option>Gender</option>
		  <option>Male</option>
		  <option>Female</option>
		  <option>Transgender</option>
		  <option>Prefer Not to Say</option>	
		</select> <?php

	}


	public function get_editor() { ?>
		<div class="form-group space-top">
    		<input type="text" name="editor" class="form-control" placeholder="Editor" />
  		</div> <?php
	}


	public function get_beats() { 
		
		$options = array(
			'Society',
			'Gender and Sexulaity',
			'Rights',
			'Cuture Vulture',
			'My Story',
			'Citizen News',
			'Campus Watch'
		);

		?>
		<div class="form-group space-top">
	  		<label>Beats</label>
			<div> 
			
			<?php foreach ($options as $option) : ?>
				<label class="checkbox-inline">
					<input type="checkbox" name="beats[]" value="<?php _e($option);?>" > <?php _e($option);?>	
				</label> 
			<?php endforeach; ?>

			</div>
				
	  	</div> <?php
	}


	public function get_states_option() {
		
		return array(
			"Andhra Pradesh",
			"Arunachal Pradesh",
			"Assam",
			"Bihar",
			"Chandigarh (UT)",
			"Chhattisgarh",
			"Dadra and Nagar Haveli (UT)",
			"Daman and Diu (UT)",
			"Delhi (NCT)",
			"Goa",
			"Gujarat",
			"Haryana",
			"Himachal Pradesh",
			"Jammu and Kashmir",
			"Jharkhand",
			"Karnataka",
			"Kerala",
			"Lakshadweep (UT)",
			"Madhya Pradesh",
			"Maharashtra",
			"Manipur",
			"Meghalaya",
			"Mizoram",
			"Nagaland",
			"Odisha",
			"Puducherry (UT)",
			"Punjab",
			"Rajasthan",
			"Sikkim",
			"Tamil Nadu",
			"Telangana",
			"Tripura",
			"Uttarakhand",
			"Uttar Pradesh",
			"West Bengal",
		);


	}

}