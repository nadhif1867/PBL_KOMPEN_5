<head>
    <style>
        .sidebar {
            background-color: #0E1F43;
        }
        .username {
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
                <p>{{ Auth::guard('admin')->user()->nama ?? 'Guest' }}</p>
            </li>
            <li class="nav">
                <a href="{{ url('/aProfile') }}" class="btn btn-block btn-sm btn-primary">Edit Profile</a>
            </li>
        </div>
    </div>
    <!-- End Profile Menu -->
    <!-- Sidebar Menu -->
    <class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
            role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link {{ ($activeMenu == 'dashboard')?
'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/aLevel') }}" class="nav-link {{ ($activeMenu == 'aLevel')?
'active' : '' }} ">
                    <i class="nav-icon fa fa-sitemap"></i>
                    <p>Level User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Users
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aAdmin') }}" class="nav-link {{ ($activeMenu == 'aAdmin')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Admin</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aDosen') }}" class="nav-link {{ ($activeMenu == 'aDosen')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dosen</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aTendik') }}" class="nav-link {{ ($activeMenu == 'aTendik')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tendik</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aMahasiswa') }}" class="nav-link {{ ($activeMenu == 'aMahasiswa')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Mahasiswa</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-graduation-cap"></i>
                    <p>
                        Daftar Mahasiswa
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aMahasiswaAlpha') }}" class="nav-link {{ ($activeMenu == 'aMahasiswaAlpha')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Daftar Mahasiswa Alpha</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aMahasiswaKompen') }}" class="nav-link {{ ($activeMenu == 'aMahasiswaKompen')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Daftar Mahasiswa Kompen</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>
                        Daftar Tugas
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aTugasDosen') }}" class="nav-link {{ ($activeMenu == 'aTugasDosen')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dosen</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aTugasTendik') }}" class="nav-link {{ ($activeMenu == 'aTugasTendik')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tendik</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aTugasAdmin') }}" class="nav-link {{ ($activeMenu == 'aTugasAdmin')?
'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Admin</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ url('/aBidangKompetensi') }}" class="nav-link {{ ($activeMenu == 'aBidangKompetensi')? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Manage Bidang Kompetensi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/aManageMahasiswaKompen') }}" class="nav-link {{ ($activeMenu =='aManageMahasiswaKompen')? 'active' : '' }} ">
                    <i class="nav-icon fa fa-newspaper"></i>
                    <p>Manage Data Mahasiswa Kompen</p>
                </a>
            </li>

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
                        <a href="{{ url('/aManageKompen') }}" class="nav-link {{ ($activeMenu == 'aManageKompen') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tambah Tugas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/aDikerjakanOleh') }}" class="nav-link {{ ($activeMenu == 'aDikerjakanOleh') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dikerjakan Oleh</p>
                        </a>
                    </li>
                </ul>
            </li>


            <!-- <li class="nav-item">
                    <i class="nav-icon fa fa-address-book"></i>
                    <p>Manage Kompen</p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="{{ url('/aManageKompen') }}" class="nav-link {{ ($activeMenu =='aManageKompen')? 'active' : '' }} ">
                    <i class="far fa-circle nav-icon"></i>
                            <p>Tambah Tugas</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/aDikerjakanOleh') }}" class="nav-link {{ ($activeMenu == 'aDikerjakanOleh')? 'active' : '' }} ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dikerjakan Oleh</p>
                        </a>
                    </li>
                </ul>
            </li> -->

            <li class="nav-item">
                <a href="{{ url('/aUpdateKompenSelesai') }}" class="nav-link {{ ($activeMenu =='aUpdateKompen')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-check-square"></i>
                    <p>Update Kompen Selesai</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/aReportKompen') }}" class="nav-link {{ ($activeMenu =='aReportKompen')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-file-archive"></i>
                    <p>Report Kompen</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/aManagePeriode') }}" class="nav-link {{ ($activeMenu =='aManagePeriode')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-calendar"></i>
                    <p>Manage Periode</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/aJenisKompen') }}" class="nav-link {{ ($activeMenu =='aJenisKompen')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-file"></i>
                    <p>Jenis Penugasan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('/')}}" class="btn btn-sm btn-danger">Logout</a>
            </li>
        </ul>
        </nav>
</div>
