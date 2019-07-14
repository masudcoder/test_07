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
					<span class="caption-subject bold uppercase"> Add New</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="{{ url('/')}}/manageUnit" >
				   {!! csrf_field() !!}
					<div class="form-body">                                           
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="text" class="form-control"  name="product_name" required>
							<label for="form_control_1"> Name </label>                                               
						</div>
						
								
						
					</div>
					<div class="form-actions noborder">
						<button type="submit" class="btn blue">Submit</button>									 
						
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
	</div>
</div>
@endsection
