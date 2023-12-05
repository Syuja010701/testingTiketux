<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link text-black d-flex align-items-center gap-2 {{ (request()->is('/')) ? 'active' : '' }} " aria-current="page" href="{{ route(('dashboard.index')) }}">
              <svg class="bi"><use xlink:href="#house-fill"/></svg>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  text-black d-flex align-items-center gap-2 {{ (request()->is('kategori-coa*')) ? 'active' : '' }} " href="{{ route('kategoriCoa.index') }}">
            <iconify-icon icon="tdesign:data"></iconify-icon>
              Master Kategori COA
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-black d-flex align-items-center gap-2 {{ (request()->is('coa*')) ? 'active' : '' }}" href="{{ route('coa.index') }}">
             <iconify-icon icon="bx:data"></iconify-icon>
              Master Chart Of Account
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-black d-flex align-items-center gap-2 {{ (request()->is('transaksi*')) ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
              <iconify-icon icon="uil:transaction"></iconify-icon>
              Transaksi
            </a>
          </li>
           {{-- <li class="nav-item">
            <a class="nav-link text-black d-flex align-items-center gap-2 " href="{{ route('transaksi.index') }}">
              <iconify-icon icon="vscode-icons:file-type-excel"></iconify-icon>
              Download Excel Profit/Loss
            </a>
          </li> --}}
        </ul>

        <hr class="my-3">

        {{-- <ul class="nav flex-column mb-auto">
          <li class="nav-item">
            <a class="nav-link text-black d-flex align-items-center gap-2" href="#">
              <svg class="bi"><use xlink:href="#door-closed"/></svg>
              Sign out
            </a>
          </li>
        </ul> --}}
      </div>
    </div>
</div>
