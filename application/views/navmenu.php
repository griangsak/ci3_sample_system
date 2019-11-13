<?php 
$per_name = isset($sessuser[0]['per_name']) ? $sessuser[0]['per_name'] : '';
$per_surname = isset($sessuser[0]['per_surname']) ? $sessuser[0]['per_surname'] : '';
$user_name = isset($sessuser[0]['user_name']) ? $sessuser[0]['user_name'] : '';
$per_picture = isset($sessuser[0]['per_picture']) ? $sessuser[0]['per_picture'] : '';
$usertype_name = isset($sessuser[0]['usertype_name']) ? $sessuser[0]['usertype_name'] : '';
?>
<!-- Main sidebar -->
<div class="sidebar sidebar-main">
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-user">
			<div class="category-content">
				<div class="media">
					<?php if($per_picture==''){?>
						<a href="#" class="media-left"><img src="<?=site_url()?>assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
					<?php }else{?>
						<a href="#" class="media-left"><img src="<?=site_url()?>assets/images/users/<?=$per_picture?>" class="img-circle img-sm" alt=""></a>
					<?php }?>
					<div class="media-body">
						<span class="media-heading text-semibold"><?=$per_name.' '.$per_surname?></span>
						<div class="text-size-mini text-muted">
							<i class="icon-pin text-size-small"></i> &nbsp;<?=$usertype_name?>
						</div>
					</div>

					<div class="media-right media-middle">
						<ul class="icons-list">
							<li>
								<a href="#"><i class="icon-cog3"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->


		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">

					<!-- Main -->
					<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
					<?php foreach($memulvl1 as $l1){?>
						<li<?php if($controllers==$l1['menu_controllers']&&$controllers!=''){?> class="active"<?php }?>>
							<a href="<?=base_url($site_url[$l1['menu_id']])?>">
								<i class="<?=$l1['menu_code']?>"></i> <span><?=$l1['menu_name']?></span>
							</a>
							<?php if(count($memulvl2[$l1['menu_id']])>0){?>
								<ul>
									<?php foreach($memulvl2[$l1['menu_id']] as $l2){?>
										<li<?php if($function==$l2['menu_function']&&$function!=''){?> class="active"<?php }?>>
											<a href="<?=base_url($site_url[$l2['menu_id']])?>">
												<?=$l2['menu_name']?>
											</a>
											<?php if(count($memulvl3[$l2['menu_id']])>0){?>
												<ul>
													<?php foreach($memulvl3[$l2['menu_id']] as $l3){?>
														<li<?php if($p1==$l3['menu_p1']&&$p1!=''){?> class="active"<?php }?>>
															<a href="<?=base_url($site_url[$l3['menu_id']])?>">
																<?=$l3['menu_name']?>
															</a>
														</li>
													<?php }?>
												</ul>
											<?php }?>
										</li>
									<?php }?>
								</ul>
							<?php }?>
						</li>
					<?php }?>
					<!-- /main -->

				</ul>
			</div>
		</div>
		<!-- /main navigation -->

	</div>
</div>
<!-- /main sidebar -->
