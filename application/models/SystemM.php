<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SystemM extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Bangkok');
		$this->load->model('UserM', 'userm');
	}

	public function getHtml($body = '', $parameter = array()){
		$parameter['sessuser'] = $this->userm->getUserById($this->session->userdata("sessuser_id"));
		$parameter['memulvl1'] = $this->getUserMenuLvl1();
		foreach ($parameter['memulvl1'] as $l1) {
            $parameter['site_url'][$l1['menu_id']] = $l1['menu_controllers'];
            if($l1['menu_function']!=''){$parameter['site_url'][$l1['menu_id']] .= '/'.$l1['menu_function'];}
            if($l1['menu_p1']!=''){$parameter['site_url'][$l1['menu_id']] .= '/'.$l1['menu_p1'];}
            if($l1['menu_p2']!=''){$parameter['site_url'][$l1['menu_id']] .= '/'.$l1['menu_p2'];}
            if($l1['menu_p3']!=''){$parameter['site_url'][$l1['menu_id']] .= '/'.$l1['menu_p3'];}

            $parameter['memulvl2'][$l1['menu_id']] = $this->getUserMenuByRefid($l1['menu_id'],'0');
            foreach ($parameter['memulvl2'][$l1['menu_id']] as $l2) {
	            $parameter['site_url'][$l2['menu_id']] = $l2['menu_controllers'];
	            if($l2['menu_function']!=''){$parameter['site_url'][$l2['menu_id']] .= '/'.$l2['menu_function'];}
	            if($l2['menu_p1']!=''){$parameter['site_url'][$l2['menu_id']] .= '/'.$l2['menu_p1'];}
	            if($l2['menu_p2']!=''){$parameter['site_url'][$l2['menu_id']] .= '/'.$l2['menu_p2'];}
	            if($l2['menu_p3']!=''){$parameter['site_url'][$l2['menu_id']] .= '/'.$l2['menu_p3'];}

	            $parameter['memulvl3'][$l2['menu_id']] = $this->getUserMenuByRefid($l2['menu_id'],'0');
	            foreach ($parameter['memulvl3'][$l2['menu_id']] as $l3) {
		            $parameter['site_url'][$l3['menu_id']] = $l3['menu_controllers'];
		            if($l3['menu_function']!=''){$parameter['site_url'][$l3['menu_id']] .= '/'.$l3['menu_function'];}
		            if($l3['menu_p1']!=''){$parameter['site_url'][$l3['menu_id']] .= '/'.$l3['menu_p1'];}
		            if($l3['menu_p2']!=''){$parameter['site_url'][$l3['menu_id']] .= '/'.$l3['menu_p2'];}
		            if($l3['menu_p3']!=''){$parameter['site_url'][$l3['menu_id']] .= '/'.$l3['menu_p3'];}
	            }
            }
		}
		$this->load->view('head', $parameter);
		$this->load->view('navmenu', $parameter);
		$this->load->view($body, $parameter);
		$this->load->view('footer', $parameter);
	}

	public function getUserMenuLvl1(){
		if($this->session->userdata("sessuser_code")!='A'){
			$this->db->select('*');
			$this->db->from('tbl_permissions');
			$this->db->where('pm_system','backend');
			$this->db->where('user_id',$this->session->userdata("sessuser_id"));
			$rs=$this->db->get();
			$rr = $rs->result_array();
			if(isset($rr[0]['pm_privilege'])){
				$menu_id = explode(',',trim($rr[0]['pm_privilege']));
			}else{
				$menu_id = '';
			}
		}else{
			$menu_id = '';
		}

		$this->db->select('*');
		$this->db->from('tbl_menu');
		$this->db->where('menu_system','backend');
		$this->db->where('menu_level','1');
		$this->db->where('menu_st','0');
		if($menu_id!=''){$this->db->where_in('menu_id',$menu_id);}
		$this->db->order_by('menu_sort','ASC');
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getUserMenuByRefid($refid='',$menu_st=''){
		if($this->session->userdata("sessuser_code")!='A'){
			$this->db->select('*');
			$this->db->from('tbl_permissions');
			$this->db->where('pm_system','backend');
			$this->db->where('user_id',$this->session->userdata("sessuser_id"));
			$rs=$this->db->get();
			$rr = $rs->result_array();
			if(isset($rr[0]['pm_privilege'])){
				$menu_id = explode(',',trim($rr[0]['pm_privilege']));
			}else{
				$menu_id = '';
			}
		}else{
			$menu_id = '';
		}

		$this->db->select('*');
		$this->db->from('tbl_menu');
		$this->db->where('menu_system','backend');
		$this->db->where('menu_refid',$refid);
		if($menu_st!=''){$this->db->where('menu_st',$menu_st);}
		if($menu_id!=''){$this->db->where_in('menu_id',$menu_id);}
		$this->db->order_by('menu_sort','ASC');
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getActivePermission($msid='',$redirect=''){
		$pid = "";
		$go = "";
		//////////////////////////////Check Permission/////////////////////////////////
		if($this->session->userdata("sessuser_code")!='A'){
			$pid = $this->getCheckPermission($this->session->userdata("sessuser_id"),$msid);
			if($pid==''){
				$go = redirect($redirect,'refresh');
			}
		}
		//////////////////////////////Check Permission/////////////////////////////////
		return $go;
	}

	public function getMenuID($controllers="",$function="",$p1='',$p2='',$p3=''){
		$this->db->select('*');
		$this->db->from('tbl_menu');
		$this->db->where('menu_controllers',$controllers);
		$this->db->where('menu_function',$function);
		if($p1!=""){
			$this->db->where('menu_p1',$p1);
		} if($p2!=""){
			$this->db->where('menu_p2',$p2);
		} if($p3!=""){
			$this->db->where('menu_p3',$p3);
		}
		$this->db->where('menu_system','backend');
		$rs=$this->db->get();
		$menu_id = '';
		foreach($rs->result() as $rows){
			$menu_id = $rows->menu_id;
		}
		return $menu_id;
	}

	public function getCheckPermission($uid='',$msid=''){
		$menu = "";
		$id = "";
		$this->db->select('*');
		$this->db->from('tbl_permissions');
		$this->db->where('pm_system','backend');
		$this->db->where('user_id',$uid);
		$rs=$this->db->get();
		foreach($rs->result() as $r){
			$menu = explode(',',trim($r->pm_privilege));
			foreach ($menu as $value) {
				if($value==$msid){
					$id = $value;
				}
			}
		}
		return $id;
	}

	public function getPermission($controllers='',$function='',$p1='',$p2='',$p3=''){
		$pid = '';
		$go = 'false';
		if($this->session->userdata("sessuser_code")=='A'){
			$go = 'true';
		}else{
			$msid = $this->getMenuID($controllers,$function,$p1,$p2,$p3);
			$pid = $this->getCheckPermission($this->session->userdata("sessuser_id"),$msid);
			if($pid!=''){
				$go = 'true';
			}else{
				$go = 'false';
			}
		}
		return $go;
	}

	public function getPermissionByUserId($user_id='',$controllers='',$function='',$p1='',$p2='',$p3=''){
		$msid = $this->getMenuID($controllers,$function,$p1,$p2,$p3);
		$pid = $this->getCheckPermission($user_id,$msid);
		if($pid!=''){
			$go = 'true';
		}else{
			$go = 'false';
		}
		return $go;
	}

	public function getMenu(){
		$this->db->select('*');
		$this->db->from('tbl_menu');
		$this->db->where('menu_system','backend');
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getMenuByLvl($lvl=''){
		$this->db->select('*');
		$this->db->from('tbl_menu');
		$this->db->where('menu_system','backend');
		$this->db->where('menu_level',$lvl);
		$this->db->order_by('menu_sort','ASC');
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getMenuById($id=''){
		$this->db->select('*');
		$this->db->from('tbl_menu');
		$this->db->where('menu_id',$id);
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getMenuByRefId($refid=''){
		$this->db->select('*');
		$this->db->from('tbl_menu');
		$this->db->order_by('menu_sort','ASC');
		$this->db->where('menu_refid',$refid);
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getProvince(){
		$this->db->select('*');
		$this->db->from('tbl_province');
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getAmphurByProvinceId($id=''){
		$this->db->select('*');
		$this->db->from('tbl_amphur');
		if($id!=''){$this->db->where('province_id',$id);}
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getDistrictByAmphurId($id=''){
		$this->db->select('*');
		$this->db->from('tbl_district');
		if($id!=''){$this->db->where('amphur_id',$id);}
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getZipcodeByDistrictId($id=''){
		$this->db->select('*');
		$this->db->from('zipcodes');
		$this->db->join('tbl_district','tbl_district.district_code=zipcodes.district_code','left');
		if($id!=''){$this->db->WHERE('tbl_district.district_id',$id);}
		$rs=$this->db->get();
		return $rs->result_array();
	}
}
?>