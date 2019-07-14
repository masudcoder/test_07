@extends('layouts.app')
@section('content')

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12 ">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="icon-pin font-green"></i>
					<span class="caption-subject bold uppercase"> Add Import Template</span>
				</div>
				<div class="actions">					
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="{{ url('/')}}/import-template">
				   {!! csrf_field() !!}
				   <input type="hidden" name="template_row_id" value="{{ $data['template_info']->template_row_id }}" >
					<div class="form-body"> 
					 <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <!-- BEGIN SAMPLE FORM PORTLET-->
                            <div>
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
                               
                                <div class="portlet-body form">										
									<div class="row" style="padding-top:50px">
										<div class="col-md-4 col-sm-4">Template Name: </div>
										<div class="col-md-8 col-sm-8"><input type="text" class="form-control input-medium"  name="template_name" value="{{ isset($data['template_info']) ? $data['template_info']->template_name : '' }}" required></div>
									</div>											
									<div class="row" style="padding-top:20px">
										<div class="col-md-12 col-sm-12"><label class="mt-checkbox"> 
											<input type="checkbox" @if ( $data['template_info']->skip_first_line ) checked="checked" @endif  name="skip_first_line" id="skip_first_line" placeholder=""> 
											<span></span>
											</label>
											Skip First Line 
										</div>
									</div>	
										
									<div class="row" style="padding-top:20px">
										<div class="col-md-12 col-sm-12">
											<label class="mt-checkbox">
												<input type="checkbox" @if ( $data['template_info']->send_email_confirmation ) checked="checked" @endif  name="send_email_confirmation" id="send_email_confirmation" placeholder=""> 
												<span></span>
											</label>
											Send Email Confirmation 
										</div>
										
									</div>
                                </div>
                            </div>
                          
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div>
							
								<div style="font-weight:bold;padding-bottom:10px">Manual Mapping</div>
								<p class="muted">Values to be filled in manually if they do not appear in your import template.</p>
								<textarea name="manual_mapping" style="width: 90%; height: 120px; color:#000000" placeholder="csv_field_name = db_field_value"><?php echo isset($data['template_info']->manual_mapping )  ? $data['template_info']->manual_mapping : ''  ?></textarea>
							</div>
						</div>
                    </div>
					
						<div class="form-group" style="padding-top:30px">
							<span style="color:#a9a9a9;font-weight:bold;">Match Fields:</span>
						</div>
						
						<div class="form-group">
							<table width="100%" border="0" >
							  <tr style="color:#a9a9a9;font-weight:bold"> 
							  <td style="width:5%"> # </td> 
							  <td style="width:25%">First Row </td> 
							  <td style="width:25%">Field Setup </td>
							  <td style="padding:0 0 0 40px" >Sample Data </td> 
							  </tr>
							  <tr><td colspan="4">&nbsp;</td></tr>
							<?php 
								$template_fields = $data['template_info']->template_fields;
								$template_fields_array = json_decode($template_fields);
								$template_csv_heads = DB::table('template_csv_heads')->where('template_row_id', $data['template_info']->template_row_id)->get();
								
							?>	
							<?php 
							$csv_field_db_mapping = json_decode ($data['template_info']->csv_field_db_mapping);
							
							$count = 1;
							
							$vendor_option = '';
							if($data['vendors_list']) {
								foreach($data['vendors_list'] as $vendor_info) {
									$vendor_option .= '<option value="vendorField_' . $vendor_info->vendor_row_id .'">' . $vendor_info->vendor_name . '</option>';
								}
							}
							
							$collection_option = '';
							if($data['collections_list']) {
								foreach($data['collections_list'] as $collection_info) {
									$collection_option .= '<option value="collectionField_' . $collection_info->collection_row_id .'">' . $collection_info->collection_name . '</option>';
								}
							}
							
							$category_option = '';
							if($data['categories_list']) {
								foreach($data['categories_list'] as $category_info) {
									$category_option .= '<option value="categoryField_' . $category_info->category_row_id .'">' . $category_info->category_name . '</option>';
								}
							}	
							
							
							$product_type_option = '';
							if($data['product_types_list']) {
								foreach($data['product_types_list'] as $product_types_info) {
									$product_type_option .= '<option value="productTypeField_' . $product_types_info->product_type_row_id .'">' . $product_types_info->product_type_name . '</option>';
								}
							}
							
							
							$price_level_option = '';
							if($data['price_levels_list']) {
								foreach($data['price_levels_list'] as $price_level_info) {
									$price_level_option .= '<option value="priceLevelField_' . $price_level_info->customer_group_row_id .'">' . $price_level_info->customer_group_name . '</option>';
								}
							}
							
							foreach ($template_csv_heads as $key => $csvHead) 
							{ ?>
							  <tr> 
							  <td style="width:5%;padding-right:5px"><?php echo $count; $count++; ?></td> 
							  <td style="width:25%;padding-right:5px"><?php echo $csvHead->csv_head_name_original; ?>:</td> 
							  <td style="width:25%;padding-left:25px">
								<select class="form-control input-medium match_field" name="head_replace_to[]" csv_head_row_id="{{ $csvHead->csv_head_row_id}}" >								  
								   <option value="Field">Skip</option>
								   <option value="product_name">Product Name</option>								   								   
								   <option value="handle">Handle</option>
								   <option value="product_sku">Product SKU</option>
								   <option value="vendor_sku">Vendor SKU</option>
								   <option value="aku_code">AKU Code</option>
								   <option value="product_price">Product Price</option>
								   <option value="product_price_unit">Product Price Unit</option>									   
								   <option value="upc">UPC</option>	
								   <option value="description">Description</option>									   								   
								   <option value="product_image">Product Image</option>
								   <option value="product_secondary_images">Product Secondary Images</option>
								   <option value="uploaded_design_image">Production Art</option>
								   <option value="print_mode">Print Mode</option>
								   <option value="print_file">Print File</option>
								   <option value="print_location">Print Location</option>
								   <option value="print_location2">Print Location2</option>
								   <option value="product_length">Length</option>								   
								   <option value="product_length_unit">Length Unit</option>
								   <option value="product_height">Height</option>		
								   <option value="product_height_unit">Height Unit</option>
								   <option value="product_width">Width</option>
								   <option value="product_width_unit">Width Unit</option>
								   <option value="product_weight">Weight</option>	
								   <option value="product_weight_unit">Weight Unit</option>
								   <option value="product_cost">Product Cost</option>
								   <option value="product_stock">Stock Level</option>	
								   <option value="inventory_serial">Inventory Serial</option>								   
								   <option value="number_of_pieces">Number of Pieces</option>								   							   
								   <option value="ship_length">Ship Length</option>	
									<option value="ship_length_unit">Ship Length Unit</option>
								   <option value="ship_height">Ship Height</option>								   
								   <option value="ship_height_unit">Ship Height Unit</option>
								   <option value="ship_width">Ship Width</option>
								   <option value="ship_width_unit">Ship Width Unit</option>
								   <option value="ship_weight">Ship Weight</option>
								   <option value="ship_weight_unit">Ship Weight Unit</option>
								   <option value="master_cartoon">Master Cartoon</option>
								   <option value="product_meta_title">Meta Title</option>
								   <option value="product_meta_keyword">Meta Key</option>
								   <option value="product_meta_description">Meta Description</option>
								   <?php echo $vendor_option . $collection_option . $category_option . $price_level_option . $product_type_option; ?>
								</select>
								   <div style="margin-top:5px">		
									<?php $csv_head_name = $csvHead->csv_head_name; ?>
									<input type="text" name="csv_field_db_mapping[<?php echo $csvHead->csv_head_name; ?>]"  value="<?php echo isset($csv_field_db_mapping->$csv_head_name) ? $csv_field_db_mapping->$csv_head_name : ''; ?>" placeholder="New Field Name" class="form-control input-medium match_field_alt"  id="match_field_alt_{{ $csvHead->csv_head_row_id}}" >
								   </div>
							   </td> 
							  <td>
								<div style="padding:0 0 0 40px;word-wrap: break-word;">
								<?php $template_csv_head_values = DB::table('template_csv_values')->where('csv_head_row_id', $csvHead->csv_head_row_id)->take(5)->get();?>
								<?php  
									foreach ($template_csv_head_values as $csvHeadValue)
									{
										echo $csvHeadValue->csv_value_name;
										echo '<br />';
									}
								?>
								</div>		
							  </td>
							  </tr>
							  <tr><td colspan="4">&nbsp;</td></tr>
							<?php } ?>
							</table>
						</div>
					</div>
					<div class="form-actions noborder">
						<button type="submit" class="btn blue">Submit</button>		
						<button type="button" class="btn default" onclick="window.location.href='{{ url('/')}}/manage-import-template'">Cancel</button>					
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
	</div>
</div>
<style type="text/css">
.portlet-body form {color:#808080;}
.available_fields {line-height:25px; padding-top:20px}
.available_fields a{padding-right:5px;}
a:hover{text-decoration:none}



</style>

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
   $(this).find('option:first').remove();
   
});

});



</script>
@endsection

@endsection
