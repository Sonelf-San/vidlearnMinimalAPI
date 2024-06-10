<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>

                <li class="{{ Route::is('admin.dashboard') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="airplay"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Apps</li>

                <li class="{{ Request::is('admin/categories*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}">
                        <i data-feather="layers"></i>
                        <span> Categories </span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/positions*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin.positions.index') }}">
                        <i data-feather="activity"></i>
                        <span> Positions </span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/logos*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin.logos.index') }}">
                        <i data-feather="image"></i>
                        <span> Logos </span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/articles*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin.articles.index') }}">
                        <i data-feather="bar-chart"></i>
                        <span> Courses </span>
                    </a>
                </li>


                @if(\Auth('admin')->user()->super_admin == false)
                @else
                <li class="{{ Request::is('admin/administrator*') ? 'menuitem-active' : '' }}">
                    <a href="{{route('admin.administrator.index')}}">
                        <i data-feather="users"></i>
                        <span> Lecturers</span>
                    </a>
                </li>
                @endif

                <!-- <li class="menu-title mt-2">Contenu de la page</li> -->

                <li class="{{ Request::is('admin/team_members*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin.team_members.index') }}">
                        <i data-feather="users"></i>
                        <span>Your Students</span>
                    </a>
                </li>


                @if(\Auth('admin')->user()->super_admin == false)
                @else
                <li class="{{ Request::is('admin/partners*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin.partners.index') }}">
                        <i data-feather="award"></i>
                        <span>Partners</span>
                    </a>
                </li>
                @endif


                <li class="{{ Request::is('admin/page*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin.pages.index') }}">
                        <i data-feather="file-text"></i>
                        <span>Pages</span>
                    </a>
                </li>

                <li class="{{ Request::is('admin/settings*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('admin.settings') }}">
                        <i data-feather="settings"></i>
                        <span>Settings</span>
                    </a>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
