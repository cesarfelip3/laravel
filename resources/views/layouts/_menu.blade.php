@is(['slc', 'admin'])
<li class="{!! (route_contains('users', 'IN')) ? 'active' : '' !!}">
    <a href="{{ route('users.index') }}">Users</a>
</li>
@endis