<?php
/*
 * Copyright (c) 2020. Golub WP-Core Developed By Keshan-Sandeepa
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


class GolubInitialize
{


    /**
     * Register the action that needed for golub plugin
     */
   public function golubRegister()
    {

        $go_lub_new_action_trigger = new GolubActionsTrigger();
        add_action('admin_enqueue_scripts',array($this,'goEnqueue'));
        add_action('admin_menu',array($this,'golubAdminPages'));
        add_action( 'admin_init', array($this,'goLubAdminSettings' ));
        add_filter('plugin_action_links_'.PLUGIN_NAME,array($this,'golubSettingsLink'));
        add_action('woocommerce_order_status_processing', array( $go_lub_new_action_trigger,'SendGolubWCProcessingAlertToCustomer'));
    }

    /**
     * @return mixed
     * return customized golub settings links
     */



    public function goLubAdminSettings() {

        register_setting( 'golub-api', 'golub_api_options_sms_carrier',array('type'=> 'string','$description' => 'SMS API Carrier','sanitize_callback' => 'sanitize_text_field'));
        register_setting( 'golub-api', 'golub_api_options_sms_user_name',array('type'=> 'string','$description' => 'SMS User Name','sanitize_callback' => 'sanitize_text_field'));
        register_setting( 'golub-api', 'golub_api_options_sms_user_password',array('type'=> 'string','$description' => 'SMS User Name','sanitize_callback' => 'sanitize_text_field') );
        register_setting( 'golub-api', 'golub_api_options_text_masking',array('type'=> 'string','$description' => 'MT Port Text Masking','sanitize_callback' => 'sanitize_text_field') );

        add_settings_section('golub-authentication-setting-section','Settings',array($this,'goLubSectionEcho'),'golub-admin-page');

        add_settings_field(
            'golub-api-options-sms-carrier', // As of WP 4.6 this value is used only internally.
            // Use $args' label_for to populate the id inside the callback.
            __( 'Sms Service', 'Sms Service' ),
            array($this,'golubApiOptionsSmsCarrier'),
            'golub-admin-page',
            'golub-authentication-setting-section',
            array(
                 'label_for'         => 'go_lub_sms_carrier',
                'class'             => 'wporg_row',
                'wporg_custom_data' => 'custom',
                )

        );

        add_settings_field(
            'golub-api-options-user-name', // As of WP 4.6 this value is used only internally.
            // Use $args' label_for to populate the id inside the callback.
            __( 'User Name', 'User Name' ),
            array($this,'golubOptionUserName'),
            'golub-admin-page',
            'golub-authentication-setting-section',
            array(
                'label_for'         => 'go_lub_sms_carrier',
                'class'             => 'wporg_row',
                'wporg_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'golub-api-options-user-password', // As of WP 4.6 this value is used only internally.
            // Use $args' label_for to populate the id inside the callback.
            __( 'Password', 'Password' ),
            array($this,'golubOptionUserPassword'),
            'golub-admin-page',
            'golub-authentication-setting-section',
            array(
                'label_for'         => 'go_lub_sms_carrier',
                'class'             => 'wporg_row',
                'wporg_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'golub-api-options-mt-port', // As of WP 4.6 this value is used only internally.
            // Use $args' label_for to populate the id inside the callback.
            __( 'Text Masking', 'Text Masking' ),
            array($this,'goLubTextMasking'),
            'golub-admin-page',
            'golub-authentication-setting-section',
            array(
                'label_for'         => 'go_lub_sms_carrier',
                'class'             => 'wporg_row',
                'wporg_custom_data' => 'custom',
            )
        );

    }
    public function golubOptionUserName($args)
  {
      $options = get_option( 'golub_api_options_sms_user_name' );
      ?>
      <input  id="<?php echo esc_attr( $args['label_for'] ); ?>" name="golub_api_options_sms_user_name" value="<?php echo isset($options)? $options : '' ?>" type="text" class="form-input" placeholder="User Name" maxlength="255">
      <?php
  }

  public function goLubTextMasking($args)
  {
      $options = get_option( 'golub_api_options_text_masking' );
      ?>
      <input  id="<?php echo esc_attr( $args['label_for'] ); ?>" name="golub_api_options_text_masking" value="<?php echo isset($options)? $options : '' ?>" type="text" class="form-input" placeholder="Text Masking Name" maxlength="255">
      <?php
  }
  public function golubOptionUserPassword($args)
    {
        $options = get_option( 'golub_api_options_sms_user_password' );
        ?>
        <input  id="<?php echo esc_attr( $args['label_for'] ); ?>" name="golub_api_options_sms_user_password" value="<?php echo isset($options)? $options : '' ?>" type="password" class="form-input" placeholder="User Name" maxlength="255">
        <?php
    }

  public function golubApiOptionsSmsCarrier($args){
      $options = get_option( 'golub_api_options_sms_carrier' );
      ?>

      <select
              id="<?php echo esc_attr( $args['label_for'] ); ?>"
              name="golub_api_options_sms_carrier" class="form-input">

          <option value="ada-dialog-api" <?php echo isset( $options ) ? ( selected( $options, 'ada-dialog-api', false ) ) : ( '' ); ?>>
              <?php esc_html_e( 'ADA DIALOG API', 'default' ); ?>
          </option>
          <option disabled value="mobitel-agency-api" <?php echo isset( $options) ? ( selected( $options, 'mobitel-agency-api', false ) ) : ( '' ); ?>>
              <?php esc_html_e( 'MOBITEL AGENCY API', 'default' ); ?>
          </option>

      </select>
      <?php
    }

  public function golubSettingsLink($links)
    {

        $go_lub_settings_links = '<a href="options-general.php?page=golub_plugin_admin_slug">Settings</a>';
        array_push($links,$go_lub_settings_links);
        return $links;
    }

  public  function goLubSectionEcho ($args)
    {
            ?>
            <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( '' ); ?></p>
            <?php

    }

    /**
     *add golub admin page links
     */
  public function golubAdminPages()
    {
        add_menu_page('Golub Plugin','GoLub','manage_options',GOLUB_SLUG,array($this,'golubAdminIndex'),'dashicons-format-status',110);
    }

    /**
     * Define Admin template index
     */
  public function golubAdminIndex()
    {
        require_once( GOLUB__PLUGIN_DIR . 'templates/admin.php' );
    }
    /**
     * add enqueue for the admin panel
     */
  public function goEnqueue()
    {
        wp_enqueue_style('golubappstyle',plugins_url('golub/assets/golub.css',GOLUB__PLUGIN_DIR));
        wp_enqueue_style('golubappscript',plugins_url('golub/assets/golub.js',GOLUB__PLUGIN_DIR));

    }

}
