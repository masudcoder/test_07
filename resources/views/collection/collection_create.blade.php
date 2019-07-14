@extends('layouts.app')

@section('content')
	<!-- BEGIN PAGE BASE CONTENT -->
	<div class="row">
		<div class="col-md-12 ">
			<form method="post" action="{{ url('/store-collection') }}">
			{{ csrf_field() }}
			<!-- BEGIN SAMPLE FORM PORTLET-->
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-green">
							<i class="icon-layers font-green"></i>
							<span class="caption-subject bold uppercase"> Add New Collection</span>
						</div>
					</div>
					<div class="portlet-body form">
						<input type="hidden" name="edit_row_id" value="{{ isset($data->collection_row_id) ? $data->collection_row_id : "" }}" >
						<div class="form-body">
							<div class="form-group form-md-line-input form-md-floating-label">
								<input type="text" class="form-control"  name="collection_name" value="{{ isset($data->collection_name) ? $data->collection_name : "" }}" required>
								<label for="form_control_1">Collection Name </label>
							</div>

							<div class="form-group form-md-line-input form-md-floating-label">
								<textarea class="form-control" rows="3" name="collection_description">{{ isset($data->collection_description) ? $data->collection_description : "" }}</textarea>
								<label for="form_control_1">Collection Description</label>
							</div>

							<div id="conditionssection">
								<div class="form-group form-md-floating-label">
									<span style="padding-right: 20px;">Products must match:</span>
									<div class="md-radio-inline">
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
									</div>
								</div>

								<hr />
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
				                                <div class="col-md-3 dynamic_fields_section" style="display: none">
				                                    <?php 
					                                    /*$dynamic_fields = DB::table('product_dynamic_fields')
				                                        ->select('field_name')
				                                        ->distinct()
				                                        ->where('created_by',  Auth::user()->id)
				                                        ->orderBy('dynamic_field_row_id')
				                                        ->get();*/
			                                    	?>
				                                    <select class="form-control" name="dynamic_field_name[]" id="dynamic_field_name" autocomplete="off">
				                                    <option value="">Select</option>
				                                        @foreach($data['dynamic_fields'] as $key => $val)
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
								<hr />
								<button type="button" class="btn green clonecondition">Add another condition</button>
							</div>
							<hr />
							<button type="button" class="btn blue" id="search">Search products</button>
						</div>
					</div>
				</div>
				<!-- END SAMPLE FORM PORTLET-->

				<div class="row search_result_loader" style="display: none;">
				    <div class="col-md-12" style="text-align: center"><img src=" {{ asset('/public/uploads/loading_icon.gif') }}"  alt="Loader" /> </div>
				</div>

				<!-- BEGIN SAMPLE FORM PORTLET-->
				<div class="portlet light bordered" id="products" @unless(isset($products) && count($products) > 0) style="display: none;" @endunless>
					<div class="portlet-title">
						<div class="caption font-green">
							<i class="icon-handbag font-green"></i>
							<span class="caption-subject bold uppercase"> Products</span>
						</div>
					</div>


					<div class="portlet-body">
						<p class="hideifempty">Please select the products you would like to add to a collection:
						</p>
						<hr class="hideifempty" />
						<div id="products-choose">
							
							@if(isset($products))
								@foreach($products as $product)
									<div class="md-checkbox has-success">									
										<input type="checkbox" id="checkbox{{ $product->product_row_id }}" class="md-check searched_product" name="products[]" checked autocomplete="off" value="{{ $product->product_row_id }}">
										<label for="checkbox{{ $product->product_row_id }}">
											<span></span>
											<span class="check"></span>
											<span class="box"></span> {{ $product->product_name }}
										</label>

									</div>
									<hr />
								@endforeach
							@endif
						</div>
						<button type="submit" class="btn blue hideifempty">Create collection</button>
					</div>
				</div>
				<!-- END SAMPLE FORM PORTLET-->
			</form>
		</div>
	</div>
@endsection

@section('after-app-js')
	<script type="text/javascript">
        $(document).ready(function() {
            $(".conditions").on("change", "select[name='condition_type[]']", function(e) {
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

                $(this).closest(".row").find("select[name='condition[]'] option").each(function() {
                    if($.inArray($(this).val(), conditions) !== -1) {
                        $(this).removeAttr("disabled");
                    } else {
                        $(this).attr("disabled", "disabled");
                    }
                });
            });

            $("select[name='condition_type[]']").each(function() {
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
           

            $("#search").click(function() {

            	$('.search_result_loader').show();
            	var $container = $("html,body");
				var $scrollTo = $('.search_result_loader');

				$container.animate({scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop(), scrollLeft: 0},300);

            	
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

                $.post("{{ url("/search-products") }}", {
                    _token: '{{ csrf_token() }}',
                    mode: $("input[name='collection_mode']:checked").val(),
					match: $("input[name='collection_match']:checked").val(),
                    conditions: conditions,
					collection: '{{ isset($data->collection_row_id) ? $data->collection_row_id : "" }}'
                }, function(response) {
                	$('.search_result_loader').hide();
                    $("#products-choose").empty();
                    $(".hideifempty").show();
                    var imgPath = '';
                    var str = '<div class="row" style="font-weight:bold;margin:0 0 20px 0"><div class="col-md-4 md-checkbox has-success"><input id="checkall" class="md-check" type="checkbox" autocomplete="off"><label for="checkall"><span></span><span class="check"></span><span class="box"></span></label>Product Name</div> <div class="col-md-4">Sku </div> <div class="col-md-4"> Image</div></div>';
                    $("#products-choose").append(str);

                    if(response.length > 0) {
                        $.each(response, function () {    

                        	var img = '';
                        	if(this.product_image && this.product_image != null) {
                            	if(this.image_external_link != 0) {
                            		img = 'Thumb Processing';                        			
                        		} else {
                        			imgPath = "<?php echo url("/public/uploads/product_images") ?>/" + "<?php echo Auth::user()->id ?>/"  + this.product_image;
                        			img = '<img style="width:101px;height:80px" src="' + imgPath + '" alt="image" />';
                        		}
                            } else {
                            	img = ' <img src="{{ asset('/')}}public/no_image.jpg" alt="No Image"  />';
							}

                            $("#products-choose").append("" +
                                '<div class="row" style="margin-left:0"><div  class="col-md-4 md-checkbox has-success">' +
                                '<input type="checkbox" id="checkbox' + this.product_row_id + '" class="md-check searched_product" name="products[]" autocomplete="off" value="' + this.product_row_id + '">' +
                                '    <label for="checkbox' + this.product_row_id + '">' +
                                '    <span></span>' +
                                '   <span class="check"></span>' +
                                '   <span class="box"></span> ' + this.product_name +
                                '   </label>' +
                                '</div>' +
                                '<div class="col-md-4">' +  this.product_sku + '</div>' +
                                '<div class="col-md-4">' +  img + '</div>' +
                                '<hr />'
                            );
                        });
                    } else {
                        $(".hideifempty").hide();
                        $("#products-choose").append('<p>No products found matching your criteria.</p>');
					}

                    $("#products").fadeIn(800);
                });
            });
			
			$("#products-choose").on('change', '#checkall', function() { 
				var status = this.checked;
				$(".searched_product").prop('checked', status);
			});

        });
	</script>
@endsection