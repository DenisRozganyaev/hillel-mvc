<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="navbar-brand" href="{{ url('admin') }}">Admin panel:</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="adminDropdownOrders" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ __('Orders') }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="adminDropdownOrders">
                        <a class="dropdown-item" href="{{ route('admin.orders') }}">{{ __('Orders List') }}</a>
                        <a class="dropdown-item" href="{{ route('admin.orders') }}">{{ __('New Order') }}</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="adminDropdownProducts" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ __('Products') }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="adminDropdownProducts">
                        <a class="dropdown-item" href="{{ route('admin.products') }}">{{ __('Products List') }}</a>
                        <a class="dropdown-item" href="{{ route('admin.products.create') }}">{{ __('New Product') }}</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
