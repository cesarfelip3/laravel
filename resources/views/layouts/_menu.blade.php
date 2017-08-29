@is(['slc', 'admin'])
<li class="{!! (route_contains('users', 'IN')) ? 'active' : '' !!}">
    <a href="{{ route('users.index') }}">Users</a>
</li>
<li class="{!! (route_contains('clients', 'IN')) ? 'active' : '' !!}">
    <a href="{{ route('clients.index') }}">Clients</a>
</li>
@endis
{{--<li class="dropdown">--}}
{{--<a aria-expanded="false" role="button" href="#" class="dropdown-toggle"--}}
{{--data-toggle="dropdown"> Menu item <span class="caret"></span></a>--}}
{{--<ul role="menu" class="dropdown-menu">--}}
{{--<li><a href="">Menu item</a></li>--}}
{{--<li><a href="">Menu item</a></li>--}}
{{--<li><a href="">Menu item</a></li>--}}
{{--<li><a href="">Menu item</a></li>--}}
{{--</ul>--}}
{{--</li>--}}