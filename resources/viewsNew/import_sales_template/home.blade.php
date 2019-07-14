@extends('layouts.app')
@section('content')
					 
 <div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i>
					<span class="caption-subject bold uppercase"> Sales Templates List</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
							<div class="btn-group">
								<button id="sample_editable_1_new" class="btn sbold green" onclick="window.location.href='{{ url('/')}}/add-sales-template'"> Add Sales Template
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
							<th style="width:50px"> # </th>
							<th> Template Name </th>
							<th> Action </th>					
						</tr>
					</thead>
					<tbody>
					
						<?php $i = 1; ?>
							@foreach($data['records']  as $row) 
						   	<tr class="odd gradeX" style="color:#808080">		
								<td> <?php echo $i; $i++; ?></td>
								<td style="padding-left:18px"> {{ $row->template_name }} </td>
								<td> 
									<div class="btn-group">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
									<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="{{ url('/')}}/import-sales-template/{{ $row->sales_template_row_id }}">
											<i class="icon-docs"></i> Edit </a>
										</li>
										<li>
										<a class="deleteLink" deleteID="{{ $row->sales_template_row_id }}" href="javascript:void(0)">
										<i class="icon-tag"></i> Delete </a>
										</li>
									</ul>
									</div> 
								</td>    
								<td>
									<div class="btn-group">
										<button class="btn btn-xs green dropdown-toggle uploadDataBtn" type="button" 	data-toggle="dropdown" sales_template_row_id="{{ $row->sales_template_row_id }}" aria-expanded="false"> 
										<a href="#myModal1"   data-toggle="modal" style="color:#fff; text-decoration: none; width:80px;height:30px">Upload Data</a>
										</button>
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


<div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">

<form action="{{ URL::to('importSalesExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
<input type="hidden" name="sales_template_row_id"  id="sales_template_row_id">
{!! csrf_field() !!}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Import Sales Data </h4>
			</div>
			<div class="modal-body">
				<div style="padding:15px 0 0 0">
					<table width="100%" cellspacing="4" cellpadding="4">
						<tr>
							<td align="left" style="width:150px">Select Template:</td>
							<td align="left">
								<select class="form-control input-medium" name="sales_data_option">
									<option value="1">Add to current data</option>
									<option value="2">Replace data with new file</option>
								</select> 
							</td>							
						</tr>
						<tr><td colspan="2">&nbsp; </td></tr>
						<tr>
							<td align="left" style="width:150px">CSV File:</td>
							<td align="left">
								<input type="file" name="import_file" />
								<div class="csv_format_note">Download a <a href="{{ url('/')}}/public/csv/sample_sales_data.csv"> sample CSV </a> file to see an example of the format.</div>
							</td>							
						</tr>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn default" data-dismiss="modal" aria-hidden="true">Cancel</button>
				 <button class="btn sbold green">Upload File</button>
			</div>
		</div>
	</div>
	
 </form>
   
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
 $('.uploadDataBtn') .click( function() {
  var sales_template_row_id = $(this).attr('sales_template_row_id');
  $('#sales_template_row_id') . val(sales_template_row_id);

 });

 $('.deleteLink').click( function() {
  if( confirm('Are you sure to Delete ? ') )
  {
   var deleteID = $(this).attr('deleteID');   
    window.location.href = "{{ url('/')}}/delete-sales-template/" + deleteID;    
  }
        
 });
 
 </script> 

@endsection