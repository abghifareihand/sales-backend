<!-- Header -->
<div class="header">

    <!-- Logo -->
    <div class="header-left active">
        <a href="{{ url('index') }}" class="logo logo-normal">
            <img src="{{ URL::asset('/build/img/logo-head.png') }}" alt="">
        </a>
        <a href="{{ url('index') }}" class="logo logo-white">
            <img src="{{ URL::asset('/build/img/logo-white.png') }}" alt="">
        </a>
        <a href="{{ url('index') }}" class="logo-small">
            <img src="{{ URL::asset('/build/img/logo-small.png') }}" alt="">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
    </div>
    <!-- /Logo -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

        <!-- Search -->
        <li class="nav-item nav-searchinputs">
            <div class="top-nav-search">
                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa fa-search"></i>
                </a>
            </div>
        </li>
        <!-- /Search -->

        <!-- Full Screen -->
        <li class="nav-item nav-item-box">
            <a href="javascript:void(0);" id="btnFullscreen">
                <i data-feather="maximize"></i>
            </a>
        </li>
        <!-- /Full Screen -->

        <!-- Notifications -->
        @php
            $user = auth()->user();
        @endphp

        @if(in_array($user->role, ['owner', 'pusat']))
            <!-- Notifications -->
            <li id="notifDropdown" class="nav-item dropdown nav-item-box">
                <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                    <i data-feather="bell"></i>
                    @if(!empty($returnCount) && $returnCount > 0)
                        <span class="badge rounded-pill">{{ $returnCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu notifications">
                    <div class="topnav-dropdown-header">
                        <span class="notification-title">Notifications</span>
                        <a href="javascript:void(0)" class="clear-noti">Clear All</a>
                    </div>
                    <div class="noti-content">
                        <ul class="notification-list">
                            @forelse($returnItems ?? [] as $item)
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details">
                                                    Produk <span class="noti-title">{{ optional($item->product)->name ?? 'Unknown' }}</span>
                                                    @if($item->type == 'cabang_to_pusat')
                                                        dikembalikan ke pusat oleh
                                                        <span class="noti-title">{{ optional($item->fromBranch)->name ?? 'Cabang' }}</span>
                                                    @elseif($item->type == 'sales_to_cabang')
                                                        dikembalikan ke cabang
                                                        <span class="noti-title">{{ optional($item->toBranch)->name ?? 'Cabang' }}</span>
                                                        oleh sales
                                                        <span class="noti-title">{{ optional($item->toSales)->name ?? 'Sales' }}</span>
                                                    @else
                                                        pergerakan stok
                                                    @endif
                                                    ({{ $item->quantity ?? 0 }} unit)
                                                </p>
                                                <p class="noti-time">
                                                    <span class="notification-time">{{ optional($item->created_at)->diffForHumans() ?? '-' }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="notification-message text-center">
                                    <span>Tidak ada notifikasi baru</span>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="{{ route('notifications.index') }}">View all Notifications</a>
                    </div>
                </div>
            </li>
        @endif


        <!-- /Notifications -->

        {{-- <!-- Email -->
        <li class="nav-item nav-item-box">
            <a href="#">
                <i data-feather="mail"></i>
            </a>
        </li>
        <!-- /Email -->

        <!-- Setting -->
        <li class="nav-item nav-item-box">
            <a href="#">
                <i data-feather="settings"></i>
            </a>
        </li>
        <!-- /Setting --> --}}

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-info">
                    <span class="user-letter">
                        <img src="{{ URL::asset('/build/img/profiles/user.png') }}" alt=""
                            class="img-fluid">
                    </span>
                    <span class="user-detail">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ strtoupper(auth()->user()->role) }}</span>
                    </span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img"><img src="{{ URL::asset('/build/img/profiles/user.png') }}"
                                alt="">
                            <span class="status online"></span></span>
                        <div class="profilesets">
                            <h6>{{ auth()->user()->name }}</h6>
                            <h5>{{ strtoupper(auth()->user()->role) }}</h5>
                        </div>
                    </div>
                    <hr class="m-0">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a class="dropdown-item logout pb-0" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <img src="{{ URL::asset('/build/img/icons/log-out.svg') }}" class="me-2" alt="img">
                        Logout
                    </a>
                </div>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ url('signin') }}">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>
<!-- /Header -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var notifDropdown = document.getElementById('notifDropdown');

        if(notifDropdown) {
            notifDropdown.addEventListener('show.bs.dropdown', function () {
                fetch("{{ route('distributions.markRead') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                }).then(response => response.json())
                  .then(data => {
                      if(data.status) {
                          // update badge menjadi 0 setelah dibaca
                          notifDropdown.querySelector('.badge').textContent = '0';
                      }
                  });
            });
        }
    });
</script>
