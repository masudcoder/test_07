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
					<span class="caption-subject bold uppercase">Change Password</span>
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
				<form role = "form" method="post" action="{{ url('/')}}/updatePassword">
				   {!! csrf_field() !!}
				   
					<div class="form-body">                                           
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="password" class="form-control"  name="current_password" required>
							<label for="form_control_1">Current Password </label>                                               
						</div>
						
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="password" class="form-control"  name="new_password" required>
							<label for="form_control_1">New Password </label>                                               
						</div>
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="password" class="form-control"  name="confirm_new_password" required>
							<label for="form_control_1">Confirm New Password </label>                                               
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
