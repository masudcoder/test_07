@extends('layouts.app')

@section('datatable-css')		        
 <link href="{{asset('/')}}public/css/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
 <link href="{{asset('/')}}public/css/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css" rel="stylesheet" type="text/css" />
@endsection
 

@section('content')
		
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">	
	<div class="col-md-12 ">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="icon-pin font-green"></i>
					<span class="caption-subject bold uppercase"> Add New Tag </span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="{{ url('/')}}/store-tag">
				   {!! csrf_field() !!}
				   
				   <input type="hidden" name="edit_row_id" value="{{ isset($data['single_record']) ? $data['single_record']->tag_row_id : '' }}" >
					<div class="form-body">
						<div class="form-group form-md-line-input form-md-floating-label">
							<select class="form-control input-small"  name="tag_group_row_id" required >
							@if( isset($data['single_record']) )
							   @foreach( $data['tag_groups']  as $row ) 
									<option value="{{ $row->tag_group_row_id}}" @if( $row->tag_group_row_id == $data['single_record']->tag_group_row_id) selected @endif>{{ $row->tag_group_name}} </option>								
								@endforeach							
							@else
								<option value="none">Select </option>				
							   @foreach( $data['tag_groups']  as $row ) 
									<option value="{{ $row->tag_group_row_id}}" >{{ $row->tag_group_name}} </option>								
								@endforeach
							@endif	
							</select>
							<label for="form_control_1">Select Tag Group </label>                                               
						</div>		
						
						<div class="form-group form-md-line-input form-md-floating-label">
						 <span style="margin: 0 0 10px 0">Tag Name</span>
						<input type="text" name="tag_name" class="form-control input-large" value="{{ isset($data['single_record']) ? $data['single_record']->tag_name : '' }}" data-role="tagsinput">
						   
							<!--input type="text" class="form-control"  name="tag_name" value="" required-->
							                                              
						</div>			
						
					</div>
					<div class="form-actions noborder">
						<button type="submit" class="btn blue">Submit</button>		
						<button type="button" class="btn default" onclick="window.location.href='{{ url('/')}}/manage-tag'">Cancel</button>					
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
	</div>
</div>
@endsection

@section('select2js')		

<script src="{{asset('/')}}public/css/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}public/css/assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}public/css/assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
@endsection
		
@section('after-app-js')			
		<script src="{{asset('/')}}public/css/assets/pages/scripts/components-bootstrap-tagsinput.min.js" type="text/javascript"></script>
@endsection		
		
