@extends('layouts.app')

@section('select2css') 
<link href="{{asset('/')}}/public/css/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" /> 
<link href="{{asset('/')}}/public/css/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/')}}/public/css/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span aria-hidden="true" class="icon-list"></span>
                    <span class="caption-subject bold uppercase"> Vendor Products List</span>
                </div>
                <div class="actions">
                    
                </div>
            </div>
            <div class="portlet-body">
                <form id ="products_listing" method="post" action="{{ url('/bulk-delete') }}" >
                {!! csrf_field() !!}
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="part-1">
                                <div class="btn-group">
                                    <a href="javascript:void(0)" id="sample_editable_1_new" class="btn sbold green" onclick="window.location.href='{{ url('/')}}/add-product'"> Add New Product
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="part-2">
                                <a href="#myModal1" role="button" class="btn sbold green" data-toggle="modal"> Import <i class="fa fa-plus"></i></a>
                            </div>

                            <div class="part-2">
                                <div class="btn-group">
                                    <button type="button" id="filter" class="btn sbold green" data-style="slide-up" data-spinner-color="#333">
                                        <span class="ladda-label">Filter</span>
                                        <span class="ladda-spinner"></span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="part-2">
                                <div class="btn-group">
                                    <button type="button" id="bulkdelete" class="btn red mt-ladda-btn ladda-button" style="background-color: #e26a6a; border-color: #e26a6a;" data-style="slide-up" data-spinner-color="#333">
                                        <span class="ladda-label">Delete <i class="fa fa-trash"></i></span>
                                        <span class="ladda-spinner"></span>
                                    </button>
                                    
                                </div>
                            </div>
                            
                        </div>                          
                        
                        <div class="col-md-6">
                            <!--div class="btn-group pull-right">
                                <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                     <li>
                                        <a href="javascript:;">
                                             Import </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                    </li>
                                </ul>
                            </div-->
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                        <div style="margin:10px 0  0 0">
                            @if(Session::has('success-message'))
                            <div class="alert alert-success">
                            <strong>Success!</strong> {{ Session::get('success-message') }}
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
                </div>      


    <div class="row search-condition" @if(!$data['search_result']) style="display: none;" @endif>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-body">
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
                                            ->get();*/
                                            
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
                                        <select class="form-control" name="dynamic_field_name[]" autocomplete="off">
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
                    <button type="button" class="btn green clonecondition" style="margin-top: 25px;">Add another condition</button>
                    <div class="clear" style="clear:both;margin:15px 0 0 0"> </div>
                  
                    <hr />
                    <button type="submit" name="submit" value="search" id="search" class="btn blue" >Search products</button>
                </div>
            </div>

        </div>
    </div>

    <div class="table-scrollable">
        @php use \App\Library\CommonLib; $ob = new CommonLib; @endphp
        <table class="table table-striped table-bordered table-hover"  id="product_list">
            <thead>
                <tr>
                   <th scope="col" style="width:450px !important">
                        <div class="md-checkbox-inline text-center">
                            <div class="md-checkbox">
                                <input id="checkall" class="md-check" type="checkbox" autocomplete="off">
                                <label for="checkall">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                </label>
                            </div>
                        </div>
                    </th>
                    <th scope="col">Action</th>
                    <th scope="col">Name</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Vendor SKU</th>
                    <th scope="col">Price</th>
                    <th scope="col">UPC</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Collection</th>
                    <th scope="col">AKU</th>
                    <th scope="col">AKU2</th>
                    <th scope="col">Description</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Category</th>
                    <th scope="col">Production Art Url 1</th>
                    <th scope="col">Production Art Url 2</th>
                    <th scope="col">Print Mode</th>
                    <th scope="col">Print Location 1</th>
                    <th scope="col">Print Location 2</th>
                    <th scope="col">Length</th>
                    <th scope="col">Width</th>
                    <th scope="col">Height</th>
                    <th scope="col">Cost</th>
                    <th scope="col">Stock levels</th>
                    <th scope="col">Inventory Serial</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Number of Pieces</th>
                    <th scope="col">Ship Cartons </th>
                    <th scope="col">Ship Weight</th>
                    <th scope="col">Ship Width</th>
                    <th scope="col">Ship Length</th>
                    <th scope="col">Ship Height</th>                   

                </tr>                
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($data['products_list'] as $row)
                <tr>
                    <td> 
                        <div class="md-checkbox-inline text-center">
                            <div class="md-checkbox checkboxes-section">
                                <input id="checkbox{{ $row->product_row_id }}" class="md-check check-product-row-id" name="products[]" autocomplete="off" value="{{ $row->product_row_id }}" type="checkbox">
                                <label for="checkbox{{ $row->product_row_id }}">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                                <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/')}}/edit-product/{{ $row->product_row_id }}" >
                                        <i class="icon-pencil"></i>Edit Product </a>
                                </li>
                                <li>
                                    <a class="deleteLink" deleteID="{{ $row->product_row_id }}" href="javascript:void(0)">
                                        <i class="icon-tag"></i> Delete </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->product_sku }}</td>
                    <td>{{ $row->vendor_sku }}</td> 
                    <td>${{ $row->product_price }}</td>    
                    <td>{{ $row->upc }}</td>  
                    <td>{{ $row->product_weight }} {{ $row->product_weight_unit }}</td>  
                    <td>{{ $ob->getFieldNameByField('collection_row_id', $row->collection_row_id, 'collection_name', 'Collection') }}</td>
                    <td>{{ $row->aku_code }}</td>
                    <td>{{ $row->aku2_code }}</td>
                    <td>{{ str_limit($row->description,50) }}</td>
                    <td>{{ $ob->getFieldNameByField('vendor_row_id', $row->vendor_row_id, 'vendor_name', 'Vendor') }}</td>
                    <td>{{ $ob->getFieldNameByField('category_row_id', $row->category_row_id, 'category_name', 'Category') }}</td>
                    
                    <td>{{ $row->production_art_url_1 }}</td>
                    <td>{{ $row->production_art_url_2 }}</td>
                    <td>{{ $row->print_mode }}</td>
                    <td>{{ $row->print_location }}</td>
                    <td>{{ $row->print_location2 }}</td>
                    <td>{{ $row->product_length }} {{ $row->product_length_unit }}</td>
                    <td>{{ $row->product_width }} {{ $row->product_width_unit }}</td>
                    <td>{{ $row->product_height }} {{ $row->product_height_unit }}</td>
                    <td>{{ $row->product_cost }}</td>
                    <td>{{ $row->product_stock }}</td>
                    <td>{{ $row->inventory_serial }}</td>
                    <td>{{ $row->tags }}</td>
                    <td>{{ $row->number_of_pieces }}</td>
                    <td>{{ $row->ship_cartoon }}</td>
                    <td>{{ $row->ship_weight }} {{ $row->ship_weight_unit }}</td>
                    <td>{{ $row->ship_width }} {{ $row->ship_width_unit }}</td>
                    <td>{{ $row->ship_length }} {{ $row->ship_length_unit }}</td>
                    <td>{{ $row->ship_height }} {{ $row->ship_height_unit }}</td>                                        
                </tr>
                @endforeach  
                <tr><td colspan="10" style="text-align: center"> </td><td colspan="22"></td></tr>                
            </tbody>
        </table>
    </div>
    </form>
    </div>
    </div>
    
    <div class="modal fade" id="commonmodal" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <a class="btn dark btn-outline" data-dismiss="modal">Close</a>
                
                </div>
            </div>
        </div>
    </div>  
        
    <div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Import Products by Vendor</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ URL::to('importExcel') }}" id="importCsvProductsForm" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div style="font-weight:bold;padding:0 0 8px 0;">Step 1</div>
                        <input type="file" name="import_file" />
                        <div class="csv_format_note">Download a <a href="{{ url('/')}}/public/csv/product_template.csv">Sample CSV </a> file to see an example of the format.</div>
                        {!! csrf_field() !!}
                        <div style="font-weight:bold;padding:15px 0 0 0;">Step 2</div>
                        <div>
                            <table width="100%" cellspacing="4" cellpadding="4">
                                <tr>
                                    <td align="left" style="width:150px">Select Template: <div> <a href="{{ url('/add-import-template') }}" >Or Create New </a></div></td>
                                    <td align="left">
                                        <select class="form-control input-medium" name="template_row_id"> 
                                        <option value="0">Select</option>
                                            @foreach($data['import_templates'] as $template)
                                                <option value="{{ $template->template_row_id}}">{{ $template->template_name}}</option> 
                                            @endforeach
                                        </select> 
                                    </td>                           
                                </tr>
                            </table>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn default" data-dismiss="modal" aria-hidden="true">Cancel</button>                 
                    <button type="button" id="importCsvProducts" class="btn btn-success mt-ladda-btn ladda-button" data-style="expand-up">
                        <span class="ladda-label">UPLOAD FILE</span>
                    </button>
                </div>
                 </form>   
            </div>
        </div>
    </div>

    </div>
</div>

@endsection 

@section('select2js')
<script src="{{asset('/')}}/public/css/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
@endsection 

@section('after-app-js')
<script src="{{ url('public/css/assets/global/plugins/ladda/spin.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/css/assets/global/plugins/ladda/ladda.min.js') }}" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
<script src="{{asset('/')}}/public/css/assets/pages/scripts/ui-buttons.min.js" type="text/javascript"></script>
@endsection 

@section('page_js')
 <script type="text/javascript">
    $(document).ready(function() {
    @if(isset($data['condition']) && $data['condition'])
        $(".search-condition").show();
    @else
        $(".search-condition").hide();
    @endif

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
                            //$(".conditions #condition_"+conditionvalue+" .row .dynamic_fields_section").css('display', 'inline-block');
                            //$(".conditions #condition_"+conditionvalue+" .row .dynamic_fields_section").append(data);
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
        //$(".conditions").append('<div id="condition_'+condid+'" class="row" style="margin-top: 15px">' + conditionsrow + '</div>').find("select[name='condition_type[]']").trigger("change");
        $(".conditions").append('<div id="condition_'+condid+'" class="row" style="margin-top: 15px">' + conditionsrow + '</div>');
        $(".conditions #condition_"+condid+" .row").find("input[name='condition_value[]']").last().val("");
        $(".conditions #condition_"+condid+" .row").find("select[name='condition_type[]']").attr('conditionvalue', condid);
        $(".conditions #condition_"+condid+" .row").find("select[name='condition_type[]']").last().find("option").removeAttr("selected");
        $(".conditions #condition_"+condid+" .row").find("select[name='condition_type[]']").last().find("option").first().attr("selected", "selected");
        $(".conditions #condition_"+condid+" .row").find("select[name='condition[]']").last().find("option").removeAttr("selected");
        $(".conditions #condition_"+condid+" .row").find("select[name='condition[]']").last().find("option").first().attr("selected", "selected");
        $(".conditions #condition_"+condid+" .row .lastdiv").after('<div class="col-md-1"><a href="javascript:;" class="btn-small btn-icon-only deletediv" conditionval="'+condid+'" style="vertical-align: -webkit-baseline-middle;"><i class="fa fa-times"></i></a></div>');
    });

    });

    $(".conditions").on('click', '.deletediv', function() {     
        var conditionval = $(this).attr('conditionval');
        $("#condition_"+conditionval+"").remove();
        conditionval--;
        $("#condval").val(conditionval);
    })

    
    $("#search") . click( function() {
         $('#products_listing').attr('action', 'manage-product');
    })

    $("#filter") . click( function() {
        var condid = $("#condval").val();
        $(".search-condition").toggle();
        for(condid; condid > 1; condid--){
            $("#condition_"+condid+"").remove();
            $("#condval").val(condid-1);
        }
    })


     $("#importCsvProducts").click(function() {
         Ladda.bind('#importCsvProducts');
         $("#importCsvProductsForm").submit();
     });

    
    
     $("#bulkdelete").click(function() {        
        Ladda.bind('#bulkdelete');
        if(confirm('Are you sure to bulk delete the selected products? ')) {
        var allVals = [];       
        $('.checkboxes-section input:checked').each(function() {
            allVals.push($(this).val());
        });

        var dataString = 'products=' + allVals;
        $.ajax({
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        url:  "{{ url('bulk-delete') }}",
        data: dataString,
        success: function (response) {
            if(response == 'yes') {
                window.location.href = "{{ url('/')}}/manage-product";  
            }
            
        }
        });

            //var deleteID = 2;   
        //  window.location.href = "{{ url('/')}}/bulk-delete/" + allVals; 
        }   else {
             Ladda.stop();
        }

     });

 $('.deleteLink').click( function() {
  if( confirm('Are you sure to Delete? ') )
  {
    var deleteID = $(this).attr('deleteID');   
    window.location.href = "{{ url('/')}}/delete-product/" + deleteID; 
  }        
 });
 
 $('#checkall').change(function() {
 
    var checkboxes = $(this).closest('form').find(':checkbox');

    if($(this).is(':checked')) {
        checkboxes.prop('checked', true);
    } else {
        checkboxes.prop('checked', false);
    }
});

$('.art_preview').click(function(e){
    $('#commonmodal .modal-title').empty();
    $('#commonmodal .modal-body').empty();
    var image_name = $(this).attr('image_name');
    var external_image = $(this).attr('external');
    
    var caption = $(this).attr('caption');
    if(!external_image)
    var image = "{{ url('/') }}/public/uploads/product_images/{{ $data['user_id'] }}/" + image_name + "";
    else
    var image = "" + image_name + "";
    
    $('#commonmodal .modal-title').append(caption);
    $('#commonmodal .modal-body').append("<img src = " + image+ "  alt='Art image' style='max-width:570px;' />");
    $('#commonmodal .modal-footer .confirmrequest').attr("href", "{{ url('/') }}/schoolAdmin/manageStudent/deletestudent/"+studentid+"/"+activestatus);
        });

$(document).ready(function () {
    if(window.location.href.indexOf("import") > -1) {
       $('#myModal1').modal('show');
    }    
    

});
 </script> 
 
 <style type="text/css">
 .select_all_checkbox, .product_checkbox{width:18px;height:18px}
 .md-checkbox label {
     padding-left: 20px;
 }
 </style>
@endsection