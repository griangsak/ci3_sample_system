		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	<!-- Footer -->
	<div class="navbar navbar-default navbar-fixed-bottom">
		<ul class="nav navbar-nav no-border visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second"><i class="icon-circle-up2"></i></a></li>
		</ul>

		<div class="navbar-collapse collapse" id="navbar-second">
			<div class="navbar-text">
                &copy; 2020. Codeigniter 3 Sample System Backend by Griangsak Wilwan And Limitless Theme by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
			</div>

			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="#">Help center</a></li>
					<li><a href="#">Policy</a></li>
					<li><a href="#" class="text-semibold">Upgrade your account</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-cog3"></i>
							<span class="visible-xs-inline-block position-right">Settings</span>
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="#"><i class="icon-dribbble3"></i> Dribbble</a></li>
							<li><a href="#"><i class="icon-pinterest2"></i> Pinterest</a></li>
							<li><a href="#"><i class="icon-github"></i> Github</a></li>
							<li><a href="#"><i class="icon-stackoverflow"></i> Stack Overflow</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /footer -->

	<!-- Edit modal -->
	<div class="modal fade modal_edit">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

			</div>
		</div>
	</div>
	<!-- /edit modal -->

	<!-- Detail modal -->
	<div class="modal fade modal_detail">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

			</div>
		</div>
	</div>
	<!-- /detail modal -->

</body>
<script type="text/javascript">
var loadinglg = '<center><img src="<?php echo base_url();?>assets/images/preloader.gif" alt="loading" class="img-center" width="200"/></center>';
var loadingmd = '<center><img src="<?php echo base_url();?>assets/images/preloader.gif" alt="loading" class="img-center" width="100"/></center>';
var loadingsm = '<center><img src="<?php echo base_url();?>assets/images/preloader.gif" alt="loading" class="img-center" width="50"/></center>';
function getRefId(lvl, id){
  	$.ajax({
    	type: 'GET',
    	url: "<?php echo base_url('systems/getMenuByLvl');?>",
    	data: ({ menu_level : lvl, id : id }),
    	dataType: "json",
    	beforeSend: function(){
      		$("#_menu_refid_"+id).html(loadingsm);
    	},
    	success: function(json){
      		$("#_menu_refid_"+id).html(json[0]);
    		$('.select').select2();
    	}
  	});
}

function getValidate(elem, rules, messages){
    var validator = $(elem).validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        success: function(label) {
            label.addClass("validation-valid-label").text("Success.")
        },
        rules: rules,
        messages: messages
    });
}

function readURL(input,id) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#_delimg_'+id).html('<img src="'+e.target.result+'" alt="your image" width="25%" /><button type="button" onclick="_delimg(`'+id+'`)" class="btn btn-link btn-xs"><i class="icon-trash"></i></button><input type="hidden" name="perpicture">');
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function _delimg(id){
  $('#_delimg_'+id).html('<input type="hidden" name="perpicture">');
  $('#_per_picture_'+id).html('<input class="form-control" type="file" name="per_picture" id="per_picture_'+id+'" onchange="readURL(this, `'+id+'`)" accept=".png, .jpg, .jpeg"/>');
}

function getAmphur(province_id, id){
  	$.ajax({
    	type: 'GET',
    	url: "<?php echo base_url('systems/getAmphur');?>",
    	data: ({ province_id : province_id, id : id }),
    	dataType: "json",
    	beforeSend: function(){
      		$("#_amphur_id_"+id).html(loadingsm);
    	},
    	success: function(json){
      		$("#_amphur_id_"+id).html(json[0]);
      		$("#_district_id_"+id).html(json[1]);
      		$("#zipcode_"+id).val('');
    		$('.select').select2();
    	}
  	});
}

function getDistrict(amphur_id, id){
  	$.ajax({
    	type: 'GET',
    	url: "<?php echo base_url('systems/getDistrict');?>",
    	data: ({ amphur_id : amphur_id, id : id }),
    	dataType: "json",
    	beforeSend: function(){
      		$("#_district_id_"+id).html(loadingsm);
    	},
    	success: function(json){
      		$("#_district_id_"+id).html(json[0]);
      		$("#zipcode_"+id).val('');
    		$('.select').select2();
    	}
  	});
}

function getZipcode(district_id, id){
  	$.ajax({
    	type: 'GET',
    	url: "<?php echo base_url('systems/getZipcode');?>",
    	data: ({ district_id : district_id, id : id }),
    	dataType: "json",
    	success: function(json){
      		$("#zipcode_"+id).val(json[0]);
    		$('.select').select2();
    	}
  	});
}
</script>
</html>
