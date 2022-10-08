<div class="pb-5 h-sidebar" id="newsidebar">

        <a href="{{route('dashboard')}}" class="list-group-item ms-3 mt-3 my-2 rounded-start px-5 py-2 link-hover {{ (request()->is('dashboard')) ? 'active' : '' }}"><i class="fa-solid fa-user me-2"></i>Users</a>
        <a href="{{route('business.index')}}" class="list-group-item ms-3 rounded-start my-2 px-5 py-2 link-hover {{ (request()->is('businesses')) ? 'active' : '' }}"><i class="fa-solid fa-briefcase me-2"></i>Businesses</a>
        <a href="{{route('location.index')}}" class="list-group-item ms-3 rounded-start my-2 px-5 py-2 link-hover {{ (request()->is('locations')) ? 'active' : '' }}"><i class="fa-solid fa-location-dot me-2"></i>Locations</a>     
</div>