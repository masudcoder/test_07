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
					<span class="caption-subject bold uppercase"> Add Export Template</span>
				</div>
				<div class="actions">	
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
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="{{ url('/')}}/store-export-template">
				   {!! csrf_field() !!}
				   <input type="hidden" name="edit_row_id" value="{{ isset($data['single_record']) ? $data['single_record']->collection_row_id : '' }}" >
					<div class="form-body">                                           
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="text" class="form-control"  name="template_name" value="{{ isset($data['single_record']) ? $data['single_record']->template_name : '' }}" required>
							<label for="form_control_1">Template Name</label>                                               
						</div>
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="text" class="form-control"  name="file_name" value="{{ isset($data['single_record']) ? $data['single_record']->file_name : '' }}" >
							<label for="form_control_1">Export File Name </label>                                               
						</div>					                                       
						<div class="row">
							<div class="col-md-6">
								<span style="color:#a9a9a9;font-weight:bold">Selected Fields:</span>
								<div class="form-body selected_fields"></div>
							</div>
							<div class="col-md-6">
							<span style="color:#a9a9a9;font-weight:bold">General:</span>
								<div class="available_fields">
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_name" >Product Name,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="handle" >Product Handle,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="handle_url" >Product Url,</a>									
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_sku">Code/Sku,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="vendor_sku">Vendor Sku,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="aku_code">AKU,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="upc">Barcode/UPC,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="vendor_row_id">Vendor,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="category_row_id">Category,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_type_row_id">Product Type,</a>

									<a href="javascript:void(0)" class="available_field_link" available_field_value="description" >Description,</a>				
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_image">Primary Image,</a>	
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_secondary_images">Secondary Image(s),</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="production_art_url_1">Production Art Url 1,</a>	
									<a href="javascript:void(0)" class="available_field_link" available_field_value="production_art_url_2">Production Art Url 2,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="print_mode">Print Mode,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="print_location">Print Location 1,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="print_location2">Print Location 2,</a>

									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_price">Price,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_price_unit">Price Unit,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="inventory_serial">Inventory Serial,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="update_source">Update Source,</a>									
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_meta_title">Meta Title,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_meta_keyword">Meta Keyword,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_meta_description">Meta Description</a>
								</div>
								<span style="color:#a9a9a9;font-weight:bold;"><br />Details:</span>
								<div class="available_fields">
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_weight">Weight,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_weight_unit"> Weight Length,</a>	
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_length">Length,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_length_unit">Length Unit,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_width">Width,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_width_unit">Width Unit,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_height">Height,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_height_unit">Height Unit,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_cost">Cost,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product_stock">Stock Level,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="number_of_pieces">Number of Pieces</a>
								</div>

								<span style="color:#a9a9a9;font-weight:bold;"><br />Price Level:</span>
								<div class="available_fields">
									@foreach($data['price_list'] as $priceList)
										<a href="javascript:void(0)" class="available_field_link" available_field_value="PT-{{ $priceList->customer_group_row_id }}">{{ $priceList->customer_group_name }},</a>
									@endforeach
								</div>

								<span style="color:#a9a9a9;font-weight:bold;"><br />Shipping:</span>
								<div class="available_fields">
									<a href="javascript:void(0)" class="available_field_link" available_field_value="ship_cartoon">Ship Cartoon,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="ship_weight">Ship Weight,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="ship_weight_unit">Ship Weight Unit,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="ship_length">Ship Length,</a>									
									<a href="javascript:void(0)" class="available_field_link" available_field_value="ship_length_unit">Ship Length Unit,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="ship_height">Ship Height,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="ship_height_unit">Ship Height Unit,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="ship_width">Ship Width,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="ship_width_unit">Ship Width Unit</a>
								</div>

								<span style="color:#a9a9a9;font-weight:bold;"><br/>Dynamic Fields:</span>
								
								<div class="available_fields">
									@foreach($data['dynamic_fields'] as $key => $val)
										<a href="javascript:void(0)" class="available_field_link" available_field_value="{{$key}}">{{ $val }},</a>
									@endforeach
								</div>

								<span style="color:#a9a9a9;font-weight:bold;"><br />Sales Data:</span>
								<div class="available_fields">
									<a href="javascript:void(0)" class="available_field_link" available_field_value="total_amount">Sales Total Amount,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="quantity">Quantity,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="order_id">Sales Order Id,</a>
									<a href="javascript:void(0)" class="available_field_link" available_field_value="customer_info">Customer Info</a>
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions noborder">
						<button type="submit" class="btn blue">Submit</button>		
						<button type="button" class="btn default" onclick="window.location.href='{{ url('/')}}/manage-export-template'">Cancel</button>					
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
	</div>
</div>
<style type="text/css">
.available_fields {line-height:25px; padding-top:20px}

a:hover{text-decoration:none}
</style>

@section('page_js')
<script type="text/javascript">
$(".available_field_link") . click( function() {
  var available_field_value = $(this).attr('available_field_value');
	$(".selected_fields").append('<div class="form-group" style="clear:both;padding-top:10px"><div style="float:left;padding-right:10px"><input type="text" class="form-control input-small"  name="template_fields[]" value="' + available_field_value + '"></div><div style="float:left"><input type="text" class="form-control input-small"  name="template_fields_values[]" value="{' + available_field_value + '}"> </div><div style="float:left;padding:7px 0 0 10px"><a href="javascript:void(0)" class="deleteOptionLink"> Delete </a> </div></div>');

	$('.deleteOptionLink') .click(  function() {	  
	  $(this).parent().parent().remove();
	});	
	
});

</script>
@endsection

@endsection
