<?php
require_once ZENDVN_MP_PLUGIN_DIR . '/includes/support.php';
class ZendvnMp{
	
	public function __construct(){
		//echo '<br/>' . __METHOD__;
		//=====================================================
		//1. Ham thay doi toan bo title trong hook 'the_title'
		//=====================================================
		add_filter('the_content', array($this,'changeString'));
		add_filter('the_title', array($this,'changeString'));
		
		//=====================================================
		//2. Hiển thị các Action đang thực thi trong Hook
		//=====================================================
		add_action('wp_footer', array($this,'showFunction'));		
	
	
	}	
	
	public function changeString($text){
		//Xu ly ma lenh $content
		// $text = $content - $title
		if(current_filter() == 'the_title'){
			if(!is_page()){
				$text .= ' - my title';
			}
		}
		
		if(current_filter() == 'the_content'){
			$text =  str_replace("example", "<u>ví dụ</u>", $text);
		}
		
		return $text;
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