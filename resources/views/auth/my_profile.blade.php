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
					<span class="caption-subject bold uppercase">Update Profile</span>
				</div>
				<div class="actions">
					@if(Session::has('success-message'))
						<div class="alert alert-success">
						<strong>Success!</strong> {{ Session::get('success-message') }}
						</div>
						@endif

						@if(Session::has('error-message'))
						<div class="alert alert-danger">
						<strong>Error!</strong> {{ Session::get('error-message') }}
						</div>								
					@endif
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="{{ url('/')}}/updateProfile">
				   {!! csrf_field() !!}
				   
					<div class="form-body">                                           
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="text" class="form-control"  name="name" value="{{ $data['user']->name }}" required>
							<label for="form_control_1">Name </label>                                               
						</div>
						
						<div class="form-group form-md-line-input form-md-floating-label">							
							<input type="text" class="form-control"  name="company_name" value="{{ $data['user']->company_name }}" >
							<label for="form_control_1">Company Name</label>
						</div> 
						
					    <div class="form-group form-md-line-input form-md-floating-label">
							<input type="text" class="form-control"  name="phone" value="{{ $data['user']->phone }}">
							<label for="form_control_1">phone </label>                                               
						</div> 						
					</div>
					<div class="form-actions noborder">
						<button type="submit" class="btn blue">Submit</button>	
						<button type="button" class="btn default" onclick="window.location.href='{{ url('/')}}/home'">Cancel</button>	
						
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
	</div>
</div>
@endsection
