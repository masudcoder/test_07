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
					<span class="caption-subject bold uppercase"> Add New Product Type </span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="{{ url('/')}}/store-product-type">
				   {!! csrf_field() !!}
				   <input type="hidden" name="edit_row_id" value="{{ isset($data['single_record']) ? $data['single_record']->product_type_row_id : '' }}" >
					<div class="form-body">                                           
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="text" class="form-control"  name="product_type_name" value="{{ isset($data['single_record']) ? $data['single_record']->product_type_name : '' }}" required>
							<label for="form_control_1">Product Type Name </label>                                               
						</div>			
						
						<div class="form-group form-md-line-input form-md-floating-label">
							<textarea class="form-control" rows="3" name="product_type_short_description">{{ isset($data['single_record']) ? $data['single_record']->product_type_short_description : '' }}</textarea>
							<label for="form_control_1"> Description</label>							
						</div>   
						
					</div>
					<div class="form-actions noborder">
						<button type="submit" class="btn blue">Submit</button>		
						<button type="button" class="btn default" onclick="window.location.href='{{ url('/')}}/manage-product-type'">Cancel</button>					
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
	</div>
</div>
@endsection
