<?php
class Route extends CI_Controller{

	function Route(){
		parent::__construct();
		$this->load->database();
		$this->load->model('location_model');
		$this->load->model('organization_model');
		$this->load->model('route_model');
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		header('Access-Control-Allow-Origin: *');
	}

	function add()

	{

		$user=$this->session->userdata('user');

		if(isset($user['int_user_id']) && $user['int_user_id']!='')

		{

			$data["page"]="add_route";
			$data["locations"]=$this->location_model->get_org_locations($user['int_organization_id']);
			$this->load->view('page',$data);	

		}

		else

		{

			$this->load->view('login');	

		}

	}
	
	function add_admin()

	{

		$user=$this->session->userdata('user');

		if(isset($user['int_user_id']) && $user['int_user_id']!='')

		{

			$data["page"]="add_route_admin";
			$data["organizations"]=$this->organization_model->get_all_organizations();
			$this->load->view('page',$data);	

		}

		else

		{

			$this->load->view('login');	

		}

	}
	
	function save_admin()

	{

		$data=$this->input->post();

		$user=$this->session->userdata('user');
		
		$data['user']=$user['int_user_id'];
		$status=$this->route_model->save($data);

		redirect('route/route_list_admin', 'refresh');

	}



	function save()

	{

		$data=$this->input->post();

		$user=$this->session->userdata('user');
		
		$data['user']=$user['int_user_id'];
		$data['org_id']=$user['int_organization_id'];
		$status=$this->route_model->save($data);

		redirect('route/route_list', 'refresh');

	}

	

	function route_list()

	{

		$user=$this->session->userdata('user');

		if(isset($user['int_user_id']) && $user['int_user_id']!='')

		{

			$data["page"]="route_list";

			$data["routes"]=$this->route_model->get_org_routes($user['int_organization_id']);
			$this->load->view('page',$data);	

		}

		else

		{

			$this->load->view('login');	

		}	

	}
	
	function route_list_admin()
	{
		$user=$this->session->userdata('user');
		$data=$this->input->post();
		if(isset($user['int_user_id']) && $user['int_user_id']!='')

		{
			if(isset($data['org_id']))
			{
				$data1["page"]="route_list_admin";
				$data1["routes"]=$this->route_model->get_org_routes($data['org_id']);
				$data1["organizations"]=$this->organization_model->get_all_organizations();
				$data1["org_id"]=$data['org_id'];
			}
			else
			{
				$data1["page"]="route_list_admin";
				$data1["routes"]=array();
				$data1["organizations"]=$this->organization_model->get_all_organizations();
				$data1["org_id"]=NULL;
			}

			$this->load->view('page',$data1);	

		}

		else

		{

			$this->load->view('login');	

		}
	}



	function delete()

	{

		$data=$this->input->get();

		$this->route_model->delete_route($data['id']);

		redirect('route/route_list', 'refresh');

	}
}
?>