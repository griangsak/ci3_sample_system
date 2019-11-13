<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Bangkok');
		$this->load->model('SystemM', 'systemm');
	}

	public function index()
	{
		//////////////////////////////Check Permission/////////////////////////////////
		$data['controllers']='dashboard';$data['function']='';$data['p1']='';$data['p2']='';$data['p3']='';
		//////////////////////////////Check Permission/////////////////////////////////
		if($this->session->userdata("sessuser_id")==''){
			redirect('systems/login','refresh');
  			exit();
		}else{
			$data['title'] = 'Dashboard';
			$data['css'] = '';
			$data['js'] = '<script type="text/javascript" src="'.site_url().'assets/js/plugins/visualization/d3/d3.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/forms/styling/switchery.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/forms/styling/uniform.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/ui/moment/moment.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/pickers/daterangepicker.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/pages/dashboard.js"></script>';
			$this->systemm->getHtml('dashboard/index', $data);
		}
	}

	public function errors404()
	{
		//////////////////////////////Check Permission/////////////////////////////////
		$data['controllers']='';$data['function']='';$data['p1']='';$data['p2']='';$data['p3']='';
		//////////////////////////////Check Permission/////////////////////////////////
		$data['title'] = 'Errors 404';
		$data['css'] = '';
		$data['js'] = '';
		$this->systemm->getHtml('dashboard/error_404', $data);
	}
}
