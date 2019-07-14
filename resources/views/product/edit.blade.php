@extends('layouts.app')

@section('select2css')
    <!-- BEGIN PAGE LEVEL PLUGINSproduct -->
   
	<link href="{{asset('/')}}/public/css/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/public/css/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
	<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css" rel="stylesheet" type="text/css" />
	<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css" rel="stylesheet" type="text/css" />
	<link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
	<link href="{{asset('/')}}/public/css/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" /> 
	
    <!-- END PAGE LEVEL PLUGINS -->
@endsection
		
@section('content')
<!-- BEGIN PAGE BASE CONTENT -->

<div class="row">
	<div class="col-md-12">
		<form class="form-horizontal form-row-seperated"   method="post" action="{{ url('/')}}/store-product" enctype="multipart/form-data">
		 {!! csrf_field() !!}
		    <input type="hidden" name="hidden_row_id" value="{{  $data['single_record']->product_row_id }}" />
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-shopping-cart"></i>Edit Product </div>
					<div class="actions btn-set">
						<button type="button" name="back" class="btn btn-secondary-outline back-button">
							<i class="fa fa-angle-left"></i> Back
						</button>
						
						<button class="btn btn-success">
							<i class="fa fa-check"></i> Save
						</button>
						
						<!--button class="btn btn-success">
							<i class="fa fa-check-circle"></i> Save & Continue Edit
						</button-->						
					</div>
				</div>
				<div class="portlet-body">
					<div class="tabbable-bordered">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="javascript:void(0)" id="tab_all" data-toggle="tab"> All Fields </a>
							</li>							
							<li>
								<a href="#tab_general" data-toggle="tab"> General </a>
							</li>
							<li>
								<a href="#tab_details" data-toggle="tab"> Details </a>
							</li>							
							<li>
								<a href="#tab_price_level" data-toggle="tab"> Price Level </a>
							</li>							
							<li>
								<a href="#tab_shipping" data-toggle="tab"> Shipping</a>
							</li>
							
							<li>
								<a href="#tab_meta" data-toggle="tab">SEO </a>
							</li>
							
							<li>
								<a href="#tab_dynamic_field" data-toggle="tab"> Dynamic Fields </a>
							</li>
						</ul>
						
						<div class="tab-content">						
							<div class="tab-pane active" id="tab_general">								
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Name:
											<span class="required"> * </span>
										</label>
										<div class="col-md-4">
											<input type="text" class="form-control" name="product_name" value="{{  $data['single_record']->product_name }}"  placeholder="" required> </div>
									</div>									
									<div class="form-group">
										<label class="col-md-2 control-label">Code/SKU:
											<span class="required"> * </span>
										</label>
										<div class="col-md-4">
											<input type="text" class="form-control" name="product_sku" value="{{  $data['single_record']->product_sku }}"  placeholder="" required> </div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Vendor SKU:
											
										</label>
										<div class="col-md-4">
											<input type="text" class="form-control" name="vendor_sku" value="{{  $data['single_record']->vendor_sku }}"  placeholder="" > </div>
									</div>
																		
									<div class="form-group">
										<label class="col-md-2 control-label">Price:
											
										</label>
										<div class="col-md-4"> <input type="text" class="form-control" id="product_price" name="product_price" value="{{  $data['single_record']->product_price }}" >  </div>
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span id="selected_product_price_unit" style="display:inline-block;width:40px">$</span>
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu">				
														<li><a href="javascript:;" onclick="setElements('product_price_unit', '$')" >$</a></li>
														<li><a href="javascript:;" onclick="setElements('product_price_unit', '&euro;')">&euro;</a></li>
													</ul>
													<input type="hidden" name="product_price_unit" id="product_price_unit" value="{{ $data['single_record']->product_price_unit }}" >
												</div>												
											</div>
											
										</div>
									</div>								
									
									<div class="form-group">
										<label class="col-md-2 control-label">Barcode (ISBN, UPC):</label>
										<div class="col-md-4">
											<input type="text" class="form-control" name="upc" value="{{  $data['single_record']->upc }}" > </div>
									</div>

									
									<div class="form-group">
										<label class="col-md-2 control-label">Weight:
											
										</label>
										<div class="col-md-4"> 
											<input type="text" class="form-control" value="{{  $data['single_record']->product_weight }}" id="product_weight"  name="product_weight" placeholder="0.00" >
										</div>
										
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span class="elements_dropdown_default_val" id="selected_product_weight_unit" style="display:inline-block;width:40px">Select</span>
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
														    <li><a href="javascript:;" onclick="setElements('product_weight_unit', '')" >Select</a></li>
                                                            <li><a href="javascript:;" onclick="setElements('product_weight_unit', 'lb')" > lb </a></li>
                                                            <li><a href="javascript:;" onclick="setElements('product_weight_unit', 'oz')"> oz </a></li>
                                                            <li><a href="javascript:;" onclick="setElements('product_weight_unit', 'kg')">kg </a></li>
                                                            <li><a href="javascript:;" onclick="setElements('product_weight_unit','g')">g </a></li>
                                                        </ul>
													<input type="hidden" name="product_weight_unit" id="product_weight_unit" value="" >
												</div>
											</div>
										</div>
											
									</div>	
										
									<div class="form-group">
										<label class="col-md-2 control-label">
										  Variants:	
										</label>
										<div class="col-md-5" style="padding:5px 0 0 10px" > 
											Does this product come in multiple variations like size or color?
										</div>
										<div class="col-md-5" style="padding:5px 0 0 10px"  > 
											<a href="javascript:void(0)" id="add_variant_btn">Edit Variants</a>
											<a href="javascript:void(0)" id="cancel_variant_btn" style="display:none">Cancel Variants</a>
											<?php if(count($data['single_record']->attributeName)) { ?>	
											 &nbsp;&nbsp;&nbsp;<a href="#myModal1"  id="manage_variant_option" data-toggle="modal" style="display:none">Manage Variants, Options  </a>
											<?php } ?>
										</div>
									</div>
									
									<?php if(count($data['single_record']->attributeName)) { ?>	

										
									<div id="variantFormElement" style="display:none">	
										
										<div class="form-group">
											<label class="col-md-2 control-label"></label>
											<div class="col-md-10">	
												<table class="table">
													<thead>
														<tr>
															<th>Variant </th>
															<th> Price</th>
															<th> SKU </th>
															<th>Barcode </th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$attribute_price =  json_decode($data['single_record']->attribute_price);														
														$attribute_sku =  json_decode($data['single_record']->attribute_sku);
														$attribute_barcode =  json_decode($data['single_record']->attribute_barcode);
														
														$no_groups = count($data['single_record']->attributeName);
														foreach($data['single_record']->attributeName  as $arr) { 
																$group_option_arr[] =  explode(',', $arr['attribute_group_options']);
														 } ?>
														
														<?php
															
															if($no_groups == 1)
															{
															    $attribute_price_loop = 0;
																$attribute_sku_loop = 0;
																$attribute_barcode_loop = 0;																			
																for($i=0; $i<count($group_option_arr[0]); $i++) 
																{			
																	$attr_price = isset($attribute_price [$attribute_price_loop]) ? $attribute_price [$attribute_price_loop] : '';
																	$attr_sku = isset($attribute_sku [$attribute_sku_loop]) ? $attribute_sku [$attribute_sku_loop] : '';
																	$attr_barcode = isset($attribute_barcode [$attribute_barcode_loop]) ? $attribute_barcode [$attribute_barcode_loop] : '';
																	echo '<tr>';
																	echo '<td>'. $group_option_arr[0][$i] . '</td>';
																	echo '<td><input type="text" class="form-control" name="attribute_price[]" value="' . $attr_price . '" placeholder="0.00" ></td>';
																	echo '<td> <input type="text" class="form-control"  name="attribute_sku[]" value="' . $attr_sku . '"></td>';
																	echo '<td> <input type="text" class="form-control" name="attribute_barcode[]" value="' . $attr_barcode . '" > </td>';
																	echo '</tr>';
																	$attribute_price_loop++;
																	$attribute_sku_loop++;
																	$attribute_barcode_loop++;
																}
															}
															
															if($no_groups == 2)
															{
															    $attribute_price_loop = 0;
																$attribute_sku_loop = 0;
																$attribute_barcode_loop = 0;
																for($i=0; $i<count($group_option_arr[0]); $i++) 
																{ 
																	for($j=0; $j<count($group_option_arr[1]); $j++)
																	{			
																		$attr_price = isset($attribute_price [$attribute_price_loop]) ? $attribute_price [$attribute_price_loop] : '';
																		$attr_sku = isset($attribute_sku [$attribute_sku_loop]) ? $attribute_sku [$attribute_sku_loop] : '';
																		$attr_barcode = isset($attribute_barcode [$attribute_barcode_loop]) ? $attribute_barcode [$attribute_barcode_loop] : '';
																		echo '<tr>';
																		echo '<td>'. $group_option_arr[0][$i] . ' . ' . $group_option_arr[1][$j] . '</td>';
																		echo '<td><input type="text" class="form-control" name="attribute_price[]" value="' . $attr_price . '" placeholder="0.00" ></td>';
																		echo '<td> <input type="text" class="form-control"  name="attribute_sku[]" value="' . $attr_sku . '"></td>';
																		echo '<td> <input type="text" class="form-control" name="attribute_barcode[]" value="' . $attr_barcode . '" > </td>';
																		echo '</tr>';
																		$attribute_price_loop++;
																		$attribute_sku_loop++;
																		$attribute_barcode_loop++;
																	}
																	
																}
															}
															
															if($no_groups == 3)
															{
															    $attribute_price_loop = 0;
																$attribute_sku_loop = 0;
																$attribute_barcode_loop = 0;
																for($i=0; $i<count($group_option_arr[0]); $i++) 
																{ 
																	for($j=0; $j<count($group_option_arr[1]); $j++)
																	{   for($k=0; $k<count($group_option_arr[2]); $k++)
																		{		
																			//echo $group_option_arr[1][$k];
																			$attr_price = isset($attribute_price [$attribute_price_loop]) ? $attribute_price [$attribute_price_loop] : '';
																			$attr_sku = isset($attribute_sku [$attribute_sku_loop]) ? $attribute_sku [$attribute_sku_loop] : '';
																			$attr_barcode = isset($attribute_barcode [$attribute_barcode_loop]) ? $attribute_barcode [$attribute_barcode_loop] : '';
																			
																			echo '<tr>';
																			echo '<td>'. $group_option_arr[0][$i] . ' . ' . $group_option_arr[1][$j] . ' . ' . $group_option_arr[2][$k] . '</td>';
																			echo '<td><input type="text" class="form-control" name="attribute_price[]" value="' . $attr_price . '" placeholder="0.00" ></td>';
																			echo '<td> <input type="text" class="form-control"  name="attribute_sku[]" value="' . $attr_sku . '"></td>';
																			echo '<td> <input type="text" class="form-control" name="attribute_barcode[]" value="' . $attr_barcode . '" > </td>';
																			echo '</tr>';
																			$attribute_price_loop++;
																			$attribute_sku_loop++;
																			$attribute_barcode_loop++;
																			
																			
																		}
																	}
																	
																}
															}		
															
																
														?>
													</tbody>
												</table>
											</div>	
										</div>
										
									</div>		
									<?php } else { ?>									
									
																
									
									<div id="variant_wrapper">
									
									<div class="form-group variant" id="variant_label_heading_title" style="display:none;margin-bottom:0">
										<label class="col-md-2 control-label">
											&nbsp;
										</label>
										<div class="col-md-2"> 
											<b>Option name</b>
										</div>
										<div class="col-md-6"> 
											<b>Option values</b>
										</div>
										<div class="col-md-2" style="text-align:left; padding:8px 0 0 0;"> 
											&nbsp;
										</div>
									</div>	
									
									<div class="form-group variant variant_group" id="variant_1" style="display:none">
										<label class="col-md-2 control-label">
											&nbsp;
										</label>
										<div class="col-md-2"> 
											<input type="text" name="group[]" placeholder="Size, Color, Etc." class="form-control input-small" > <br />											
										</div>
										<div class="col-md-6"> 
											<input type="text" placeholder="S, M, L, XL, Etc" name="group_options[][]" id="size_multi_tag" class="form-control input-large variant-tag"  data-role="tagsinput">
										</div>
										
									</div>	
									
									<div class="form-group variant variant_group" id="variant_2"  style="display:none">
										<label class="col-md-2 control-label">
											&nbsp;
										</label>
										<div class="col-md-2"> 
											<input type="text" name="group[]" placeholder="Size, Color, Etc." class="form-control input-small" > <br />
											
										</div>
										<div class="col-md-6"> 
											<input type="text"  name="group_options[][]"  placeholder="Red, Green, Blue, Etc."  id="color_multi_tag" class="form-control input-large variant-tag"  data-role="tagsinput">
										</div>
										
									</div>	
									
									
									<div class="form-group variant variant_group" id="variant_3" style="display:none">
										<label class="col-md-2 control-label">
											&nbsp;
										</label>
										<div class="col-md-2"> 
											<input type="text" name="group[]" placeholder="Size, Color, Etc." class="form-control input-small" > <br />
											
										</div>
										<div class="col-md-6"> 
											<input type="text" name="group_options[][]" placeholder="L, XL, Red, Green, Etc."  id="material_multi_tag" class="form-control input-large variant-tag"  data-role="tagsinput">
										</div>
										
									</div>	
									
									<!--a href="javascript:void(0)" id="variant_add_more"> <span class="glyphicon glyphicon-plus"></span> Add Another</a-->
									
									</div>							
																
									<div id="variantFormElement">									
										
									</div>		
									<?php } ?>
									<div class="form-group">
										<label class="col-md-2 control-label">Collection:
											
										</label>
										<div class="col-md-4"> 
											<input type="text"  name="collection_new" id="collection_new" placeholder="" class="form-control input-medium" >
										</div>
										
										<div class="col-md-6">
										   <div class="part-or-1">Or:</div>
											<div class="part-or-2">
													<select class="table-group-action-input form-control input-medium" name="collection_row_id" id="collection_row_id">
														<option value="0">Use Preset...</option>
														@foreach($data['collection_list'] as $row)
															<option value="{{ $row->collection_row_id }}" @if($data['single_record']->collection_row_id == $row->collection_row_id) selected="selected" @endif >{{ $row->collection_name }}</option>
														@endforeach
													</select>
											</div>	
											<div class="edit_preset"> <a href="{{ url('/')}}/manage-collection"  target="_blank">Edit Presets</a></div>
										</div>										
									</div>				
									
									<div class="form-group">
										<label class="col-md-2 control-label">AKU:</label>
										<div class="col-md-10">
											<div style="float:left;"><input type="text" name="aku_code" maxlength="5" value="{{ $data['single_record']->aku_code }}"  id="aku_code" class="form-control input-medium"  placeholder="5 digit # only"></div><div style="float:left;padding:0 0 0 10px">  <button type="button" id="aku_code_btn" class="btn green btn-large">Generate Art Keeping Unit (AKU)</button></div>											
											<br/><div style="clear:both;padding:5px 0 0 0;color:red" id="aku_code_status"> <input type="hidden" valur="mas9d" name="hidden_aku_code" id="hidden_aku_code" /></div>
										</div>			
									</div>	
									
									<div class="form-group">
										<label class="col-md-2 control-label">Description:</label>
										<div class="col-md-10">		
											<div style="padding:0 0 5px 0">
												<select class="table-group-action-input form-control input-medium" name="description_row_id" id="description_row_id">
													<option value="0">Use Preset...</option>
													@foreach($data['description_list'] as $row)
															<option value="{{ $row->description_row_id }}" @if($data['single_record']->description_row_id == $row->description_row_id) selected="selected" @endif>{{ $row->description_name }}</option>
													@endforeach													
												</select> 
											</div>
											<textarea class="wysihtml5 form-control" rows="8" id="description_new" name="description">{{ $data['single_record']->description }}</textarea>											
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Vendor:
											
										</label>
										<div class="col-md-4"> 
											<input type="text" name="vendor_new" id="vendor_new" placeholder="" class="form-control input-medium" value="@if(isset($data['current_vendorname'])){{ $data['current_vendorname'] }} @endif" readonly>
										</div>										
										<div class="col-md-6">
										   <div class="part-or-1">Or:</div>
											<div class="part-or-2">
													<select class="table-group-action-input form-control input-medium" name="vendor_row_id" id="vendor_row_id">
														<option value="0">Use Preset...</option>
														@foreach($data['vendors_list'] as $row)
															<option value="{{ $row->vendor_row_id }}" @if($data['single_record']->vendor_row_id == $row->vendor_row_id) selected="selected" @endif>{{ $row->vendor_name }}</option>
														@endforeach
													</select>
											</div>	
											 <div class="edit_preset"> <a href="{{ url('/')}}/manage-vendor"  target="_blank">Edit Presets</a></div>
										</div>										
									</div>			
									
									<div class="form-group">
										<label class="col-md-2 control-label">Category:</label>
										<div class="col-md-4"> 
											<input type="text" name="category_new" id="category_new" placeholder="" class="form-control input-medium" >
										</div>										
										<div class="col-md-6">
										   <div class="part-or-1">Or:</div>
											<div class="part-or-2">
													<select class="table-group-action-input form-control input-medium" name="category_row_id" id="category_row_id">
														<option value="0">Use Preset...</option>
														@foreach($data['categories_list'] as $row)
															<option value="{{ $row->category_row_id }}" @if($data['single_record']->category_row_id == $row->category_row_id) selected="selected" @endif>{{ $row->category_name }}</option>
														@endforeach
													</select>
											</div>	
											 <div class="edit_preset"> <a href="{{ url('/')}}/manage-category"  target="_blank">Edit Presets</a></div>
										</div>										
									</div>		
									
									
									
									<div class="form-group">
										<label class="col-md-2 control-label">Product Type:</label>
										<div class="col-md-4"> 
											<input type="text" name="product_type_new" id="product_type_new" placeholder="" class="form-control input-medium" >
										</div>										
										<div class="col-md-6">
										  <div class="part-or-1">Or:</div>
											<div class="part-or-2">
													 <select class="table-group-action-input form-control input-medium" name="product_type_row_id" id="product_type_row_id">
														<option value="0">Use Preset...</option>
														@foreach($data['product_types_list'] as $row)
															<option value="{{ $row->product_type_row_id }}" @if($data['single_record']->product_type_row_id == $row->product_type_row_id) selected="selected" @endif >{{ $row->product_type_name }}</option>
														@endforeach
													</select>
											</div>	
											 <div class="edit_preset"> <a href="{{ url('/')}}/manage-product-type"  target="_blank">Edit Presets</a></div>
										</div>										
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Folder:</label>
										<div class="col-md-4"> 
											<input type="text" name="folder_new" id="folder_new" placeholder="" class="form-control input-medium" >
										</div>										
										<div class="col-md-6">
										  <div class="part-or-1">Or:</div>
											<div class="part-or-2">
													 <select class="table-group-action-input form-control input-medium" name="folder_row_id" id="folder_row_id">
														<option value="0">Use Preset...</option>
														@foreach($data['folder_list'] as $row)
															<option value="{{ $row->folder_row_id }}" @if($data['single_record']->folder_row_id == $row->folder_row_id) selected="selected" @endif>{{ $row->folder_name }}</option>
														@endforeach
													</select>
											</div>	
											 <div class="edit_preset"> <a href="{{ url('/')}}/manage-folder"  target="_blank">Edit Presets</a></div>
										</div>										
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Is Favorite:</label>
										<div class="col-md-4">	
											<div class="ichek_options">
											<input type="hidden" name="assign_to_folder">
											<input type="checkbox" class="icheck" name="is_favourite" @if($data['single_record']->is_favourite) checked="checked" @endif>
											</div>
										</div>
									</div>
									
									
									
									<div class="form-group">
										<label class="col-md-2 control-label">Product Primary Image:</label>
										<div class="col-md-10">
											@if($data['single_record']->product_image && $data['single_record']->image_external_link)
											<img style="width:100px;height:80px" src="{{ $data['single_record']->product_image }}" alt="image" />
											@else
											<div action="{{ url('/')}}/upload-product-image" class="dropzone dropzone-file-area sortable" id="productImagesDropzone" style="margin:0; width: 400px; margin-top: 0px;background-color:#f1f1f1"">
											<b>Drop Primary Image Here or Click to Upload</b><br />
											<div class="dz-default dz-message"><span></span></div>	
											@if($data['single_record']->product_image)
												<div id="uploaded_product_image_box" class="dz-preview dz-processing dz-image-preview dz-success dz-complete design-image-preview "> 
													<div class="dz-image">
														<img data-dz-thumbnail="" style="width:120px;height:120px" alt="product image" src="{{ url('/')}}/public/uploads/product_images/{{ $data['user_id']}}/{{ $data['single_record']->product_image }}"  /> 
													</div>  
													<div class="dz-error-mark">   
														<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Error</title>      <defs></defs>
															<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> 
																<g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
																	<path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
																</g>
															</g>   
														</svg>  
													</div>
													<a href="javascript:;" '=""   class="btn red btn-sm btn-block product-image-delete">Remove</a>
												</div>
											@endif	
											</div>
											@endif
										</div>
									</div>
									
									<div class="form-group" style="padding-top:20px">
										<label class="col-md-2 control-label">Product Secondary Image(s):</label>
										<div class="col-md-10">
											
											<div action="{{ url('/')}}/upload-secondary-image" class="dropzone dropzone-file-area sortable" id="productSecondaryImagesDropzone" style="margin:0; width: 400px; margin-top: 0px;background-color:#f1f1f1"">
												<b>Drop Secondary Image(s) Here or Click to Upload</b><br />
												
												
												<div class="dz-default dz-message"><span></span></div>			
												 <?php for($i=0; $i<count($data['product_secondary_images']); $i++) { ?>
													<div id="secondary_image_<?php echo $i;?>" class="dz-preview dz-processing dz-image-preview dz-success dz-complete"> 
														<div class="dz-image">
														  <img data-dz-thumbnail="" style="width:120px;height:120px"  alt="product image" src="{{ url('/')}}/public/uploads/product_images/{{$data['user_id']}}/<?php echo $data['product_secondary_images'][$i] ?>" /> 														  
														</div>  
														<div class="dz-error-mark">   
															<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Error</title>      <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">          <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
																 </g>      </g>   
															</svg>  
														</div>
														
														<a href="javascript:;" '=""  secondary_image_name = "<?php echo $data['product_secondary_images'][$i] ?>"  id="secondary_image_<?php echo $i;?>" class="btn red btn-sm btn-block product-secondary-image-remove">Remove</a>														
													</div>
													
												<?php } ?>	
													
												
											 </div>
											
										</div>
									</div>

								<div class="form-group" style="padding-top:0px">
									<label class="col-md-2 control-label">Production Art Url 1:</label>
									<div class="col-md-10">
										<input type="text" name="production_art_url_1" value="{{ $data['single_record']->production_art_url_1 }}" class="form-control" >
									</div>
								</div>	

								<div class="form-group" style="padding-top:0px">
									<label class="col-md-2 control-label">Production Art Url 2:</label>
									<div class="col-md-10">
										<input type="text" name="production_art_url_2" value="{{ $data['single_record']->production_art_url_2 }}" class="form-control" >
									</div>
								</div>	

								<div class="form-group" style="padding-top:0px">
									<label class="col-md-2 control-label">Print Mode:</label>
									<div class="col-md-10">
										<input type="text" name="print_mode" value="{{ $data['single_record']->print_mode }}" class="form-control input-medium" >
									</div>
								</div>	
								
								
									
								<div class="form-group">
									<label class="col-md-2 control-label">Print Location 1:</label>
									<div class="col-md-10">
										<input type="text" name="print_location" value="{{ $data['single_record']->print_location }}" class="form-control input-medium" >
									</div>
								</div>	
								
								<div class="form-group">
									<label class="col-md-2 control-label">Print Location 2:</label>
									<div class="col-md-10">
										<input type="text" name="print_location2" value="{{ $data['single_record']->print_location2 }}" class="form-control input-medium">
									</div>
								</div>	
									
								</div>							
							</div>						
							
							<div class="tab-pane" id="tab_details">
								<div class="form-body">
								
								<div class="form-group">
										<label class="col-md-2 control-label">Length:</label>
										<div class="col-md-4"> 
											<input type="text" class="form-control" id="product_length" name="product_length" value="{{ $data['single_record']->product_length }}" > 
										</div>
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span class="elements_dropdown_default_val" id="selected_product_length_unit" style="display:inline-block;width:40px"></span>
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu">
														<li><a href="javascript:;" onclick="setElements('product_length_unit', '')" >Select</a></li>
														<li><a href="javascript:;" onclick="setElements('product_length_unit', 'Ft')" >Ft</a></li>
														<li><a href="javascript:;" onclick="setElements('product_length_unit', 'M')">M</a></li> 
														<li><a href="javascript:;" onclick="setElements('product_length_unit', 'Cm')" >Cm</a></li>
														<li><a href="javascript:;" onclick="setElements('product_length_unit', 'Inch')">Inch</a></li> 															
													</ul>
												    <input type="hidden" name="product_length_unit" id="product_length_unit" value="{{  $data['single_record']->product_length_unit }}" >
												</div>
											</div>
										</div>
									</div>	
									
								
								<div class="form-group">
										<label class="col-md-2 control-label">Width:</label>
										<div class="col-md-4"> <input type="text" class="form-control" id="product_width" name="product_width" value="{{  $data['single_record']->product_width }}" >  </div>
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span class="elements_dropdown_default_val" id="selected_product_width_unit" style="display:inline-block;width:40px">Select</span>
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu">
														<li><a href="javascript:;" onclick="setElements('product_width_unit', '')" >Select</a></li>
														<li><a href="javascript:;" onclick="setElements('product_width_unit', 'Ft')" >Ft</a></li>
														<li><a href="javascript:;" onclick="setElements('product_width_unit', 'M')">M</a></li> 
														<li><a href="javascript:;" onclick="setElements('product_width_unit', 'Cm')" >Cm</a></li>
														<li><a href="javascript:;" onclick="setElements('product_width_unit', 'Inch')">Inch</a></li> 															
													</ul>
												    <input type="hidden" name="product_width_unit" id="product_width_unit" value="{{  $data['single_record']->product_width_unit }}" >
												</div>
											</div>
										</div>
									</div>		
									
								
								
								<div class="form-group">
										<label class="col-md-2 control-label">Height:</label>
										<div class="col-md-4"> <input type="text" class="form-control" id="product_height" name="product_height" value="{{  $data['single_record']->product_height }}" >  </div>
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span class="elements_dropdown_default_val" id="selected_product_height_unit" style="display:inline-block;width:40px">Select</span>
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu">
														<li><a href="javascript:;" onclick="setElements('product_height_unit', '')" >Select</a></li>
														<li><a href="javascript:;" onclick="setElements('product_height_unit', 'Ft')" >Ft</a></li>
														<li><a href="javascript:;" onclick="setElements('product_height_unit', 'M')">M</a></li> 
														<li><a href="javascript:;" onclick="setElements('product_height_unit', 'Cm')" >Cm</a></li>
														<li><a href="javascript:;" onclick="setElements('product_height_unit', 'Inch')">Inch</a></li> 															
													</ul>
												   <input type="hidden" name="product_height_unit" id="product_height_unit" value="{{  $data['single_record']->product_height_unit }}" >
												</div>
											</div>
										</div>
									</div>
									
								
								<div class="form-group">
										<label class="col-md-2 control-label">Cost:
											
										</label>
										<div class="col-md-4"> <input type="text" class="form-control" id="product_cost" name="product_cost" value="{{  $data['single_record']->product_cost }}" placeholder="0.00" >  </div>
										
										<div class="col-md-6">
										   
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span id="selected_product_cost_unit" style="display:inline-block;width:40px">$</span>
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu">															
														<li><a href="javascript:;" onclick="setElements('product_cost_unit', '$')" >$</a></li>
														<li><a href="javascript:;" onclick="setElements('product_cost_unit', '&euro;')">&euro;</a></li>                                                           
													</ul>
													<input type="hidden" name="product_cost_unit" id="product_cost_unit" value="{{  $data['single_record']->product_cost_unit }}" >
												</div>												
											</div>
										</div>											
									</div>
									
								
								
								
								<div class="form-group">
									<label class="col-md-2 control-label">
										Stock levels:
									</label>
									<div class="col-md-4"> <input type="text" class="form-control" id="product_stock" name="product_stock" value="{{  $data['single_record']->product_stock }}" placeholder="0.00" >  </div>
									<div class="col-md-6">										
										<div class="input-group-btn">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span id="selected_product_stock_type" style="display:inline-block;width:80px">Select</span>
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu">															
														<li><a href="javascript:;" onclick="setElements('product_stock_type', 'On-Demand / Unlimited')" >On-Demand / Unlimited</a></li>
														<li><a href="javascript:;" onclick="setElements('product_stock_type', 'On-Demand / Limited')">On-Demand / Limited</a></li> 
														<li><a href="javascript:;" onclick="setElements('product_stock_type', 'Inventoried / Unlimited')" >Inventoried / Unlimited</a></li>
														<li><a href="javascript:;" onclick="setElements('product_stock_type', 'Inventoried / Limited')">Inventoried / Limited</a></li> 														
													</ul>
										</div>
										<input type="hidden" name="product_stock_type" id="product_stock_type" value="{{  $data['single_record']->product_stock_type }}" >
									</div>
								</div>
									
								<div class="form-group">
									<label class="col-md-2 control-label">Inventory Serial:</label>
									<div class="col-md-10">
										<input type="text" class="form-control" value="{{  $data['single_record']->inventory_serial }}" name="inventory_serial" placeholder=""> </div>
								</div>
									
								<div class="form-group">
									<label class="col-md-2 control-label">Tags:
										
									</label>
									<div class="col-md-4">											
										<select class="form-control input-medium" name="tag_group_row_id" >
											<option value="0">Select Tag Group</option>
											@foreach($data['tag_groups'] as $row)
												<option value="{{ $row->tag_group_row_id }}" @if($data['single_record']->tag_group_row_id == $row->tag_group_row_id) selected="selected" @endif >{{ $row->tag_group_name }}</option>
											@endforeach
																						
										</select>
									</div>
									<div class="col-md-6">											
										<input type="text" name="tags" value="{{  $data['single_record']->tags }}" class="form-control input-large"  data-role="tagsinput">
									</div>
								</div>
									
								<div class="form-group">
									<label class="col-md-2 control-label">Number of Pieces:
									</label>
									<div class="col-md-10">
									<input type="text" class="form-control" name="number_of_pieces" value="{{  $data['single_record']->number_of_pieces }}" placeholder=""> </div>											
								</div>
								</div>
							</div>
							
							
							<div class="tab-pane" id="tab_price_level">							 
								<div class="form-body">
									@foreach($data['price_list'] as $row)
										<?php 
										if (array_key_exists($row->customer_group_row_id, $data['price_types'])) {
											if($data['price_types'][$row->customer_group_row_id] != '') {
												$value = number_format($data['price_types'][$row->customer_group_row_id], 2);
											}
										} else {
											$value = '';
										}

										?>
										<div class="form-group">
										<label class="col-md-2 control-label">{{$row->customer_group_name}}
											
										</label>
										<div class="col-md-2"> 
											<input type="text" class="form-control"  value="{{ $value }}" id="product_level_amount_{{$row->customer_group_row_id}}" name="product_level_amount[{{$row->customer_group_row_id}}][]" placeholder="0.00" >  
										</div>
										<div class="col-md-2">
											<select class="table-group-action-input form-control" name="product_level_amount_normal_price[]" >													
												<option value="0"> Select</option>												
												<option value="3">% Above Cost</option>
												<option value="4">% Below Cost</option>
												<option value="1">Amount Above Cost</option>
												<option value="2">Amount Below Cost</option>
											</select>
										</div>
										
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span id="selected_product_cost_unit_{{$row->customer_group_row_id}}" style="display:inline-block;width:40px">$</span>
															<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu">															
														<li><a href="javascript:;" onclick="setElements('product_cost_unit_{{$row->customer_group_row_id}}', '$')" >$</a></li>
														<li><a href="javascript:;" onclick="setElements('product_cost_unit_{{$row->customer_group_row_id}}', '&euro;')">&euro;</a></li>                                                           
													</ul>
													<input type="hidden" name="product_cost_unit_{{$row->customer_group_row_id}}" id="product_cost_unit_{{$row->customer_group_row_id}}" value="$" >
												</div>												
											</div>
										</div>											
									</div>										
									@endforeach
															
								</div>							
							</div>	
							
							<div class="tab-pane" id="tab_shipping">
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Ship Cartons:
											
										</label>
										<div class="col-md-10">											
											<select class="form-control input-medium" name="ship_cartoon">												
												@for($i=1; $i<=20; $i++)												    
													<option value="{{ $i}}"> {{ $i}}</option>
												@endfor									
											</select>
										</div>										
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Ship Weight:
											
										</label>
										<div class="col-md-4"> <input type="text" class="form-control" id="ship_weight" name="ship_weight" value="{{  $data['single_record']->ship_weight }}" >  </div>
										
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span class="elements_dropdown_default_val" id="selected_ship_weight_unit" style="display:inline-block;width:40px"></span>
															<i class="fa fa-angle-down"></i>
														</button>
														<ul class="dropdown-menu">
															<li><a href="javascript:;" onclick="setElements('ship_weight_unit', '')" >Select</a></li>
                                                            <li><a href="javascript:;" onclick="setElements('ship_weight_unit', 'lb')" > lb </a></li>
                                                            <li><a href="javascript:;" onclick="setElements('ship_weight_unit', 'oz')"> oz </a></li>
                                                            <li><a href="javascript:;" onclick="setElements('ship_weight_unit', 'kg')">kg </a></li>
                                                            <li><a href="javascript:;" onclick="setElements('ship_weight_unit','g')">g </a></li>
														</ul>
														<input type="hidden" name="ship_weight_unit" id="ship_weight_unit" value="{{  $data['single_record']->ship_weight_unit }}" >
												</div>
											</div>
										</div>											
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Ship Width:
											
										</label>
										<div class="col-md-4"> 
											<input type="text" class="form-control" id="ship_width"  name="ship_width" value="{{  $data['single_record']->ship_width }}" placeholder="0.00" >
										</div>
										
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span class="elements_dropdown_default_val" id="selected_ship_width_unit" style="display:inline-block;width:40px"></span>
															<i class="fa fa-angle-down"></i>
														</button>
														<ul class="dropdown-menu">
															<li><a href="javascript:;" onclick="setElements('ship_width_unit', '')" >Select</a></li>
															<li><a href="javascript:;" onclick="setElements('ship_width_unit', 'Ft')" >Ft</a></li>
															<li><a href="javascript:;" onclick="setElements('ship_width_unit', 'M')">M</a></li> 
															<li><a href="javascript:;" onclick="setElements('ship_width_unit', 'Cm')" >Cm</a></li>
															<li><a href="javascript:;" onclick="setElements('ship_width_unit', 'Inch')">Inch</a></li>  															
														</ul>
													<input type="hidden" name="ship_width_unit" id="ship_width_unit" value="{{  $data['single_record']->ship_width_unit }}" />
												</div>
											</div>
										</div>											
									</div>	
									
									<div class="form-group">
										<label class="col-md-2 control-label">Ship Length:</label>
										<div class="col-md-4"> <input type="text" class="form-control" id="ship_length" name="ship_length" value="{{  $data['single_record']->ship_length }}" >  </div>
										
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span class="elements_dropdown_default_val" id="selected_ship_length_unit" style="display:inline-block;width:40px"></span>
															<i class="fa fa-angle-down"></i>
														</button>
														<ul class="dropdown-menu">
															<li><a href="javascript:;" onclick="setElements('ship_length_unit', '')" >Select</a></li>
															<li><a href="javascript:;" onclick="setElements('ship_length_unit', 'Ft')" >Ft</a></li>
															<li><a href="javascript:;" onclick="setElements('ship_length_unit', 'M')">M</a></li> 
															<li><a href="javascript:;" onclick="setElements('ship_length_unit', 'Cm')" >Cm</a></li>
															<li><a href="javascript:;" onclick="setElements('ship_length_unit', 'Inch')">Inch</a></li>  															
														</ul>
													<input type="hidden" name="ship_length_unit" id="ship_length_unit" value="{{  $data['single_record']->ship_length_unit }}" >
												</div>
											</div>
										</div>											
									</div>	
									<div class="form-group">
										<label class="col-md-2 control-label">Ship Height:</label>
										<div class="col-md-4"> <input type="text" class="form-control" id="ship_height" name="ship_height" value="{{  $data['single_record']->ship_height }}" >  </div>										
										<div class="col-md-6">
											<div class="part-or-3">
												<div class="input-group-btn" class="col-md-4" style="float:left;width:110px">
													<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown"><span class="elements_dropdown_default_val" id="selected_ship_height_unit" style="display:inline-block;width:40px"></span>
															<i class="fa fa-angle-down"></i>
														</button>
														<ul class="dropdown-menu">
															<li><a href="javascript:;" onclick="setElements('ship_height_unit', '')" >Select</a></li>
															<li><a href="javascript:;" onclick="setElements('ship_height_unit', 'Ft')" >Ft</a></li>
															<li><a href="javascript:;" onclick="setElements('ship_height_unit', 'M')">M</a></li> 
															<li><a href="javascript:;" onclick="setElements('ship_height_unit', 'Cm')" >Cm</a></li>
															<li><a href="javascript:;" onclick="setElements('ship_height_unit', 'Inch')">Inch</a></li> 															
														</ul>
													<input type="hidden" name="ship_height_unit" id="ship_height_unit" value="{{  $data['single_record']->ship_height_unit }}" >
												</div>
											</div>
										</div>											
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">  Master Carton:
											
										</label>
										<div class="col-md-10">
											<input type="text" class="form-control" name="master_cartoon" value="{{  $data['single_record']->master_cartoon }}" placeholder=""> </div>
									</div>
								
									
								</div>
							</div>
							
							<div class="tab-pane" id="tab_images">
								
							</div>
							
							<div class="tab-pane" id="tab_meta">
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Meta Title:</label>
										<div class="col-md-10">
											<input type="text" class="form-control maxlength-handler" name="product_meta_title" maxlength="100" value="{{  $data['single_record']->product_meta_title }}" placeholder="">
											
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Meta Keywords:</label>
										<div class="col-md-10">
											<textarea class="form-control maxlength-handler" rows="5" name="product_meta_keyword" maxlength="1000">{{  $data['single_record']->product_meta_keyword }}</textarea>
											
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Meta Description:</label>
										<div class="col-md-10">
											<textarea class="form-control maxlength-handler" rows="5" name="product_meta_description" maxlength="255">{{  $data['single_record']->product_meta_description }}</textarea>
											
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label">Handle: </label>
										<div class="col-md-10">
											<input type="text" class="form-control" id="handle" name="handle" value="{{ $data['single_record']->handle }}" >											
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Base URL: </label>
										<div class="col-md-10">
											<input type="text" class="form-control" id="handle_url" name="handle_url" value="{{ url('/')}}/products/{{ $data['single_record']->handle }}">											
										</div>
									</div>
									
								</div>
							</div>			

							<div class="tab-pane" id="tab_dynamic_field">
								<div class="form-body dynamic-section">	
									<?php $i = 0; ?>
									@if(count($data['dynamic_fields']))
									    @foreach($data['dynamic_fields'] as $key => $val)
										<?php
											$field_name = '';
											if(array_key_exists($key, $data['build_dynamic_field_row'])) {
												$field_name =  $data['build_dynamic_field_row'][$key];
											}
										 	//if($val == '') continue; 
										?>
											<div class="form-group" id="meta_first_option">		
												<label class="col-md-2 control-label">
													<?php if($i == 0) :?>Dynamic Fields:<?php endif; ?>
												</label>
												<div class="col-md-4">
													<input type="text" class="form-control" value="{{ $field_name }}" name="dynamic_fields[][]"  placeholder="Name">											
												</div>
												<div class="col-md-4">
													<input type="text" class="form-control" value="{{ $val }}" name="dynamic_fields_value[{{$key}}]" placeholder="Value">											
												</div>
												<div class="col-md-2 remove_field_icon_wrapper"><a href="#" dynamic_field_row_id = "{{ $row->dynamic_field_row_id }}" class="remove_each_dynamic_field">Remove</a></div>
												<input type="hidden" value="{{ $row->dynamic_field_row_id }}" name="dynamic_field_row_id[]" />
											</div>
											<?php $i++; ?>
										@endforeach
									@else
										<div class="form-group" id="meta_first_option">		
											<label class="col-md-2 control-label">Dynamic Fields:</label>
											<div class="col-md-4">
												<input type="text" class="form-control" name="dynamic_fields[]"  placeholder="Name">											
											</div>
											<div class="col-md-4">
												<input type="text" class="form-control" name="dynamic_fields_value[]" placeholder="Value">											
											</div>
										</div>
									@endif
									
									<div class="form-group" id="add_dynamic_field_wrapper">
										<div class="col-md-4 col-md-offset-2">
											<button class="btn btn-default	 add_dynamic_field">+ Add Another Field</button>
										</div>
									</div>		
								
								</div>
							</div>	
						
						    <div class="actions btn-set" style="float:right;margin:30px 0">
								<button type="button" name="back" class="btn btn-secondary-outline back-button">
									<i class="fa fa-angle-left"></i> Back
								</button>								
								<button class="btn btn-success">
									<i class="fa fa-check"></i> Save
								</button>
								<!--button class="btn btn-success">
									<i class="fa fa-check-circle"></i> Save & Continue Edit
								</button-->						
							</div> 
						</div>
						
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- END PAGE BASE CONTENT -->
	<div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Manage Variant Group and Value</h4>
				</div>
				
				<div class="modal-body">
					<input type="hidden" name="product_row_id" value="{{ $data['single_record']->product_row_id }}" >
					<?php $c = 1;?>
					@foreach($data['attribute_groups'] as $group)
					<form action="{{ URL::to('/') }}/addVariantsGroupOptions" class="form-horizontal" method="post" >
						{!! csrf_field() !!}	
						<input type="hidden" name="attribute_group_row_id" value="{{ $group->attribute_group_row_id}}" >
						<input type="hidden" name="product_row_id" value="{{ $data['single_record']->product_row_id }}" >
						<div class="form-group variant variant_group">												
							<div class="col-md-4"> 
								<input type="text" name="group" value="{{ $group->attribute_group_name}}"  class="form-control input-small" > <br />											
							</div>
							<div class="col-md-5"> 
								<input type="text" value="{{ $group->attribute_group_options}}"  name="group_options"  class="form-control input-large"  data-role="tagsinput">													
							</div>
							<div class="col-md-2"> 
								<button class="btn sbold green">Update &nbsp;</button>
							</div>
						</div>	
						<?php $c++; ?>
						
					 </form>   
					@endforeach
											
					@for($i=count($data['attribute_groups'] ); $i<3;  $i++)		
					<form action="{{ URL::to('/') }}/addVariantsGroupOptions" class="form-horizontal" method="post" >
					{!! csrf_field() !!}										
					<input type="hidden" name="attribute_group_row_id" value="0" >
					<input type="hidden" name="product_row_id" value="{{ $data['single_record']->product_row_id }}" >
					<div class="form-group variant variant_group"  style="display:none">
						
						<div class="col-md-4"> 
							<input type="text" name="group" placeholder="Size, Color, Etc." class="form-control input-small" > <br />
						</div>
						<div class="col-md-5"> 
							<input type="text"  name="group_options"  placeholder="Red, Green, Blue, Etc." class="form-control input-large variant-tag"  data-role="tagsinput">
						</div>	
						<div class="col-md-2"> 
							<button class="btn sbold green">Add New</button>
						</div>	
					</div>	
					</form>
					@endfor									
				</div>	
			</div>
		</div>
	</div>
	
</div>

@endsection

@section('select2js')
	<!-- BEGIN PAGE LEVEL PLUGINSproduct -->
		
		 <script src="{{asset('/')}}/public/css/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
		 <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
		
		 <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
        <script src="{{asset('/')}}/public/css/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{asset('/')}}/public/css/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
		
	<!-- END PAGE LEVEL PLUGINS -->
@endsection		

@section('after-app-js')
	<!-- BEGIN PAGE LEVEL SCRIPTSproduct -->	
	 <script src="{{asset('/')}}/public/css/assets/pages/scripts/components-bootstrap-tagsinput.min.js" type="text/javascript"></script>
	 <script src="{{asset('/')}}/public/css/assets/pages/scripts/form-dropzone.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL SCRIPTS -->		
	<script src="{{asset('/')}}/public/css/assets/pages/scripts/components-editors.min.js" type="text/javascript"></script>	
	<script src="{{asset('/')}}/public/css/assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
	<style type="text/css">
		.btn:not(.md-skip):not(.bs-select-all):not(.bs-deselect-all) {text-transform:none;}
		.ichek_options{padding-top:8px}
	</style>
	<script type="text/javascript"> 
	
	function setWeightIcon( weightVal)
	{	  
	  $(this).html( weightVal);
	  $(this).val( weightVal);	  
	}
	
	function setElements(element, unitVal)
	{
	  if(unitVal == '') {
	   $('#selected_' + element).html('Select');	 
	  } else {
		$('#selected_' + element).html( unitVal);	 
	  }
	  
	  $('#' + element ).val( unitVal);	  
	}
	
	$("#product_name").blur(function (e) {
		var str = $(this).val() ;
		str = str.replace(/\s+/g, '-').toLowerCase();
		$('#handle').val(str);
		$('#handle_url').val( "{{ url('/')}}/products/" + str );
    });
	
	$('#tab_all').click( function() {
		$('#tab_general').addClass("active");
		$('#tab_details').addClass("active");
		$('#tab_price_level').addClass("active");
		$('#tab_shipping').addClass("active");
		$('#tab_meta').addClass("active");
		$('#tab_dynamic_field').addClass("active");
	});
	
	
	$(".preset_product_level_amount, .preset_cents_product_level_amount").change(function() 
	{		
	    var preset_customer_group_row_id =  $(this).attr("customer_group_row_id");		
		var preset =  $("#preset_product_level_amount_" + preset_customer_group_row_id).val();
		var cents_preset =  $("#preset_cents_product_level_amount_" + preset_customer_group_row_id).val();	
	    $("#product_level_amount_" + preset_customer_group_row_id).val(preset + '.' + cents_preset);		
	});
	
	$("#price_preset, #price_cents_preset").change(function() 
	{
		var preset =  $("#price_preset").val();
		var cents_preset =  $("#price_cents_preset").val();		
	    $("#product_price").val(preset + '.' + cents_preset);		
	});
	
	$("#cost_preset, #cost_cents_preset").change(function() 
	{
		var preset =  $("#cost_preset").val();
		var cents_preset =  $("#cost_cents_preset").val();		
	    $("#product_cost").val(preset + '.' + cents_preset);		
	});
	
	
	$('.back-button') .click( function() {	
		window.location.href= "{{ url('/')}}/manage-product";
	});
	
	
	$("#collection_new").blur(function (e) {
        if( $("#collection_new").val() ) {
			$("#collection_row_id").val("0");	
			 $("#collection_row_id").prop("disabled", true);
			  $('#edit_collection').hide();	
		} else {
		  $("#collection_row_id").prop("disabled", false);		
		}
    });
	
	$("#vendor_new").blur(function (e) {	
        if( $("#vendor_new").val() ) {
			$("#vendor_row_id").val("0");	
			 $("#vendor_row_id").prop("disabled", true);
			  $('#edit_vendor').hide();	
		} else {
		  $("#vendor_row_id").prop("disabled", false);		
		}
    });
	
	
	$("#category_new").blur(function (e) {
        if( $("#category_new").val() ) {
			$("#category_row_id").val("0");	
			 $("#category_row_id").prop("disabled", true);
			  $('#edit_category').hide();	
		} else {
		  $("#category_row_id").prop("disabled", false);		
		}
    });
	
	
	 
	$("#product_type_new").blur(function (e) {
        if( $("#product_type_new").val() ) {
			$("#product_type_row_id").val("0");	
			 $("#product_type_row_id").prop("disabled", true);
			  $('#edit_product_type').hide();	
		} else {
		  $("#product_type_row_id").prop("disabled", false);		
		}
    });
	
	$("#folder_new").blur(function (e) {
        if( $("#folder_new").val() ) {
			$("#folder_row_id").val("0");	
			 $("#folder_row_id").prop("disabled", true);
			  $('#edit_folder').hide();	
		} else {
		  $("#folder_row_id").prop("disabled", false);		
		}
    });
	

$('#handle').on('input', function(event) {
	var handle = $(this).val();
	$('#handle_url').val("{{ url('/')}}/products/" + handle);
});


	$("#weight_preset").change(function() 
	{
	    $("#product_weight").val($(this).val());		
	});
	
	$("#length_preset").change(function() 
	{
	    $("#product_length").val($(this).val());		
	});
	$("#length_preset").change(function() 
	{
	    $("#product_length").val($(this).val());		
	});
	
	$("#width_preset").change(function() 
	{
	    $("#product_width").val($(this).val());		
	});
	$("#height_preset").change(function() 
	{
	    $("#product_height").val($(this).val());		
	});
	
	$("#ship_weight_preset").change(function() 
	{
	    $("#ship_weight").val($(this).val());		
	});
	$("#ship_width_preset").change(function() 
	{
	    $("#ship_width").val($(this).val());		
	});
	
	$("#ship_length_preset").change(function() 
	{
	    $("#ship_length").val($(this).val());		
	});
	$("#ship_height_preset").change(function() 
	{
	    $("#ship_height").val($(this).val());		
	});
	
	
	$("#description_row_id").change(function() 
	{
		if( $(this).val() != 0 )
		{
			var description_row_id = $(this).val();
			$.ajax({
				url: "{{ url('setDescriptionField') }}" + "/" + description_row_id,
				type: "GET",	
				dataType:"html",
				success: function(data){					
					var ed = $("#description_new").data('wysihtml5').editor;					
					ed.setValue(data, true);					
				},
			});		 
			
		}
	});
	
	
	$('#add_variant_btn').click( function() {	
	
		$('#variant_label_heading_title').show();
		$('#variant_1').show();
		$('#variant_wrapper').show();	
		$('.variant_group').show();	
		
		$('#variantFormElement').show();		
		$(this).hide();
		$('#cancel_variant_btn').show();
		$('#manage_variant_option').show();
		
	});
	
	$('#cancel_variant_btn').click( function() {		
		$(this).hide();
		$('#add_variant_btn').show();
		$('#variant_wrapper').hide();
		$('#variantFormElement').hide();
		$('#manage_variant_option').hide();
	});
	
	$('#variant_add_more').click( function() {
			$('.variant_group').show();
	});	
	
	
	$('#variant_1_add_more').click( function() {
	
		$('#variant_2').show();
	});	
	
	$('#variant_2_add_more').click( function() {
		$('#variant_3').show();
	});	
	
	$('.variant_delete').click( function() {	
	
		var textBoxid = $(this).attr('textBoxid');
		$('#' + textBoxid).val('');		
		//$('#variant_2').find('span.label-info').remove();		
		$(this).parent(). parent(). hide();		
		generateVariantContent();		
	});
	
	$('.variant').keyup(function(e)
	{	
	   if(e.keyCode == 8)
		{				
			generateVariantContent();		  
		}
	})
	
	
	
	$('.variant').keypress(function(event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);		
		
		if(keycode == '13' || keycode == '44')
		{
		generateVariantContent();			
		}
	});
	
	
	function generateVariantContent() 
	{
		var buildRow='';
		$str = '<div class="form-group"><label class="col-md-2 control-label"></label><div class="col-md-10">'
											+'<table class="table">'
                                            + '<thead>'
                                            + '<tr><th>Variant </th><th> Price</th><th> SKU </th><th>Barcode </th></tr>'
											+ '</thead>'
											+ '<tbody>';
											
			var size_multi_tag_val  = $('#size_multi_tag').val().trim();			
			if(size_multi_tag_val)			
			var size_multi_tag_array = size_multi_tag_val.split(',');
			else
			var size_multi_tag_array = [];		
			
			
			var color_multi_tag_val  = $('#color_multi_tag').val().trim();
			if(color_multi_tag_val)			
			var color_multi_tag_array = color_multi_tag_val.split(',');
			else
			var color_multi_tag_array = [];
			
			
			var material_multi_tag_val  = $('#material_multi_tag').val().trim();
			if(material_multi_tag_val)			
			var material_multi_tag_array = material_multi_tag_val.split(',');
			else
			var material_multi_tag_array = [];
			
			// Size combination
			if(size_multi_tag_array.length && !color_multi_tag_array.length && !material_multi_tag_array.length)
			{
			    buildRow = '';
			    for(i=0; i<size_multi_tag_array.length; i++)
				{
						buildRow += '<tr><td>' + size_multi_tag_array[i] +  '</td><td><input type="text" class="form-control" name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control"  name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';						
				}
			}
			
			if(size_multi_tag_array.length  && color_multi_tag_array.length && !material_multi_tag_array.length)
			{			
			    buildRow = '';
			    for(i=0; i<size_multi_tag_array.length; i++)
				{
					for(k=0; k<color_multi_tag_array.length; k++)
					{
					buildRow += '<tr><td>' + size_multi_tag_array[i] + ' . ' +  color_multi_tag_array[k] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';						
					}	
				}
			}
			
			if(size_multi_tag_array.length  && material_multi_tag_array.length && !color_multi_tag_array.length)
			{			
				buildRow = '';
				for(i=0; i<size_multi_tag_array.length; i++)
				{
					for(k=0; k<material_multi_tag_array.length; k++)
					{
					
					  buildRow += '<tr><td>' + size_multi_tag_array[i] + ' . ' +  material_multi_tag_array[k] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
					
					}
				}
			}
			
			
			//color combination
			if(color_multi_tag_array.length && !size_multi_tag_array.length && !material_multi_tag_array.length)
			{
			    buildRow = '';
			    for(i=0; i<color_multi_tag_array.length; i++)
				{
						buildRow += '<tr><td>' + color_multi_tag_array[i] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
				}
			}
			
			if(color_multi_tag_array.length  && material_multi_tag_array.length && !size_multi_tag_array.length)
			{
			        buildRow = '';
			        for(i=0; i<color_multi_tag_array.length; i++)
						{
							for(k=0; k<material_multi_tag_array.length; k++)
							{
							
							  buildRow += '<tr><td>' + color_multi_tag_array[i] + ' . ' +  material_multi_tag_array[k] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
							
							}
						}
			   
			}
			
		//material combination	
		if(material_multi_tag_array.length && !size_multi_tag_array.length && !color_multi_tag_array.length)
		{
			    buildRow = '';
			    for(i=0; i<material_multi_tag_array.length; i++)
				{
						buildRow += '<tr><td>' + material_multi_tag_array[i] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
				}
		}
			
			
		if(size_multi_tag_array.length && color_multi_tag_array.length && material_multi_tag_array.length)
		{
			for(i=0; i<size_multi_tag_array.length; i++)
			{		  
			  
			   for(j=0; j<color_multi_tag_array.length; j++) 
			   { 			   
				 
				  for(k=0; k<material_multi_tag_array.length; k++) 
					{
				 
						buildRow += '<tr><td>' + size_multi_tag_array[i] + '.' + color_multi_tag_array[j] + '.' + material_multi_tag_array[k] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
					}					
			   }
			}		
		}
			
		$str += buildRow
			    + '</tbody>'
				+ '</table>'
				+ '</div></div>';
				

			
		if(!size_multi_tag_array.length && !color_multi_tag_array.length  && !material_multi_tag_array.length)
		{	
			$str = '';

		}			
			
		$('#variantFormElement').html($str);
			
	}
	

	

	$('#aku_code').blur( function() {	
		var aku_code =  $(this).val();
		
		if(!aku_code)
		return;
		
		if( aku_code.length <5 )
		{
		   $('#aku_code_status').html('Must be 5 digit #');
			$('#aku_code').val('');						
			return;			
		}
		
		$.ajax({
				url: "{{ url('is_valid_aku_code') }}/" + aku_code,
				type: "GET",	
				dataType:"html",
				success: function(data){
					if(data == 'exist')
					{
						$('#aku_code_status').html('The code is already exist, Please choose another!');
						$('#aku_code').val('');
					}
					else
					$('#aku_code_status').html('');

				},
				
            });
			
	});
	
$('#aku_code_btn') . click(function() {
	$.ajax({
			url: "{{ url('generate_aku_code') }}",
			type: "GET",			
			success: function(data){
				$('#aku_code').val(data['aku_code']);
				$('#aku_code_status').html('');
				
			},
			 dataType:"json"
		});
})	



    $("#aku_code").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	 
	
	
	
	
	/*
	function setWeightIcon( weightVal)
	{	  
	  $(this).html( weightVal);
	  $(this).val( weightVal);	  
	}
	
	function setElements(element, unitVal)
	{
	  if(unitVal == '') {
	   $('#selected_' + element).html('Select');	 
	  } else {
		$('#selected_' + element).html( unitVal);	 
	  }
	  
	  $('#' + element ).val( unitVal);	  
	}
	
	
	$('#add_variant_btn').click( function() {	
	
		$('#variant_label_heading_title').show();
		$('#variant_1').show();
		$('#variant_wrapper').show();	
		$('.variant_group').show();	
		
		$('#variantFormElement').show();		
		$(this).hide();
		$('#cancel_variant_btn').show();
	});
	
	$('#cancel_variant_btn').click( function() {		
		$(this).hide();
		$('#add_variant_btn').show();
		$('#variant_wrapper').hide();
		$('#variantFormElement').hide();
	});
	
	$('#tab_all').click( function() {
		$('#tab_general').addClass("active");
		$('#tab_details').addClass("active");
		$('#tab_price_level').addClass("active");
		$('#tab_shipping').addClass("active");
		$('#tab_meta').addClass("active");
	});
	$(".preset_product_level_amount, .preset_cents_product_level_amount").change(function() 
	{		
	    var preset_customer_group_row_id =  $(this).attr("customer_group_row_id");		
		var preset =  $("#preset_product_level_amount_" + preset_customer_group_row_id).val();
		var cents_preset =  $("#preset_cents_product_level_amount_" + preset_customer_group_row_id).val();	
	    $("#product_level_amount_" + preset_customer_group_row_id).val(preset + '.' + cents_preset);		
	});
	
	$("#price_preset, #price_cents_preset").change(function() 
	{
		var preset =  $("#price_preset").val();
		var cents_preset =  $("#price_cents_preset").val();		
	    $("#product_price").val(preset + '.' + cents_preset);		
	});
	

	
	
	$('.back-button') .click( function() {	
		window.location.href= "{{ url('/')}}/manage-product";
	});
	
	$('#variant_add_more').click( function() {
			$('.variant_group').show();
	});	
	
	
	$('#variant_1_add_more').click( function() {
	
		$('#variant_2').show();
	});	
	
	$('#variant_2_add_more').click( function() {
		$('#variant_3').show();
	});	
	
	$('.variant_delete').click( function() {	
	
		var textBoxid = $(this).attr('textBoxid');
		$('#' + textBoxid).val('');		
		//$('#variant_2').find('span.label-info').remove();		
		$(this).parent(). parent(). hide();		
		generateVariantContent();		
	});
	
	$('.variant').keyup(function(e)
	{
	
	   if(e.keyCode == 8)
		{				
			generateVariantContent();		  
		}
	})

	
	$('.variant').keypress(function(event) {	
		var keycode = (event.keyCode ? event.keyCode : event.which);		
		
		if(keycode == '13' || keycode == '44')
		{
		generateVariantContent();			
		}
	});
	
	
	function generateVariantContent() 
	{
		var buildRow='';
		$str = '<div class="form-group"><label class="col-md-2 control-label"></label><div class="col-md-10">'
											+'<table class="table">'
                                            + '<thead>'
                                            + '<tr><th>Variant </th><th> Price</th><th> SKU </th><th>Barcode </th></tr>'
											+ '</thead>'
											+ '<tbody>';
											
			var size_multi_tag_val  = $('#size_multi_tag').val().trim();			
			if(size_multi_tag_val)			
			var size_multi_tag_array = size_multi_tag_val.split(',');
			else
			var size_multi_tag_array = [];		
			
			
			var color_multi_tag_val  = $('#color_multi_tag').val().trim();
			if(color_multi_tag_val)			
			var color_multi_tag_array = color_multi_tag_val.split(',');
			else
			var color_multi_tag_array = [];
			
			
			var material_multi_tag_val  = $('#material_multi_tag').val().trim();
			if(material_multi_tag_val)			
			var material_multi_tag_array = material_multi_tag_val.split(',');
			else
			var material_multi_tag_array = [];
			
			// Size combination
			if(size_multi_tag_array.length && !color_multi_tag_array.length && !material_multi_tag_array.length)
			{
			    buildRow = '';
			    for(i=0; i<size_multi_tag_array.length; i++)
				{
						buildRow += '<tr><td>' + size_multi_tag_array[i] +  '</td><td><input type="text" class="form-control" name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control"  name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';						
				}
			}
			
			if(size_multi_tag_array.length  && color_multi_tag_array.length && !material_multi_tag_array.length)
			{			
			    buildRow = '';
			    for(i=0; i<size_multi_tag_array.length; i++)
				{
					for(k=0; k<color_multi_tag_array.length; k++)
					{
					buildRow += '<tr><td>' + size_multi_tag_array[i] + ' . ' +  color_multi_tag_array[k] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';						
					}	
				}
			}
			
			if(size_multi_tag_array.length  && material_multi_tag_array.length && !color_multi_tag_array.length)
			{			
				buildRow = '';
				for(i=0; i<size_multi_tag_array.length; i++)
				{
					for(k=0; k<material_multi_tag_array.length; k++)
					{
					
					  buildRow += '<tr><td>' + size_multi_tag_array[i] + ' . ' +  material_multi_tag_array[k] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
					
					}
				}
			}
			
			
			//color combination
			if(color_multi_tag_array.length && !size_multi_tag_array.length && !material_multi_tag_array.length)
			{
			    buildRow = '';
			    for(i=0; i<color_multi_tag_array.length; i++)
				{
						buildRow += '<tr><td>' + color_multi_tag_array[i] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
				}
			}
			
			if(color_multi_tag_array.length  && material_multi_tag_array.length && !size_multi_tag_array.length)
			{
			        buildRow = '';
			        for(i=0; i<color_multi_tag_array.length; i++)
						{
							for(k=0; k<material_multi_tag_array.length; k++)
							{
							
							  buildRow += '<tr><td>' + color_multi_tag_array[i] + ' . ' +  material_multi_tag_array[k] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
							
							}
						}
			   
			}
			
		//material combination	
		if(material_multi_tag_array.length && !size_multi_tag_array.length && !color_multi_tag_array.length)
		{
			    buildRow = '';
			    for(i=0; i<material_multi_tag_array.length; i++)
				{
						buildRow += '<tr><td>' + material_multi_tag_array[i] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
				}
		}
			
			
		if(size_multi_tag_array.length && color_multi_tag_array.length && material_multi_tag_array.length)
		{
			for(i=0; i<size_multi_tag_array.length; i++)
			{		  
			  
			   for(j=0; j<color_multi_tag_array.length; j++) 
			   { 			   
				 
				  for(k=0; k<material_multi_tag_array.length; k++) 
					{
				 
						buildRow += '<tr><td>' + size_multi_tag_array[i] + '.' + color_multi_tag_array[j] + '.' + material_multi_tag_array[k] +  '</td><td><input type="text" class="form-control"  name="attribute_price[]" placeholder="0.00" ></td><td> <input type="text" class="form-control" name="attribute_sku[]" > </td> <td> <input type="text" class="form-control" name="attribute_barcode[]" > </td></tr>';
					}					
			   }
			}		
		}
			
		$str += buildRow
			    + '</tbody>'
				+ '</table>'
				+ '</div></div>';
				

			
		if(!size_multi_tag_array.length && !color_multi_tag_array.length  && !material_multi_tag_array.length)
		{	
			$str = '';

		}			
			
		$('#variantFormElement').html($str);
			
	}
	

	

	$('#aku_code').blur( function() {	
		var aku_code =  $(this).val();
		
		if(!aku_code)
		return;
		
		if( aku_code.length <5 )
		{
		   $('#aku_code_status').html('Must be 5 digit #');
			$('#aku_code').val('');						
			return;			
		}
		
		$.ajax({
				url: "{{ url('is_valid_aku_code') }}/" + aku_code + '/' + {{  $data['single_record']->product_row_id }},
				type: "GET",	
				dataType:"html",
				success: function(data){
					if(data == 'exist')
					{
						$('#aku_code_status').html('The code is already exist, Please choose another!');
						$('#aku_code').val('');
					}
					else
					$('#aku_code_status').html('');

				},
				
            });
			
	});
	
$('#aku_code_btn') . click(function() {
	$.ajax({
			url: "{{ url('generate_aku_code') }}",
			type: "GET",			
			success: function(data){
				$('#aku_code').val(data['aku_code']);
				$('#aku_code_status').html('');
				
			},
			 dataType:"json"
		});
})	



$("#product_name").blur(function (e) {
		var str = $(this).val() ;
		str = str.replace(/\s+/g, '-').toLowerCase();
		$('#handle').val( "{{ url('/')}}/products/" + str );
		
    });


    $("#aku_code").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

	
	
	 
	$("#collection_new").blur(function (e) {
        if( $("#collection_new").val() ) {
			$("#collection_row_id").val("0");	
			 $("#collection_row_id").prop("disabled", true);
			  $('#edit_collection').hide();	
		} else {
		  $("#collection_row_id").prop("disabled", false);		
		}
    });
	
	
	
	$("#vendor_new").blur(function (e) {
        if( $("#vendor_new").val() ) {
			$("#vendor_row_id").val("0");	
			 $("#vendor_row_id").prop("disabled", true);
			  $('#edit_vendor').hide();	
		} else {
		  $("#vendor_row_id").prop("disabled", false);		
		}
    });
	
	
	 
	$("#category_new").blur(function (e) {
        if( $("#category_new").val() ) {
			$("#category_row_id").val("0");	
			 $("#category_row_id").prop("disabled", true);
			  $('#edit_category').hide();	
		} else {
		  $("#category_row_id").prop("disabled", false);		
		}
    });
	
	
	 
	$("#product_type_new").blur(function (e) {
        if( $("#product_type_new").val() ) {
			$("#product_type_row_id").val("0");	
			 $("#product_type_row_id").prop("disabled", true);
			  $('#edit_product_type').hide();	
		} else {
		  $("#product_type_row_id").prop("disabled", false);		
		}
    });
	
	$("#folder_new").blur(function (e) {
        if( $("#folder_new").val() ) {
			$("#folder_row_id").val("0");	
			 $("#folder_row_id").prop("disabled", true);
			  $('#edit_folder').hide();	
		} else {
		  $("#folder_row_id").prop("disabled", false);		
		}
    });
	
	

$('#handle').on('input', function(event) {
	var handle = $(this).val();
	$('#handle_url').val("{{ url('/')}}/products/" + handle);
});
	
	$("#weight_preset").change(function() 
	{
	    $("#product_weight").val($(this).val());		
	});
	
	
$("#description_row_id").change(function() 
	{
		if( $(this).val() != 0 )
		{
			var description_row_id = $(this).val();
			$.ajax({
				url: "{{ url('setDescriptionField') }}" + "/" + description_row_id,
				type: "GET",	
				dataType:"html",
				success: function(data){					
					var ed = $("#description_new").data('wysihtml5').editor;					
					ed.setValue(data, true);					
				},
			});		 
			
		}
	});
	
	*/
var i = 0;	
 $(document).ready(function(){  
	$('#tab_general').addClass("active");
	$('#tab_details').addClass("active");
	$('#tab_price_level').addClass("active");
	$('#tab_shipping').addClass("active");
	$('#tab_meta').addClass("active");
	$('#tab_dynamic_field').addClass("active");
		
	$('span.elements_dropdown_default_val').html('Select'); 
	
	
	@if($data['single_record']->product_price_unit)
		$('#selected_product_price_unit').html('{{  $data['single_record']->product_price_unit }}');
	@endif	
	@if($data['single_record']->product_weight_unit)
		$('#selected_product_weight_unit').html('{{  $data['single_record']->product_weight_unit }}');
	@endif	
	@if($data['single_record']->product_length_unit)
		$('#selected_product_length_unit').html('{{  $data['single_record']->product_length_unit }}');
	@endif
	@if($data['single_record']->product_width_unit)
		$('#selected_product_width_unit').html('{{  $data['single_record']->product_width_unit }}');
	@endif	
	@if($data['single_record']->product_height_unit)
		$('#selected_product_height_unit').html('{{  $data['single_record']->product_height_unit }}');
	@endif
	@if($data['single_record']->product_cost_unit)
		$('#selected_product_cost_unit').html('{{  $data['single_record']->product_cost_unit }}');
	@endif
	@if($data['single_record']->product_stock_type)
		$('#selected_product_stock_type').html('{{  $data['single_record']->product_stock_type }}');
	@endif
	
	@if($data['single_record']->distributor_price_unit)
		$('#selected_distributor_price_unit').html('{{  $data['single_record']->distributor_price_unit }}');
	@endif
	@if($data['single_record']->wholesale_price_unit)
		$('#selected_wholesale_price_unit').html('{{  $data['single_record']->wholesale_price_unit }}');
	@endif
	@if($data['single_record']->retail_price_unit)
		$('#selected_retail_price_unit').html('{{  $data['single_record']->retail_price_unit }}');
	@endif
	
	@if($data['single_record']->ship_weight_unit)
		$('#selected_ship_weight_unit').html('{{  $data['single_record']->ship_weight_unit }}');
	@endif	
	@if($data['single_record']->ship_width_unit)
		$('#selected_ship_width_unit').html('{{  $data['single_record']->ship_width_unit }}');
	@endif	
	
	@if($data['single_record']->ship_length_unit)
		$('#selected_ship_length_unit').html('{{  $data['single_record']->ship_length_unit }}');
	@endif	
	@if($data['single_record']->ship_height_unit)
		$('#selected_ship_height_unit').html('{{  $data['single_record']->ship_height_unit }}');
	@endif	
	
	
	
	Dropzone.options.productImagesDropzone = {
	init: function() {
    //this.on("addedfile", function(file) { alert("Added file."); });
	//this.on("removedfile", function(file) { alert("removed file."); });
	Dropzone.options.productImagesDropzone = false;
	maxFiles: 1,
	Dropzone.options.autoProcessQueue = false,
	
	this.on("addedfile", function(file) {	
						
						if (this.files[1]!=null){
							this.removeFile(this.files[0]);
						}
						 $("#uploaded_product_image_box").hide();
						i++;
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");
				        
                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
						   $.ajax({
								url: "{{ url('removePrimaryImage') }}",
								type: "GET",	
								dataType:"html",
								success: function(data){								

								},
							});		
						  
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
                        });
						
						
                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);						
                    });
  }
};



	Dropzone.options.productSecondaryImagesDropzone = {
	init: function() {
    //this.on("addedfile", function(file) { alert("Added file."); });
	//this.on("removedfile", function(file) { alert("removed file."); });
	Dropzone.options.productSecondaryImagesDropzone = false;
	
	this.on("addedfile", function(file) {						
		i++;
		// Create the remove button
		var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");
							
		// Capture the Dropzone instance as closure.
		var _this = this;

		// Listen to the click event
		removeButton.addEventListener("click", function(e) {
		  // Make sure the button click doesn't submit the form:
		  e.preventDefault();
		  e.stopPropagation();

		  // Remove the file preview.
		  _this.removeFile(file);
		  
		  // If you want to the delete the file on the server as well,
		  // you can do the AJAX request here.
		});
						
		// Add the button to the file preview element.
		file.previewElement.appendChild(removeButton);						
    });
  }
};





Dropzone.options.HireImageDropzone = {
  init: function() {
    //this.on("addedfile", function(file) { alert("Added file."); });
	//this.on("removedfile", function(file) { alert("removed file."); });
	Dropzone.options.HireImageDropzone = false;
	maxFiles: 1,
	Dropzone.options.autoProcessQueue = false,
	
	this.on("addedfile", function(file) {
						
						if (this.files[1]!=null){
							this.removeFile(this.files[0]);
						}
						 $("#uploaded_design_image_box").hide();
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");
                        
                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
						
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
						  $.ajax({
								url: "{{ url('removeHireDesignImage') }}",
								type: "GET",	
								dataType:"html",
								success: function(data){								

								},

							});					
						 
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
					
  }
};
	
	
	$(".product-image-delete").click(function(){
	  //var uploaded_design_image_name = $(this) . attr('image_name');
	  $("#uploaded_product_image_box").hide();
	  $.ajax({
			url: "{{ url('removePrimaryImage') }}",
			type: "GET",	
			dataType:"html",
			success: function(data) {
				
			},

		});
	});
	
	$(".design-image-delete").click(function(){
	  //var uploaded_design_image_name = $(this) . attr('image_name');
	  $("#uploaded_design_image_box").hide();
	  $.ajax({
			url: "{{ url('removeHireDesignImage') }}",
			type: "GET",	
			dataType:"html",
			success: function(data) {
				
			},

		});
	});
	
	$(".product-secondary-image-remove").click(function(){
	  var secondary_image_holder = $(this) . attr('id');
	  var secondary_image_name = $(this) . attr('secondary_image_name');
	  
	  $("#" + secondary_image_holder).hide();
	  $.ajax({
			url: "{{ url('removeSecondaryImage') }}/" + secondary_image_name,
			type: "GET",	
			dataType:"html",
			success: function(data) {
				
			},

		});
		
	});
	
//Dynamic Section
	var max_fields      = 10; //maximum input boxes allowed    
    var add_button      = $(".add_dynamic_field"); //Add button ID    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $("#add_dynamic_field_wrapper").before('<div class="form-group"><label class="col-md-2 control-label"></label><div class="col-md-4"><input type="text" class="form-control" name="dynamic_fields[]" placeholder="Name"></div><div class="col-md-4"><input type="text" class="form-control" name="dynamic_fields_value[]" placeholder="Value"></div><div class="col-md-2	 remove_field_icon_wrapper"><a href="#" class="remove_field">Remove</a></div></div>'); //add input box
        }
    });
    $(".dynamic-section").on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
    })
//End Of Dynamic Section
	
	
	$(".remove_each_dynamic_field").click(function(e){
        e.preventDefault();
		if(  confirm("Are you sure to delete") )
		{
			$(this).parent().parent().remove();
			var dynamic_field_row_id = $(this).attr('dynamic_field_row_id');
			$.ajax({
				url: "{{ url('delete_dynamic_field') }}/" + dynamic_field_row_id,
				type: "GET",	
				dataType:"html",
				success: function(data) {
					
				},

			});
		}
    });
	
});
</script>

@endsection		
