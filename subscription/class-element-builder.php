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
			
			default:
				return "Field didn't Match!!";
				break;
		}	
	}


	public function get_name() { ?>
		<div class="form-group">
    		<input type="name" name="name" class="form-control" placeholder="Name" required>
  		</div> <?php		
	}

	public function get_email() { ?>
		<div class="form-group">
	    	<input type="email" name="email" class="form-control" placeholder="Email" required>
	  	</div> <?php
	}

	public function get_state() { ?>
		<select name="state" class="form-control">
		  <option value="">State/UT</option>
		  <?php
		  	$states = $this->get_states_option();
		  	foreach ($states as $state) {
		  		_e("<option>$state</option>");
		  	}
		  ?>
		</select> <?php
		
	}

	
	public function get_language() { ?>
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
	  	</div> <?php	
	}


	public function get_states_option() {
		
		return array(
			"Andaman and Nicobar Islands",
			"Andhra Pradesh",
			"Arunachal Pradesh",
			"Assam",
			"Bihar",
			"Chandigarh",
			"Chhattisgarh",
			"Dadar and Nagar Haveli",
			"Daman and Diu",
			"Delhi",
			"Goa",
			"Gujarat",
			"Haryana",
			"Himachal Pradesh",
			"Jammu and Kashmir",
			"Jharkhand",
			"Karnataka",
			"Kerala",
			"Lakshadweep",
			"Madhya Pradesh",
			"Maharashtra",
			"Manipur",
			"Meghalaya",
			"Mizoram",
			"Nagaland",
			"Orissa",
			"Punjab",
			"Puducherry",
			"Rajasthan",
			"Sikkim",
			"Tamil Nadu",
			"Telangana",
			"Tripura",
			"Uttaranchal",
			"Uttar Pradesh",
			"West Bengal",
		);

	}

}