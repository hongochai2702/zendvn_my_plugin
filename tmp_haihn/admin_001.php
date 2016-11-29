<?php 
require_once ZENDVN_MP_PLUGIN_DIR . '/includes/support.php';

class ZendvnMpAdmin{
	
	private $_menuSlug = 'zendvn-my-setting-menu';
	
	private $_setting_option;
	//Hàm Construct
	public function __construct() {
		//echo '<br />' . __METHOD__;
		$this->_setting_option = get_option( 'zendvn_mp_name', array() );
		
		add_action('admin_menu', array($this, 'settingMenu'));
		
		add_action('admin_init', array($this, 'register_setting_and_fields'));
	}

	public function register_setting_and_fields(){
		register_setting('zendvn_mp_options', 'zendvn_mp_name' , array($this, 'validate_setting'));
		
		// MAIN SETTING.
		$mainSection = 'zendvn_mp_main_setting';
		add_settings_section($mainSection , 'Main Setting', 
								array($this,'main_setting_section'), $this->_menuSlug);
		
		add_settings_field('zendvn_mp_my_title', 'Site Title', 
								array($this, 'my_title_input') ,$this->_menuSlug, $mainSection);
		
		// EXT SETTING.
		/* $extSection = 'zendvn_mp_ext_setting';
		add_settings_section($extSection, 'Extension Setting', 
								array($this, 'main_setting_section'), $this->_menuSlug); */
		
		add_settings_field('zendvn_mp_logo', 'Logo',
				array($this, 'logo_input_file') ,$this->_menuSlug, $mainSection);
		
		
	}
	
	public function my_title_input(){
		echo '<input type="text" name="zendvn_mp_name[zendvn_mp_my_title]" value="'.$this->_setting_option["zendvn_mp_my_title"].'" />';
	}
	
	public function logo_input_file(){
		echo '<input type="file" name="zendvn_mp_logo" />';
	}
	
	public function main_setting_section(){
		
	}
	
	public function validate_setting( $data_input ){

		if ( !empty($_FILES['zendvn_mp_logo']['name']) ){
			echo 'Upload file thành công.';
			$override = array( 'test_form' => false );
			$fileInfo = wp_handle_upload( $_FILES['zendvn_mp_logo'], $override );
			$data_input['zendvn_mp_logo'] = $fileInfo['url'];

		}
		//die();
		return $data_input;
	}
	
	public function settingMenu(){
		/* add_menu_page( 
			'Setting Page Title', 
			'My Setting', 
			'manage_options', 
			$this->_menuSlug, 
			array($this, 'settingPage')
		); */
		
		add_options_page(
				'Setting Page ZendVN',
				'My Setting',
				'manage_options',
				$this->_menuSlug,
				array( $this, 'settingPage' )
		);
	}
	
	public function settingPage(){
		require_once ZENDVN_MP_VIEWS_DIR . '/setting-page.php';
	}

	
}