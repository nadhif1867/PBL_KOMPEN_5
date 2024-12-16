<head>
    <style>
        .sidebar {
            background-color: #0E1F43;
        }
    </style>
</head>
<div class="sidebar">
    <!-- Profile Menu -->
    <div class="user-panel mt-3 pb-3 d-flex">
        <div class="image">
            <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" alt="user" class="img-circle elevation-2">
        </div>
        <div class="info">
            <li class="nav" style="color: white;">
                <p>{{ Auth::guard('tendik')->user()->nama ?? 'Guest' }}</p>
            </li>
            <li class="nav">
                <a href="{{ url('/tProfile') }}" class="btn btn-block btn-sm btn-primary">Edit Profile</a>
            </li>
        </div>
    </div>
    <!-- End Profile Menu -->
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
            role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/tendik') }}" class="nav-link {{ ($activeMenu == 'dashboard')?
'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Daftar Mahasiswa
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/tMahasiswaAlpha') }}" class="nav-link {{ ($activeMenu == 'tMahasiswaAlpha')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Daftar Mahasiswa Alpha</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/tMahasiswaKompen') }}" class="nav-link {{ ($activeMenu == 'tMahasiswaKompen')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Daftar Mahasiswa Kompen</p>
                        </a>
                    </li>
                </ul>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-address-book"></i>
                    <p>
                        Manage Kompen
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/tManageKompen') }}" class="nav-link {{ ($activeMenu == 'tManageKompen') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tambah Tugas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/tDikerjakanOleh') }}" class="nav-link {{ ($activeMenu == 'tDikerjakanOleh') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dikerjakan Oleh</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ url('/tUpdateKompenSelesai') }}" class="nav-link {{ ($activeMenu =='tUpdateKompen')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-check-square"></i>
                    <p>Update Kompen Selesai</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('/')}}" class="btn btn-sm btn-danger">Logout</a>
            </li>
        </ul>
    </nav>
</div>
