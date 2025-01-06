<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Insights Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto py-10 px-6 space-y-8">
        <!-- Earnings Overview -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
            <h2 class="text-2xl font-semibold text-gray-800">Earnings Overview 💰</h2>
            <p class="text-gray-500">Total earnings in the past month</p>
            <div class="mt-4 flex items-center space-x-4">
                <div class="text-4xl font-bold text-indigo-600">Rp {{ number_format($user->total_earning_current_month, 0, ',', '.') }}</div>
                <div class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded">+15% from last month</div>
            </div>
        </div>

        <!-- Product Sales Metrics with Line Chart -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
            <h2 class="text-2xl font-semibold text-gray-800">Product Sales Metrics 📊</h2>
            <p class="text-gray-500">Overview of items sold in various categories</p>

            <!-- Year and View Toggle -->
            <div class="flex items-center space-x-4 mt-4">
                <label for="yearSelect" class="text-gray-700 font-medium">Year:</label>
                <select id="yearSelect" class="px-3 py-1 rounded border-gray-300">
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>

                <label for="viewSelect" class="text-gray-700 font-medium">View:</label>
                <select id="viewSelect" class="px-3 py-1 rounded border-gray-300">
                    <option value="monthly">Monthly</option>
                    <option value="weekly">Weekly</option>
                </select>

                <label for="monthSelect" class="text-gray-700 font-medium">Month:</label>
                <select id="monthSelect" class="px-3 py-1 rounded border-gray-300 hidden">
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <!-- Add other months as needed -->
                </select>
            </div>
            
            <canvas id="salesChart" class="mt-4"></canvas>
        </div>
        <!-- Engagement Metrics -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                <h2 class="text-2xl font-semibold text-gray-800">Engagement Metrics</h2>
                <p class="text-gray-500">Insights on audience engagement</p>
                <div class="mt-4 grid grid-cols-3 gap-6">
                    <div class="bg-indigo-100 text-indigo-700 rounded-lg p-4 text-center">
                        <div class="text-xl font-bold">{{ $user->Artist->VIEW }}</div>
                        <div class="text-sm">Profile Views</div>
                    </div>
                    <div class="bg-indigo-100 text-indigo-700 rounded-lg p-4 text-center">
                        <div class="text-xl font-bold">{{ $user->Artist->MasterUser->total_art_like }}</div>
                        <div class="text-sm">Project likes</div>
                    </div>
                    <div class="bg-indigo-100 text-indigo-700 rounded-lg p-4 text-center">
                        <div class="text-xl font-bold">{{ $user->Artist->average_artist_rating }}</div>
                        <div class="text-sm">Overall rating</div>
                    </div>
                </div>
            </div>

        <!-- Sales Transactions Table with Year and Month Filter -->
    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sales Transactions 💳</h2>
    
    <!-- Filter Section -->
    <div class="flex space-x-4 mb-4">
        <!-- Year Filter -->
        <div>
            <label for="yearFilter" class="block text-sm font-medium text-gray-700">Year</label>
            <select id="yearFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Years</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <!-- Add more years as needed -->
            </select>
        </div>
        
        <!-- Month Filter -->
        <div>
            <label for="monthFilter" class="block text-sm font-medium text-gray-700">Month</label>
            <select id="monthFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Months</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>
    </div>
    
<!-- Sales Transactions Table -->
<div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
    <h2 class="text-2xl font-semibold text-gray-800">Sales Transactions</h2>
    <div class="overflow-y-auto max-h-96 mt-4">
        <!-- Table Container with Overflow -->
    <div class="overflow-auto max-h-80">
        <table class="w-full mt-4 text-left table-auto border-collapse">
                <thead>
                <tr class="border-b text-gray-600">
                        <th class="py-3">Image</th>
                        <th class="py-3">Product Name</th>
                        <th class="py-3">Category</th>
                        <th class="py-3">Date & Time</th>
                        <th class="py-3">Amount (Rp)</th>
                </tr>
                </thead>
        </table>
        <div class="overflow-y-auto max-h-64">
        <table class="w-full text-left table-auto border-collapse">
            <tbody class="text-gray-700">
                @foreach($user->getSoldItems() as $item)
                <tr class="border-b">
                    <td class="py-3"><img src="{{ Str::startsWith($item->Art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($item->Art->ArtImages()->first()->IMAGE_PATH) : $item->Art->ArtImages()->first()->IMAGE_PATH }}" alt="Product {{ $item->ORDER_ITEM_ID }}" class="w-12 h-12 rounded shadow-sm"></td>
                    <td class="py-3">{{ $item->Art->ART_TITLE }}</td>
                    <td class="py-3">
                        @foreach($item->Art->ArtCategories as $category)
                            {{ $item->Art->ArtCategories->map(fn($category) => $category->ArtCategoryMaster->DESCR)->implode(' | ') }}
                        @endforeach
                    </td>
                    <td class="py-3">{{ $item->created_at }}</td>
                    <td class="py-3 font-semibold text-indigo-600">Rp {{ number_format($item->PRICE_PER_ITEM, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

        <script>
            const yearlyData = {
                2024: [5200000, 6800000, 7100000, 6500000, 7500000, 8000000, 8500000, 7800000, 8200000, 8700000, 9000000, 9200000],
                2023: [4800000, 5900000, 6300000, 6000000, 7200000, 7500000, 8000000, 7400000, 7900000, 8200000, 8500000, 8700000]
            };

            const weeklyData = {
                January: [700000, 1200000, 800000, 1500000],
                February: [600000, 1000000, 1100000, 1300000],
                March: [900000, 850000, 1100000, 950000],
                // Add similar weekly data for other months
            };

            const ctx = document.getElementById('salesChart').getContext('2d');
            let salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array.from({ length: 12 }, (_, i) => new Date(0, i).toLocaleString('en', { month: 'long' })),
                    datasets: [{
                        label: 'Sales (Rp)',
                        data: yearlyData[2024],
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderColor: '#4F46E5',
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#6366F1',
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (tooltipItem) => `Rp ${tooltipItem.raw.toLocaleString()}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { callback: (value) => `Rp ${value.toLocaleString()}` }
                        },
                        x: { title: { display: true, text: 'Months' } }
                    }
                }
            });

            document.getElementById('yearSelect').addEventListener('change', function() {
                const selectedYear = this.value;
                updateChartWithYearlyData(selectedYear);
            });

            document.getElementById('viewSelect').addEventListener('change', function() {
                const viewMode = this.value;
                const monthSelect = document.getElementById('monthSelect');

                if (viewMode === 'weekly') {
                    monthSelect.classList.remove('hidden');
                    updateChartWithMonthlyData();
                } else {
                    monthSelect.classList.add('hidden');
                    updateChartWithYearlyData(document.getElementById('yearSelect').value);
                }
            });

            document.getElementById('monthSelect').addEventListener('change', function() {
                const selectedMonth = this.value;
                updateChartWithWeeklyData(selectedMonth);
            });

            function updateChartWithYearlyData(year) {
                salesChart.data.labels = Array.from({ length: 12 }, (_, i) => new Date(0, i).toLocaleString('en', { month: 'long' }));
                salesChart.data.datasets[0].data = yearlyData[year];
                salesChart.options.scales.x.title.text = 'Months';
                salesChart.update();
            }

            function updateChartWithMonthlyData() {
                salesChart.data.labels = Object.keys(weeklyData);
                salesChart.data.datasets[0].data = Object.values(weeklyData).map(weeks => weeks.reduce((a, b) => a + b, 0));
                salesChart.options.scales.x.title.text = 'Months';
                salesChart.update();
            }

            function updateChartWithWeeklyData(month) {
                salesChart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                salesChart.data.datasets[0].data = weeklyData[month];
                salesChart.options.scales.x.title.text = `Weeks in ${month}`;
                salesChart.update();
            }

            // JavaScript to filter transactions by year and month
            document.getElementById('yearFilter').addEventListener('change', filterTransactions);
            document.getElementById('monthFilter').addEventListener('change', filterTransactions);

            function filterTransactions() {
                const year = document.getElementById('yearFilter').value;
                const month = document.getElementById('monthFilter').value;
                const rows = document.querySelectorAll('#transactionTable tr');

                rows.forEach(row => {
                const date = row.getAttribute('data-date');
                const [rowYear, rowMonth] = date.split('-');
                const showRow = (!year || rowYear === year) && (!month || rowMonth === month);
                row.style.display = showRow ? '' : 'none';
                });
        }
            
        </script>
</body>
</html>
