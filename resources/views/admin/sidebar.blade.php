<nav id="sidebar" class="bg-danger">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="{{ asset('admincss/img/murtaza.png') }}" class="img-fluid rounded-circle"></div>
        <div class="title">
            <h1 class="h5 text-white">{{ Auth::user()->name }}</h1>
            <p class="text-white">{{ Auth::user()->usertype }}</p>
        </div>
    </div>
    <!-- Sidebar Navidation Menus--><span class="heading text-white">Main</span>
    <ul class="list-unstyled bg-dark">
        <li><a href="{{ route('admin.dashboard') }}" class="text-white"> <i class="icon-home"></i>Home </a></li>
        @can('manage-users')
        <li><a href="{{ route('viewUsers') }}" class="text-white"> <i class="icon-user"></i>Users </a></li>
        @endcan
        @can('manage-category')
        <li><a href="{{ route('view.category') }}" class="text-white"> <i class="icon-grid"></i>Category </a></li>
        @endcan
        @can('manage-products')
        <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse" class="text-white"> <i
            class="icon-windows" class="text-white"></i>Products </a>
    <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
        <li><a href="{{ route('addProduct') }}" class="text-white">Add Product</a></li>
        <li><a href="{{ route('showProduct') }}" class="text-white">View Products</a></li>
    </ul>
</li>
        @endcan
       @can('manage-orders')
       <li><a href="{{ route('viewOrders') }}" class="text-white"> <i class="icon-grid"></i>Orders </a></li>
       @endcan

        </nav>
