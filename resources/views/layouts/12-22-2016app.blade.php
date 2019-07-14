<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Merchware | Product Management for On-Demand Merchandise</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Merchware, Ecommerce" name="description" />
        
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- BEGIN LAYOUT FIRST STYLES -->
        <link href="//fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet" type="text/css" />
        <!-- END LAYOUT FIRST STYLES -->
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}public/css/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}public/css/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}public/css/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}public/css/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		 @yield('datatable-css')		        
        <!-- END PAGE LEVEL PLUGINS -->
		
		@yield('select2css')		
		
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{asset('/')}}public/css/assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{asset('/')}}public/css/assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{asset('/')}}public/css/assets/layouts/layout6/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}public/css/assets/layouts/layout6/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
		 <link href="{{asset('/')}}public/css/custom.css" rel="stylesheet" type="text/css" />
        
        <link rel="shortcut icon" href="{{asset('/')}}public/css/assets/pages/img/favicon.png" /> 
		<script>
			var siteUrl = "{{asset('/')}}public/css";
			window.Laravel = <?php echo json_encode([
				'csrfToken' => csrf_token(),
			]); ?>
		</script>
		</head>
    <!-- END HEAD --> 
	
    <body class="page-md">
       @include("common/header")
        <!-- BEGIN CONTAINER -->
        <div class="container-fluid">
            <div class="page-content page-content-popup">
                <div class="page-content-fixed-header">
				    <ul class="page-breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li>Welcome</li>
                    </ul>
                   
                </div>
                <div class="page-sidebar-wrapper">
				   @include("common/left-sidebar")
                </div>
                <div class="page-fixed-main-content">					
						 @yield('content')                 
                    <!-- END PAGE BASE CONTENT -->
                </div>
               
			   <!-- BEGIN FOOTER -->
                @include("common/footer")
                <!-- END FOOTER -->
            </div>
        </div>
        <!-- END CONTAINER -->
       
           
	
	 <!-- END QUICK NAV -->
        <!--[if lt IE 9]>
<script src="{{asset('/')}}public/css/assets/global/plugins/respond.min.js"></script>
<script src="{{asset('/')}}public/css/assets/global/plugins/excanvas.min.js"></script> 
<script src="{{asset('/')}}public/css/assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{asset('/')}}public/css/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}public/css/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}public/css/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}public/css/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}public/css/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}public/css/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->		
		@yield('select2js')		
		
		<!-- BEGIN PAGE LEVEL PLUGINS -->		
		@yield('datatable-js')		        
        <!-- END PAGE LEVEL PLUGINS -->	
		
		 <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{asset('/')}}public/css/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->	
		@yield('after-app-js')		
		
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
		@yield('datatable-js-2')
        <!-- END PAGE LEVEL SCRIPTS -->
		
		
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{asset('/')}}public/css/assets/layouts/layout6/scripts/layout.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}public/css/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="{{asset('/')}}public/css/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
		
		<script type="text/javascript">
		
		
		  $(".cancelBtn") .click( function() {
		   window.location.href="{{ url('/')}}";
		  });
		  
		  $(function() {
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // $("#successMessage").hide() function
    setTimeout(function() {
        $(".alert-success").hide('blind', {}, 500)
    }, 5000);
	
	setTimeout(function() {
        $(".alert-danger").hide('blind', {}, 500)
    }, 5000);
	
});


$('.alert-success').delay(5000).fadeOut('slow');
$('.alert-danger').delay(5000).fadeOut('slow');

		   
		</script>
        <!-- END THEME LAYOUT SCRIPTS -->
		
		@yield('page_js')
    </body>

</html>