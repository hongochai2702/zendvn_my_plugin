<?php
require_once ZENDVN_MP_PLUGIN_DIR . '/includes/support.php';
class ZendvnMp{
	
	public function __construct(){
		echo '<br/>' . __METHOD__;
		//=====================================================
		//1. Ham thay doi toan bo title trong hook 'the_title'
		//=====================================================
		add_filter('the_title', array($this,'theTitle'));
		
		//=====================================================
		//2. Hiển thị các Action đang thực thi trong Hook
		//=====================================================
		add_action('wp_footer', array($this,'showFunction'));		
	
		//=====================================================
		//3. Loai bo tat cac ham trong Hook theo do uu tien
		//=====================================================
		remove_all_filters('the_content',10);
		
		//=====================================================
		//4. Loai bo tat cac ham trong Hook 
		//=====================================================
		remove_all_filters('the_content');
		
	}	
	
	//=====================================================
	//2. Hiển thị các Action đang thực thi trong Hook
	//=====================================================
	public function showFunction(){
		ZendvnMpSupport::showFunc('the_content');
	}
		
	//=====================================================
	//1. Ham thay doi toan bo title trong hook 'the_title'
	//=====================================================
	public function theTitle(){
		$str = 'Thay doi tieu cua bai viet';
		return $str;
	}
}