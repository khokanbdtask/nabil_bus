
				<!-- new tax -->
				<div class="row">
						<div class="col-sm-12">
								<div class="panel panel-bd lobidrag">
										<div class="panel-heading">
												<div class="panel-title">
														<h4><?php echo display('tax_settings') ?> </h4>
														 <div id="outputPreview1" class="alert hide modal-title" role="alert" >
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
												</div>
										</div>
									 <?php echo form_open_multipart('tax/tax/update_tax_settins',array('class' => 'form-vertical','id' => 'tax_settings_update' ))?>
										<div class="panel-body">
											 
											<div class="form-group row">
														<label for="number_of_tax" class="col-sm-2 col-form-label"><?php echo display('number_of_tax') ?> <i class="text-danger">*</i></label>
														<div class="col-sm-3">
																<input type="text" class="form-control" name="nt" id="number_of_tax"  placeholder="<?php echo display('number_of_tax') ?>" onkeyup="add_columnTaxsettings(this.value)" value=""/>
																<input type="hidden" name="id" value="">
														</div>
												</div>
												 
												<span id="taxfield" class="form-group row">
														<?php  
												$i=1;
												if($setinfo)
												{
												foreach (@$setinfo as $taxss) {?>
													<div class="form-group row"><label for="fieldname" class="col-sm-1 col-form-label">Tax Name <?php echo $i;?>*</label><div class="col-sm-2"><input type="text" class="form-control" name="taxfield[]" required="" value="<?php echo html_escape($taxss['tax_name']);?>"></div>
													<label for="default_value" class="col-sm-1 col-form-label"><?php echo display('default_value') ?><span class="text-danger">(%)</span></label><div class="col-sm-2"><input type="text" class="form-control" name="default_value[]" value="<?php echo html_escape($taxss['default_value']);?>" id="default_value"  placeholder="<?php echo display('default_value') ?>" /></div><label for="reg" class="col-sm-1 col-form-label"><?php echo display('reg_no'); ?></label>
													<div class="col-sm-2"><input type="text" class="form-control" name="reg_no[]" value="<?php echo html_escape($taxss['reg_no']);?>" id="reg_no"  placeholder="<?php echo display('reg_no') ?>" /></div>

													<div class="col-sm-1">
														<input type="checkbox" name="is_show[]" class="form-control" value="<?php echo $i;?>" <?php if($taxss['is_show']==$i){echo 'checked';}?>>
													</div>
													<label for="isshow" class="col-sm-1 col-form-label">
														<?php echo 'Want to Show?'; ?>
													</label>
											</div>  
											<?php $i++;
									}
								}
											?>
												</span>

												<div class="form-group row">
														<label for="apply_tax_module" class="col-sm-2 col-form-label"><?php echo display('apply_tax_module') ?> <i class="text-danger">*</i></label>
														
														<div class="col-sm-2">
															<label>Ticket Management</label>
														</div>
														<div class="col-sm-2">

																<input type="checkbox" class="form-control" name="ticket" id="apply_tax_module"  placeholder="<?php echo display('apply_tax_module') ?>" value="1" <?php echo (!empty($tax_module[0]))?"checked":'' ?>/>
																
														</div>

														<div class="col-sm-2">
															<label>Luggage</label>
														</div>

														<div class="col-sm-2">

																<input type="checkbox" class="form-control" name="luggage" id="apply_tax_module"  placeholder="<?php echo display('apply_tax_module') ?>" value="2" <?php echo (!empty($tax_module[1]))?"checked":'' ?>  />
																
														</div>

												</div>

												<div class="form-group row">
														<label for="example-text-input" class="col-sm-2 col-form-label"></label>
														<div class="col-sm-6">
																<input type="submit" id="add-settings" class="btn btn-success" name="add-settings" value="<?php echo display('save') ?>" />
														</div>
												</div>
												<div class="row text-center">
													 <h3> <span class="text-danger">If you Update tax settings ,All of your previous tax record will be destroy.You Will Need to set tax product wise and Service wise</span></h3>
												</div>
										</div>


										<?php echo form_close()?>

								</div>
						</div>
				</div>
 
