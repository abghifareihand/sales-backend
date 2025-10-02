<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            @php
                $role = auth()->user()->role;
                switch ($role) {
                    case 'owner':
                        $brandName = 'Owner';
                        $brandHref = route('owner.dashboard.index');
                        break;
                    case 'pusat':
                        $brandName = 'Admin Pusat';
                        $brandHref = route('pusat.dashboard.index');
                        break;
                    case 'cabang':
                        $brandName = 'Admin Cabang';
                        $brandHref = route('cabang.dashboard.index');
                        break;
                    default:
                        $brandName = '';
                        $brandHref = url('/');
                        break;
                }
            @endphp
            <ul>
                <li class="submenu-open">
                <h6 class="submenu-hdr">{{ $brandName }}</h6>
                    <ul>
                        {{-- OWNER --}}
                        @if($role == 'owner')
                            <li class="{{ Request::is('owner/dashboard') ? 'active' : '' }}">
                                <a href="{{ route('owner.dashboard.index') }}">
                                    <i data-feather="grid"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <li class="{{ Request::is('owner/product') ? 'active' : '' }}">
                                <a href="{{ route('owner.product.index') }}">
                                    <i data-feather="package"></i>
                                    <span>Produk</span>
                                </a>
                            </li>

                            <li class="{{ Request::is('owner/branch') ? 'active' : '' }}">
                                <a href="{{ route('owner.branch.index') }}">
                                    <i data-feather="archive"></i>
                                    <span>Cabang</span>
                                </a>
                            </li>

                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('owner/stock*') ? 'active subdrop' : '' }}">
                                    <i data-feather="clipboard"></i>
                                    <span>Stock</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('owner.stock.pusat.index') }}"
                                        class="{{ Request::is('owner/stock/pusat*') ? 'active' : '' }}">
                                        Pusat
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('owner.stock.cabang.index') }}"
                                        class="{{ Request::is('owner/stock/cabang*') ? 'active' : '' }}">
                                        Cabang
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('owner.stock.sales.index') }}"
                                        class="{{ Request::is('owner/stock/sales*') ? 'active' : '' }}">
                                        Sales
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('owner/user*') ? 'active subdrop' : '' }}">
                                    <i data-feather="user"></i>
                                    <span>Akun</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('owner.user.pusat.index') }}"
                                        class="{{ Request::is('owner/user/pusat*') ? 'active' : '' }}">
                                        Pusat
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('owner.user.cabang.index') }}"
                                        class="{{ Request::is('owner/user/cabang*') ? 'active' : '' }}">
                                        Cabang
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('owner.user.sales.index') }}"
                                        class="{{ Request::is('owner/user/sales*') ? 'active' : '' }}">
                                        Sales
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="{{ Request::is('owner/transaction') ? 'active' : '' }}">
                                <a href="{{ route('owner.transaction.index') }}">
                                    <i data-feather="file-text"></i>
                                    <span>Transaksi Sales</span>
                                </a>
                            </li>

                            <li class="{{ Request::is('owner/transaction/edit') ? 'active' : '' }}">
                                <a href="{{ route('owner.transaction.index.edit') }}">
                                    <i data-feather="file-text"></i>
                                    <span>Perubahan Harga</span>
                                </a>
                            </li>
                        @endif


                        {{-- PUSAT --}}
                        @if($role == 'pusat')
                            <li class="{{ Request::is('pusat/dashboard') ? 'active' : '' }}">
                                <a href="{{ route('pusat.dashboard.index') }}"><i data-feather="grid"></i><span>Dashboard</span></a>
                            </li>

                            <li class="{{ Request::is('pusat/product') ? 'active' : '' }}">
                                <a href="{{ route('pusat.product.index') }}">
                                    <i data-feather="package"></i>
                                    <span>Produk</span>
                                </a>
                            </li>

                            <li class="{{ Request::is('pusat/branch') ? 'active' : '' }}">
                                <a href="{{ route('pusat.branch.index') }}">
                                    <i data-feather="archive"></i>
                                    <span>Cabang</span>
                                </a>
                            </li>

                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('pusat/stock*') ? 'active subdrop' : '' }}">
                                    <i data-feather="clipboard"></i>
                                    <span>Stock</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('pusat.stock.pusat.index') }}"
                                        class="{{ Request::is('pusat/stock/pusat*') ? 'active' : '' }}">
                                        Pusat
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pusat.stock.cabang.index') }}"
                                        class="{{ Request::is('pusat/stock/cabang*') ? 'active' : '' }}">
                                        Cabang
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pusat.stock.sales.index') }}"
                                        class="{{ Request::is('pusat/stock/sales*') ? 'active' : '' }}">
                                        Sales
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="{{ Request::is('pusat/transaction') ? 'active' : '' }}">
                                <a href="{{ route('pusat.transaction.index') }}">
                                    <i data-feather="file-text"></i>
                                    <span>Transaksi Sales</span>
                                </a>
                            </li>

                            <li class="{{ Request::is('pusat/transaction/edit') ? 'active' : '' }}">
                                <a href="{{ route('pusat.transaction.index.edit') }}">
                                    <i data-feather="file-text"></i>
                                    <span>Perubahan Harga</span>
                                </a>
                            </li>

                        @endif

                        {{-- CABANG --}}
                        @if($role == 'cabang')
                            <li class="{{ Request::is('cabang/dashboard') ? 'active' : '' }}">
                                <a href="{{ route('cabang.dashboard.index') }}"><i data-feather="grid"></i><span>Dashboard</span></a>
                            </li>

                            <li class="submenu">
                                <a href="javascript:void(0);" class="{{ Request::is('cabang/stock*') ? 'active subdrop' : '' }}">
                                    <i data-feather="clipboard"></i>
                                    <span>Stock</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('cabang.stock.cabang.index') }}"
                                        class="{{ Request::is('cabang/stock/cabang*') ? 'active' : '' }}">
                                        Cabang
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('cabang.stock.sales.index') }}"
                                        class="{{ Request::is('cabang/stock/sales*') ? 'active' : '' }}">
                                        Sales
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="{{ Request::is('cabang/user') ? 'active' : '' }}">
                                <a href="{{ route('cabang.user.index') }}">
                                    <i data-feather="user"></i>
                                    <span>Akun Sales</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('cabang/transaction') ? 'active' : '' }}">
                                <a href="{{ route('cabang.transaction.index') }}">
                                    <i data-feather="file-text"></i>
                                    <span>Transaksi Sales</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
