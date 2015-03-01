<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper{

	public $constants;
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function showError($message, $errorMsg=null)
	{
		$status['code'] = ERROR_CODE;
		$status['message'] = $message;
		$status['errorMsg'] = $errorMsg;
		return json_encode($status);
	}

	public function showSuccess( $message, $data=NULL )
	{
		$status['code'] = SUCCESS_CODE;
		$status['message'] = $message;
		$status['data'] = $data;
		return json_encode($status);
	}

	public function _render_page($view, $data=null, $render=false)
	{
		$view_html = array( 
			$this->CI->load->view('base/header', $data, $render),
			$this->CI->load->view('menu/sidebar', $data, $render),
			$this->CI->load->view($view, $data, $render),
			$this->CI->load->view('base/footer', $data, $render)
			);
		if (!$render) return $view_html;
	}
}

?>