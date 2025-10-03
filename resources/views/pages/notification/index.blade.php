@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>All Notifications</h4>
                <h6>View your all activities</h6>
            </div>
        </div>

        <div class="activity">
            <div class="activity-box">
                <ul class="activity-list">
                    @forelse($notifications as $item)
                        <li>
                            <div class="activity-user">
                                <a href="" title="" data-toggle="tooltip" data-original-title="{{ optional($item->user)->name ?? 'User' }}">
                                    <div style="display:flex; justify-content:center; align-items:center; width:50px; height:50px;">
                                        <i data-feather="bell" style="font-size:32px;"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="activity-content">
                                <div class="timeline-content">
                                    Produk <strong class="noti-title">{{ optional($item->product)->name ?? 'Unknown' }}</strong>
                                    @if($item->type == 'cabang_to_pusat')
                                        dikembalikan ke pusat oleh
                                        <strong class="noti-title">{{ optional($item->fromBranch)->name ?? 'Cabang' }}</strong>
                                    @elseif($item->type == 'sales_to_cabang')
                                        dikembalikan ke cabang
                                        <strong class="noti-title">{{ optional($item->toBranch)->name ?? 'Cabang' }}</strong>
                                        oleh sales
                                        <strong class="noti-title">{{ optional($item->toSales)->name ?? 'Sales' }}</strong>
                                    @endif
                                    ({{ $item->quantity ?? 0 }} unit)
                                    <span class="time">{{ optional($item->created_at)->diffForHumans() ?? '-' }}</span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-center">Tidak ada notifikasi</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
