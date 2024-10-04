@extends('layouts.app')
@section('bodycontent')
<h1 class="text-center font-bold text-purple-700 uppercase">New Diamond - Company System <br>
<div class="py-12 ml-4 md:ml-0">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-24 lg:px-26">
            <div class="md:flex md:space-x-40 justify-center">
                <a href="{{ route('transactions.index') }}">
                    <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
                        <div class="px-6 py-4 text-center">
                        <div class="font-bold text-5xl text-pink-600">{{ App\Models\Bank::sum('balance') }}</div>
                        <p class="text-gray-700">
                            Bank Balance
                        </p>
                        <span class="text-gray-700 text-sm">(in USD)</span>
                        </div>
                    </div>
                </a>
            </div><br>
            <h1 class="text-gray-500 text-lg font-bold">This Month</h1><br>
            <div class="md:flex md:space-x-40">
                <a href="{{ route('transactions.index') }}">
                    <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
                        <div class="px-6 py-4 text-center">
                        <div class="font-bold text-5xl text-green-500">{{ App\Models\Transaction::whereMonth('created_at', now())->where('type', 1)->sum('amount') }}</div>
                        <p class="text-gray-700">
                            Income
                        </p>
                        <span class="text-gray-700 text-sm">(in USD)</span>
                        </div>
                    </div>
                </a>
                <a href="{{ route('transactions.index') }}">
                    <div class="justify-center inline-flex bg-gray-50 rounded overflow-hidden shadow-lg" style="width:320px; height:128px;">
                        <div class="px-6 py-4 text-center">
                        <div class="font-bold text-5xl text-red-500">{{ App\Models\Transaction::whereMonth('created_at', now())->where('type', 2)->sum('amount') }}</div>
                        <p class="text-gray-700">
                            Expense
                        </p>
                        <span class="text-gray-700 text-sm">(in USD)</span>
                        </div>
                    </div>
                </a>
            </div><br>
            <div class="py-12">
                <div class="px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-24 lg:px-26">
                        <div class="chart">
                            <canvas class="inline-flex" id="mnthincomeChart" width="400" height="200"></canvas>
                        </div>  
                    </div>
                </div>
            </div><br>
            <div class="py-12">
                <div class="px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-24 lg:px-26">
                        <div class="chart">
                            <canvas class="inline-flex" id="mnthexpenseChart" width="400" height="200"></canvas>
                        </div>  
                    </div>
                </div>
            </div><br>
            <div class="py-12">
                <div class="sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-24 lg:px-26">
                    <div class="chart">
                        <canvas class="inline-flex" id="incvsexpChart" width="400" height="300"></canvas>
                    </div>
                    </div>
                </div>
            </div><br>
        </div>        
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  <?php
    $incomeData = [];
    $expenseData = [];
    for ($month = 1; $month <= 12; $month++) {
        $sum = App\Models\Transaction::whereMonth('created_at', $month)->where('type', 1)->sum('amount');
        array_push($incomeData, $sum);
        $expenseSum = App\Models\Transaction::whereMonth('created_at', $month)->where('type', 2)->sum('amount');
        array_push($expenseData, $expenseSum);
    }
  ?>

  const ctx2 = document.getElementById('mnthincomeChart');

  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [{
        label: '# income in usd',
        data: <?php echo json_encode($incomeData); ?>,
        borderWidth: 1,
        barPercentage: 0.5,
        barThickness: 20,
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  const ctx3 = document.getElementById('mnthexpenseChart');

  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [{
        label: '# expense in usd',
        data: <?php echo json_encode($expenseData); ?>,
        borderColor: 'rgba(255, 99, 132, 1)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderWidth: 1,
        barPercentage: 0.5,
        barThickness: 20,
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  const options = {
    responsive: true,
    maintainAspectRatio: false
  };
  const ctx4 = document.getElementById('incvsexpChart');

  const mixedChart = new Chart(ctx4, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
        label: '# income in usd',
        data: <?php echo json_encode($incomeData); ?>,
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)'
        }, {
        label: '# expense in usd',
        data: <?php echo json_encode($expenseData); ?>,
        borderColor: 'rgba(255, 99, 132, 1)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        }]
    },
    options: options
  });
</script>
@endpush