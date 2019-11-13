<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Systems extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Bangkok');
		$this->load->model('SystemM', 'systemm');
		$this->load->model('UserM', 'userm');
	}

	public function login(){
		if($this->session->userdata("sessuser_id")==''){
			if($this->input->post('btnlogin')!=''){
				$username = $this->input->post("user_name");
				$password = md5($this->input->post("user_password"));

				$sql = "SELECT * FROM tbl_user 
					LEFT JOIN tbl_usertype ON (tbl_usertype.usertype_id = tbl_user.usertype_id)
					WHERE user_name = '$username' and user_password = '$password' and usertype_type = 'E'";
				$query = $this->db->query($sql);
				$numrows = $query->num_rows();

				if($numrows==0){
					$alert='<div class="row" id="alertincorrect">
	                  	<div class="col-md-12">
	                    	<div class="alert alert-danger" role="alert">
		          				<span class="mdi mdi-exclamation" aria-hidden="true"></span>Error : Username หรือ Password ผ่านของคุณไม่ถูกต้อง
	                    	</div>
	                  	</div>
	                </div>';
					$this->session->set_flashdata('alert',$alert);
					redirect('systems/login','refresh');
				}else{
					foreach($query->result() as $r){
						//////////////////////////////Check Permission/////////////////////////////////
						$controllers="systems";$function="login";$p1='';$p2='';$p3='';
						$msid = $this->systemm->getMenuID($controllers,$function,$p1,$p2,$p3);
						$pid = $this->systemm->getCheckPermission($r->user_id,$msid);
						//////////////////////////////Check Permission/////////////////////////////////
						if($r->usertype_code=="A"){
							$user_id = $r->user_id;
							$user_code = $r->usertype_code;
							$user_type = $r->usertype_type;
							$arr=array(
								"sessuser_id"=>$user_id,
								"sessuser_code"=>$user_code,
								"sessuser_type"=>$user_type
							);
							$this->session->set_userdata($arr);
							redirect('dashboard','refresh');
							die();
						}else{
							if($pid==""){
								$alert='<div class="row" id="alertincorrect">
									<div class="col-md-12">
										<div class="alert alert-danger" role="alert">
							          		<span class="mdi mdi-exclamation" aria-hidden="true"></span> การเข้าสู่ระบบไม่สำเร็จ:
											ชื่อผู้ใช้งานระบบนี้ถูกระงับการใช้งาน กรุณาติดต่อผู้ดูแลระบบ
										</div>
									</div>
								</div>';
								$this->session->set_flashdata('alert',$alert);
								redirect('systems/login','refresh');
								exit();
							}else{
								$user_id = $r->user_id;
								$user_code = $r->usertype_code;
								$user_type = $r->usertype_type;
								$arr=array(
									"sessuser_id"=>$user_id,
									"sessuser_code"=>$user_code,
									"sessuser_type"=>$user_type
								);
								$this->session->set_userdata($arr);
								redirect('dashboard','refresh');
								die();
							}
						}
						//////////////////////////////Check Permission/////////////////////////////////
					}
				}
			}
			$this->load->view('systems/login');
		}else{
			redirect('dashboard','refresh');
			exit();
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('systems/login','refresh');
		exit();
	}

	public function menu($menu='',$id=''){
		if($menu=='show'){
			//////////////////////////////Check Permission/////////////////////////////////
			$data['controllers']='systems';$data['function']='menu';$data['p1']='show';$data['p2']='';$data['p3']='';
			$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
			$redirect = "dashboard";
			$this->systemm->getActivePermission($msid,$redirect);
			//////////////////////////////Check Permission/////////////////////////////////
			$data['title'] = 'Menu';
			$data['css'] = '';
			$data['js'] = '<script type="text/javascript" src="'.site_url().'assets/js/plugins/tables/datatables/datatables.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/notifications/sweet_alert.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/notifications/bootbox.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/forms/styling/uniform.min.js"></script>';
			$data['menuies'] = $this->systemm->getMenu();
			$data['peradd'] = $this->systemm->getPermission($data['controllers'],$data['function'],'add','','');
			$data['peredit'] = $this->systemm->getPermission($data['controllers'],$data['function'],'edit','','');
			$data['perremove'] = $this->systemm->getPermission($data['controllers'],$data['function'],'remove','','');
			$this->systemm->getHtml('systems/menu', $data);
		}else if($menu=='add'){
			//////////////////////////////Check Permission/////////////////////////////////
			$data['controllers']='systems';$data['function']='menu';$data['p1']='add';$data['p2']='';$data['p3']='';
			$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
			$redirect = "dashboard";
			$this->systemm->getActivePermission($msid,$redirect);
			//////////////////////////////Check Permission/////////////////////////////////
			if($this->input->post('btnsaveadd')!=''){
				$arr = array(
					"menu_code"=>$this->input->post('menu_code'),
					"menu_name"=>$this->input->post('menu_name'),
					"menu_level"=>$this->input->post('menu_level'),
					"menu_controllers"=>$this->input->post('menu_controllers'),
					"menu_function"=>$this->input->post('menu_function'),
					"menu_p1"=>$this->input->post('menu_p1'),
					"menu_p2"=>$this->input->post('menu_p2'),
					"menu_p3"=>$this->input->post('menu_p3'),
					"menu_refid"=>$this->input->post('menu_refid'),
					"menu_sort"=>$this->input->post('menu_sort'),
					"menu_st"=>$this->input->post('menu_st'),
					"menu_system"=>'backend'
				);
				$this->db->insert('tbl_menu',$arr);
				$alert='<div class="row" id="alertincorrect">
					<div class="col-md-12">
						<div class="alert alert-success" role="alert">
			          		<i class="icon-checkbox-checked"></i> Add new menu success
						</div>
					</div>
				</div>';
				$this->session->set_flashdata('alert',$alert);
				redirect('systems/menu/show','refresh');
				exit();
			}else{
				redirect('systems/menu/show','refresh');
				exit();
			}
		}else if($menu=='edit'){
			//////////////////////////////Check Permission/////////////////////////////////
			$data['controllers']='systems';$data['function']='menu';$data['p1']='edit';$data['p2']='';$data['p3']='';
			$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
			$redirect = "dashboard";
			$this->systemm->getActivePermission($msid,$redirect);
			//////////////////////////////Check Permission/////////////////////////////////
			if($this->input->post('btnsave'.$id)!=''){
				$arr = array(
					"menu_code"=>$this->input->post('menu_code'),
					"menu_name"=>$this->input->post('menu_name'),
					"menu_level"=>$this->input->post('menu_level'),
					"menu_controllers"=>$this->input->post('menu_controllers'),
					"menu_function"=>$this->input->post('menu_function'),
					"menu_p1"=>$this->input->post('menu_p1'),
					"menu_p2"=>$this->input->post('menu_p2'),
					"menu_p3"=>$this->input->post('menu_p3'),
					"menu_refid"=>$this->input->post('menu_refid'),
					"menu_sort"=>$this->input->post('menu_sort'),
					"menu_st"=>$this->input->post('menu_st'),
					"menu_system"=>'backend'
				);
				$this->db->where('menu_id',$id)->update('tbl_menu',$arr);
				$alert='<div class="row" id="alertincorrect">
					<div class="col-md-12">
						<div class="alert alert-success" role="alert">
			          		<i class="icon-checkbox-checked"></i> Edit menu success
						</div>
					</div>
				</div>';
				$this->session->set_flashdata('alert',$alert);
				redirect('systems/menu/show','refresh');
				exit();
			}else{
				redirect('systems/menu/show','refresh');
				exit();
			}
		}else if($menu=='remove'){
			//////////////////////////////Check Permission/////////////////////////////////
			$data['controllers']='systems';$data['function']='menu';$data['p1']='remove';$data['p2']='';$data['p3']='';
			$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
			$redirect = "dashboard";
			$this->systemm->getActivePermission($msid,$redirect);
			//////////////////////////////Check Permission/////////////////////////////////
			$this->db->delete('tbl_menu',array('menu_id'=>$id));
			$alert='<div class="row" id="alertincorrect">
				<div class="col-md-12">
					<div class="alert alert-success" role="alert">
		          		<i class="icon-checkbox-checked"></i> Remove menu success
					</div>
				</div>
			</div>';
			$this->session->set_flashdata('alert',$alert);
			redirect('systems/menu/show','refresh');
			exit();
		}else{
			redirect('dashboard','refresh');
			exit();
		}
	}

	public function getMenuByLvl(){
		//////////////////////////////Check Permission/////////////////////////////////
		$data['controllers']='systems';$data['function']='menu';$data['p1']='show';$data['p2']='';$data['p3']='';
		$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
		$redirect = "dashboard";
		$this->systemm->getActivePermission($msid,$redirect);
		//////////////////////////////Check Permission/////////////////////////////////
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$menu_level = isset($_GET['menu_level']) ? ($_GET['menu_level'] - 1) : '';
		$menu = $this->systemm->getMenuByLvl($menu_level);
		if($menu_level>0){
			$data = '<label>Parent Menu <span class="text-danger">*</span></label>
			<select class="select" name="menu_refid" id="menu_refid_'.$id.'" required>';
				$data .= '<option value="">---- Please choose parent menu ----</option>';
				foreach ($menu as $mn) {
					$data .= '<option value="'.$mn['menu_id'].'">'.$mn['menu_name'].'</option>';
				}
			$data .= '</select>';
		}else{
			$data = '<label>Parent Menu</label>
			<select class="select" name="menu_refid" id="menu_refid_'.$id.'">
				<option value="">---- No need to have parent menu ----</option>
			</select>';
		}
		echo json_encode(array($data));
	}

	public function getEditMenu(){
		//////////////////////////////Check Permission/////////////////////////////////
		$data['controllers']='systems';$data['function']='menu';$data['p1']='edit';$data['p2']='';$data['p3']='';
		$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
		$redirect = "dashboard";
		$this->systemm->getActivePermission($msid,$redirect);
		//////////////////////////////Check Permission/////////////////////////////////
		$menu_id = isset($_GET['menu_id']) ? $_GET['menu_id'] : '';
		$mn = $this->systemm->getMenuById($menu_id);
		$attrib = array(
			'name' => 'menu_form_'.$menu_id, 
			'id' => 'menu_form_'.$menu_id,
			'class'=>'form-horizontal form-validate-jquery'
		);
		$data = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h5 class="modal-title">Edit Menu</h5>
		</div>

		<div class="modal-body">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Menu info<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
				</div>

				<div class="panel-body">

        			'.form_open_multipart('systems/menu/edit/'.$menu_id, $attrib).'

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Icon Menu</label>
									<input type="text" class="form-control" name="menu_code" id="menu_code_'.$menu_id.'" value="'.$mn[0]['menu_code'].'">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="menu_name" id="menu_name_'.$menu_id.'" value="'.$mn[0]['menu_name'].'">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="display-block">Level <span class="text-danger">*</span></label>

									<label class="radio-inline">
										<input type="radio" class="styled" name="menu_level" id="menu_level_'.$menu_id.'_1" onclick="getRefId(1, '.$menu_id.')" value="1"';if($mn[0]['menu_level']==1){$data .= ' checked';}$data .= '>
										1
									</label>

									<label class="radio-inline">
										<input type="radio" class="styled" name="menu_level" id="menu_level_'.$menu_id.'_2" onclick="getRefId(2, '.$menu_id.')" value="2"';if($mn[0]['menu_level']==2){$data .= ' checked';}$data .= '>
										2
									</label>

									<label class="radio-inline">
										<input type="radio" class="styled" name="menu_level" id="menu_level_'.$menu_id.'_3" onclick="getRefId(3, '.$menu_id.')" value="3"';if($mn[0]['menu_level']==3){$data .= ' checked';}$data .= '>
										3
									</label>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group" id="_menu_refid_'.$menu_id.'">';
									if($mn[0]['menu_level']>1){
										$menu = $this->systemm->getMenuByLvl(($mn[0]['menu_level']-1));
										$data .= '<label>Parent Menu <span class="text-danger">*</span></label>
										<select class="select" name="menu_refid" id="menu_refid_'.$menu_id.'" required>';
											$data .= '<option value="">---- Please choose parent menu ----</option>';
											foreach ($menu as $m) {
												$data .= '<option value="'.$m['menu_id'].'"';if($m['menu_id']==$mn[0]['menu_refid']){$data .= ' selected';}$data .= '>'.$m['menu_name'].'</option>';
											}
										$data .= '</select>';
									}else{
										$data .= '<label>Parent Menu</label>
										<select class="select" name="menu_refid" id="menu_refid_'.$menu_id.'">
											<option value="">---- No need to have parent menu ----</option>
										</select>';
									}
								$data .= '</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Sort <span class="text-danger">*</span></label>
									<input type="number" class="form-control" name="menu_sort" id="menu_sort_'.$menu_id.'" min="0" value="'.$mn[0]['menu_sort'].'">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Controllers <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="menu_controllers" id="menu_controllers_'.$menu_id.'" value="'.$mn[0]['menu_controllers'].'">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Function</label>
									<input type="text" class="form-control" name="menu_function" id="menu_function_'.$menu_id.'" value="'.$mn[0]['menu_function'].'">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Parameter 1</label>
									<input type="text" class="form-control" name="menu_p1" id="menu_p1_'.$menu_id.'" value="'.$mn[0]['menu_p1'].'">
								</div>
							</div>
							
							<div class="col-lg-6">
								<div class="form-group">
									<label>Parameter 2</label>
									<input type="text" class="form-control" name="menu_p2" id="menu_p2_'.$menu_id.'" value="'.$mn[0]['menu_p2'].'">
								</div>
							</div>
							
							<div class="col-lg-6">
								<div class="form-group">
									<label>Parameter 3</label>
									<input type="text" class="form-control" name="menu_p3" id="menu_p3_'.$menu_id.'" value="'.$mn[0]['menu_p3'].'">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label class="display-block">Nav menu status <span class="text-danger">*</span></label>

									<label class="radio-inline">
										<input type="radio" class="styled" name="menu_st" id="menu_st_'.$menu_id.'_1" value="0"';if($mn[0]['menu_st']==0){$data .= ' checked';}$data .= '>
										Show
									</label>

									<label class="radio-inline">
										<input type="radio" class="styled" name="menu_st" id="menu_st_'.$menu_id.'_2" value="1"';if($mn[0]['menu_st']==1){$data .= ' checked';}$data .= '>
										Hide
									</label>
								</div>
							</div>
						</div>

						<div class="text-right">
							<input type="hidden" name="btnsave'.$menu_id.'" id="btnsave'.$menu_id.'" value="save">
							<button type="submit" class="btn btn-primary">Submit form <i class="icon-arrow-right14 position-right"></i></button>
						</div>
					'.form_close().'
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
		</div>';
		echo json_encode(array($data));
	}

	public function users($menu='',$id=''){
		if($menu=='show'){
			//////////////////////////////Check Permission/////////////////////////////////
			$data['controllers']='systems';$data['function']='users';$data['p1']='show';$data['p2']='';$data['p3']='';
			$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
			$redirect = "dashboard";
			$this->systemm->getActivePermission($msid,$redirect);
			//////////////////////////////Check Permission/////////////////////////////////
			$data['title'] = 'Users';
			$data['css'] = '';
			$data['js'] = '<script type="text/javascript" src="'.site_url().'assets/js/plugins/tables/datatables/datatables.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/notifications/sweet_alert.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/notifications/bootbox.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/forms/styling/uniform.min.js"></script>';
			$data['users'] = $this->userm->getUser();
			$data['user_type'] = $this->userm->getUserType();
			$data['peradd'] = $this->systemm->getPermission($data['controllers'],$data['function'],'add','','');
			$data['peredit'] = $this->systemm->getPermission($data['controllers'],$data['function'],'edit','','');
			$data['perremove'] = $this->systemm->getPermission($data['controllers'],$data['function'],'remove','','');
			$data['pereditper'] = $this->systemm->getPermission($data['controllers'],$data['function'],'editper','','');
			$this->systemm->getHtml('systems/users', $data);
		}else if($menu=='add'){
			//////////////////////////////Check Permission/////////////////////////////////
			$data['controllers']='systems';$data['function']='users';$data['p1']='add';$data['p2']='';$data['p3']='';
			$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
			$redirect = "dashboard";
			$this->systemm->getActivePermission($msid,$redirect);
			//////////////////////////////Check Permission/////////////////////////////////
			if($this->input->post('btnsaveadd')!=''){
	            if (isset($_FILES['per_picture']['name']) && !empty($_FILES['per_picture']['name'])) {
		    		$config['upload_path']			= './assets/images/users';
		            $config['allowed_types']		= 'gif|jpg|png';
		            $config['encrypt_name']			= true;
		            $config['overwrite']			= true;
		            $this->load->library('upload', $config, 'upload_user');
		            if (!$this->upload_user->do_upload('per_picture')){
		        		$filename = $this->input->post('perpicture');
		            }else{
		                $data_file = array('upload_data' => $this->upload_user->data());
		                $filename = $data_file['upload_data']['file_name'];
		            }
		        }else{
		        	$filename = $this->input->post('perpicture');
	        	}
				$per = array(
					"per_name"=>$this->input->post('per_name'),
					"per_surname"=>$this->input->post('per_surname'),
					"per_email"=>$this->input->post('per_email'),
					"per_picture"=>$filename,
					"per_status"=>'0'
				);
				$this->db->insert('tbl_personal',$per);
				$per_id = $this->db->insert_id();

				$user = array(
					"user_name"=>$this->input->post('user_name'),
					"user_password"=>md5($this->input->post('user_password')),
					"per_id"=>$per_id,
					"usertype_id"=>$this->input->post('usertype_id'),
					"user_status"=>'0'
				);
				$this->db->insert('tbl_user',$user);
				$alert='<div class="row" id="alertincorrect">
					<div class="col-md-12">
						<div class="alert alert-success" role="alert">
			          		<i class="icon-checkbox-checked"></i> Add new users success
						</div>
					</div>
				</div>';
				$this->session->set_flashdata('alert',$alert);
				redirect('systems/users/show','refresh');
				exit();
			}else{
				redirect('systems/users/show','refresh');
				exit();
			}
		}else if($menu=='edit'){
			//////////////////////////////Check Permission/////////////////////////////////
			$data['controllers']='systems';$data['function']='users';$data['p1']='edit';$data['p2']='';$data['p3']='';
			$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
			$redirect = "dashboard";
			$this->systemm->getActivePermission($msid,$redirect);
			//////////////////////////////Check Permission/////////////////////////////////
			if($this->input->post('btnsave'.$id)!=''){
				$us = $this->userm->getUserById($id);
	            if (isset($_FILES['per_picture']['name']) && !empty($_FILES['per_picture']['name'])) {
		    		$config['upload_path']			= './assets/images/users';
		            $config['allowed_types']		= 'gif|jpg|png';
		            $config['encrypt_name']			= true;
		            $config['overwrite']			= true;
		            $this->load->library('upload', $config, 'upload_user');
		            if (!$this->upload_user->do_upload('per_picture')){
		        		$filename = $this->input->post('perpicture');
		            }else{
		                $data_file = array('upload_data' => $this->upload_user->data());
		                $filename = $data_file['upload_data']['file_name'];
		            }
		        }else{
		        	$filename = $this->input->post('perpicture');
	        	}
				$per = array(
					"per_name"=>$this->input->post('per_name'),
					"per_surname"=>$this->input->post('per_surname'),
					"per_email"=>$this->input->post('per_email'),
					"per_picture"=>$filename
				);
				$this->db->where('per_id',$us[0]['per_id'])->update('tbl_personal',$per);

				if($this->input->post('user_password')==$us[0]['user_password']){
					$user_password = $this->input->post('user_password');
				}else{
					$user_password = md5($this->input->post('user_password'));
				}

				$user = array(
					"user_name"=>$this->input->post('user_name'),
					"user_password"=>$user_password,
					"usertype_id"=>$this->input->post('usertype_id')
				);
				$this->db->where('user_id',$id)->update('tbl_user',$user);

				$alert='<div class="row" id="alertincorrect">
					<div class="col-md-12">
						<div class="alert alert-success" role="alert">
			          		<i class="icon-checkbox-checked"></i> Edit users success
						</div>
					</div>
				</div>';
				$this->session->set_flashdata('alert',$alert);
				redirect('systems/users/show','refresh');
				exit();
			}else{
				redirect('systems/users/show','refresh');
				exit();
			}
		}else if($menu=='remove'){
			//////////////////////////////Check Permission/////////////////////////////////
			$data['controllers']='systems';$data['function']='users';$data['p1']='remove';$data['p2']='';$data['p3']='';
			$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
			$redirect = "dashboard";
			$this->systemm->getActivePermission($msid,$redirect);
			//////////////////////////////Check Permission/////////////////////////////////
			$this->db->where('user_id',$id)->update('tbl_user',array('user_status'=>1));
			$alert='<div class="row" id="alertincorrect">
				<div class="col-md-12">
					<div class="alert alert-success" role="alert">
		          		<i class="icon-checkbox-checked"></i> Remove users success
					</div>
				</div>
			</div>';
			$this->session->set_flashdata('alert',$alert);
			redirect('systems/users/show','refresh');
			exit();
		}else if($menu=='editper'){
			//////////////////////////////Check Permission/////////////////////////////////
			$data['controllers']='systems';$data['function']='users';$data['p1']='editper';$data['p2']='';$data['p3']='';
			$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
			$redirect = "dashboard";
			$this->systemm->getActivePermission($msid,$redirect);
			//////////////////////////////Check Permission/////////////////////////////////
			if($this->input->post('btnsave'.$id)!=''){
				$us = $this->userm->getUserById($id);
				$per = $this->userm->getPerByUserId($id);
				$pm_id = isset($per[0]['pm_id']) ? $per[0]['pm_id'] : '';
				$arr = array(
					'user_id'=>$id,
					'pm_privilege'=>implode(',', $this->input->post('menu_id')),
					'pm_system'=>'backend'
				);
				if($pm_id!=''){
					$this->db->where('pm_id',$pm_id)->update('tbl_permissions',$arr);
				}else{
					$this->db->insert('tbl_permissions',$arr);
				}
				$alert='<div class="row" id="alertincorrect">
					<div class="col-md-12">
						<div class="alert alert-success" role="alert">
			          		<i class="icon-checkbox-checked"></i> Edit permission user success
						</div>
					</div>
				</div>';
				$this->session->set_flashdata('alert',$alert);
				redirect('systems/users/show','refresh');
				exit();
			}else{
				redirect('systems/users/show','refresh');
				exit();
			}
		}else{
			redirect('dashboard','refresh');
			exit();
		}
	}

	public function getEditUser(){
		//////////////////////////////Check Permission/////////////////////////////////
		$data['controllers']='systems';$data['function']='users';$data['p1']='edit';$data['p2']='';$data['p3']='';
		$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
		$redirect = "dashboard";
		$this->systemm->getActivePermission($msid,$redirect);
		//////////////////////////////Check Permission/////////////////////////////////
		$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
		$us = $this->userm->getUserById($user_id);
		$user_type = $this->userm->getUserType();
		$attrib = array(
			'name' => 'user_form_'.$user_id, 
			'id' => 'user_form_'.$user_id,
			'class'=>'form-horizontal form-validate-jquery'
		);
		$data = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h5 class="modal-title">Edit User</h5>
		</div>

		<div class="modal-body">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">User info<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
				</div>

				<div class="panel-body">

        			'.form_open_multipart('systems/users/edit/'.$user_id, $attrib).'

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>User Type <span class="text-danger">*</span></label>
									<select class="select" name="usertype_id" id="usertype_id">
										<option value="">---- Please choose user type ----</option>';
										foreach($user_type as $ut){
											$data .= '<option value="'.$ut['usertype_id'].'"';if($ut['usertype_id']==$us[0]['usertype_id']){$data .= ' selected';}$data .= '>'.$ut['usertype_name'].'</option>';
										}
									$data .= '</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>User Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="user_name" id="user_name" value="'.$us[0]['user_name'].'">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Password <span class="text-danger">*</span></label>
									<input type="password" class="form-control" name="user_password" id="user_password" value="'.$us[0]['user_password'].'">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Confirm Password <span class="text-danger">*</span></label>
									<input type="password" class="form-control" name="confirm_password" id="confirm_password" value="'.$us[0]['user_password'].'">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="per_name" id="per_name" value="'.$us[0]['per_name'].'">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Surname <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="per_surname" id="per_surname" value="'.$us[0]['per_surname'].'">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Email <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="per_email" id="per_email" value="'.$us[0]['per_email'].'">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
			                        <div id="_delimg_'.$user_id.'">';
			                        	if($us[0]['per_picture']!=''){
			                        		$data .= '<img src="'.base_url('assets/images/users/'.$us[0]['per_picture']).'" alt="your image" width="25%">
				                        	<button type="button" onclick="_delimg(`'.$user_id.'`)" class="btn btn-link btn-xs"><i class="icon-trash"></i></button>
				                        	<input type="hidden" name="perpicture" value="'.$us[0]['per_picture'].'">';
			                        	}else{
			                        		$data .= '
				                        	<input type="hidden" name="perpicture">';
			                        	}
			                        $data .= '</div>
									<label>User Picture</label>
			                        <div id="_per_picture_'.$user_id.'">
			                            <input type="file" name="per_picture" id="per_picture_'.$user_id.'" onchange="readURL(this, `'.$user_id.'`)" class="form-control" accept=".png, .jpg, .jpeg" />
			                        </div>
								</div>
							</div>
						</div>

						<div class="text-right">
							<input type="hidden" name="btnsave'.$user_id.'" id="btnsave'.$user_id.'" value="save">
							<button type="submit" class="btn btn-primary">Submit form <i class="icon-arrow-right14 position-right"></i></button>
						</div>
					'.form_close().'
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
		</div>';
		echo json_encode(array($data));
	}

	public function getEditPermission(){
		//////////////////////////////Check Permission/////////////////////////////////
		$data['controllers']='systems';$data['function']='users';$data['p1']='editper';$data['p2']='';$data['p3']='';
		$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
		$redirect = "dashboard";
		$this->systemm->getActivePermission($msid,$redirect);
		//////////////////////////////Check Permission/////////////////////////////////
		$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
		$us = $this->userm->getUserById($user_id);
		$menu1 = $this->systemm->getMenuByLvl(1);
		$attrib = array(
			'name' => 'user_form_'.$user_id, 
			'id' => 'user_form_'.$user_id,
			'class'=>'form-horizontal form-validate-jquery'
		);
		$data = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h5 class="modal-title">Edit permission of user : '.$us[0]['user_name'].'</h5>
		</div>

		<div class="modal-body">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Permission<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
				</div>

				<div class="panel-body">

        			'.form_open_multipart('systems/users/editper/'.$user_id, $attrib).'

						<div class="form-group">
							<div class="row">';

								foreach ($menu1 as $mn1) {
									$menu2 = $this->systemm->getMenuByRefId($mn1['menu_id']);
									$check1 = $this->systemm->getPermissionByUserId(
										$us[0]['user_id'],
										$mn1['menu_controllers'],
										$mn1['menu_function'],
										$mn1['menu_p1'],
										$mn1['menu_p2'],
										$mn1['menu_p3']
									);
									if($check1=='true'){$true1 = ' checked="checked"';}else{$true1 = '';}
									$data .= '<div class="col-md-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="control-warning" name="menu_id[]" value="'.$mn1['menu_id'].'"'.$true1.'>
												'.$mn1['menu_name'].'
											</label>
										</div>
										<ol>';
											foreach ($menu2 as $mn2) {
												$menu3 = $this->systemm->getMenuByRefId($mn2['menu_id']);
												$check2 = $this->systemm->getPermissionByUserId(
													$us[0]['user_id'],
													$mn2['menu_controllers'],
													$mn2['menu_function'],
													$mn2['menu_p1'],
													$mn2['menu_p2'],
													$mn2['menu_p3']
												);
												if($check2=='true'){$true2 = ' checked="checked"';}else{$true2 = '';}
												$data .= '<div class="checkbox">
													<label>
														<input type="checkbox" class="control-primary" name="menu_id[]" value="'.$mn2['menu_id'].'"'.$true2.'>
														'.$mn2['menu_name'].'
													</label>
												</div>
												<ol>';
													foreach ($menu3 as $mn3) {
														$check3 = $this->systemm->getPermissionByUserId(
															$us[0]['user_id'],
															$mn3['menu_controllers'],
															$mn3['menu_function'],
															$mn3['menu_p1'],
															$mn3['menu_p2'],
															$mn3['menu_p3']
														);
														if($check3=='true'){$true3 = ' checked="checked"';}else{$true3 = '';}
														$data .= '<div class="checkbox">
															<label>
																<input type="checkbox" class="control-success" name="menu_id[]" value="'.$mn3['menu_id'].'"'.$true3.'>
																'.$mn3['menu_name'].'
															</label>
														</div>';
													}
												$data .= '</ol>';
											}
										$data .= '</ol>
									</div>';
								}

							$data .= '</div>
						</div>

						<div class="text-right">
							<input type="hidden" name="btnsave'.$user_id.'" id="btnsave'.$user_id.'" value="save">
							<button type="submit" class="btn btn-primary">Submit form <i class="icon-arrow-right14 position-right"></i></button>
						</div>
					'.form_close().'
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
		</div>';
		echo json_encode(array($data));
	}

	public function getDetailUser(){
		//////////////////////////////Check Permission/////////////////////////////////
		$data['controllers']='systems';$data['function']='users';$data['p1']='show';$data['p2']='';$data['p3']='';
		$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
		$redirect = "dashboard";
		$this->systemm->getActivePermission($msid,$redirect);
		//////////////////////////////Check Permission/////////////////////////////////
		$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
		$us = $this->userm->getUserById($user_id);
		$attrib = array(
			'name' => 'user_form_'.$user_id, 
			'id' => 'user_form_'.$user_id,
			'class'=>'form-horizontal form-validate-jquery'
		);
		$data = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h5 class="modal-title">Edit User</h5>
		</div>

		<div class="modal-body">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">User info<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
				</div>

				<div class="panel-body">

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Name</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['per_name'].'">
							</div>
							<div class="col-md-6">
								<label>Surename</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['per_surname'].'">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Identity card</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['per_code'].'">
							</div>
							<div class="col-md-6">
								<label>Identity card expired</label>
								<input type="date" readonly class="form-control" value="'.$us[0]['per_code_expired'].'">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Birthdate</label>
								<input type="date" readonly class="form-control" value="'.$us[0]['per_birthdate'].'">
							</div>
							<div class="col-md-6">
								<label class="display-block">Sex</label>';
								if($us[0]['per_sex']=='M'){
									$per_sex ='Male';
								}else{
									$per_sex ='Female';
								}
								$data .='<input type="text" readonly class="form-control" value="'.$per_sex.'">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Address</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['per_address'].'">
							</div>
							<div class="col-md-6">
								<label>Province</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['province_name'].'">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<label>Amphur</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['amphur_name'].'">
							</div>
							<div class="col-md-4">
								<label>District</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['district_name'].'">
							</div>
							<div class="col-md-4">
								<label>ZIP code</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['zipcode'].'">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                    		<div class="col-md-6">
								<label>Phone</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['per_tel'].'">
                    		</div>
							<div class="col-md-6">
								<label>Email</label>
								<input type="text" readonly class="form-control" value="'.$us[0]['per_email'].'">
							</div>
						</div>
					</div>';
		                        	
		            if($us[0]['per_picture']!=''){
		                $data .= '<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label>User Picture</label>
			                        <div>
			                        	<img src="'.base_url('assets/images/users/'.$us[0]['per_picture']).'" alt="your image" width="25%">
			                        </div>
								</div>
							</div>
						</div>';
			        }

				$data .= '</div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
		</div>';
		echo json_encode(array($data));
	}

	public function profile($menu='',$id=''){
		//////////////////////////////Check Permission/////////////////////////////////
		$data['controllers']='systems';$data['function']='profile';$data['p1']='show';$data['p2']='';$data['p3']='';
		$msid = $this->systemm->getMenuID($data['controllers'],$data['function'],$data['p1'],$data['p2'],$data['p3']);
		$redirect = "dashboard";
		$this->systemm->getActivePermission($msid,$redirect);
		//////////////////////////////Check Permission/////////////////////////////////
		if($menu=='show'){
			$data['title'] = 'Users';
			$data['css'] = '';
			$data['js'] = '<script type="text/javascript" src="'.site_url().'assets/js/plugins/notifications/sweet_alert.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/notifications/bootbox.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/forms/styling/uniform.min.js"></script>
			<script type="text/javascript" src="'.site_url().'assets/js/plugins/forms/inputs/formatter.min.js"></script>';
			$data['us'] = $this->userm->getUserById($this->session->userdata("sessuser_id"));
			$data['province'] = $this->systemm->getProvince();
			$data['amphur'] = $this->systemm->getAmphurByProvinceId($data['us'][0]['province_id']);
			$data['district'] = $this->systemm->getDistrictByAmphurId($data['us'][0]['amphur_id']);
			$this->systemm->getHtml('systems/profile', $data);
		}else if($menu=='per'){
			if($this->input->post('btnsave')!=''){
				$us = $this->userm->getUserById($this->session->userdata("sessuser_id"));
	            if (isset($_FILES['per_picture']['name']) && !empty($_FILES['per_picture']['name'])) {
		    		$config['upload_path']			= './assets/images/users';
		            $config['allowed_types']		= 'gif|jpg|png';
		            $config['encrypt_name']			= true;
		            $config['overwrite']			= true;
		            $this->load->library('upload', $config, 'upload_user');
		            if (!$this->upload_user->do_upload('per_picture')){
		        		$filename = $this->input->post('perpicture');
		            }else{
		                $data_file = array('upload_data' => $this->upload_user->data());
		                $filename = $data_file['upload_data']['file_name'];
		            }
		        }else{
		        	$filename = $this->input->post('perpicture');
	        	}
				$per = array(
					"per_name"=>$this->input->post('per_name'),
					"per_surname"=>$this->input->post('per_surname'),
					"per_code"=>$this->input->post('per_code'),
					"per_code_expired"=>$this->input->post('per_code_expired'),
					"per_birthdate"=>$this->input->post('per_birthdate'),
					"per_sex"=>$this->input->post('per_sex'),
					"per_address"=>$this->input->post('per_address'),
					"province_id"=>$this->input->post('province_id'),
					"amphur_id"=>$this->input->post('amphur_id'),
					"district_id"=>$this->input->post('district_id'),
					"zipcode"=>$this->input->post('zipcode'),
					"per_tel"=>$this->input->post('per_tel'),
					"per_picture"=>$filename
				);
				$this->db->where('per_id',$us[0]['per_id'])->update('tbl_personal',$per);
				$alert='<div class="row" id="alertincorrect">
					<div class="col-md-12">
						<div class="alert alert-success" role="alert">
			          		<i class="icon-checkbox-checked"></i> Save profile information success
						</div>
					</div>
				</div>';
				$this->session->set_flashdata('alert_per',$alert);
				redirect('systems/profile/show','refresh');
				exit();
			}else{
				redirect('systems/profile/show','refresh');
				exit();
			}
		}else if($menu=='user'){
			if($this->input->post('btnsave')!=''){
				$us = $this->userm->getUserById($this->session->userdata("sessuser_id"));
				if(md5($this->input->post('old_password'))==$us[0]['user_password']){
					$user = array(
						"user_password"=>md5($this->input->post('user_password'))
					);
					$this->db->where('user_id',$this->session->userdata("sessuser_id"))->update('tbl_user',$user);
					$alert='<div class="row" id="alertincorrect">
						<div class="col-md-12">
							<div class="alert alert-success" role="alert">
				          		<i class="icon-checkbox-checked"></i> Change password success
							</div>
						</div>
					</div>';
					$this->session->set_flashdata('alert_user',$alert);
					redirect('systems/profile/show','refresh');
					exit();
				}else{
					$alert='<div class="row" id="alertincorrect">
						<div class="col-md-12">
							<div class="alert alert-warning" role="alert">
				          		<i class="icon-warning"></i> The old password is incorrect.
							</div>
						</div>
					</div>';
					$this->session->set_flashdata('alert_user',$alert);
					redirect('systems/profile/show','refresh');
					exit();
				}
			}else{
				redirect('systems/profile/show','refresh');
				exit();
			}
		}else{
			redirect('dashboard','refresh');
			exit();
		}
	}

	public function getAmphur(){
		if($this->session->userdata("sessuser_id")!=''){
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$province_id = isset($_GET['province_id']) ? $_GET['province_id'] : '';
			$amphur = $this->systemm->getAmphurByProvinceId($province_id);
			$data = '<label>Amphur <span class="text-danger">*</span></label>
			<select class="select" name="amphur_id" id="amphur_id_'.$id.'" onchange="getDistrict($(`#amphur_id_'.$id.'`).val(), `'.$id.'`)">';
				$data .= '<option value="">---- Please choose parent menu ----</option>';
				foreach ($amphur as $ap) {
					$data .= '<option value="'.$ap['amphur_id'].'">'.$ap['amphur_name'].'</option>';
				}
			$data .= '</select>';

			$data1 = '<label>District <span class="text-danger">*</span></label>
			<select class="select" name="district_id" id="district_id_'.$id.'">
				<option value="">---- Please choose you amphur ----</option>
			</select>';
			echo json_encode(array($data,$data1));
		}else{
			redirect('systems/login','refresh');
  			exit();
		}
	}

	public function getDistrict(){
		if($this->session->userdata("sessuser_id")!=''){
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$amphur_id = isset($_GET['amphur_id']) ? $_GET['amphur_id'] : '';
			$district = $this->systemm->getDistrictByAmphurId($amphur_id);
			$data = '<label>District <span class="text-danger">*</span></label>
			<select class="select" name="district_id" id="district_id_'.$id.'" onchange="getZipcode($(`#district_id_'.$id.'`).val(), `'.$id.'`)">';
				$data .= '<option value="">---- Please choose parent menu ----</option>';
				foreach ($district as $dt) {
					$data .= '<option value="'.$dt['district_id'].'">'.$dt['district_name'].'</option>';
				}
			$data .= '</select>';
			echo json_encode(array($data));
		}else{
			redirect('systems/login','refresh');
  			exit();
		}
	}

	public function getZipcode(){
		if($this->session->userdata("sessuser_id")!=''){
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$district_id = isset($_GET['district_id']) ? $_GET['district_id'] : '';
			$district = $this->systemm->getZipcodeByDistrictId($district_id);
			$data = $district[0]['zipcode'];
			echo json_encode(array($data));
		}else{
			redirect('systems/login','refresh');
  			exit();
		}
	}
}
