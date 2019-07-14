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
                    for ( $i=0; $i< count($data['condition']); $i++ ) { if ($i>0) $margin='style="margin-top:15px"'; else $margin = ''; ?>
                    <div class="row" <?php echo $margin; ?> >
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="form-control" name="condition_type[]" autocomplete="off">
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
                                        <option <?php if($data['condition_type'][$i] == "xyz") echo 'selected="selected"'; ?> value="dynamic_fields">Dynamic Fields</option>
                                        <option <?php if($data['condition_type'][$i] == "print_mode") echo 'selected="selected"'; ?> value="print_mode">Print Mode</option>
                                        <option <?php if($data['condition_type'][$i] == "production_art_url_1") echo 'selected="selected"'; ?> value="production_art_url_1">Production Art url 1</option>
                                        <option <?php if($data['condition_type'][$i] == "production_art_url_2") echo 'selected="selected"'; ?> value="production_art_url_2">Production Art url 2</option>
                                        <option <?php if($data['condition_type'][$i] == "total_amount") echo 'selected="selected"'; ?> value="total_amount">Sale Price</option>
                                        <option <?php if($data['condition_type'][$i] == "quantity") echo 'selected="selected"'; ?> value="quantity">Sale Quantity</option>
                                        <option <?php if($data['condition_type'][$i] == "order_id") echo 'selected="selected"'; ?> value="order_id">Sales Order Id</option>
                                        <option <?php if($data['condition_type'][$i] == "customer_info") echo 'selected="selected"'; ?> value="customer_info">Customer</option>
                                    </select>
                                </div>
                                <div class="col-md-3 dynamic_fields_section" style="display: none">
                                    <?php $dynamic_fields = DB::table('product_dynamic_fields As df')
                                        ->join('products As p', 'df.product_row_id', '=', 'p.product_row_id')
                                        ->select('df.dynamic_field_row_id', 'df.field_name')
                                        ->where('p.created_by',  Auth::user()->id)
                                        ->orderBy('df.dynamic_field_row_id')
                                        ->get(); 
                                        ?>
                                    <select class="form-control" name="dynamic_field_name" id="dynamic_field_name" autocomplete="off">
                                    <option value="">Select</option>
                                        @foreach($dynamic_fields as $fields)
                                            <option value="{{ $fields->field_name }}">{{ $fields->field_name }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <input type="text" value="{{ $data['condition_value'][$i] }}" class="form-control" name="condition_value[]" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } }  else { ?>    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="form-control" name="condition_type[]" autocomplete="off">
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
                                    <?php $dynamic_fields = DB::table('product_dynamic_fields As df')
                                        ->join('products As p', 'df.product_row_id', '=', 'p.product_row_id')
                                        ->select('df.dynamic_field_row_id', 'df.field_name')
                                        ->where('p.created_by',  Auth::user()->id)
                                        ->orderBy('df.dynamic_field_row_id')
                                        ->get(); 
                                        ?>
                                    <select class="form-control" name="dynamic_field_name" id="dynamic_field_name" autocomplete="off">
                                    <option value="">Select</option>
                                        @foreach($dynamic_fields as $fields)
                                            <option value="{{ $fields->field_name }}">{{ $fields->field_name }}</option>
                                        @endforeach 
                                    </select>
                                </div>

                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="condition_value[]" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <button type="button" class="btn green clonecondition" style="margin-top: 25px;">Add another condition</button>
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
                <button type="submit" name="submit" value="pdf" class="btn default report-csv"  onclick="javascript:void(0)"><i class="icon-docs"></i> Export To PDF</button>
                <button type="button" class="btn default report-csv" data-toggle="modal" data-target="#export_filename"><i class="icon-picture"></i> Export Images</button>
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
                                <input type="text" class="form-control" name="filenameCSV" />
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


<?php if( isset($data['search_result_page']) && $data['search_result_page'] ) { ?>


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
                                <th>Product Name</th>
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
                         @foreach($data['products_list'] as $product)
                            <tr> 
                                <td>{{ $product['product_name'] }}</td>
                                <td>{{ $product['product_sku'] }}</td>
                                <td>{{ $product['product_price'] }}</td>
                                <td>
                                    @if($product['image_external_link'])
                                        <img src="{{$product['product_image']}}" alt="product Image" style="width:100px;height:80px" />
                                    @else
                                        <img src="{{ url('/')}}/public/uploads/product_images/{{ $data['user_id']}}/{{ $product['product_image'] }}" alt="image" style="width:100px;height:80px" />
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
                <button type="submit" name="submit" value="pdf" class="btn default report-csv" onclick="javascript:void(0)"><i class="icon-docs"></i> Export To PDF</button>
                <button type="button" class="btn default report-csv" data-toggle="modal" data-target="#export_filename"><i class="icon-picture"></i> Export Images</button>
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
            $(".conditions").on("change", "select[name='condition_type[]']", function () {                
                $(".dynamic_fields_section").css('display', 'none');
                
                if( $(this).val() == "dynamic_fields" ) {
                    $(".dynamic_fields_section").css('display', 'inline-block');
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

        var conditionsrow = $(".conditions .row").first().html();

        $(".clonecondition").click(function () {
                $(".conditions").append('<div class="row" style="margin-top: 15px">' + conditionsrow + '</div>').find("select[name='condition_type[]']").trigger("change");
                $(".conditions .row").find("input[name='condition_value[]']").last().val("");

                $(".conditions .row").find("select[name='condition_type[]']").last().find("option").removeAttr("selected");
                $(".conditions .row").find("select[name='condition_type[]']").last().find("option").first().attr("selected", "selected");

                $(".conditions .row").find("select[name='condition[]']").last().find("option").removeAttr("selected");
                $(".conditions .row").find("select[name='condition[]']").last().find("option").first().attr("selected", "selected");
            });

           


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