<?php
class My404 extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();	
	}

	public function index()
	{
		$this->output->set_status_header('404');
		$data['content'] = 'error_404'; // View name
		$data ='';
      	//echo "sdfsdfgsdfg sfd";
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title(WEBSITE_NAME.' - 404 Page Not Found')
			->build('page-not-found', $data);
	}
}