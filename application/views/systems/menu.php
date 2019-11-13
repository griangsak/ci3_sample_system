<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">System Setup</span> - Menu</h4>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-component">
			<ul class="breadcrumb">
				<li><a href="<?=site_url('dashboard')?>"><i class="icon-home2 position-left"></i> Dashboard</a></li>
				<li><a href="<?=site_url('dashboard/systems')?>">System Setup</a></li>
				<li class="active">Menu</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<!-- Basic initialization -->
		<div class="panel panel-flat">

			<div class="panel-heading">
				<h4 class="panel-title">Menu Setup<a class="heading-elements-toggle"><i class="icon-more"></i></a></h4>
				<?php if($peradd=='true'){?>
					<div class="heading-elements">
						<button type="button" data-toggle="modal" data-target="#modal_add" class="btn border-success text-success-600 btn-flat btn-icon btn-add text-right">
							<i class="icon-import"></i> Add Menu
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
						<th class="text-center">Icon</th>
						<th>Name</th>
						<th class="text-center">Level</th>
						<th>Url</th>
						<th class="text-center">Status</th>
						<?php if($peredit=='true'){?>
							<th class="text-center">Edit</th>
	            		<?php }?>
						<?php if($perremove=='true'){?>
							<th class="text-center">Remove</th>
	            		<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($menuies as $mn){
			            $site_url = $mn['menu_controllers'];
			            if($mn['menu_function']!=''){$site_url .= '/'.$mn['menu_function'];}
			            if($mn['menu_p1']!=''){$site_url .= '/'.$mn['menu_p1'];}
			            if($mn['menu_p2']!=''){$site_url .= '/'.$mn['menu_p2'];}
			            if($mn['menu_p3']!=''){$site_url .= '/'.$mn['menu_p3'];}
			            if($mn['menu_st']==0){
			            	$menu_st = '<span class="label label-success">Show</span>';
			            }else{
			            	$menu_st = '<span class="label label-default">Hide</span>';
			            }?>
						<tr>
							<td class="text-right"><?=$mn['menu_id']?></td>
							<td class="text-center"><i class="<?=$mn['menu_code']?>"></i></td>
							<td><?=$mn['menu_name']?></td>
							<td class="text-center"><?=$mn['menu_level']?></td>
							<td><?=base_url($site_url)?></td>
							<td class="text-center"><?=$menu_st?></td>
							<?php if($peredit=='true'){?>
								<td class="text-center">
									<button type="button" data-toggle="modal" data-target=".modal_edit" onclick="getEditMenu(<?=$mn['menu_id']?>)" class="label border-primary text-primary-600 btn-flat btn-icon"><i class="icon-pencil7"></i></button>
								</td>
	            			<?php }?>
							<?php if($perremove=='true'){?>
								<td class="text-center">
									<button type="button" class="label border-warning text-warning-600 btn-flat btn-icon" onclick="if(confirm('Are you sure to remove?')==true){window.location='<?=base_url('systems/menu/remove/'.$mn['menu_id'])?>'}"><i class="icon-trash"></i></button>
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
				<h5 class="modal-title">Add Menu</h5>
			</div>

			<div class="modal-body">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Menu info<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
					</div>

					<div class="panel-body">

            			<?php $attrib = array(
            				'name' => 'menu_form', 
            				'id' =>'menu_form',
            				'class'=>'form-horizontal form-validate-jquery'
            			);
                		echo form_open_multipart('systems/menu/add', $attrib) ;?>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Icon Menu</label>
										<input type="text" class="form-control" name="menu_code" id="menu_code">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="menu_name" id="menu_name">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="display-block">Level <span class="text-danger">*</span></label>

										<label class="radio-inline">
											<input type="radio" class="styled" name="menu_level" id="menu_level_1" onclick="getRefId(1, 'add')" value="1">
											1
										</label>

										<label class="radio-inline">
											<input type="radio" class="styled" name="menu_level" id="menu_level_2" onclick="getRefId(2, 'add')" value="2">
											2
										</label>

										<label class="radio-inline">
											<input type="radio" class="styled" name="menu_level" id="menu_level_3" onclick="getRefId(3, 'add')" value="3">
											3
										</label>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group" id="_menu_refid_add">
										<label>Parent Menu</label>
										<select class="select" name="menu_refid" id="menu_refid_add">
											<option value="">---- Please choose parent menu ----</option>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Sort <span class="text-danger">*</span></label>
										<input type="number" class="form-control" name="menu_sort" id="menu_sort" min="0">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label>Controllers <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="menu_controllers" id="menu_controllers">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Function</label>
										<input type="text" class="form-control" name="menu_function" id="menu_function">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label>Parameter 1</label>
										<input type="text" class="form-control" name="menu_p1" id="menu_p1">
									</div>
								</div>
								
								<div class="col-lg-6">
									<div class="form-group">
										<label>Parameter 2</label>
										<input type="text" class="form-control" name="menu_p2" id="menu_p2">
									</div>
								</div>
								
								<div class="col-lg-6">
									<div class="form-group">
										<label>Parameter 3</label>
										<input type="text" class="form-control" name="menu_p3" id="menu_p3">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label class="display-block">Nav menu status <span class="text-danger">*</span></label>

										<label class="radio-inline">
											<input type="radio" class="styled" name="menu_st" id="menu_st_1" value="0">
											Show
										</label>

										<label class="radio-inline">
											<input type="radio" class="styled" name="menu_st" id="menu_st_2" value="1">
											Hide
										</label>
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
        'menu_name' : { required:true },
        'menu_level' : { required:true },
        'menu_sort' : { required:true },
        'menu_controllers' : { required:true },
        'menu_st' : { required:true },
    };
}

function getMessages(){
	return {
        'menu_name' : 'Please enter menu name',
        'menu_level' : 'Please enter level menu',
        'menu_sort' : 'Please enter sort menu',
        'menu_controllers': 'Please choose controllers menu',
        'menu_st' : 'Please choose nav menu status',
    };
}
<?php if($peredit=='true'){?>
	function getEditMenu(id){
	  	$.ajax({
	    	type: 'GET',
	    	url: "<?php echo base_url('systems/getEditMenu');?>",
	    	data: ({ menu_id : id }),
	    	dataType: "json",
	    	beforeSend: function(){
	    		$('.modal_edit .modal-content').html(loadingmd);
	    	},
	    	success: function(json){
	    		$('.modal_edit .modal-content').html(json[0]);
	    		$('.select').select2();
	    		$(".styled").uniform({ radioClass: 'choice' }); 
	    		
			    var rules = getRules();
			    var messages = getMessages();
			    getValidate('#menu_form_'+id, rules, messages);
	    	}
	  	});
	}
<?php }?>
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
    getValidate('#menu_form', rules, messages);
});
</script>