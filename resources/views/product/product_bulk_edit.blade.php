
@extends('layouts.app')

@section('select2css')

@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<span aria-hidden="true" class="icon-note"></span>
					<span class="caption-subject bold uppercase"> Bulk Edit of Product(s) </span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="form-group form-md-floating-label">
					<strong style="padding-right: 20px;">Products must match:</strong>
					<div class="md-radio-inline" style="margin-top: 10px;">
						<div class="md-radio">
							<input type="radio" id="radio1" value="all" name="collection_match" autocomplete="off" class="md-radiobtn" checked>
							<label for="radio1">
								<span></span>
								<span class="check"></span>
								<span class="box"></span> All conditions
							</label>
						</div>
                        <div class="md-radio">
                            <input type="radio" id="radio2" value="any" name="collection_match" autocomplete="off" class="md-radiobtn">
                            <label for="radio2">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Any condition
                            </label>
                        </div>
                        <div class="md-radio">
                                <input type="radio" id="radio3" value="listall" name="collection_match" autocomplete="off" class="md-radiobtn" >
                                <label for="radio3">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Show All
                                </label>
                        </div>
                        <!--
                        <span style="color: #989898; padding-left: 10px; padding-right: 7px;">Or</span>
                        <button type="button" class="btn blue mt-ladda-btn ladda-button btn-outline" style="margin-bottom: 5px;" id="listall" data-style="slide-up" data-spinner-color="#333">
                            <span class="ladda-label">SHOW ALL</span>
                        </button>
                        -->

					</div>
				</div>
                <div class="conditions">
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
                                <div class="col-md-3 dynamic_fields_section" >
                                    <?php 
                                        /*$dynamic_fields = DB::table('product_dynamic_fields')
                                        ->select('field_name')
                                        ->distinct()
                                        ->where('created_by',  Auth::user()->id)
                                        ->orderBy('dynamic_field_row_id')
                                        ->get();*/
                                        //$product_dynamic_fields = config('site_config.product_dynamic_fields');
                                        //dd($product_dynamic_fields);
                                    ?>
                                    <select class="form-control" name="dynamic_field_name[]" id="dynamic_field_name" autocomplete="off">
                                    <option value="">Select</option>
                                       @foreach($product_dynamic_fields as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
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
                </div>
                <input id="condval" type="hidden" name="condval" value="1" />
                <button type="button" class="btn green clonecondition" style="margin-top: 25px;">Add another condition</button>
                <hr />
                <button type="button" class="btn blue" id="search">Search products</button>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->

        <div class="portlet light bordered" id="products-box" style="display: none;">
            <div class="portlet-title">
                <div class="caption font-green">
                    <i class="icon-handbag font-green"></i>
                    <span class="caption-subject bold uppercase"> Matching Products</span>
                </div>
            </div>
            <div class="portlet-body">
                <p class="hideifempty"><strong>Instructions:</strong> Select the field(s), edit, and then click "Save Changes" below. Scroll right to view & edit all results.</p>
                <p id="products-empty" style="display: none;">No products found matching your criteria.</p>
                <div class="table-responsive">
                    <table class="hideifempty table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Product Name </th>
                            <th>SKU</th>
                            <th>Image</th>
                        </tr>
                        </thead>
                        <tbody id="products"></tbody>
                    </table>
                </div>
                <button type="button" class="btn blue" disabled="disabled" id="saveproducts">Save Changes</button>
            </div>
        </div>
	</div>
</div>
@endsection

@section('after-app-js')
    <script src="{{ url('public/css/assets/global/plugins/ladda/spin.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/css/assets/global/plugins/ladda/ladda.min.js') }}" type="text/javascript"></script>
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

                switch($(this).val()) {
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

            $("#search").click(function () {
                var conditions = [];
                var condid = 1;

                $("select[name='condition_type[]']").each(function() {
                    conditions.push({
                        column: $(".conditions #condition_"+condid+" select[name='condition_type[]']").val(),
                        rule: $(".conditions #condition_"+condid+" select[name='condition[]']").val(),
                        value: $(".conditions #condition_"+condid+" input[name='condition_value[]']").val(),
                        dynamic_field_name : $(".conditions #condition_"+condid+" select[name='dynamic_field_name[]']").val()
                    });
                    condid++;
                });
                //console.log(conditions);

                $.post("{{ url("/bulk-edit") }}", {
                    _token: '{{ csrf_token() }}',
                    match: $("input[name='collection_match']:checked").val(),
                    conditions: conditions,
                }, function (response) {
                    $("#products").empty();
                    $(".hideifempty").show();
                    $("#products-empty").hide();
                    if (response.length > 0) {
                        $.each(response, function () {

                            var img = '';
                            if(this.product_image && this.product_image != null) {
                                if(this.image_external_link) {
                                    img = 'Thumb Processing';                                   
                                } else {
                                    imgPath = "<?php echo url("/public/uploads/product_images") ?>/" + "<?php echo Auth::user()->id ?>/"  + this.product_image;
                                    img = '<img style="width:101px;height:80px" src="' + imgPath + '" alt="image" />';
                                }
                            } else {
                                img = ' <img src="{{ asset('/')}}public/no_image.jpg" alt="No Image"  />';
                            }


                            $("#products").append('<tr data-id="' + this.product_row_id + '"><td contenteditable="true" column="product_name">' + this.product_name + '</td><td contenteditable="true" column="product_sku">' + this.product_sku + '</td><td>' + img + '</td></tr>');
                        });
                    } else {
                        $(".hideifempty").hide();
                        $("#products-empty").show();
                    }

                    $("#products-box").fadeIn(800);
                });
            });

            $("#listall").click(function() {
                $.post("{{ url("/bulk-edit") }}", {
                    _token: '{{ csrf_token() }}',
                    match: 'listall'
                }, function (response) {
                    Ladda.stopAll();

                    $("#products").empty();
                    $(".hideifempty").show();
                    $("#products-empty").hide();
                    if (response.length > 0) {
                        $.each(response, function () {
                            $("#products").append('<tr data-id="' + this.product_row_id + '">@foreach($fields as $field) <td contenteditable="true" column="{{ $field }}">' + this.{{ $field }} + '</td> @endforeach</tr>');
                        });
                    } else {
                        $(".hideifempty").hide();
                        $("#products-empty").show();
                    }

                    $("#products-box").fadeIn(800);
                });
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