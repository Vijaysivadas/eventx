<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('user.profile')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">EventX</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.profile')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Profile</span></a>
    </li>

    <!-- Divider -->

    <!-- Heading -->

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link " href="{{route('user.events')}}"
        >
            <i class="fas fa-fw fa-cog"></i>
            <span>Events</span>
        </a>

    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{route('user.inbox')}}" >
            <i class="fas fa-fw fa-cog"></i>
            <span>Inbox</span>
        </a>

    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{route('user.announcements')}}" >
            <i class="fas fa-fw fa-cog"></i>
            <span>Announcements</span>
        </a>

    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
