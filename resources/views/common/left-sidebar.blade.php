    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <!--<li class="nav-item start active open">
            <a href="{{ url('/home')}}" class="nav-link nav-toggle">
                <i class="icon-home" style="color: #32cfd2"></i>
            <span class="title">Dashboard</span></a>
        </li>-->
        <li class="heading">
            <h3 class="uppercase">Products</h3>
        </li>

         <li id="manage_products" class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-list"></i>
                <span class="title">Products</span> <span class="arrow"></span> 
            </a>
          <ul class="sub-menu">
              <li class="nav-item"><a href="{{ url('/manage-product')}}" class="nav-link nav-toggle"> <span class="title"> My Products List</span> </a> </li>
              <li class="nav-item"> <a href="{{ url('/manage-vendor-product')}}" class="nav-link "> <span class="title">Products By Vendor </span></a></li>
            </ul>
        </li>

        <li id="addProduct" class="nav-item">
            <a href="{{ url('/add-product')}}" class="nav-link nav-toggle">
                <i class="icon-plus"></i>
            <span class="title">Add New Product</span></a>                              
        </li>

        <li id="manage_import_product" class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-cloud-upload"></i>
                <span class="title">Import Products</span> <span class="arrow"></span> 
            </a>
          <ul class="sub-menu">
              <li class="nav-item"> <a href="{{ url('/manage-product/import')}}" class="nav-link "> <span class="title"> Import Products</span> </a> </li>
              <li class="nav-item"> <a href="{{ url('/manage-import-template')}}" class="nav-link "> <span class="title"> Product Templates </span></a></li>             
              <li class="nav-item"><a href="{{ url('/import-product-by-vendor')}}" class="nav-link"><span class="title">Import By Vendor</span></a></li>
              <li class="nav-item"><a href="{{ url('/manage-vendor-template')}}" class="nav-link"><span class="title">Vendor Templates</span></a></li>
              <li class="nav-item"><a href="{{ url('/import-artist')}}" class="nav-link"><span class="title">Import By Artist</span></a></li>
              <li class="nav-item"><a href="{{ url('/manage-artist-template')}}" class="nav-link"><span class="title">Artist Templates</span></a></li>
            </ul>
        </li>

        <li id="manage_export_product" class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-share-alt"></i>
                <span class="title">Export Products</span> <span class="arrow"></span> 
            </a>
          <ul class="sub-menu">
              <li class="nav-item"> <a href="javascript:void(0)" class="nav-link "> <span class="title"> Export Products</span> </a> </li>
              <li class="nav-item"> <a href="{{ url('/manage-export-template')}}" class="nav-link "> <span class="title"> Export Templates </span></a></li>
            </ul>
        </li>

    	<li id="manageCollection" class="nav-item">
            <a href="{{ url('/manage-collection')}}" class="nav-link nav-toggle">
                <i class="icon-layers"></i>
                <span class="title">Collections</span>
            </a>
        </li>
    	
      
        <li class="heading">
          <h3 class="uppercase">REPORTS & SEARCH</h3>
        </li>
        <li id="productReports" class="nav-item">
            <a href="{{ url('/reports')}}" class="nav-link ">
                <i class="icon-pie-chart"></i> 
                <span class="title">Product Report</span>
            </a>
        </li>
        <!--
        <li class="nav-item  ">
            <a href="{{ url('/report-builder')}}" class="nav-link ">
                <i class="icon-magic-wand"></i> 
                <span class="title">Report Builder</span>
            </a>
        </li>                           

        <li class="nav-item  ">
            <a href="{{ url('/search')}}" class="nav-link ">
                <i class="icon-magnifier"></i> 
                <span class="title">Product Search</span>
            </a>
        </li>
         -->
        

         <li class="heading">
            <h3 class="uppercase">Sales TEMPLATES</h3>
        </li>
       
        <li id="salesTemplate" class="nav-item"> <a href="{{ url('/manage-sales-template')}}" class="nav-link "><i class="icon-cloud-upload"></i> <span class="title"> Import Templates </span></a></li>

    	
      
        
        <li class="heading">
            <h3 class="uppercase">Tools</h3>
        </li>
    	<li id="managePreset" class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">Manage Presets</span> <span class="arrow"></span> 
            </a>
          <ul class="sub-menu">
              <li class="nav-item"> <a href="{{ url('/manage-vendor')}}" class="nav-link "> <span class="title"> Vendors</span> </a> </li>
              <li class="nav-item"> <a href="#" class="nav-link "> <span class="title"> Vendor Products</span> </a> </li>
              <li class="nav-item"> <a href="#" class="nav-link "> <span class="title"> Artist / Artwork</span> </a> </li>
              
              <li class="nav-item"> <a href="{{ url('/manage-price-type')}}" class="nav-link "> <span class="title"> Price Types </span></a></li>
              <li class="nav-item"> <a href="{{ url('/manage-folder')}}" class="nav-link "> <span class="title"> Folders </span></a></li>
              <li class="nav-item"> <a href="{{ url('/manage-description')}}" class="nav-link "> <span class="title"> Descriptions </span></a></li>
              <li class="nav-item"> <a href="{{ url('/manage-category')}}" class="nav-link "> <span class="title"> Product Categories </span></a></li>
              <li class="nav-item"> <a href="{{ url('/manage-product-type')}}" class="nav-link "> <span class="title"> Product Types </span></a></li>                                 
              <li class="nav-item"> <a href="{{ url('/manage-tag-group')}}" class="nav-link "> <span class="title"> Tag Groups </span></a></li>
              <li class="nav-item"> <a href="{{ url('/manage-tag')}}" class="nav-link "> <span class="title"> Tags </span></a></li>
              <!--li class="nav-item"> <a href="{{ url('/manage-currency')}}" class="nav-link "> <span class="title"> Currency </span></a></li-->
              <li class="nav-item"><a href="{{ url('/integrations')}}" class="nav-link"><span class="title">Integrations</span></a></li>   
              
            </ul>
        </li>
        <li class="nav-item"> <a href="http://nymbl.io/designer/#!/dashboard" target="_blank" class="nav-link nav-toggle"> <i class="icon-rocket"></i> <span class="title">Mockup Generator</span></a></li>
        
        <li class="heading">
          <h3 class="uppercase">Account</h3>
        </li>
        <li id="billIng" class="nav-item ">
            <a href="{{ url('/billing')}}" class="nav-link ">
                <i class="icon-credit-card"></i> 
                <span class="title">Billing</span>
            </a>
        </li>
        <li id="apiKey" class="nav-item ">
            <a href="{{ url('/apikey')}}" class="nav-link ">
                <i class="icon-settings"></i>
                <span class="title">API Key</span>
            </a>
        </li>
        <li id="myAccount" class="nav-item  ">
            <a href="{{ url('/my-profile')}}" class="nav-link ">
                <i class="icon-user"></i> 
                <span class="title">My Account</span>
            </a>
        </li>
        <!--
        <li class="nav-item  ">
            <a href="javascript:void(0)" class="nav-link ">
                <i class="icon-list"></i> 
                <span class="title">Create New Store</span>
            </a>
        </li>
        -->
    </ul>
    <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR --> 
