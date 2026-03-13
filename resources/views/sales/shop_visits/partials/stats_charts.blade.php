<div class="row g-4 mt-1">

  {{-- Chart 1: Current Month Daily Visits --}}
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5 class="card-title mb-4">{{ __('messages.shop_visits.current_month_chart') }}</h5>
        <div style="height:300px; position:relative;">
          <canvas id="shopVisitsMonthChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Chart 2: Overall Work Period Monthly Visits --}}
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5 class="card-title mb-4">{{ __('messages.shop_visits.overall_period_chart') }}</h5>
        <div style="height:300px; position:relative;">
          <canvas id="shopVisitsOverallChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Chart 3: Active Cards Current Month --}}
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5 class="card-title mb-4">{{ __('messages.shop_visits.current_month_sales_chart') }}</h5>
        <div style="height:300px; position:relative;">
          <canvas id="shopVisitsSalesMonthChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Chart 4: Active Cards All-Time (Monthly) --}}
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5 class="card-title mb-4">{{ __('messages.shop_visits.overall_sales_chart') }}</h5>
        <div style="height:300px; position:relative;">
          <canvas id="shopVisitsSalesOverallChart"></canvas>
        </div>
      </div>
    </div>
  </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  if (typeof Chart === 'undefined') {
    return;
  }

  const monthLabels = @json($stats['month_chart']['labels']);
  const monthData = @json($stats['month_chart']['data']);

  const overallLabels = @json($stats['overall_chart']['labels']);
  const overallData = @json($stats['overall_chart']['data']);

  const salesMonthLabels = @json($stats['month_sales_chart']['labels']);
  const salesMonthData = @json($stats['month_sales_chart']['data']);

  const salesOverallLabels = @json($stats['overall_sales_chart']['labels']);
  const salesOverallData = @json($stats['overall_sales_chart']['data']);

  const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          precision: 0
        }
      }
    }
  };

  // Chart 1
  const monthCtx = document.getElementById('shopVisitsMonthChart');
  if (monthCtx) {
    new Chart(monthCtx.getContext('2d'), {
      type: 'line',
      data: {
        labels: monthLabels,
        datasets: [{
          data: monthData,
          borderColor: '#1C274C',
          backgroundColor: 'rgba(28, 39, 76, 0.15)',
          tension: 0.35,
          fill: true
        }]
      },
      options: commonOptions
    });
  }

  // Chart 2
  const overallCtx = document.getElementById('shopVisitsOverallChart');
  if (overallCtx) {
    new Chart(overallCtx.getContext('2d'), {
      type: 'bar',
      data: {
        labels: overallLabels,
        datasets: [{
          data: overallData,
          backgroundColor: '#2A9D8F',
          borderColor: '#2A9D8F',
          borderWidth: 1
        }]
      },
      options: commonOptions
    });
  }

  // Chart 3
  const salesMonthCtx = document.getElementById('shopVisitsSalesMonthChart');
  if (salesMonthCtx) {
    new Chart(salesMonthCtx.getContext('2d'), {
      type: 'bar',
      data: {
        labels: salesMonthLabels,
        datasets: [{
          data: salesMonthData,
          backgroundColor: 'rgba(76, 175, 80, 0.75)',
          borderColor: '#4CAF50',
          borderWidth: 1,
          borderRadius: 4
        }]
      },
      options: commonOptions
    });
  }

  // Chart 4
  const salesOverallCtx = document.getElementById('shopVisitsSalesOverallChart');
  if (salesOverallCtx) {
    new Chart(salesOverallCtx.getContext('2d'), {
      type: 'line',
      data: {
        labels: salesOverallLabels,
        datasets: [{
          data: salesOverallData,
          borderColor: '#3F51B5',
          backgroundColor: 'rgba(63, 81, 181, 0.15)',
          tension: 0.35,
          fill: true
        }]
      },
      options: commonOptions
    });
  }

});
</script>
@endpush
