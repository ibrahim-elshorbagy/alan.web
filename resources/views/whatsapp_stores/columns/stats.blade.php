@if (analyticsFeature())
<a href="{{ route('whatsapp.store.analytics', $row->id)}}" class="text-primary" >
    <i class="fa-solid fa-chart-line fs-2"></i>
</a>
@endif

