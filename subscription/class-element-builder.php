<?php

/*
 This class serves as proxy for sendy custom fields support in subscription form.
 Usage of this class requires updating it's methods whenever new custom fields are created in sendy dashboard and requires to be displayed on form.
*/

class ELEMENT_BUILDER extends YKA_SENDY_BASE
{

	// returned value is used to pass fields slug into js through form hidden field
	public function get_fields_slug_string($fields)
	{

		$str = "";
		foreach ($fields as $field) {
			$str .= trim($field);
			$str .= ',';
		}

		return rtrim($str, ',');
	}


	// return form elements in subscription form
	public function get_form_element($field)
	{

		switch (trim($field)) {

			case 'name':
				return $this->textfield(array(
					//'type'				=> 'text',
					'name' 				=> 'name',
					'placeholder' => 'Name',
					'required'		=> true
				));

			case 'email':
				return $this->textfield(array(
					'type'				=> 'email',
					'name' 				=> 'email',
					'placeholder' => 'Email',
					'required'		=> true
				));

			case 'state':
				return $this->get_state();

			case 'language':
				return $this->checkboxes(array(
					'class'		=> 'form-group space-top form-language',
					'label'		=> 'Preferred Language',
					'name' 		=> 'language',
					'options'	=> array('english', 'hindi')
				));

			case 'gender':
				return $this->dropdown(array(
					'name'	=> 'gender',
					'options'	=> array('Gender', 'Male', 'Female', 'Transgender', 'Prefer Not to Say')
				));

			case 'editor':
				return $this->textfield(array(
					'parent_class'	=> 'form-group space-top',
					'name'					=> 'editor',
					'placeholder'		=> 'Editor'
				));

			case 'beats':
				return $this->checkboxes(array(
					'class'		=> 'form-group space-top',
					'label'		=> 'Beats',
					'name' 		=> 'beats',
					'options'	=> array('Society', 'Gender and Sexuality', 'Rights', 'Cuture Vulture', 'My Story', 'Citizen News', 'Campus Watch')
				));

			case 'city':
				return $this->get_city();

			case 'topics':
				return $this->textarea(array(
					'name' 				=> 'topics',
					'placeholder' => 'Topics I\'m interested in',
					'rows'				=>	'3'
				));

			default:
				return "Field didn't Match!! Needs to be added.";
				break;
		}
	}

	function textarea($atts)
	{
		$atts['parent_class'] = isset($atts['parent_class']) && $atts['parent_class'] ? $atts['parent_class'] : "form-group";

		$atts['class'] = isset($atts['class']) && $atts['class'] ? $atts['class'] : "form-control";

		_e('<div class="' . $atts['parent_class'] . '">');

		_e("<textarea");
		foreach (array('rows', 'name', 'class', 'placeholder') as $slug) {
			if (isset($atts[$slug]) && $atts[$slug]) {
				_e(' ' . $slug . '="' . $atts[$slug] . '"');
			}
		}
		_e("></textarea>");

		_e('</div>');
	}


	function textfield($atts)
	{

		$atts['parent_class'] = isset($atts['parent_class']) && $atts['parent_class'] ? $atts['parent_class'] : "form-group";

		$atts['class'] = isset($atts['class']) && $atts['class'] ? $atts['class'] : "form-control mb-3";

		$atts['type'] = isset($atts['type']) && $atts['type'] ? $atts['type'] : "text";

		_e('<div class="' . $atts['parent_class'] . '">');

		_e('<input');
		foreach (array('type', 'name', 'class', 'placeholder') as $slug) {
			if (isset($atts[$slug]) && $atts[$slug]) {
				_e(" $slug='" . $atts[$slug] . "'");
			}
		}

		if (isset($atts['required']) && $atts['required']) {
			_e(' required');
		}
		_e(' />');



		_e('</div>');
	}


	public function get_state()
	{ ?>
		<select name="state" class="form-control space-top" data-location="<?php _e(admin_url('admin-ajax.php') . '?action=yka_sendy_user_location'); ?>">
			<option value="">State/UT</option>
			<?php
			$states = $this->get_states_option();
			foreach ($states as $state) {
				_e("<option>$state</option>");
			}
			?>
		</select> <?php

				}

				public function get_city()
				{ ?>
		<div data-behaviour="sendy-city">
			<select name="city" class="form-control space-top">
				<option value="">City</option>
			</select>
		</div> <?php
				}


				function dropdown($atts)
				{

					$atts['class'] = isset($atts['class']) && $atts['class'] ? $atts['class'] : 'form-control';

					_e('<select name="' . $atts['name'] . '" class="' . $atts['class'] . '">');
					foreach ($atts['options'] as $option) {
						_e('<option>' . $option . '</option>');
					}
					_e('</select>');
				}


				function checkboxes($atts)
				{

					$atts['class'] = isset($atts['class']) && $atts['class'] ? $atts['class'] : "form-group space-top";

					_e('<div class="' . $atts['class'] . '">');
					if (isset($atts['label']) && $atts['label']) {
						$this->label($atts['label']);
					}
					_e('<div>');
					foreach ($atts['options'] as $option) {
						_e('<label class="checkbox-inline">');
						_e('<input type="checkbox" name="' . $atts['name'] . '[]" value="' . $option . '" >');
						_e($option);
						_e('</label>');
					}
					_e('</div>');
					_e('</div>');
				}


				function label($label)
				{
					_e('<label>' . $label . '</label>');
				}


				public function get_states_option()
				{

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
