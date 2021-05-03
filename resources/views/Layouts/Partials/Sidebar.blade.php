<div class="main-sidebar">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">{{config('app.name')}}</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">St</a>
      </div>
      <ul class="sidebar-menu">
          <li class="menu-header">Master Data</li>
          <li class="nav-item dropdown">
            <a class="nav-link" href=" {{route('siswa')}} "><i class="far fa-square"></i> <span>Siswa</span></a>
            <a class="nav-link" href=" {{route('siswa')}} "><i class="far fa-square"></i> <span>Pembina Ekskul</span></a>
            <a class="nav-link" href=" {{route('siswa')}} "><i class="far fa-square"></i> <span>Kelas</span></a>
            <a class="nav-link" href=" {{route('siswa')}} "><i class="far fa-square"></i> <span>Ekskul</span></a>
          </li>
          <li class="menu-header">Transaction</li>
          <li class="nav-item dropdown">
            <a class="nav-link" href=" {{route('daftar_ekskul')}} "><i class="far fa-square"></i> <span>Pendaftaran Ekskul</span></a>
            <a class="nav-link" href=" {{route('siswa')}} "><i class="far fa-square"></i> <span>Laporan Ekskul</span></a>
            <a class="nav-link" href=" {{route('siswa')}} "><i class="far fa-square"></i> <span>Rekap Ekskul</span></a>
          </li>
        </ul>
    </aside>
</div>