<?php
/*
Plugin Name: MIX GCM Sender
Description: Google Cloud Messaging Plugin for WordPress.
Version: 1.0
Author: Dmitriy Mikheev
*/

require_once('class-mix-gcm-sender.php');

add_action('admin_menu', 'MIXGCMSenderSubmenu');
add_action('admin_init', 'MIXGCMAddSettings');

function MIXGCMSenderSubmenu(){
    add_submenu_page('options-general.php', 'Settings', 'MIXGCMSender', 'manage_options', 'mix-gcm-sender', 'MIXGCMAddSettingsForm'); 
}

function MIXGCMAddSettingsForm(){
	?>
	<div class="wrap">
            <form action="options.php" method="POST">
                <?php settings_fields( 'mix_gsm_setting' ); ?>                      
                <?php do_settings_sections( 'mix-gcm-sender' ); ?>
                <?php submit_button(); ?>
            </form>
        </div>
            <?php
}

function MIXGCMAddSettings(){
    register_setting( 'mix_gsm_setting', 'MIXGCMAPI' );
    register_setting( 'mix_gsm_setting', 'MIXGCMMessage' );
    add_settings_section( 'main_settings', 'Main_setting', '', 'mix-gcm-sender' );
    add_settings_field(
        'MIXGCMAPI',
        'Google Api Key',
        'MIXGCMAPI_callback',
        'mix-gcm-sender', // page
        'main_settings' // section
    ); 
    add_settings_field(
        'MIXGCMMessage',
        'Message',
        'MIXGCMMessage_callback',
        'mix-gcm-sender', // page
        'main_settings' // section
    );
}

function MIXGCMMessage_callback(){
    
    $val = get_option('MIXGCMMessage');
    $val = $val['input'];
    ?>
<textarea name="MIXGCMMessage[input]" maxlength='160'
><?=$val ?></textarea>
    
    <?php
}

function MIXGCMAPI_callback(){
    $val = get_option('MIXGCMAPI');
    $val = $val['input'];
    ?>
    
    <input name="MIXGCMAPI[input]" type="text" value="<?=$val ?>" />
    <?php
}