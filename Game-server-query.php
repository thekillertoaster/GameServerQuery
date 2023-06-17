<?php

/*
Plugin Name: GSQ - Game Server Query
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Provides methods of querying game servers for information.
Version: 0.1
Author: Aaron
Author URI: mailto:thekillertoaster@gmail.com
License: 1-Clause BSD License (http://opensource.org/licenses/BSD-1-Clause)
*/


if (!defined('WPINC')) {
    die;
}

class GSQPlugin {
	public $post_type, $settings;

	public function __construct() {
		include_once plugin_dir_path( __FILE__ ) . 'pages/gsq-settings-page.php';

		$this->settings = new GSQ\GSQ_Settings_Page();
	}
}

new GSQPlugin();