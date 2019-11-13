<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">System Setup</span> - My Account</h4>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-component">
			<ul class="breadcrumb">
				<li><a href="<?=site_url('dashboard')?>"><i class="icon-home2 position-left"></i> Dashboard</a></li>
				<li><a href="<?=site_url('dashboard/systems')?>">System Setup</a></li>
				<li class="active">My Account</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<!-- User profile -->
		<div class="row">
			<div class="col-lg-9">

				<!-- Profile info -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title">Profile information</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<li><a data-action="reload"></a></li>
		                		<li><a data-action="close"></a></li>
		                	</ul>
		            	</div>
					</div>

					<div class="panel-body">
						<?php if($this->session->flashdata("alert_per")!=''){echo $this->session->flashdata("alert_per");}?>
            			<?php $attrib = array(
            				'name' => 'info_form', 
            				'id' =>'info_form',
            				'class'=>'form-horizontal form-validate-jquery'
            			);
                		echo form_open_multipart('systems/profile/per', $attrib) ;?>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Name <span class="text-danger">*</span></label>
										<input type="text" id="per_name" name="per_name" class="form-control" value="<?=$us[0]['per_name']?>">
									</div>
									<div class="col-md-6">
										<label>Surename <span class="text-danger">*</span></label>
										<input type="text" id="per_surname" name="per_surname" class="form-control" value="<?=$us[0]['per_surname']?>">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Identity card <span class="text-danger">*</span></label>
										<input type="text" id="per_code" name="per_code" class="form-control mask-identity-card" value="<?=$us[0]['per_code']?>">
									</div>
									<div class="col-md-6">
										<label>Identity card expired <span class="text-danger">*</span></label>
										<input type="date" id="per_code_expired" name="per_code_expired" class="form-control" value="<?=$us[0]['per_code_expired']?>">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Birthdate</label>
										<input type="date" id="per_birthdate" name="per_birthdate" class="form-control" value="<?=$us[0]['per_birthdate']?>">
									</div>
									<div class="col-md-6">
										<label class="display-block">Sex <span class="text-danger">*</span></label>

										<label class="radio-inline">
											<input type="radio" class="styled" name="per_sex" id="per_sex_M" value="M"
											<?php if($us[0]['per_sex']=='M'){?> checked<?php }?>>
											Male
										</label>

										<label class="radio-inline">
											<input type="radio" class="styled" name="per_sex" id="per_sex_F" value="F"
											<?php if($us[0]['per_sex']=='F'){?> checked<?php }?>>
											Female
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Address <span class="text-danger">*</span></label>
										<input type="text" name="per_address" id="per_address" class="form-control" value="<?=$us[0]['per_address']?>">
									</div>
									<div class="col-md-6">
										<label>Province <span class="text-danger">*</span></label>
										<select class="select" name="province_id" id="province_id_<?=$us[0]['user_id']?>" onchange="getAmphur($('#province_id_<?=$us[0]['user_id']?>').val(), <?=$us[0]['user_id']?>)">
											<option value="">---- Please choose you province ----</option>
											<?php foreach($province as $pv){?>
												<option value="<?=$pv['province_id']?>"<?php if($pv['province_id']==$us[0]['province_id']){?> selected<?php }?>><?=$pv['province_name']?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4" id="_amphur_id_<?=$us[0]['user_id']?>">
										<label>Amphur <span class="text-danger">*</span></label>
										<select class="select" name="amphur_id" id="amphur_id_<?=$us[0]['user_id']?>" onchange="getDistrict($('#amphur_id_<?=$us[0]['user_id']?>').val(), <?=$us[0]['user_id']?>)">
											<option value="">---- Please choose you amphur ----</option>
											<?php foreach($amphur as $ap){?>
												<option value="<?=$ap['amphur_id']?>"<?php if($ap['amphur_id']==$us[0]['amphur_id']){?> selected<?php }?>><?=$ap['amphur_name']?></option>
											<?php }?>
										</select>
									</div>
									<div class="col-md-4" id="_district_id_<?=$us[0]['user_id']?>">
										<label>District <span class="text-danger">*</span></label>
										<select class="select" name="district_id" id="district_id_<?=$us[0]['user_id']?>" onchange="getZipcode($('#district_id_<?=$us[0]['user_id']?>').val(), <?=$us[0]['user_id']?>)">
											<option value="">---- Please choose you district ----</option>
											<?php foreach($district as $dt){?>
												<option value="<?=$dt['district_id']?>"<?php if($dt['district_id']==$us[0]['district_id']){?> selected<?php }?>><?=$dt['district_name']?></option>
											<?php }?>
										</select>
									</div>
									<div class="col-md-4">
										<label>ZIP code <span class="text-danger">*</span></label>
										<input type="text" name="zipcode" id="zipcode_<?=$us[0]['user_id']?>" class="form-control" value="<?=$us[0]['zipcode']?>" readonly>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
		                    		<div class="col-md-6">
										<label>Phone <span class="text-danger">*</span></label>
										<input type="text" name="per_tel" id="per_tel" class="form-control mask-phone" value="<?=$us[0]['per_tel']?>">
		                    		</div>
									<div class="col-md-6">
										<label>Email</label>
										<input type="text" readonly="readonly" class="form-control" value="<?=$us[0]['per_email']?>">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-lg-12">
				                        <div id="_delimg_<?=$us[0]['user_id']?>">
				                        	<?php if($us[0]['per_picture']!=''){?>
				                        		<img src="<?=base_url('assets/images/users/'.$us[0]['per_picture'])?>" alt="your image" width="25%">
					                        	<button type="button" onclick="_delimg(`<?=$us[0]['user_id']?>`)" class="btn btn-link btn-xs"><i class="icon-trash"></i></button>
					                        	<input type="hidden" name="perpicture" value="<?=$us[0]['per_picture']?>">
				                        	<?php }else{?>
				                        		<input type="hidden" name="perpicture">
				                        	<?php }?>
				                        </div>
										<label>User Picture</label>
				                        <div id="_per_picture_<?=$us[0]['user_id']?>">
				                            <input type="file" name="per_picture" id="per_picture_<?=$us[0]['user_id']?>" onchange="readURL(this, `<?=$us[0]['user_id']?>`)" class="form-control" accept=".png, .jpg, .jpeg" />
				                        </div>
									</div>
								</div>
							</div>

		                    <div class="text-right">
		                    	<input type="hidden" name="btnsave" value="save">
		                    	<button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
		                    </div>
						<?php echo form_close();?>
					</div>
				</div>
				<!-- /profile info -->


				<!-- Account settings -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title">Account settings</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<li><a data-action="reload"></a></li>
		                		<li><a data-action="close"></a></li>
		                	</ul>
		            	</div>
					</div>

					<div class="panel-body">
						<?php if($this->session->flashdata("alert_user")!=''){echo $this->session->flashdata("alert_user");}?>
            			<?php $attrib = array(
            				'name' => 'user_form', 
            				'id' =>'user_form',
            				'class'=>'form-horizontal form-validate-jquery'
            			);
                		echo form_open_multipart('systems/profile/user', $attrib) ;?>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>Username</label>
										<input type="text" readonly="readonly" class="form-control" value="<?=$us[0]['user_name']?>">
									</div>

									<div class="col-md-6">
										<label>User type</label>
										<input type="text" readonly="readonly" class="form-control" value="<?=$us[0]['usertype_name']?>">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Old password</label>
										<input type="password" name="old_password" id="old_password" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label>New password</label>
										<input type="password" name="user_password" id="user_password" class="form-control">
									</div>

									<div class="col-md-6">
										<label>Repeat password</label>
										<input type="password" name="confirm_password" id="confirm_password" class="form-control">
									</div>
								</div>
							</div>

		                    <div class="text-right">
		                    	<input type="hidden" name="btnsave" value="save">
		                    	<button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
		                    </div>
						<?php echo form_close();?>
					</div>
				</div>
				<!-- /account settings -->

			</div>

			<div class="col-lg-3">

				<!-- User thumbnail -->
				<div class="thumbnail">
					<div class="thumb thumb-rounded thumb-slide">
                    	<?php if($us[0]['per_picture']!=''){?>
							<img src="<?=site_url()?>assets/images/users/<?=$us[0]['per_picture']?>" alt="">
                    	<?php }else{?>
							<img src="<?=site_url()?>assets/images/placeholder.jpg" alt="">
                    	<?php }?>
						<div class="caption">
							<span>
								<a href="#" class="btn bg-success-400 btn-icon btn-xs" data-popup="lightbox"><i class="icon-plus2"></i></a>
								<a href="user_pages_profile.html" class="btn bg-success-400 btn-icon btn-xs"><i class="icon-link"></i></a>
							</span>
						</div>
					</div>
				
			    	<div class="caption text-center">
			    		<h6 class="text-semibold no-margin"><?=$us[0]['per_name']?> <?=$us[0]['per_surname']?> <small class="display-block"><?=$us[0]['usertype_name']?></small></h6>
			    	</div>
		    	</div>
		    	<!-- /user thumbnail -->


				<!-- Navigation -->
		    	<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title">Profile information</h6>
					</div>

					<div class="list-group no-border no-padding-top">
						<a href="#" class="list-group-item"><i class="icon-user"></i> My profile</a>
						<a href="#" class="list-group-item"><i class="icon-cash3"></i> Balance</a>
						<a href="#" class="list-group-item"><i class="icon-tree7"></i> Connections <span class="badge bg-danger pull-right">29</span></a>
						<a href="#" class="list-group-item"><i class="icon-users"></i> Friends</a>
						<div class="list-group-divider"></div>
						<a href="#" class="list-group-item"><i class="icon-calendar3"></i> Events <span class="badge bg-teal-400 pull-right">48</span></a>
						<a href="#" class="list-group-item"><i class="icon-cog3"></i> Account settings</a>
					</div>
				</div>
				<!-- /navigation -->

			</div>

		</div>
		<!-- /user profile -->

	</div>
	<!-- /content area -->
</div>
<!-- /main content -->
<script type="text/javascript">
function getRules(){
	return {
	    'usertype_id' : { required:true },
	    'user_name' : { required:true },
	    'old_password': {
	    	required:true,
	        minlength: 6,
	        maxlength: 20,
	    },
	    'user_password': {
	    	required:true,
	        minlength: 6,
	        maxlength: 20,
	    },
	    'confirm_password': {
	    	required:true,
	        minlength: 6,
	        maxlength: 20,
	        equalTo: "#user_password",
	    },
	    'per_name' : { required:true },
	    'per_surname' : { required:true },
	    'per_code' : { required:true },
	    'per_code_expired' : { required:true },
	    'per_birthdate' : { required:true },
	    'per_sex' : { required:true },
	    'per_address' : { required:true },
	    'district_id' : { required:true },
	    'amphur_id' : { required:true },
	    'province_id' : { required:true },
	    'zipcode' : { required:true },
	    'per_tel' : { required:true },
	};
}

function getMessages(){
	return {
	    'usertype_id' : 'Please choose user type',
	    'user_name' : 'Please enter username',
	    'per_name' : 'Please enter name',
	    'per_surname' : 'Please enter surname',
	};
}
$(function() {
    $('.select').select2();
    $(".styled").uniform({ radioClass: 'choice' }); 
    $('.mask-phone').formatter({
        pattern: '{{999}}-{{999}}-{{9999}}'
    });

    $('.mask-identity-card').formatter({
        pattern: '{{9}}-{{9999}}-{{99999}}-{{99}}-{{9}}'
    });

	var rules = getRules();
	var messages = getMessages();
	getValidate('#info_form', rules, messages);
	getValidate('#user_form', rules, messages);
});
</script>