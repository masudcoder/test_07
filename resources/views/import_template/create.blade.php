@extends('layouts.app')
@section('content')

<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12 ">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">					
					<span class="caption-subject bold uppercase">Setup Import Template</span>
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
				<form role="form" method="post" action="{{ url('/')}}/store-import-template" enctype="multipart/form-data">
				   {!! csrf_field() !!}
				   <input type="hidden" name="edit_row_id" value="{{ isset($data['single_record']) ? $data['single_record']->collection_row_id : '' }}" >
					<div class="form-body"> 
						<div class="form-group row">
							<div class="col-md-2">Name: </div>
							<div class="col-md-10"><input type="text" class="form-control input-large"  name="template_name" value="{{ isset($data['single_record']) ? $data['single_record']->template_name : '' }}" required> </div>
						</div>
						<!--
						<div class="form-group row">
							<div class="col-md-2">Delimiter: </div>
							<div class="col-md-10">
								<label class="mt-checkbox">
									<input type="checkbox" name="skip_first_line" id="skip_first_line" placeholder=""> 
									<span></span>
								</label>
								<span class="checkbox_text">Comma</span>
								<label class="mt-checkbox">
									<input type="checkbox" name="skip_first_line" id="skip_first_line" placeholder=""> 
									<span></span>
								</label>
								<span class="checkbox_text">Tab</span>
								<label class="mt-checkbox">
									<input type="checkbox" name="skip_first_line" id="skip_first_line" placeholder=""> 
									<span></span>
								</label>
								<span class="checkbox_text">Pipe</span>
								
								<label class="mt-checkbox">
									<input type="checkbox" name="skip_first_line" id="skip_first_line" placeholder=""> 
									<span></span>
								</label>
								<span class="checkbox_text">Semicolon</span>
							
							</div>
						</div>
						-->
						<div class="form-group row" style="padding-top:20px">
							<div class="col-md-2">CSV File: </div>
							<div class="col-md-10"><input type="file" name="import_file" required> </div>						
						</div>
						
						<div class="form-group row">							
							<div class="col-md-12">Download a <a href=" {{ url('/')}}/public/csv/product_template.csv"> sample CSV </a> file to see an example of the format.</div>
						</div>
					</div>
					<div class="form-actions noborder">
						<button type="submit" class="btn blue">UPLOAD SAMPLE FILE</button>		
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
.mt-checkbox, .mt-radio { padding-left: 20px;}
.checkbox_text{padding-right:15px}

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
