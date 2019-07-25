<?php

class YKA_SENDY_SUBSCRIPTION extends YKA_SENDY_BASE {

	function __construct() {
		add_action('wp_enqueue_scripts', array( $this, 'assets' ));

		add_shortcode( 'yka_sendy_form', array($this, 'subscription_form') );

	}

	function assets() {

		$plugin_assets_folder = "yka-sendy/assets/";

		wp_enqueue_script(
			'yka-sendy-js',
			plugins_url( $plugin_assets_folder.'js/yka-sendy.js' ),
			array( 'jquery'),
			YKA_SENDY_VERSION,
			true
		);
	}

	function subscription_form( $atts ) {

		$args = shortcode_atts( array(
			'id' => 'WrbSjPq8qtb2GEWyOTFrIw', /*defaults to test list*/
		), $atts );


		ob_start();
			include 'forms/subscription.php';
		return ob_get_clean();

	}


	function get_states() {
		
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

new YKA_SENDY_SUBSCRIPTION;

