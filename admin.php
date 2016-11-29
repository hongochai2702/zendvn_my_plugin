<?php 
require_once ZENDVN_MP_PLUGIN_DIR . '/includes/support.php';

class ZendvnMpAdmin{
	
	private $_menuSlug = 'zendvn-my-setting-menu';
	
	private $_setting_option;
	//Hàm Construct
	public function __construct() {
		//echo '<br />' . __METHOD__;
		$this->_setting_option = get_option( 'haitrang_setting_name', array() );
		add_action( 'admin_menu', array( $this, 'settingMenu' ) );
		add_action( 'admin_init', array( $this, 'register_setting_and_fields' ) );
	}

	public function register_setting_and_fields(){
		
		// Register Setting ,
		register_setting( 'haitrang_mp_options' , 'haitrang_setting_name', array( $this, 'validate_setting' ) );

		$mainSection = 'haitrang_mp_mainSection';
		add_settings_section( $mainSection, 'Main Section', array($this,'haitrang_mainSection'), $this->_menuSlug );

		add_settings_field( 'haitrang_mp_title', 'Site Title', array( $this, 'create_form' ), $this->_menuSlug, $mainSection, 
							array('name' => 'ht_input_title') );

		add_settings_field( 'haitrang_mp_logo', 'Logo', array( $this, 'create_form' ), $this->_menuSlug, $mainSection, 
							array('name' => 'ht_mp_logo') );
	}
	
	public function create_form($arg){
		
		if ( $arg['name'] == 'ht_input_title' ) {
			echo '<input type="text" name="haitrang_setting_name[haitrang_mp_title]"
						 value="'.$this->_setting_option['haitrang_mp_title'].'" />';
			echo '<p class="description">Nhập không quá 20 ký tự.</p>';
		}
		
		if ( $arg['name'] == 'ht_mp_logo' ) {
			echo '<input type="file" name="ht_mp_logo" />';
			echo '<p class="description">Định dạng hình phải là PNG - JPG - GIF.</p>';
			if ( !empty($this->_setting_option['ht_mp_logo']) ){
				echo '<p><img src="'.$this->_setting_option['ht_mp_logo'].'" title="'.$this->_setting_option['haitrang_mp_title'].'"
								width="150" height="150" /></p>';
			}
		}
	}

	public function ht_mp_logo(){
		echo '<input type="file" name="ht_mp_logo" />';
		if ( !empty($this->_setting_option['ht_mp_logo']) ){
			echo '<p><img src="'.$this->_setting_option['ht_mp_logo'].'" title="'.$this->_setting_option['haitrang_mp_title'].'" 
							width="150" height="150" /></p>';
		}
	}

	public function ht_input_title(){
		echo '<input type="text" name="haitrang_setting_name[haitrang_mp_title]" 
					 value="'.$this->_setting_option['haitrang_mp_title'].'" />';
	}

	public function haitrang_mainSection(){

	}

	//======================================
	// Kiểm tra các dữ liệu được gửi lên Server.
	//======================================
	public function validate_setting( $data ){

		// Lưu thông báo lỗi.
		$error = array();
		
		if ( !$this->stringValidateMax($data['haitrang_mp_title'], 20) ){
			$error['haitrang_mp_title'] = 'Lỗi: Site title không được nhập quá 20 ký tự !';
		}
		
		if ( !empty($_FILES['ht_mp_logo']['name']) ){
			
			if ( !$this->fileValidateExtension($_FILES['ht_mp_logo']['name'], 'JPG|PNG|GIF') ){
				$error['ht_mp_logo'] = 'Lỗi: Tập tin tải lên không phải là định dạng hình ảnh.';
			} else {
		
				if ( !empty( $this->_setting_option['ht_mp_logo_path'] ) ){
					@unlink($this->_setting_option['ht_mp_logo_path']);
				}
				$overrides = array( 'test_form' => false );
				$fileInfo = wp_handle_upload( $_FILES['ht_mp_logo'], $overrides );
				$data['ht_mp_logo']			= $fileInfo['url'];
				$data['ht_mp_logo_path']	= $fileInfo['file'];
			}
			
		} else {
			$data['ht_mp_logo']			= $this->_setting_option['ht_mp_logo'];
			$data['ht_mp_logo_path']	= $this->_setting_option['ht_mp_logo_path'];
		}
		if (count($error) > 0) {
			$data = $this->_setting_option;
			
			foreach ($error as $key => $val) {
				$strError .= $val . '<br />';
			}
			add_settings_error($this->_menuSlug, 'my-setting', $strError, 'error');
		//die();
		}
		
		return $data;
	}
	
	//======================================
	// Kiểm tra độ dài của chuổi.
	//======================================
	private function stringValidateMax( $val, $max ) {
		$flag = false;
		
		$str = trim($val);
		if ( strlen($str) <= $max ) {
			$flag = true;
		}
		
		return $flag;
	}
	
	//======================================
	// Kiểm tra phần mở rộng của hình.
	//======================================
	private function fileValidateExtension( $filename, $filetype ){
		$flag = false;
		$pattern = '/^.*\.(' . strtolower($filetype) . ')$/i';
		if (preg_match($pattern, strtolower($filename)) == 1 ){
			$flag = true;
		}
		
		return $flag;
	}
	
	public function settingMenu(){
		add_options_page( 
			'HT Setting', 
			'Setting Page HT', 
			'manage_options', 
			$this->_menuSlug, 
			array( $this, 'settingPage' )
		);
	}

	public function settingPage(){
		require_once ZENDVN_MP_VIEWS_DIR . '/setting-page.php';
	}
	
}