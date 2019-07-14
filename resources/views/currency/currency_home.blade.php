@extends('layouts.app')

@section('content')


 
 
 <div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div>			
			<div class="portlet-body">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
							<div class="btn-group">
								<button id="sample_editable_1_new" class="btn sbold green" onclick="javascript:void(0)"> Add New Currency
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
				
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
		
		<div class="portlet box green">		
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-money"></i>Currency List </div>
					
				<div class="tools">
					<a href="javascript:;" class="collapse"> </a>
					<a href="#portlet-config" data-toggle="modal" class="config"> </a>
					<a href="javascript:;" class="reload"> </a>
					<a href="javascript:;" class="remove"> </a>
				</div>
			</div>
			
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th> # </th>
								<th style="width:30%"> Currency Name </th>	
								<th> Currency Icon </th>								
								<th> Action </th>								
							</tr>
						</thead>
						<tbody>
						    <?php $i = 1; ?>
							@foreach($data['records']  as $row) 
						   <tr>
								<td> <?php echo $i; $i++; ?></td>
								<td> {{ $row->currency_name }} </td>	
								<td> {{ $row->currency_icon }} </td>								
								<td> 
									<div class="btn-group">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
									<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
									<li>
									<a href="#">
									<i class="icon-docs"></i> Edit </a>
									</li>
									<li>
									<a class="deleteLinkssss" deleteID="{{ $row->currency_row_id }}" href="javascript:void(0)">
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
        </div>		
	</div>
</div> 

@endsection

@section('page_js')
 <script type="text/javascript"> 
 $('.deleteLink').click( function() {
  if( confirm('Are you sure to Delete ? ') )
  {
   var deleteID = $(this).attr('deleteID');      
    window.location.href = "{{ url('/')}}/delete-product-type/" + deleteID;    
  }
        
 }); 
 </script> 
 @endsection