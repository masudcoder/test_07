@extends('layouts.app')
@section('content')                  
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">					
					<span class="caption-subject bold uppercase"> Descriptions List</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
							<div class="btn-group">
								<button id="sample_editable_1_new" class="btn sbold green" onclick="window.location.href='{{ url('/')}}/add-description'"> Add New Description
									<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="col-md-6">
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
				</div>
				<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
					<thead>
						<tr>
							<th> # </th>
							<th> Description Title </th>	
							<th> Description </th>								
							<th> Action </th>					
						</tr>
					</thead>
					<tbody>					
					 <?php $i = 1; ?>
							@foreach($data['records']  as $row) 
						   	<tr class="odd gradeX">		
								<td> <?php echo $i; $i++; ?></td>
								<td> {{ $row->description_name }} </td>
								<td> {!! str_limit($row->description_text, 50) !!} </td>
								<td> 
									<div class="btn-group">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="{{ url('/')}}/edit-description/{{ $row->description_row_id }}">
												<i class="icon-docs"></i> Edit </a>
											</li>
											<li>
												<a class="deleteLink" deleteID="{{ $row->description_row_id }}" href="javascript:void(0)">
												<i class="icon-tag"></i> Delete </a>
											</li>
										</ul>
									</div> 
								</td>                                                    
							</tr>      
						@endforeach	
						
						
						
						</tbody>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>


@endsection

@section('datatable-css')
	<link href="{{asset('/')}}/public/css/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/public/css/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
@endsection

@section('datatable-js')
    <script src="{{asset('/')}}/public/css/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{asset('/')}}/public/css/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="{{asset('/')}}/public/css/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
@endsection
@section('datatable-js-2')
<script src="{{asset('/')}}/public/css/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
@endsection

@section('page_js')



 <script type="text/javascript"> 
 $('.deleteLink').click( function() {
  if( confirm('Are you sure to Delete ? ') )
  {
   var deleteID = $(this).attr('deleteID');   
    window.location.href = "{{ url('/')}}/delete-description/" + deleteID;    
  }
        
 });
 
 </script> 

@endsection