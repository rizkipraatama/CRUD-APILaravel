<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">Admin</strong>
                            </span> 
                    </a>
                    
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li >
                <a href="{{ route($createUser) }}"><i class="fa fa-users"></i> <span class="nav-label">Tambah Anggota</span></a>
            </li>
            <li >
                <a href="{{ route($createBook) }}"><i class="fa fa-th-large"></i> <span class="nav-label">Tambah Buku</span> </a>
            </li>
        </ul>

    </div>
</nav>
