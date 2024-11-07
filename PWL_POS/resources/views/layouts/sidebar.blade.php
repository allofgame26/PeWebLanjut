<!-- Sidebar -->
<div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>
        <li class="nav-header">Profile</li>
        <li class="nav-item">
            <a href="{{ url('profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Edit Profile</p>
            </a>
        </li>
        <li class="nav-header">Data Pengguna</li> 
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Level User</p> 
          </a> 
        </li> 
        <li class="nav-item"> 
          <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user')? 'active' : '' }}"> 
            <i class="nav-icon far fa-user"></i> 
            <p>Data User</p> 
          </a> 
        </li> 
        <li class="nav-item">
          <a href="{{ url('/profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }} ">
              <i class="nav-icon far fa-address-card"></i>
              <p>Profile</p>
          </a>
      </li>
        <li class="nav-header">Data Barang</li> 
        <li class="nav-item"> 
          <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 
  'kategori')? 'active' : '' }} "> 
            <i class="nav-icon far fa-bookmark"></i> 
            <p>Kategori Barang</p> 
          </a> 
        </li> 
        <li class="nav-item"> 
          <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang')? 'active' : '' }} "> 
            <i class="nav-icon far fa-list-alt"></i> 
            <p>Data Barang</p> 
          </a> 
        </li>
        <li class="nav-item"> 
          <a href="{{ url('/supplier') }}" class="nav-link {{ ($activeMenu == 'supplier')? 'active' : '' }} "> 
            <i class="nav-icon far fa-list-alt"></i> 
            <p>Data Supplier</p> 
          </a> 
        </li>  
        <li class="nav-header">Data Transaksi</li> 
        <li class="nav-item"> 
          <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok')? 
  'active' : '' }} "> 
            <i class="nav-icon fas fa-cubes"></i> 
            <p>Stok Barang</p> 
          </a> 
        </li> 
        <li class="nav-item"> 
          <a href="{{ url('/penjualan') }}" class="nav-link {{ ($activeMenu == 
  'penjualan')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-cash-register"></i> 
            <p>Transaksi Penjualan</p> 
          </a> 
        </li>  
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<style>
  .sidebar {
    background: linear-gradient(180deg, #2c3e50 0%, #3498db 100%);
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.sidebar .nav-link {
    border-radius: 8px;
    margin: 5px 15px;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover {
    background-color: rgba(255,255,255,0.1);
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background: rgba(255,255,255,0.2);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.sidebar .nav-header {
    color: #ecf0f1;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 1rem 1rem 0.5rem;
}

.sidebar-search .form-control-sidebar {
    background: rgba(255,255,255,0.1);
    border: none;
    color: #fff;
}

.sidebar-search .btn-sidebar {
    background: rgba(255,255,255,0.1);
    border: none;
}

/* header.blade.php styles */
.main-header {
    background: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.navbar-light .navbar-nav .nav-link {
    color: #2c3e50;
    font-weight: 500;
    padding: 0.8rem 1rem;
    transition: color 0.3s ease;
}

.navbar-light .navbar-nav .nav-link:hover {
    color: #3498db;
}

.navbar-badge {
    padding: 0.35em 0.6em;
    font-size: 0.75rem;
    border-radius: 0.5rem;
}
</style>