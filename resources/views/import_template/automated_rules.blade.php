@extends('layouts.app')
@section('content')

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12 ">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="icon-magic-wand" style="color: #32C5D2"></i>
					<span class="caption-subject bold uppercase">FIELD Automation</span>
				</div>
				<div class="actions">					
				</div>
			</div>
			<div class="portlet-body form">
				<div class="table-toolbar" style="margin-bottom: 0">
					<div class="row">						
						<div class="col-md-12">						
						   @if(Session::has('success-message'))
								<div class="alert alert-success">
								<strong>Success!</strong> {{ Session::get('success-message') }}
								</div>
								@endif

								@if(Session::has('error-message'))
								<div class="alert alert-danger">
								<strong>Error!</strong>{{ Session::get('error-message') }}
								</div>								
							@endif
						</div>
					</div>
				</div>                                   
				
					<div class="form-body"> 
						<div class="form-group">
							<div>
								<?php $exist_any_rule = 0;?>
								@if(isset($data['automation_rules']) && count($data['automation_rules']))
								    <div style="font-weight: bold;padding-bottom: 30px; color:#a9a9a9;">Current Automation Rules: </div>
								    <div style="padding: 0 0 30px 0 ">
								    	<div style="height: 25px;clear:both"> 
								    		<div style="float: left;width:37%;font-weight: bold"> Product Field</div>
								    		<div style="float: left;width:63%;font-weight: bold"> Rules </div>
								    	</div>
										@foreach ($data['automation_rules'] as $row)
										<div style="clear:both;padding-top:12px">
											<div style="float: left;width:37%">
												<?php							  	    	
							  	       				$csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, $row->product_column_name);
							  	       				echo $csvHeadLabel ? $csvHeadLabel : $row->product_column_name;
							  	    			?>
							  	      </div>
											<div style="float: left;width:63%">
											<?php 
												
												$automation_rules = json_decode( $row->rules); 
												if(count($automation_rules)) {
													$exist_any_rule = 1;
													foreach ($automation_rules as $key => $value) {
														if(!$value)
															continue;
							  	       				
							  	                    echo '[ ' .  $value . ' ]';

													}
											    }													
												?>
											</div>
										</div>										
										@endforeach
								</div>
								@endif
						    </div>

							<table width="100%" border="0" >
							  <tr style="color:#a9a9a9;font-weight:bold">							 
							  	<td style="width:25%;"><div><?php echo $exist_any_rule ? 'Add' : 'Create' ?> New Field Automation Rule</div></td>
							  	<td style="width:35%;" >&nbsp; </td> 
							  </tr>
							  <tr><td colspan="4">&nbsp;</td></tr>
								<?php 
									$template_fields = $data['template_info']->template_fields;
									$template_fields_array = json_decode($template_fields);								
									$template_csv_heads = DB::table('template_csv_heads')->where('template_row_id', $data['template_info']->template_row_id)->get();
								?>	
								<?php 
								$csv_field_db_mapping = json_decode ($data['template_info']->csv_field_db_mapping, true);
								$count = 1;
								$countDbFieldsPrinted = 0;

								function getCSVHeadNameOriginal($template_row_id, $head_replace_to) {									
									$r= DB::Table('template_csv_heads')->where('head_replace_to', "$head_replace_to")->first();
									if($r)
									return $r->csv_head_name_original;
									
								}


								?>
								
							  <tr>
							  <td style="width:25%;">

								<select class="form-control input-medium match_field" name="db_field_name"  id="db_fields_list">
								   <option value="">Select Field</option>
								   <option value="product_name"> 
								   	<?php							  	    	
							  	       $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_name');
							  	       echo $csvHeadLabel ? $csvHeadLabel : 'Product Name';
							  	    ?>									   							  	   
							  	   </option>
								   <option value="handle">
								   <?php							  	    	
							  	       $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'handle');
							  	       echo $csvHeadLabel ? $csvHeadLabel : 'Handle';
							  	    ?>
							  	  </option>
								   <option value="product_sku">
								   	<?php							  	    	
							  	       $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_sku');
							  	       echo $csvHeadLabel ? $csvHeadLabel : 'Product SKU';
							  	    ?>							  	    	
							  	   </option>
								   <option value="vendor_sku">
									   <?php							  	    	
								  	       $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'vendor_sku');
								  	       echo $csvHeadLabel ? $csvHeadLabel : 'Vendor SKU';
								  	    ?>							  	    	
							  	    </option>
								   <option value="aku_code">
								   		<?php							  	    	
								  	       $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'aku_code');
								  	       echo $csvHeadLabel ? $csvHeadLabel : 'Aku Code';
								  	    ?>	
								   </option>
								   <option value="product_price">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_price');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Product Price';
								  	?>
								  	</option>
								   <option value="product_price_unit">
								   	<?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_price_unit');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Product Price Unit';
								  	?>
								  </option>
								   <option value="upc">
								    <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'upc');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'UPC';
								  	?>
								  </option>	
								   <option value="description">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'description');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Description';
								  	?>
								   </option>
								   <option value="product_image">Product Image</option>
								   <option value="product_secondary_images">Product Secondary Images</option>
								   <option value="production_art_url_1">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'production_art_url_1');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Production Art Url 1';
								  	?>
								  </option>
								   <option value="production_art_url_2">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'production_art_url_2');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Production Art Url 2';
								  	?>
								  </option>
								   <option value="print_mode">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'print_mode');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Print Mode';
								  	?>
								   </option>								   
								   <option value="print_location">
								   	<?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'print_location');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Print Location';
								  	?>
								   </option>
								   <option value="print_location2">
								   	<?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'print_location2');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Print Location2';
								  	?>
								   </option>
								   <option value="product_length">
								   	<?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_length');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Length';
								  	?>
								   </option>								   
								   <option value="product_length_unit">
								   	<?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_length_unit');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Length Unit';
								  	?>
								  </option>
								   <option value="product_height">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_height');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Height';
								  	?>
								  </option>		
								   <option value="product_height_unit">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_height_unit');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Height Unit';
								  	?>
								  </option>
								   <option value="product_width">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_width');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Width';
								  	?>
								  </option>
								   <option value="product_width_unit">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_width_unit');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Width Unit';
								  	?>
								  </option>
								   <option value="product_weight">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_weight');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Weight';
								  	?>
								   </option>	
								   <option value="product_weight_unit">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_weight_unit');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Weight Unit';
								  	?>
								  </option>
								   <option value="product_cost">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_cost');
								  	     echo $csvHeadLabel ? $csvHeadLabel : ' Product Cost';
								  	?>
								   </option>
								   <option value="product_stock">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_stock');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Stock Level';
								  	?>
								  </option>	
								   <option value="inventory_serial">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'inventory_serial');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Inventory Serial';
								  	?>
								  </option>
								   <option value="number_of_pieces">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'number_of_pieces');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Number of Pieces';
								  	?>
								  </option>
								   <option value="ship_length">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'ship_length');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Ship Length';
								  	?>
								  </option>	
								   <option value="ship_length_unit">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'ship_length_unit');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Ship Length Unit';
								  	?>
								  </option>
								   <option value="ship_height">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'ship_height');
								  	     echo $csvHeadLabel ? $csvHeadLabel : ' Ship Height';
								  	?>
								   </option>								   
								   <option value="ship_height_unit">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'ship_height_unit');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Ship Height Unit';
								  	?>
								  </option>
								   <option value="ship_width">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'ship_width');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Ship Width';
								  	?>
								  </option>
								   <option value="ship_width_unit">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'ship_width_unit');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Ship Width Unit';
								  	?>
								   </option>
								   <option value="ship_weight">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'ship_weight');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Ship Weight';
								  	?>
								  </option>
								   <option value="ship_weight_unit">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'ship_weight_unit');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Ship Weight Unit';
								  	?>
								  </option>
								   <option value="master_cartoon">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'master_cartoon');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Master Cartoon';
								  	?>
								  </option>
								   <option value="product_meta_title">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_meta_title');
								  	     echo $csvHeadLabel ? $csvHeadLabel : ' Product Meta Title';
								  	?>
								  </option>
								   <option value="product_meta_keyword">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_meta_keyword');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Product Meta Key';
								  	?>
								  </option>
								   <option value="product_meta_description">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'product_meta_description');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Product Meta Description';
								  	?>
								   </option>
								   <option value="vendor_row_id">
								   <?php							  	    	
								  	    $csvHeadLabel =  getCSVHeadNameOriginal($data['template_info']->template_row_id, 'description');
								  	     echo $csvHeadLabel ? $csvHeadLabel : 'Description';
								  	?>
								  Vendor ID</option>
								   @foreach($data['records'] as $pricetypes)
								   	<option value="PT-{{$pricetypes['customer_group_row_id']}}">Price Type-{{$pricetypes['customer_group_row_id']}}</option>
								   @endforeach
								</select>
								   <div style="margin-top:5px">		
									
								   </div>
							   </td> 
							  <td style="width:35%;">
								<div style="padding:0 0 0 40px;word-wrap: break-word;">
									<div id="csv_head_list">
										<select class="form-control input-medium match_field" name="csv_head_row_id_first_step" style="display: none">
											<?php  
												foreach ($template_fields_array as $key=>$val)
												{
													echo '<option value="' . $key . '">' .  $val . '</option>';
												}
											?>
										</select>
										
										
									</div>								
								</div>		
							  </td>
							  </tr>
							  <tr><td colspan="4">&nbsp;</td></tr>
							
							</table>
						</div>
					</div>
					<div class="form-actions noborder">
						<!--
						<button type="submit" class="btn blue submitBtn">Submit</button>		
						<button type="button" class="btn default" onclick="window.location.href='{{ url('/')}}/manage-import-template'">Cancel</button>
					-->
					</div>
				
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
	</div>
</div>

<div id="csv_head_name_list_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="caption font-green class="modal-title" style="font-size:16px">
						<i class="icon-magic-wand" style="color: #32C5D2;padding-left: 11px"></i>
						<span class="caption-subject bold uppercase">FIELD Automation</span>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					</div>
					
					
				</div>
				<div class="modal-body">
					<form action="{{ URL::to('automated-rules') }}" id="importCsvProductsForm" class="form-horizontal" method="post" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<input type="hidden" name="template_row_id" value="{{ $data['template_info']->template_row_id }}">
						<input type="hidden" name="selected_db_field_name" id="selected_db_field_name">						
						
						<div class="modal_section" style="width:100%;height:350px;overflow-y: auto; overflow-x: hidden">
							
						</div>


				</div>
				<div class="modal-footer">
					<button class="btn default" data-dismiss="modal" aria-hidden="true" style="float:left">Cancel </button>
					<button type="submit" class="btn blue">Save & Finish</button>	
					<button current_step="1" type="button" class="btn green btn-large nextBtn">Next >></button>	
				</div>
				 </form>   
			</div>
		</div>

<div id="csv_head_list_part" style="display: none;">
	<table width="100%" cellspacing="4" cellpadding="4" border="0" cellpadding="10" cellspacing="10" class="csv_head_table" id="csv_head_table_1">
		<tr>
			<td align="left" style="width:20px">&nbsp;</td>
			<td align="left" style="width:400px">
				<div class="form-group">
                    <label style="font-weight: bold; color: #a9a9a9">Choose <span id="current_step_show"></span> field data to add to <span id="selected_field_label"></span></label>
                    <div class="mt-checkbox-list" style="color:#a9a9a9;padding-top: 20px">
                    	<?php  
						foreach ($template_fields_array as $key=>$val) { ?>
                        <label class="mt-checkbox mt-checkbox-outline"> <?php echo $val; ?>
                            <input class="fieldChkBox" type="checkbox" value="<?php echo $val; ?>" name="field[]" />
                            <span></span>
                        </label>
                        <?php } ?>                                                   
                    </div>
                </div>
			</td>						
		</tr>
	</table>
</div>

<div id="separator_part" style="display: none;">
	<table width="100%" cellspacing="4" cellpadding="4"  class="separator_part_table" id="separator_part_table_1">
		<tr>
			<td align="left" style="width:20px;" >&nbsp;</td>
			<td align="left" style="width:400px">
				<div class="form-group">
					<label style="font-weight: bold">Seperator:</label>
					<div class="mt-checkbox-list" style="color:#a9a9a9;padding-top: 10px">                                            	
				   		<input type="text" class="txtSeperator form-control" name="field[]" placeholder="ie: -,_">
			   			<label class="mt-checkbox mt-checkbox-outline"> No Seperator
			        		<input type="checkbox" name="field[]" value="">
			        		<span></span>
			    		</label>
					     <label class="mt-checkbox mt-checkbox-outline">Add a Blank Space
					        <input type="checkbox" name="field[]" value=" ">
					        <span></span>
					    </label>                                          
					</div>
				</div>
			</td>																
		</tr>
	</table>
</div>
<style type="text/css">
.portlet-body form {color:#808080;}
.available_fields {line-height:25px; padding-top:20px}
.available_fields a{padding-right:5px;}
a:hover{text-decoration:none}
.modal_section{min-height:250px;}
.txtSeperator{width:150px; height: 30px; margin: 0 0 15px 0}
</style>

@endsection

@section('page_js')
<script type="text/javascript">
$(".available_field_link") . click( function() {
  var available_field_value = $(this).attr('available_field_value');
	$(".selected_fields").append('<div class="form-group" style="clear:both;padding-top:10px"><div style="float:left;padding-right:10px"><input type="text" class="form-control input-small"  name="template_fields[]" value="' + available_field_value + '"></div><div style="float:left"><input type="text" class="form-control input-small"  name="template_fields_values[]" value="{' + available_field_value + '}"></div>');
});

$(document).ready(function(){
	
	$(".match_field") . change( function() {
	    var selected_item = $(this).val();    	
		var csv_head_row_id = $(this).attr("csv_head_row_id");    
	   $("#match_field_alt_" + csv_head_row_id) . val(selected_item);	   
	});

	$(".submitBtn") . click( function() {
	    var static_assignment = $('#static_assignment').val();
	    if(static_assignment)
	    {
 		  if(static_assignment.search('==') ==  -1)
 		  {
			alert("Static Assignment should contain '=='  \nExample: porduct_sku == 'skuValue' "); 		  	
			return false;	
 		  }
	     
	    }  
	});

	$('#db_fields_list') . change( function() {
	    var selected_field_name = $('#db_fields_list option:selected').val(); 
	    console.log('aa' + $('#db_fields_list option:selected').text()); 
	    $('#csv_head_list_part #selected_field_label').html($('#db_fields_list option:selected').text()); 
	    $('#selected_db_field_name').val(selected_field_name);
        $('#csv_head_name_list_modal').modal('show');  
        $('.nextModalSection').attr('modal_section_id', 1);			
	    $('#current_step_show').html('first');
	    $('.modal_section').html('');
	    //$('#modal_section_2').html('');

	    $('.modal_section').html($('#csv_head_list_part').html());
	    $('.modal_section').show();
	});

	$('.nextBtn') . click(function() {
		//$('.modal_section').hide();
		var current_step = parseInt($(this).attr('current_step'));		
				
		//var maxAllowed = 2;
		var cnt = $(".mt-checkbox-outline .fieldChkBox:checked").length;		
		var maxAllowed =  Math.ceil(current_step/2);
		
		if(cnt > maxAllowed)
		{
			alert('To add more field go to next step, here you can select only one option');
			return false;
		}

		$(this).attr('current_step', current_step+1);
		$('#csv_head_list_part #current_step_show').html('next'); // if you want to show step -2, step-3 etc.
		$('.modal_section').find('.csv_head_table').hide(); 
		$('.modal_section').find('.separator_part_table').hide();

		if(current_step%2==0) {				
			$('.modal_section').append( $('#csv_head_list_part').html());
		} else {
			$('.modal_section').append( $('#separator_part').html());
		}
		
		
	})

	$(".mt-checkbox-outline .fieldChkBox:checked").click(function() {
		alert('checked');
  		//$(".csv_head_table input.fieldChkBox").attr("checked", false); //uncheck all checkboxes
  		//$(this).attr("checked", true);  //check the clicked one
	});

	
});



</script>
@endsection

