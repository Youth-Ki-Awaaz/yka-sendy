<?php

class YKA_SENDY_SUBSCRIPTION extends YKA_SENDY_BASE {

	function __construct() {
		add_action('wp_enqueue_scripts', array( $this, 'assets' ));

		add_shortcode( 'yka_sendy_pm_brief', array($this, 'pm_brief_sh_cb') );

	}

	function assets() {

		$plugin_assets_folder = "yka-sendy/assets/";

		wp_enqueue_script(
			'yka-sendy-js',
			plugins_url( $plugin_assets_folder.'js/sendy-subs.js' ),
			array( 'jquery'),
			KEPLER_POLL_VERSION,
			true
		);
	}

	function pm_brief_sh_cb( $atts ) {

		$args = shortcode_atts( array(
			'list_id' => 'WrbSjPq8qtb2GEWyOTFrIw', /*default to test list*/
		), $atts );

		ob_start();
			include 'forms/pm-brief.php';
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

$sendy = new YKA_SENDY_SUBSCRIPTION();

