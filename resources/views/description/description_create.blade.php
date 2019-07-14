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
	<div class="col-md-12 ">
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">					
					<span class="caption-subject bold uppercase"> Add New Description</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body form">                                    
				<form role = "form" method="post" action="{{ url('/')}}/store-description">
				   {!! csrf_field() !!}
				   <input type="hidden" name="edit_row_id" value="{{ isset($data['single_record']) ? $data['single_record']->description_row_id : '' }}" >
					<div class="form-body">                                           
						<div class="form-group form-md-line-input form-md-floating-label">
							<input type="text" class="form-control"  name="description_name" value="{{ isset($data['single_record']) ? $data['single_record']->description_name : '' }}" required>
							<label for="form_control_1">Description Title </label>                                               
						</div>						
						<div class="form-group">							
							<div class="col-md-12">										
								<textarea class="wysihtml5 form-control" rows="8" placeholder="Description text" name="description_text">{{ isset($data['single_record']) ? $data['single_record']->description_text : '' }}</textarea>											
							</div>
						</div>
					</div>
					<div class="form-actions noborder">
						<button type="submit" class="btn blue" style="margin:30px 0 0 0">Submit</button>		
						<button type="button" class="btn default" style="margin:30px 0 0 0" onclick="window.location.href='{{ url('/')}}/manage-description'">Cancel</button>					
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->                            
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
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{asset('/')}}/public/css/assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
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



	$("#product_name").blur(function (e) {
		var str = $(this).val() ;
		str = str.replace(/\s+/g, '-').toLowerCase();
		$('#handle').val(str);
		$('#handle_url').val( "{{ url('/')}}/products/" + str );
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
	
var i = 0;	
 $(document).ready(function(){  
	$('span.elements_dropdown_default_val').html('Select'); 
	
	Dropzone.options.productImagesDropzone = {
	init: function() {
    //this.on("addedfile", function(file) { alert("Added file."); });
	//this.on("removedfile", function(file) { alert("removed file."); });
	Dropzone.options.productImagesDropzone = false;
	
	
	this.on("addedfile", function(file) {
					
		if (this.files[1]!=null){
			this.removeFile(this.files[0]);
		}
	
		
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
	
		
		// Create the remove button
		var removeButton = Dropzone.createElement("<a href='javascript:;'' serial='" + i +"' class='btn red btn-sm btn-block'>Remove</a>");
			i++;					
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
				
					url: "{{ url('removeSecondaryImageWhileCreate') }}/" + $(this).attr('serial') ,
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
	
});
</script>

@endsection		
