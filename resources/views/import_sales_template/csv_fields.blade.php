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
				<form role = "form" method="post" action="{{ url('/')}}/import-sales-template">
				   {!! csrf_field() !!}
				   <input type="hidden" name="template_row_id" value="{{ $data['template_info']->sales_template_row_id }}" >
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
								<!--<p class="muted">Values to be filled in manually if they do not appear in your import template.</p>-->
								<textarea name="manual_mapping" style="width: 90%; height: 70px; color:#000000" placeholder="csv_field_name = db_field_value"><?php echo isset($data['template_info']->manual_mapping )  ? $data['template_info']->manual_mapping : ''  ?></textarea>
							</div>
							<div>
								<div style="font-weight:bold;padding-bottom:10px">Static Assignment</div>
								<!--<p class="muted">Values to be filled in manually if they do not appear in your import template.</p>-->
								<textarea name="static_assignment" id="static_assignment" style="width: 90%; height: 70px; color:#000000" placeholder="field_name == static value"><?php echo isset($data['template_info']->static_assignment )  ? $data['template_info']->static_assignment : ''  ?></textarea>
							</div>
						</div>
                    </div>
					
					<div class="form-group" style="padding-top:30px">
						<span style="color:#a9a9a9;font-weight:bold;">Match Fields:</span>
					</div>
						
					<div class="form-group">
						<table width="100%" border="0" >
						  <tr style="color:#a9a9a9;font-weight:bold"> 
						  <td style="width:5%;padding-right:5px"> # </td> 
						  <td style="width:35%;">First Row </td> 
						  <td style="width:25%;">Field Setup </td>
						  <td style="width:35%;" >Sample Data </td> 
						  </tr>
						  <tr><td colspan="4">&nbsp;</td></tr>
						<?php 
							$template_fields = $data['template_info']->template_fields;
							$template_fields_array = json_decode($template_fields);
							$sample_data_array = json_decode($data['template_info']->sample_data, true);
						
						?>	
						<?php 
						$csv_field_db_mapping = json_decode ($data['template_info']->csv_field_db_mapping);
						$count = 1;
						
						foreach ($template_fields_array as $key => $val) 
						{ ?>
						  <tr> 
						  <td style="width:5%;padding-right:5px"><?php echo $count; $count++; ?></td> 
						  <td style="width:35%;padding-right:25px"><?php echo $val; ?>:</td> 
						  <td style="width:25%;padding-left:25px">
							<select class="form-control input-medium match_field" name="head_replace_to[]" >
							   <option value="">Skip</option>
							   <option value="order_id">Order ID</option>
							   <option value="order_date">Date</option>
							   <option value="customer_info">Customer Info</option>
							   <option value="product_name">Product Name</option>							   
							   <option value="product_sku">Product SKU</option>
							   <option value="upc">UPC</option>
							   <option value="product_price">Product Price</option>
							   <option value="quantity">Quantity</option>								   
							   <option value="total_amount">Total Amount</option>							   
							</select>
							<div style="margin-top:5px">		
									<?php $csv_head_name = $val; ?>
									<input type="text" name="csv_field_db_mapping[<?php echo $val; ?>]"  value="<?php echo isset($csv_field_db_mapping->$csv_head_name) ? $csv_field_db_mapping->$csv_head_name : ''; ?>" placeholder="New Field Name" class="form-control input-medium match_field_alt" >
							</div>
						   </td> 
						  <td style="width:35%;">
							<div style="padding:0 0 0 40px;word-wrap: break-word;">
						
								<?php 
							
								foreach ($sample_data_array as $key => $value) {
									if (array_key_exists($val, $value)) {

											echo str_replace(',', '<br />', $value[$val] );
										
									}
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
						<button type="submit" class="btn blue submitBtn">Submit</button>		
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

$(document).ready(function() {
	
	$(".match_field") . change( function() {
	    var selected_item = $(this).val();
		$(this).next().find('.match_field_alt').val(selected_item);
	});

	$(".submitBtn") . click( function() {
	    var static_assignment = $('#static_assignment').val();
	    if(static_assignment) {
 		  if(static_assignment.search('==') ==  -1) {
				alert("Static Assignment should contain '=='  \nExample: porduct_sku == 'skuValue' "); 		  	
				return false;	
 		  }	     
	    }
	});
});
</script>
@endsection

@endsection
