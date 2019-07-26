<?php

class YKA_SENDY_SUBSCRIPTION extends YKA_SENDY_BASE {

	function __construct() {
		add_action('wp_enqueue_scripts', array( $this, 'assets' ));

		add_shortcode( 'yka_sendy_form', array($this, 'subscription_form') );

		add_action( 'wp_ajax_yka_sendy_subs', array( $this, 'sendy_ajax_handler' ) );
		add_action( 'wp_ajax_nopriv_yka_sendy_subs', array( $this, 'sendy_ajax_handler' ) );

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
			'id' => 'WrbSjPq8qtb2GEWyOTFrIw', /* defaults to test list */
			'cf' => false, /* set true to enable custom fields in form */	
		), $atts );

		
		$ajax_url 	= admin_url( 'admin-ajax.php' ) . '?action=yka_sendy_subs'; 
		$nonce 		= wp_create_nonce('YKA-SENDY-FORM');


		ob_start();
			include 'forms/subscription.php';
		return ob_get_clean();

	}


	function sendy_ajax_handler() {

		check_ajax_referer( 'YKA-SENDY-FORM', 'token' );

		$sendy_url 	= 'https://newsletters.youthkiawaaz.com';
		$list 		= sanitize_text_field( $_POST['list'] );
		
		//POST variables
		$name 		= sanitize_text_field( $_POST['name'] );
		$email 		= sanitize_email( $_POST['email'] );
		$cf 		= sanitize_text_field( $_POST['cf'] );

		$data_args 	= array(
		    'name' 	=> $name,
		    'email' => $email,
		    'list' 	=> $list,
		    'boolean' => 'true'
		);

		if( $cf === "true" ) {

			//grab values of custom fields
			$state = sanitize_text_field( $_POST['state'] ); 
			$lang  = sanitize_text_field( $_POST['lang'] );

			//update postdata args
			$data_args['State'] = $state;
			$data_args['Preferredlanguage'] = $lang;
		
		}

		
		$postdata = http_build_query( $data_args );

		$opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));

		
		$context  = stream_context_create($opts);
		
		$result = file_get_contents($sendy_url.'/subscribe', false, $context);
		
		echo $result;

		wp_die();
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

