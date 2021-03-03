<?php

//create plugin settings page
add_action( 'admin_menu', 'yka_sendy_admin_menu');
add_action( 'admin_init', 'yka_sendy_settings_init' );


function yka_sendy_admin_menu() {
	add_options_page( 'Sendy Settings Page', 'Yka Sendy', 'manage_options', 'yka-sendy-settings', 'yka_sendy_settings_page' );
}


function yka_sendy_settings_init() {
	register_setting( 'yka_sendy_group', 'yka_sendy_settings' );

	add_settings_section(
        'yka_sendy_section',
        __( '', 'wordpress' ),
        'yka_sendy_section_callback',
        'yka_sendy_group'
    );

    add_settings_field(
        'yka_sendy_signup_sync',
        __( 'Enable New User Signup Sync', 'wordpress' ),
        'yka_sendy_signup_sync_render',
        'yka_sendy_group',
        'yka_sendy_section'
    );

    add_settings_field(
        'yka_sendy_signup_list',
        __( 'List ID to Sync Signed Up User', 'wordpress' ),
        'yka_sendy_signup_list_render',
        'yka_sendy_group',
        'yka_sendy_section'
    );

    add_settings_field(
        'yka_sendy_api_key',
        __( 'Sendy API Key', 'wordpress' ),
        'yka_sendy_api_key_render',
        'yka_sendy_group',
        'yka_sendy_section'
    );

}


function yka_sendy_section_callback() {
	//echo __( 'This Section Description', 'wordpress' );
}

function yka_sendy_signup_sync_render() {

	$options = get_option( 'yka_sendy_settings' ); 

	if( !isset($options['yka_sendy_signup_sync']) ) {
		$options['yka_sendy_signup_sync'] = false;
	} 

	?>

    <input type='checkbox' name='yka_sendy_settings[yka_sendy_signup_sync]' value="1" <?php checked( $options['yka_sendy_signup_sync'], 1 ); ?> /> <?php

}


function yka_sendy_signup_list_render() {

	$options = get_option( 'yka_sendy_settings' ); ?>
    
    <input type='text' name='yka_sendy_settings[yka_sendy_signup_list]' value='<?php isset( $options['yka_sendy_signup_list'] ) ? _e($options['yka_sendy_signup_list']) : ''; ?>'> <?php

}


function yka_sendy_api_key_render() {

    $options = get_option( 'yka_sendy_settings' ); ?>
    
    <input type='text' name='yka_sendy_settings[yka_sendy_api_key]' value='<?php isset( $options['yka_sendy_api_key'] ) ? _e($options['yka_sendy_api_key']) : ''; ?>'> <?php

}


function yka_sendy_settings_page() { ?>

    <form action='options.php' method='post'>

        <h1>Yka Sendy Settings</h1>

        <?php
        settings_fields( 'yka_sendy_group' );
        do_settings_sections( 'yka_sendy_group' );
        submit_button();
        ?>

    </form> <?php

}

