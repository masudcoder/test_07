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
						
						<div class="form-group">
							<table width="100%" border="0" cellspacing="4" cellpadding="4">
							    <tr>
									
									<td width="60%">
										<table width="100%" cellspacing="4" cellpadding="4">
										    <tr>
											<td align="left" style="width:200px">Template Name: </td>
											<td align="left"> 
												<input type="text" class="form-control input-medium"  name="template_name" value="{{ isset($data['template_info']) ? $data['template_info']->template_name : '' }}" required>
											</td>
											</tr>
											<tr><td colspan="2">&nbsp;</td></tr>
											<!--
											<tr>
											<td align="left" style="width:200px">Order Match Column:</td>
											<td align="left">
											<?php $count_fields = $data['template_info']->count_fields; ?>
												<select class="form-control input-medium" name="order_match_column"> 
													<option value="">None</option>
													<?php for($i=1; $i<=$count_fields; $i++) { ?>
														<option> Column <?php echo $i; ?> </option>
													<?php } ?>
												</select>
												<div style="font-size:12px">This column indicates that multiple lines<br /> belong to the same order.</div>
											</td>							
											</tr>
											-->
											
											<tr><td colspan="2">&nbsp;</td></tr>											
											<tr>											
											<td align="left" colspan="2"> 
												<label class="mt-checkbox"> 
												<input type="checkbox" @if ( $data['template_info']->skip_first_line ) checked="checked" @endif  name="skip_first_line" id="skip_first_line" placeholder=""> 
												<span></span>
												</label>
												Skip First Line 
											</td>
											</tr>
											<tr><td colspan="2">&nbsp;</td></tr>											
											<tr>											
											<td align="left" colspan="2"> 
												<label class="mt-checkbox">
													<input type="checkbox" @if ( $data['template_info']->send_email_confirmation ) checked="checked" @endif  name="send_email_confirmation" id="send_email_confirmation" placeholder=""> 
													<span></span>
												</label>
												Send Email Confirmation 
											</td>
											</tr>
											
											
										</table>
									</td>	
									
									<td width="40%">
										<table width="100%" cellspacing="4" cellpadding="4">
											<tr>
											<td align="left">
												<div style="font-weight:bold;padding-bottom:10px">Manual Mapping</div>
												<p class="muted">Values to be filled in manually if they do not appear in your import template.</p>
												<textarea name="manual_mapping" style="width: 90%; height: 120px;" placeholder="field_name = field_value"><?php echo isset($data['template_info']->manual_mapping )  ? $data['template_info']->manual_mapping : ''  ?></textarea>
											</td>																
											</tr>
										</table>
									</td>	
							    </tr>
							</table>
						</div>
												
						<div class="form-group" style="padding-top:30px">
							<span style="color:#a9a9a9;font-weight:bold;">Match Fields:</span>
						</div>						
						<div class="form-group">
							<table width="100%" border="0" >
							  <tr style="color:#a9a9a9;font-weight:bold"> 
							  <td style="width:15%"> # </td> 
							  <td style="width:25%">First Row </td> 
							  <td style="width:30%">Field Setup </td> 
							  
							  <td style="width:30%;padding:0 0 0 40px">Sample Data </td> 
							  </tr>
							  <tr><td colspan="4">&nbsp;</td></tr>
							<?php 
								$template_fields = $data['template_info']->template_fields;
								$template_fields_array = json_decode($template_fields);
								$template_csv_heads = DB::table('template_csv_heads')->where('template_row_id', $data['template_info']->template_row_id)->get();
							?>	
							<?php 
							//for($i=0; $i<count($template_fields_array); $i++ ) 
							$count = 1;
							foreach ($template_csv_heads as $key => $csvHead) 
							{ ?>
							  <tr> 
							  <td style="width:15%"><?php echo $count; $count++; ?> </td> 
							  <td style="width:25%"><?php echo $csvHead->csv_head_name ?>:</td> 
							  <td style="width:30%">
								   <select class="form-control input-medium match_field"  csv_head_row_id="{{ $csvHead->csv_head_row_id}}" >								  
								   <option value="Field"> Skip</option>
								   <option value="name">Name</option>
								   <option value="sku">SKU</option>
								   <option value="vendor_sku">Vendor SKU</option>
								   <option value="price">Price</option>
								   <option value="upc">UPC</option>
								   <option value="Description">Description</option>
								   <option value="image">Image</option>
								   <option value="image_alt_text">Image Alt Text</option>
								   <option value="height">Height</option>
								   <option value="height_unit">Height Unit</option>								   
								   <option value="width">Width</option>
								   <option value="width_unit">Width Unit</option>
								   <option value="length">Length</option>
								   <option value="length_unit">Length Unit</option>
								   <option value="weight">Weight</option>
								   <option value="weight_unit">Weight Unit</option>
								   <option value="meta_title">Meta Title</option>
								   <option value="meta_key">Meta Key</option>
								   <option value="meta_description">Meta Description</option>
								   </select>
								   <div style="margin-top:5px"><input type="text" class="form-control input-medium match_field_alt"  id="match_field_alt_{{ $csvHead->csv_head_row_id}}" ></div>
							   </td> 
							  <td style="width:30%">
								<div style="padding:0 0 0 40px;">
								<?php $template_csv_head_values = DB::table('template_csv_values')->where('csv_head_row_id', $csvHead->csv_head_row_id)->get();?>
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
});

});



</script>
@endsection

@endsection
