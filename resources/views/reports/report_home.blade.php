@extends('layouts.app')
@section('select2css')
@endsection

@section('content')
<form role = "form" method="post" action="{{ url('/')}}/reports">
{!! csrf_field() !!}    
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<span aria-hidden="true" class="icon-note"></span>
					<span class="caption-subject bold uppercase"> Report </span>

				</div>
			</div>
			<div class="portlet-body">
                <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                &nbsp;
                            </div>
                            <div class="col-md-6">
                                @if(Session::has('success-message'))
                                    <div class="alert alert-success">
                                        <strong>Success! </strong> {{ Session::get('success-message') }}
                                    </div>
                                @endif

                                @if(Session::has('error-message'))
                                    <div class="alert alert-danger">
                                        <strong>Error! </strong>{{ Session::get('error-message') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
				<div class="form-group form-md-floating-label">
					<strong style="padding-right: 20px;">Products must match:</strong>
					<div class="md-radio-inline" style="margin-top: 10px;">
						<div class="md-radio">
							<input type="radio" id="radio1"  @if( isset($data['collection_match']) && ($data['collection_match'] == 'all') ) checked="checked" @endif value="all" name="collection_match" autocomplete="off" class="md-radiobtn" >
							<label for="radio1">
								<span></span>
								<span class="check"></span>
								<span class="box"></span> All conditions
							</label>
						</div>
                        <div class="md-radio">
                            <input type="radio" id="radio2"  @if( isset($data['collection_match']) && ($data['collection_match'] == 'any') ) checked="checked" @endif value="any" name="collection_match" autocomplete="off" class="md-radiobtn">
                            <label for="radio2">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Any condition
                            </label>
                        </div>

                        <div class="md-radio">
                            <input type="radio" id="radio3"  @if( (isset($data['collection_match']) && ($data['collection_match'] == 'listall')) || ( !isset($data['collection_match'])) ) checked="checked" @endif value="listall" name="collection_match" autocomplete="off" class="md-radiobtn" >
                            <label for="radio3">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Show All
                            </label>
                        </div>
					</div>
				</div>
                
                <div class="conditions">
                    <?php
                     if(isset($data['condition']) && $data['condition']) {
                        $j=1;
                        for ( $i=0; $i< count($data['condition']); $i++ ) { 
                            if ($i>0) $margin='style="margin-top:15px"'; else $margin = ''; 
                        ?>
                        <div id="condition_{{$j}}" class="row" <?php echo $margin; ?> >
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" name="condition_type[]" autocomplete="off" conditionvalue="{{$j}}">
                                            <option <?php if($data['condition_type'][$i] == "product_name") echo 'selected="selected"'; ?>  value="product_name">Product Name</option>
                                            <option <?php if($data['condition_type'][$i] == "product_sku") echo 'selected="selected"'; ?> value="product_sku">SKU</option>
                                            <option <?php if($data['condition_type'][$i] == "product_price") echo 'selected="selected"'; ?>  value="product_price">Price</option>
                                            <option <?php if($data['condition_type'][$i] == "vendor_name") echo 'selected="selected"'; ?> value="vendor_name">Vendor</option>
                                            <option <?php if($data['condition_type'][$i] == "vendor_sku") echo 'selected="selected"'; ?> value="vendor_sku">Vendor SKU</option>
                                            <option <?php if($data['condition_type'][$i] == "collection_name") echo 'selected="selected"'; ?> value="collection_name">Collection</option>
                                            <option <?php if($data['condition_type'][$i] == "folder_name") echo 'selected="selected"'; ?> value="folder_name">Folder</option>
                                            <option <?php if($data['condition_type'][$i] == "aku") echo 'selected="selected"'; ?> value="aku">AKU</option>
                                            <option <?php if($data['condition_type'][$i] == "category_name") echo 'selected="selected"'; ?> value="category_name">Category</option>
                                            <option <?php if($data['condition_type'][$i] == "product_type_name") echo 'selected="selected"'; ?> value="product_type_name">Product Type</option>
                                            <option <?php if($data['condition_type'][$i] == "dynamic_fields") echo 'selected="selected"'; ?> value="dynamic_fields">Dynamic Fields</option>
                                            <option <?php if($data['condition_type'][$i] == "print_mode") echo 'selected="selected"'; ?> value="print_mode">Print Mode</option>
                                            <option <?php if($data['condition_type'][$i] == "production_art_url_1") echo 'selected="selected"'; ?> value="production_art_url_1">Production Art url 1</option>
                                            <option <?php if($data['condition_type'][$i] == "production_art_url_2") echo 'selected="selected"'; ?> value="production_art_url_2">Production Art url 2</option>
                                            <option <?php if($data['condition_type'][$i] == "total_amount") echo 'selected="selected"'; ?> value="total_amount">Sale Price</option>
                                            <option <?php if($data['condition_type'][$i] == "quantity") echo 'selected="selected"'; ?> value="quantity">Sale Quantity</option>
                                            <option <?php if($data['condition_type'][$i] == "order_id") echo 'selected="selected"'; ?> value="order_id">Sales Order Id</option>
                                            <option <?php if($data['condition_type'][$i] == "customer_info") echo 'selected="selected"'; ?> value="customer_info">Customer</option>
                                        </select>
                                    </div>
                                     <?php /*$dynamic_fields = DB::table('product_dynamic_fields')  
                                            ->select('field_name')
                                            ->distinct()
                                            ->where('created_by',  Auth::user()->id)
                                            ->orderBy('dynamic_field_row_id')
                                            ->get();
                                            */
                                        ?>
                                    @if($data['condition_type'][$i] == "dynamic_fields")
                                    <div class="col-md-3 dynamic_fields_section" style="display: none">
                                        <select class="form-control" name="dynamic_field_name[{{$i}}]" autocomplete="off">
                                            <option value="">Select</option>
                                            @foreach($data['product_dynamic_fields'] as $fields => $val)
                                                @if($data['dynamic_field_name'][$i] != '')
                                                <option @if($data['dynamic_field_name'][$i] == $fields) selected="selected" @endif value="{{ $fields }}">{{ $val }}</option>
                                                @endif
                                            @endforeach   
                                        </select>
                                    </div>
                                    @else
                                    <div class="dynamic_fields_section" style="display: none">
                                        <select class="form-control" name="dynamic_field_name[]"  autocomplete="off">
                                        <option value="">Select</option>
                                            @foreach($data['product_dynamic_fields'] as $fields => $val)
                                                <option value="{{ $fields }}">{{ $val }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    @endif

                                    <div class="col-md-2">
                                        <select class="form-control" name="condition[]" autocomplete="off">
                                            <option <?php if($data['condition'][$i] == "equals") echo 'selected="selected"'; ?> value="equals">Is Equal To</option>
                                            <option <?php if($data['condition'][$i] == "not_equals") echo 'selected="selected"'; ?> value="not_equals">Is Not Equal To</option>
                                            <option <?php if($data['condition'][$i] == "greater_than") echo 'selected="selected"'; ?> value="greater_than">Is Greater Than</option>
                                            <option <?php if($data['condition'][$i] == "less_than") echo 'selected="selected"'; ?> value="less_than">Is Less Than</option>
                                            <option <?php if($data['condition'][$i] == "starts_with") echo 'selected="selected"'; ?> value="starts_with">Starts With</option>
                                            <option <?php if($data['condition'][$i] == "ends_with") echo 'selected="selected"'; ?> value="ends_with">Ends With</option>
                                            <option <?php if($data['condition'][$i] == "contains") echo 'selected="selected"'; ?> value="contains">Contains</option>
                                            <option <?php if($data['condition'][$i] == "not_contains") echo 'selected="selected"'; ?> value="not_contains">Does Not Contain</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 lastdiv">
                                        <input type="text" value="{{ $data['condition_value'][$i] }}" class="form-control" name="condition_value[]" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $j++; } }  else { ?>    
                        <div id="condition_1" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" name="condition_type[]" autocomplete="off" conditionvalue="1">
                                            <option value="product_name">Product Name</option>
                                            <option value="product_sku">SKU</option>
                                            <option value="product_price">Price</option>
                                            <option value="vendor_name">Vendor</option>
                                            <option value="vendor_sku">Vendor SKU</option>
                                            <option value="collection_name">Collection</option>
                                            <option value="folder_name">Folder</option>
                                            <option value="aku">AKU</option>
                                            <option value="category_name">Category</option>
                                            <option value="product_type_name">Product Type</option>
                                            <option value="dynamic_fields">Dynamic Fields</option>
                                            <option value="print_mode">Print Mode</option>
                                            <option value="production_art_url_1">Production Art url 1</option>
                                            <option value="production_art_url_2">Production Art url 2</option>
                                            <option value="total_amount">Sale Price</option>
                                            <option value="quantity">Sale Quantity</option>
                                            <option value="order_id">Sales Order Id</option>
                                            <option value="customer_info">Customer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 dynamic_fields_section" style="display: none">
                                        <?php 
                                        /*$dynamic_fields = DB::table('product_dynamic_fields')                                       
                                        ->select('field_name')
                                        ->distinct()
                                        ->where('created_by',  Auth::user()->id)
                                        ->orderBy('dynamic_field_row_id')
                                        ->get();
                                        */
                                        ?>
                                        <select class="form-control" name="dynamic_field_name[]" autocomplete="off">
                                        <option value="">Select</option>
                                            @foreach($data['product_dynamic_fields'] as $fields => $val)
                                                <option value="{{ $fields }}">{{ $val }}</option>
                                            @endforeach  
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select class="form-control" name="condition[]" autocomplete="off">
                                            <option value="equals">Is Equal To</option>
                                            <option value="not_equals">Is Not Equal To</option>
                                            <option value="greater_than">Is Greater Than</option>
                                            <option value="less_than">Is Less Than</option>
                                            <option value="starts_with">Starts With</option>
                                            <option value="ends_with">Ends With</option>
                                            <option value="contains">Contains</option>
                                            <option value="not_contains">Does Not Contain</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 lastdiv">
                                        <input type="text" class="form-control" name="condition_value[]" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <input id="condval" type="hidden" name="condval" @if(isset($data['condition'])) value="{{$j}}" @else value="1" @endif />

                <button type="button" class="btn green clonecondition" style="margin-top: 25px; display: none;">Add another condition</button>
                <div class="clear" style="clear:both;margin:15px 0 0 0"> </div>
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-2">Date From</label>
                        <div class="col-md-3">
                            <input class="form-control form-control-inline input-medium date-picker" name="sales_data_from" id="sales_data_from" size="16" type="text" value="{{ isset($data['sales_data_from']) && $data['sales_data_from'] != '1970-01-01' ? $data['sales_data_from'] : ''  }}" />                                
                        </div>
                        <label class="control-label col-md-1">Date To</label>
                        <div class="col-md-3">
                            <input class="form-control form-control-inline input-medium date-picker" name="sales_data_to" id="sales_data_to" size="16" type="text" value="{{ isset($data['sales_data_to']) && $data['sales_data_to'] != '1970-01-01' ? $data['sales_data_to'] : ''  }}" />                                
                        </div>
                    </div>
                </div>
                <hr />
                <button type="submit" name="submit" value="search" class="btn blue" >Search products</button>
                <button type="button" name="submit" value="csv" class="btn default report-csv" data-toggle="modal" data-target="#export_csv"><i class="icon-share-alt"></i> Export To CSV</button>
                <button type="button" name="submit" value="pdf" class="btn default report-csv"  onclick="javascript:void(0)" data-toggle="modal" data-target="#export_pdf"><i class="icon-docs"></i> Export To PDF</button>
                <!--<button type="button" class="btn default report-csv" data-toggle="modal" data-target="#export_filename"><i class="icon-picture"></i> Export Images</button>-->
                 <button type="button" class="btn default report-csv" data-toggle="modal" data-target="#export_hire_image"><i class="icon-picture"></i> Export Images</button>
			</div>
		</div>

	</div>
</div>

<div id="export_hire_image" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Download Images </h4>
            </div>
            <div class="modal-body">
                <table width="100%" cellspacing="4" cellpadding="4">
                    <tr>
                        <td align="left" style="width:150px">Choose a file name:</td>
                        <td align="left">
                            <div class="input-group">
                                <input type="text" class="form-control" name="filename" />
                                <span class="input-group-addon">.zip</span>
                            </div>
                        </td>
                    </tr>
                    <tr> <td> &nbsp;</td><td> &nbsp;</td></tr>
                    <tr>
                        <td align="left" style="width:150px">Don't Rename as default on images:</td>
                        <td align="left">
                            <div class="input-group">
                                <select class="form-control" name="rename" style="width:200px"> 
                                    <option value="">Select</option>
                                    <option value="product_sku">Product SKU</option>
                                    <option value="vendor_sku">Vendor SKU</option>
                                    <option value="aku_code">Aku Code</option>
                                    <option value="upc">UPC</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true" type="button">Cancel</button>
                <button class="btn sbold green" type="submit" name="submit" value="hireimagesOnly">Download Zip Images</button>
            </div>
        </div>
    </div>
</div>

<div id="export_filename" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Download Images </h4>
            </div>
            <div class="modal-body">
                <table width="100%" cellspacing="4" cellpadding="4">
                    <tr>
                        <td align="left" style="width:150px">Choose a file name:</td>
                        <td align="left">
                            <div class="input-group">
                                <input type="text" class="form-control" name="filename_already_exist_another_filename" />
                                <span class="input-group-addon">.zip</span>
                            </div>
                        </td>
                    </tr>
                    <tr> <td> &nbsp;</td><td> &nbsp;</td></tr>
                    <tr>
                        <td align="left" style="width:150px">Don't Rename as default on images:</td>
                        <td align="left">
                            <div class="input-group">
                                <select class="form-control" name="rename_already_exist_another_rename" style="width:200px"> 
                                    <option value="">Select</option>
                                    <option value="product_sku">Product SKU</option>
                                    <option value="vendor_sku">Vendor SKU</option>
                                    <option value="aku_code">Aku Code</option>
                                    <option value="upc">UPC</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true" type="button">Cancel</button>
                <button class="btn sbold green" type="submit" name="submit" value="imagesOnly">Download Zip Images</button>
            </div>
        </div>
    </div>
</div>


<div id="export_csv" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Export To CSV </h4>
            </div>
            <div class="modal-body">
                <table width="100%" cellspacing="4" cellpadding="4">
                    <tr>    
                        <td align="left" style="width:200px">Select Export Template:</td>
                        <td align="left">
                            <div class="input-group">
                                <select class="form-control" name="template_row_id" style="width:250px"> 
                                    <option value="0">Select</option>
                                    @foreach($data['export_templates'] as $template)
                                        <option value="{{ $template->template_row_id}}">{{ $template->template_name}}</option> 
                                    @endforeach
                                </select> 
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true" type="button">Cancel</button>
                <button class="btn sbold green" type="submit" name="submit" value="csv">Export To CSV</button>
            </div>
        </div>
    </div>
</div>

<div id="export_pdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Export To PDF </h4>
            </div>
            <div class="modal-body">
                <table width="100%" cellspacing="4" cellpadding="4">
                    <tr>    
                        <td align="left" style="width:200px">Select Export Template:</td>
                        <td align="left">
                            <div class="input-group">
                                <select class="form-control" name="template_type" style="width:250px" required> 
                                    <option value="1">Matrix with Price</option>
                                    <option value="2">3X4 No Price</option>
                                </select> 
                            </div>
                        </td>
                    </tr>
                    <tr>    
                        <td align="left" style="width:200px">Sort By:</td>
                        <td align="left" style="padding-top: 10px;">
                            <div class="input-group">
                                <select class="form-control" name="sorting_order" style="width:250px" required>
                                    <option value="1">SKU – Lowest to highest</option>
                                    <option value="2">Product Name – Alphabetical</option>
                                    <option value="3">Price (high to low) – Descending Order</option>
                                    <option value="4">Price (low to high) – Ascending Order</option>
                                    <option value="5">Color – Alphabetical</option>
                                </select> 
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true" type="button">Cancel</button>
                <button class="btn sbold green" type="submit" name="submit" value="pdf">Export To PDF</button>
            </div>
        </div>
    </div>
</div>




<div id="sales_data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Sales Data</h4>
            </div>
            <div class="modal-body">
                <table width="100%" cellspacing="4" cellpadding="4">
                    <tr>
                        <td align="left">
                            <div class="input-group">
                                <div id="sales_data_shown_section"> </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true" type="button">Cancel</button>
            </div>
        </div>
    </div>
</div>


<?php if( isset($data['search_result_page']) && ($data['search_result_page'] !='')) { ?>

<div class="row search_result_loader">
    <div class="col-md-12" style="text-align: center"><img src=" {{ asset('/public/uploads/loading_icon.gif') }}"  alt="Loader" /> </div>
</div>

<div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">                              
                <div class="portlet-body">
                    <div class="table-toolbar">                         
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="width:400px">Product Name</th>
                                <th>Sku</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Sales</th>
                                <th>Qty</th
                            </tr>
                        </thead>
                        <tbody>
                        <?php if( !$data['products_list']) {
                             echo '<tr class="odd gradeX"><td style="text-align:center;" colspan="6"> No Data </td></tr>'; 
                            }
                        ?>
                         <?php $procount = 1; ?>   
                         @foreach($data['products_list'] as $product)
                            <tr> 
                                <td>{{ $procount.'.' }}</td>
                                <td>{{ $product['product_name'] }}</td>
                                <td>{{ $product['product_sku'] }}</td>
                                <td>{{ $product['product_price'] }}</td>
                                <td>
                                    @if($product['product_image'])
                                        @if($product['image_external_link'])
                                            Thumb Processing
                                        @else
                                            <img src="{{ url('/')}}/public/uploads/product_images/{{ $data['user_id']}}/{{ $product['product_image'] }}" alt="image" style="width:100px;height:80px" />
                                        @endif

                                        @else
                                            <img src="{{ asset('/')}}public/no_image.jpg" alt="No Image"  />    
                                    @endif
                                </td>
                                <td>
                                    <button type="button" product_row_id="{{ $product['product_row_id'] }}" class="btn default view-sales-data" data-toggle="modal" data-target="#sales_data"> View</button>
                                 </td>
                                <td>
                                    <?php                             
                                        echo \App\Models\ProductSalesData::where('product_row_id', $product['product_row_id'])->whereBetween('order_date',[$data['sales_data_from'], $data['sales_data_to']])->count(); 
                                    ?>
                                </td>
                            </tr>
                            <?php $procount++; ?>   
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
</div>
<div class="row">
    <div class="col-md-6"> </div>
    <div class="col-md-6">
        <div class="form-actions noborder">
            <button type="button" name="submit" value="csv" class="btn default report-csv" data-toggle="modal" data-target="#export_csv"><i class="icon-share-alt"></i> Export To CSV</button>
            <button type="button" name="submit" value="pdf" class="btn default report-csv"  onclick="javascript:void(0)" data-toggle="modal" data-target="#export_pdf"><i class="icon-docs"></i> Export To PDF</button>
            <button type="button" class="btn default report-csv" data-toggle="modal" data-target="#export_hire_image"><i class="icon-picture"></i> Export Images</button>
        </div>
    </div>
</div>
<?php } ?>
@endsection

@section('select2js')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ url('public/css/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/css/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/css/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src=" {{ url('public/css/assets/global/plugins/bootstrap-datepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/css/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/css/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="{{asset('/')}}/public/css/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
@endsection 


@section('after-app-js')
<script src="{{ url('public/css/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
 <script src="{{ url('public/css/assets/global/plugins/ladda/spin.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/css/assets/global/plugins/ladda/ladda.min.js') }}" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL SCRIPTSproduct -->         
 <script src="{{asset('/')}}/public/css/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
 <script src="{{asset('/')}}/public/css/assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {

            Ladda.bind('#listall');
            $(".conditions").on("change", "select[name='condition_type[]']", function (e) {                
                var conditionvalue = $(this).attr('conditionvalue');
                $(".conditions #condition_"+conditionvalue+" .row .dynamic_fields_section").css('display', 'none');        
                if( $(this).val() == "dynamic_fields" ) {
                    @if(isset($data['condition']))
                        if (e.originalEvent !== undefined) {
                            //alert ('human');
                            $(".conditions #condition_"+conditionvalue+" .row .dynamic_fields_section").empty();
                            $.ajax({
                                url: "{{ url('getDynamicFields/') }}",
                                type: "GET",
                                dataType: "html",
                                success: function(data){
                                    $(".conditions #condition_"+conditionvalue+" .row .dynamic_fields_section").addClass('col-md-3').append(data);
                                }
                            });
                        }
                    @endif
                    $(".conditions #condition_"+conditionvalue+" .row .dynamic_fields_section").css('display', 'inline-block');
                }

                switch ($(this).val()) {
                    case "product_name":
                    case "product_sku":
                    case "vendor_name":
                    case "vendor_sku":
                    case "collection_name":
                    case "folder_name":
                    case "category_name":
                    case "product_type_name":
                    case "print_mode":
                    case "production_art_url_1":
                    case "production_art_url_2":
                    case "customer_info":
                    case "dynamic_fields":
                        var conditions = ["equals", "not_equals", "starts_with", "ends_with", "contains", "not_contains"];
                        break;

                    case "product_price":
                    case "total_amount":
                    case "quantity":
                        var conditions = ["equals", "not_equals", "greater_than", "less_than"];
                        break;

                    case "order_id":
                        var conditions = ["equals", "not_equals"];
                        break;     
                }

                $(this).closest(".row").find("select[name='condition[]'] option").each(function () {
                    if ($.inArray($(this).val(), conditions) !== -1) {
                        $(this).removeAttr("disabled");
                    } else {
                        $(this).attr("disabled", "disabled");
                    }
                });
            });

        $("select[name='condition_type[]']").each(function () {
            $(this).trigger("change");
        });

        @if(isset($data['condition']))
            var conditionsrow;
            $.ajax({
                url: "{{ url('getDefaultFields/') }}",
                type: "GET",
                dataType: "html",
                success: function(data){
                    conditionsrow = data;
                }
            });
        @else
            var conditionsrow = $(".conditions .row").first().html();
        @endif

        $(".clonecondition").click(function () {
            var condid = $("#condval").val();
            condid++;
            $("#condval").val(condid);
            $(".conditions").append('<div id="condition_'+condid+'" class="row" style="margin-top: 15px">' + conditionsrow + '</div>');
            $(".conditions #condition_"+condid+" .row").find("input[name='condition_value[]']").last().val("");
            $(".conditions #condition_"+condid+" .row").find("select[name='condition_type[]']").attr('conditionvalue', condid);
            $(".conditions #condition_"+condid+" .row").find("select[name='condition_type[]']").last().find("option").removeAttr("selected");
            $(".conditions #condition_"+condid+" .row").find("select[name='condition_type[]']").last().find("option").first().attr("selected", "selected");
            $(".conditions #condition_"+condid+" .row").find("select[name='condition[]']").last().find("option").removeAttr("selected");
            $(".conditions #condition_"+condid+" .row").find("select[name='condition[]']").last().find("option").first().attr("selected", "selected");
            $(".conditions #condition_"+condid+" .row .lastdiv").after('<div class="col-md-1"><a href="javascript:;" class="btn-small btn-icon-only deletediv" conditionval="'+condid+'" style="vertical-align: -webkit-baseline-middle;"><i class="fa fa-times"></i></a></div>');
        });

        $(".conditions").on('click', '.deletediv', function() {     
            var conditionval = $(this).attr('conditionval');
            $("#condition_"+conditionval+"").remove();
            conditionval--;
            $("#condval").val(conditionval);
        })

        $(document).on("blur", "td[contenteditable]", function() {
            $(this).attr("value", $(this).text());
        });

        $(document).on("focus", "td[contenteditable]", function() {
            $("#saveproducts").text("Save Changes").removeClass("green").removeProp("disabled");
        });

        $("#saveproducts").click(function() {
            $("tr").has("td[contenteditable][column][value]").each(function() {
                var product = {};

                $(this).find("td[contenteditable][column][value]").each(function() {
                    product[$(this).attr("column")] = $(this).attr("value");
                });

                $.post('{{ url('/bulk-edit-update') }}', {
                    _token: '{{ csrf_token() }}',
                    product: $(this).attr("data-id"),
                    data: product
                }, function() {
                    $("#saveproducts").text("Changes Saved").addClass("green").prop("disabled", "disabled");
                    $("td[contenteditable][column][value]").removeAttr("value");
                });
            });
        });

        $(".view-sales-data").click( function(){
           var product_row_id = $(this).attr('product_row_id');
           
           var sales_data_from = $("#sales_data_from").val();
           var sales_data_to = $("#sales_data_to").val();               
           var formData = {product_row_id:product_row_id, sales_data_from:sales_data_from, sales_data_to:sales_data_to};
            $.ajax({                        
                    url : "getSalesData",
                    type: "POST",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data : formData,
                    success: function(data, textStatus, jqXHR) {
                        $("#sales_data_shown_section") .html(data);                            
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                 
                    }
            });

            
        });

    $('.search_result_loader').hide();
    $('.clonecondition').show();    

    });
</script>
    <style type="text/css">
    td[contenteditable]:focus {
        border: 2px solid #0b94ea;
        outline: none;
    }

    th {
        background-color: #f6fafb;
    }
    </style>
@endsection