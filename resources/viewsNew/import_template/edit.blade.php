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
					
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="">
				   {!! csrf_field() !!}
				   <input type="hidden" name="edit_row_id" value="{{ isset($data['single_record']) ? $data['single_record']->collection_row_id : '' }}" >
					<div class="form-body">                                           
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="text" class="form-control"  name="template_name" value="{{ isset($data['single_record']) ? $data['single_record']->template_name : '' }}" required>
							<label for="form_control_1">Template Name</label>                                               
						</div>
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="text" class="form-control"  name="file_name" value="{{ isset($data['single_record']) ? $data['single_record']->file_name : '' }}" >
							<label for="form_control_1">File Name </label>                                               
						</div>
					                                       
						<div class="row">
							<div class="col-md-6">
								Selected Fields
								<div class="form-body selected_fields">
									                                              
								</div>
							</div>
							
							<div class="col-md-6">
							Available Fields
								<div class="available_fields">
									<a href="javascript:void(0)" class="available_field_link" available_field_value="name" >Product Name</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="price">Price</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="weight">Weight</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="code">Code</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="barcode">Barcode</a>,
									
									<a href="javascript:void(0)" class="available_field_link" available_field_value="description" >Description</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="vendor">Vendor</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="category">Category</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="product type">Product Type</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="primary image">Primary Image</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="secondary image" >Secondary Image</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="production art">Production Art</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="length">Length</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="width">Width</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="height">Height</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="cost" >Cost</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="stock level">Stock Level</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="inventory serial">Inventory Serial</a>,
									<a href="javascript:void(0)" class="available_field_link" available_field_value="update source">Update Source</a>
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
.available_fields {line-height:25px;}
.available_fields a{padding:0 0 0 5px;}
</style>

@section('page_js')
<script type="text/javascript">
$(".available_field_link") . click( function() {
  var available_field_value = $(this).attr('available_field_value');
	$(".selected_fields").append('<div class="form-group" style="clear:both;padding-top:10px"><div style="float:left;padding-right:10px"><input type="text" class="form-control input-small"  name="template_fields[]" value="' + available_field_value + '"></div><div style="float:left"><input type="text" class="form-control input-small"  name="template_fields_values[]" value="{' + available_field_value + '}"></div>');
});
</script>
@endsection

@endsection
