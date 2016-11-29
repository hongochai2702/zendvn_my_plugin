<?php
require_once ZENDVN_MP_PLUGIN_DIR . '/includes/support.php';
class ZendvnMp{
	
	public function __construct(){
		echo '<br/>' . __METHOD__;
		//=====================================================
		//1. Ham thay doi toan bo title trong hook 'the_title'
		//=====================================================
		//add_filter('the_title', array($this,'theTitle'));
		
		//=====================================================
		//2. Ham su dung 2 tham cua hook 'the_title'
		//=====================================================
		//add_filter('the_title', array($this,'theTitle2'),10,2);
		
		//=====================================================
		//3. Ham su dung 2 tham cua hook 'the_title'
		//=====================================================
		//add_filter('the_title', array($this,'theTitle3'),10,2);
		
		//=====================================================
		//4. Hiển thị các Action đang thực thi trong Hook
		//=====================================================
		add_action('wp_footer', array($this,'showFunction'));
		
		//=====================================================
		//5. Su dung tham so content trong Hook 'the_content'
		//=====================================================
		//add_filter('the_content', array($this,'changeContent'));
		
		//=====================================================
		//6 Su dung tham so content trong Hook 'the_content'
		//=====================================================
		//add_filter('the_content', array($this,'changeContent2'));
		
		//=====================================================
		//7 Su dung tham so content trong Hook 'the_content'
		//=====================================================
		add_filter('the_content', array($this,'changeContent3'));
	}
	
	//=====================================================
	//7. Su dung tham so content trong Hook 'the_content'
	//=====================================================
	public function changeContent3($content){
		global $post;
		/* echo '<pre>';
		print_r($post->post_type);
		echo '</pre>'; */
		if($post->post_type == 'page'){
			$content .= "Day la mot bai viet cua ZendVN";
		}
		return $content;
	}
	
	
	//=====================================================
	//6. Su dung tham so content trong Hook 'the_content'
	//=====================================================
	public function changeContent2($content){
		$content = str_replace('WordPress', '<a href="http://www.zend.vn">WP</a>', $content);
		return $content;
	}
	
	
	//=====================================================
	//5. Su dung tham so content trong Hook 'the_content'
	//=====================================================
	public function changeContent($content){
		$content .= 'Day la bai viet cua ZendVN';
		return $content;
	}
	
	//=====================================================
	//4. Hiển thị các Action đang thực thi trong Hook
	//=====================================================
	public function showFunction(){
		ZendvnMpSupport::showFunc('wp_footer');
	}
	
	//=====================================================
	//3. Ham su dung 2 tham cua hook 'the_title'
	//=====================================================
	public function theTitle3($title, $id){
		//echo "<br/>" . $id;
		if($id == 1){
			$title = 'Chào mừng các bạn đến với thế giới WP';
		}
		return $title;
	}
	
	//=====================================================
	//2. Ham su dung 2 tham cua hook 'the_title'
	//=====================================================
	public function theTitle2($title, $id){
		//echo "<br/>" . $id;
		if($id == 1){
			$title = str_replace("Hello", "Xin chào", $title);
		}
		return $title;
	}
	
	//=====================================================
	//1. Ham thay doi toan bo title trong hook 'the_title'
	//=====================================================
	public function theTitle(){
		$str = 'Thay doi tieu cua bai viet';
		return $str;
	}
}