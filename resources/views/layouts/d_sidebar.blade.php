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
                <p>{{ Auth::guard('dosen')->user()->nama ?? 'Guest' }}</p>
            </li>
            <li class="nav">
                <a href="{{ url('/dProfile') }}" class="btn btn-block btn-sm btn-primary">Edit Profile</a>
            </li>
        </div>
    </div>
    <!-- End Profile Menu -->
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
            role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/dosen') }}" class="nav-link {{ ($activeMenu == 'dashboard')?
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
                        <a href="{{ url('/dMahasiswaAlpha') }}" class="nav-link {{ ($activeMenu == 'dMahasiswaAlpha')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Daftar Mahasiswa Alpha</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/dMahasiswaKompen') }}" class="nav-link {{ ($activeMenu == 'dMahasiswaKompen')?
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
                        <a href="{{ url('/dManageKompen') }}" class="nav-link {{ ($activeMenu == 'dManageKompen') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tambah Tugas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/dDikerjakanOleh') }}" class="nav-link {{ ($activeMenu == 'dDikerjakanOleh') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dikerjakan Oleh</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ url('/dUpdateKompenSelesai') }}" class="nav-link {{ ($activeMenu =='dUpdateKompen')? 'active' : '' }} ">
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
