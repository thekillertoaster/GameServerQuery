<?php

namespace GSQ;

class GSQ_Settings_Page {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'gsq_plugin_create_settings' ) );
        add_action( 'admin_init', array( $this, 'gsq_plugin_setup_sections' ) );
        add_action( 'admin_init', array( $this, 'gsq_plugin_setup_fields' ) );
    }

    public function gsq_plugin_create_settings() {
        $page_title = 'GSQ Plugin Settings';
        $menu_title = 'GSQ Settings';
        $capability = 'manage_options';
        $slug       = 'gsq_plugin';
        $callback   = array( $this, 'gsq_plugin_settings_content' );

        add_options_page( $page_title, $menu_title, $capability, $slug, $callback );
    }

    public function gsq_plugin_settings_content() { ?>
        <div class="wrap">
            <h1>GSQ Plugin Settings</h1>
            <form method="POST" action="options.php">
                <?php
                settings_fields( 'gsq_plugin' );
                do_settings_sections( 'gsq_plugin' );
                submit_button();
                ?>
            </form>
        </div> <?php
    }

    public function gsq_plugin_setup_sections() {
        add_settings_section( 'gsq_plugin_section', 'General Settings', array(), 'gsq_plugin' );
    }

    public function gsq_plugin_setup_fields() {
        $fields = array(
            array(
                'label' => 'Generate Shortcodes?',
                'id' => 'generate_shortcodes',
                'type' => 'checkbox',
                'section' => 'gsq_plugin_section',
                'desc' => 'Should Shortcodes be generated for each server?',
            ),
			array(
                'label' => 'Register Post-Type',
                'id' => 'regster_post_type',
                'type' => 'checkbox',
                'section' => 'gsq_plugin_section',
                'desc' => 'Should the "server" post type be registered?',
            )
        );
        foreach ( $fields as $field ) {
            add_settings_field( $field['id'], $field['label'], array(
                $this,
                'gsq_plugin_field_callback'
            ), 'gsq_plugin', $field['section'], $field );
            register_setting( 'gsq_plugin', $field['id'] );
        }
    }

    public function gsq_plugin_field_callback( $field ) {
        $value = get_option( $field['id'] );
        if ($field["type"] == "checkbox") {
            $checked = ($value == "on" ? "checked" : "");
            echo '<input name="' . $field['id'] . '" id="' . $field['id'] . '" type="' . $field['type'] . '" ' . $checked . ' />';
        } else {
            echo '<input name="' . $field['id'] . '" id="' . $field['id'] . '" type="' . $field['type'] . '" value="' . $value . '" />';
        }
        if ( isset( $field['desc'] ) ) {
            if ( $desc = $field['desc'] ) {
                echo '<p class="description">' . $desc . '</p>';
            }
        }
    }

}
