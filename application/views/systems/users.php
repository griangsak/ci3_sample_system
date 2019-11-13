<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">System Setup</span> - Users</h4>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-component">
			<ul class="breadcrumb">
				<li><a href="<?=site_url('dashboard')?>"><i class="icon-home2 position-left"></i> Dashboard</a></li>
				<li><a href="<?=site_url('dashboard/systems')?>">System Setup</a></li>
				<li class="active">Users</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<!-- Basic initialization -->
		<div class="panel panel-flat">

			<div class="panel-heading">
				<h4 class="panel-title">Users Setup<a class="heading-elements-toggle"><i class="icon-more"></i></a></h4>
				<?php if($peradd=='true'){?>
					<div class="heading-elements">
						<button type="button" data-toggle="modal" data-target="#modal_add" class="btn border-success text-success-600 btn-flat btn-icon btn-add text-right">
							<i class="icon-user-plus"></i> Add User
						</button>
	            	</div>
	            <?php }?>
			</div>

			<hr>

			<?php if($this->session->flashdata("alert")!=''){echo $this->session->flashdata("alert");}?>

			<table class="table datatable-button-init-basic table-striped table-bordered">
				<thead>
					<tr>
						<th class="text-right">#</th>
						<th>User Type</th>
						<th>User Name</th>
						<th>Name - Surname</th>
						<th class="text-center">Detail</th>
						<?php if($pereditper=='true'){?>
							<th class="text-center">Edit Per</th>
						<?php }?>
						<?php if($peredit=='true'){?>
							<th class="text-center">Edit</th>
	            		<?php }?>
						<?php if($perremove=='true'){?>
							<th class="text-center">Remove</th>
	            		<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($users as $us){?>
						<tr>
							<td class="text-right"><?=$us['user_id']?></td>
							<td><?=$us['usertype_name']?></td>
							<td><?=$us['user_name']?></td>
							<td><?=$us['per_name'].' '.$us['per_surname']?></td>
							<td class="text-center">
								<button type="button" data-toggle="modal" data-target=".modal_detail" onclick="getDetailUser(<?=$us['user_id']?>)" class="label border-success text-success-600 btn-flat btn-icon"><i class="icon-eye"></i></button>
							</td>
							<?php if($pereditper=='true'){?>
								<td class="text-center">
									<button type="button" data-toggle="modal" data-target=".modal_edit" onclick="getEditPermission(<?=$us['user_id']?>)" class="label border-info text-info-600 btn-flat btn-icon"><i class="icon-pencil7"></i></button>
								</td>
	            			<?php }?>
							<?php if($peredit=='true'){?>
								<td class="text-center">
									<button type="button" data-toggle="modal" data-target=".modal_edit" onclick="getEditUser(<?=$us['user_id']?>)" class="label border-primary text-primary-600 btn-flat btn-icon"><i class="icon-pencil7"></i></button>
								</td>
	            			<?php }?>
							<?php if($perremove=='true'){?>
								<td class="text-center">
									<button type="button" class="label border-warning text-warning-600 btn-flat btn-icon" onclick="if(confirm('Are you sure to remove?')==true){window.location='<?=base_url('systems/users/remove/'.$us['user_id'])?>'}"><i class="icon-user-cancel"></i></button>
								</td>
	            			<?php }?>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
		<!-- /basic initialization -->

	</div>
	<!-- /content area -->
</div>
<!-- /main content -->

<!-- Large modal -->
<div id="modal_add" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Add User</h5>
			</div>

			<div class="modal-body">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">User info<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
					</div>

					<div class="panel-body">

            			<?php $attrib = array(
            				'name' => 'user_form', 
            				'id' =>'user_form',
            				'class'=>'form-horizontal form-validate-jquery'
            			);
                		echo form_open_multipart('systems/users/add', $attrib) ;?>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label>User Type <span class="text-danger">*</span></label>
										<select class="select" name="usertype_id" id="usertype_id">
											<option value="">---- Please choose user type ----</option>
											<?php foreach($user_type as $ut){?>
												<option value="<?=$ut['usertype_id']?>"><?=$ut['usertype_name']?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label>User Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="user_name" id="user_name">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Password <span class="text-danger">*</span></label>
										<input type="password" class="form-control" name="user_password" id="user_password">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label>Confirm Password <span class="text-danger">*</span></label>
										<input type="password" class="form-control" name="confirm_password" id="confirm_password">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="per_name" id="per_name">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label>Surname <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="per_surname" id="per_surname">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label>Email <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="per_email" id="per_email">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
				                        <div id="_delimg_add">
				                            <input type="hidden" name="perpicture">
				                        </div>
										<label>User Picture</label>
				                        <div id="_per_picture_add">
				                            <input type="file" name="per_picture" id="per_picture_add" onchange="readURL(this, 'add')" class="form-control" accept=".png, .jpg, .jpeg" />
				                        </div>
									</div>
								</div>
							</div>

							<div class="text-right">
								<input type="hidden" name="btnsaveadd" id="btnsaveadd" value="save">
								<button type="submit" class="btn btn-primary">Submit form <i class="icon-arrow-right14 position-right"></i></button>
							</div>
						<?php echo form_close();?>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- /large modal -->

<script type="text/javascript">
function getRules(){
	return {
	    'usertype_id' : { required:true },
	    'user_name' : { required:true },
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
	    'per_email': {
	    	required:true,
	        email: true
	    }
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

<?php if($peredit=='true'){?>
	function getEditUser(id){
	  	$.ajax({
	    	type: 'GET',
	    	url: "<?php echo base_url('systems/getEditUser');?>",
	    	data: ({ user_id : id }),
	    	dataType: "json",
	    	beforeSend: function(){
	    		$('.modal_edit .modal-content').html(loadingmd);
	    	},
	    	success: function(json){
	    		$('.modal_edit .modal-content').html(json[0]);
	    		$('.select').select2();

			    var rules = getRules();
			    var messages = getMessages();
			    getValidate('#user_form_'+id, rules, messages);
	    	}
	  	});
	}
<?php }?>
<?php if($pereditper=='true'){?>
	function getEditPermission(id){
	  	$.ajax({
	    	type: 'GET',
	    	url: "<?php echo base_url('systems/getEditPermission');?>",
	    	data: ({ user_id : id }),
	    	dataType: "json",
	    	beforeSend: function(){
	    		$('.modal_edit .modal-content').html(loadingmd);
	    	},
	    	success: function(json){
	    		$('.modal_edit .modal-content').html(json[0]);
	    		$('.select').select2();
			    $(".control-primary").uniform({
			        radioClass: 'choice',
			        wrapperClass: 'border-primary-600 text-primary-800'
			    });
			    $(".control-success").uniform({
			        radioClass: 'choice',
			        wrapperClass: 'border-success-600 text-success-800'
			    });
			    $(".control-warning").uniform({
			        radioClass: 'choice',
			        wrapperClass: 'border-warning-600 text-warning-800'
			    });
	    	}
	  	});
	}
<?php }?>
function getDetailUser(id){
  	$.ajax({
    	type: 'GET',
    	url: "<?php echo base_url('systems/getDetailUser');?>",
    	data: ({ user_id : id }),
    	dataType: "json",
    	beforeSend: function(){
    		$('.modal_detail .modal-content').html(loadingmd);
    	},
    	success: function(json){
    		$('.modal_detail .modal-content').html(json[0]);
    	}
  	});
}
$(function() {

    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        }
    });

    $('.datatable-button-init-basic').DataTable({
        buttons: {
            dom: {
                button: {
                    className: 'btn btn-default'
                }
            },
            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel'},
                {extend: 'pdf'},
                {extend: 'print'}
            ]
        }
    });

    $('.select').select2();

    $(".styled").uniform({ radioClass: 'choice' }); 

    var rules = getRules();
    var messages = getMessages();
    getValidate('#user_form', rules, messages);
});
</script>