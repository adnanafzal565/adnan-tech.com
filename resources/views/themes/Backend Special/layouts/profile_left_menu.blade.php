@php
    $path = request()->path();
@endphp

<ul class="profile-left-menu">
    <li class="{{ $path === 'profile' ? 'active' : '' }}">
        <a href="{{ route('profile') }}">Profile</a>
    </li>
    <li class="{{ $path === 'change_password' ? 'active' : '' }}">
        <a href="{{ route('change_password') }}">Change Password</a>
    </li>
</ul>

<style>
    .profile-left-menu .active a {
        color: black !important;
    }
    .profile-left-menu a:hover {
        text-decoration: underline;
    }
    .profile-left-menu a {
        text-decoration: none;
        color: black;
    }
</style>