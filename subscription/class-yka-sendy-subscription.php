<?php

class YKA_SENDY_SUBSCRIPTION extends YKA_SENDY_BASE {

	function __construct() {
		add_action('wp_enqueue_scripts', array( $this, 'assets' ));

		add_shortcode( 'yka_sendy_form', array($this, 'subscription_form') );

		add_action( 'wp_ajax_yka_sendy_subs', array( $this, 'sendy_ajax_handler' ) );
		add_action( 'wp_ajax_nopriv_yka_sendy_subs', array( $this, 'sendy_ajax_handler' ) );


		add_action( 'wp_ajax_yka_sendy_user_location', array( $this, 'sendy_location_handler' ) );
		add_action( 'wp_ajax_nopriv_yka_sendy_user_location', array( $this, 'sendy_location_handler' ) );

		add_action( 'user_register', array( $this, 'signup_user_sync' ), 99, 1 );

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
			'fields' => "name, email",
		), $atts );


		$ajax_url 	= admin_url( 'admin-ajax.php' ) . '?action=yka_sendy_subs';
		$nonce 		= wp_create_nonce('YKA-SENDY-FORM');

		$fields = explode(',', $args['fields'] );


		ob_start();
			include 'forms/subscription.php';
		return ob_get_clean();

	}


	function sendy_ajax_handler() {

		check_ajax_referer( 'YKA-SENDY-FORM', 'token' );

		$list 		= sanitize_text_field( $_POST['list'] );

		//POST variables
		$name 		= sanitize_text_field( $_POST['name'] );
		$email 		= sanitize_email( $_POST['email'] );
		$fields 	= sanitize_text_field( $_POST['fields'] );

		$data = array(
		    'name' 	=> $name,
		    'email' => $email,
		    'list' 	=> $list,
		    'boolean' => 'true'
		);

		if( strlen($fields) ) {

			$fields = explode(',', $fields);

			$fieldsData = array(
				'state'			=> 'State',
				'gender'		=> 'Gender',
				'editor'		=> 'Editor',
				'beats'			=> 'Beats',
				'city'			=> 'City',
				'topics'		=> 'Topics'
			);

			foreach( $fieldsData as $slug => $label ){
				if( in_array( $slug, $fields, true) ) {
					$data[ $label ] = sanitize_text_field( $_POST[ $slug ] );
				}
			}

			// HERE THE SLUG IS DIFFERENT FROM THE ONE PASSED IN THE POST PARAMETER
			if( in_array('language', $fields, true) ) {
				$lang  = sanitize_text_field( $_POST['lang'] );
				$data['Preferredlanguage'] = $lang;
			}

		}

		$result = $this->sync_with_sendy( $data );

		echo $result;

		wp_die();
	}



	function sync_with_sendy( $data ) {

		$api_endpoint 	= 'https://newsletters.youthkiawaaz.com/subscribe';

		$postdata = http_build_query( $data );

		$opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));


		$context  = stream_context_create($opts);

		$result = file_get_contents($api_endpoint, false, $context);

		return $result;

	}


	function signup_user_sync( $user_id ) {

		$options = get_option( 'yka_sendy_settings' );

		if(isset( $options['yka_sendy_signup_sync']) && $options['yka_sendy_signup_sync'] && !empty($options['yka_sendy_signup_list']) ) {

			$list = $options['yka_sendy_signup_list'];

			$user_info = get_userdata($user_id);

      		$args = array(
      			"name" 		=> $user_info->user_nicename,
      			"email"		=> $user_info->user_email,
      			'list' 		=> trim( $list ),
		        'boolean' 	=> 'true'
      		);

      		$result = $this->sync_with_sendy($args);

      	}
	}


	function sendy_location_handler() {
		if( isset($_GET['place']) ) {

			$place = $_GET['place'];

			$data = file_get_contents( plugin_dir_path( __DIR__ ) . "assets/json/location.json" );

			$json = json_decode($data, true);


			foreach ($json['states'] as $key => $location) {
				if( $location['state'] == $place ){
					$result = $location['districts'];
					echo json_encode( $result );
				}

			}
		}

		wp_die();

	}

}

new YKA_SENDY_SUBSCRIPTION;
