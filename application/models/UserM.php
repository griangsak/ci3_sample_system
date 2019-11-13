<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserM extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Bangkok');
	}

	public function getUserById($id='')
	{
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->join('tbl_personal','tbl_personal.per_id=tbl_user.per_id','left');
		$this->db->join('tbl_usertype','tbl_usertype.usertype_id=tbl_user.usertype_id','left');
		$this->db->join('tbl_province','tbl_province.province_id=tbl_personal.province_id','left');
		$this->db->join('tbl_amphur','tbl_amphur.amphur_id=tbl_personal.amphur_id','left');
		$this->db->join('tbl_district','tbl_district.district_id=tbl_personal.district_id','left');
		$this->db->WHERE('tbl_user.user_id',$id);
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getUser()
	{
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->join('tbl_personal','tbl_personal.per_id=tbl_user.per_id','left');
		$this->db->join('tbl_usertype','tbl_usertype.usertype_id=tbl_user.usertype_id','left');
		$this->db->WHERE('tbl_user.user_status','0');
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getUserType()
	{
		$this->db->select('*');
		$this->db->from('tbl_usertype');
		$this->db->WHERE('usertype_type','E');
		$rs=$this->db->get();
		return $rs->result_array();
	}

	public function getPerByUserId($user_id=''){
		$this->db->select('*');
		$this->db->from('tbl_permissions');
		if($user_id!=''){$this->db->where('user_id',$user_id);}
		$rs=$this->db->get();
		return $rs->result_array();
	}
}
?>