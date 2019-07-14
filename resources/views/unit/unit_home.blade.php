@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i>
					<span class="caption-subject bold uppercase"> Units List</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
							<div class="btn-group">
								<button id="sample_editable_1_new" class="btn sbold green" onclick="window.location.href='{{ url('/')}}/createUnit'"> Add New
									<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="col-md-6">
						<!--
							<div class="btn-group pull-right">
								<button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
									<i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right">
									<li>
										<a href="javascript:;">
											<i class="fa fa-print"></i> Print </a>
									</li>
									<li>
										<a href="javascript:;">
											<i class="fa fa-file-pdf-o"></i> Save as PDF </a>
									</li>
									<li>
										<a href="javascript:;">
											<i class="fa fa-file-excel-o"></i> Export to Excel </a>
									</li>
								</ul>
							</div>
							-->
						</div>
					</div>
				</div>
				<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
					<thead>
						<tr>
							
							<th>Unit Name</th>    						
							
							<th>Action</th>							
						</tr>
					</thead>
					<tbody>
					
						<tr class="odd gradeX">							
							<td> Inch(s)</td> 
														 
							<td>							
								<div class="btn-group">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
										<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="javascript:;">
												<i class="icon-docs"></i> Edit </a>
										</li>
										<li>
											<a href="javascript:;">
												<i class="icon-tag"></i> Delete </a>
										</li>
										
									</ul>
								</div>
							</td>
						</tr>			

					<tr class="odd gradeX">							
							<td> Meter(s)</td> 
													 
							<td>							
								<div class="btn-group">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
										<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="javascript:;">
												<i class="icon-docs"></i> Edit </a>
										</li>
										<li>
											<a href="javascript:;">
												<i class="icon-tag"></i> Delete </a>
										</li>
										
									</ul>
								</div>
							</td>
						</tr>	
						
						<tr class="odd gradeX">							
							<td> Ft</td> 
													 
							<td>							
								<div class="btn-group">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
										<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="javascript:;">
												<i class="icon-docs"></i> Edit </a>
										</li>
										<li>
											<a href="javascript:;">
												<i class="icon-tag"></i> Delete </a>
										</li>
										
									</ul>
								</div>
							</td>
						</tr>	
						
						
						</tbody>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
 <script type="text/javascript"> 
 $('.deleteLink').click( function() {
  if( confirm('Are you sure to Delete ? ') )
  {
   var deleteID = $(this).attr('deleteID');   
    window.location.href = "{{ url('/')}}/products/deleteRecord/" + deleteID;    
  }
        
 });
 
 </script> 
@endsection