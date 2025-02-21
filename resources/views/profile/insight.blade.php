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

        <a href="javascript:history.back()" 
        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-300 transition duration-300 shadow-sm mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            <span class="text-sm font-medium text-white">Back</span>
        </a>
        
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
            <h2 class="text-2xl font-semibold text-gray-800">Earnings Overview 💰</h2>
            <p class="text-gray-500">Total earnings in the past month</p>
            <div class="mt-4 flex items-center space-x-4">
                <div class="text-4xl font-bold text-indigo-600">
                    Rp <span id="totalEarnings">{{ number_format($user->total_earning, 0, ',', '.') }}</span>
                </div>
            </div>
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
                <option value="ALL">All Years</option>
                @foreach($user->getYearSoldItems() as $listYear)
                <option value="{{ $listYear->YEAR_NAME }}">{{ $listYear->YEAR_NAME }}</option>
                @endforeach
                <!-- Add more years as needed -->
            </select>
        </div>
        
        <!-- Month Filter -->
        <div>
            <label for="monthFilter" class="block text-sm font-medium text-gray-700">Month</label>
            <select id="monthFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="ALL">All Months</option>
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
                <table id="salesTable" class="w-full mt-4 text-left table-auto border-collapse">
                    <thead>
                        <tr class="border-b text-gray-600">
                            <th class="py-3">Image</th>
                            <th class="py-3">Product Name</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Date & Time</th>
                            <th class="py-3">Amount (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($user->getSoldItems() as $item)
                            <tr class="border-b" data-year="{{ $item->created_at->format('Y') }}" data-month="{{ $item->created_at->format('m') }}">
                                <td class="py-3">
                                    <img src="{{ Str::startsWith($item->Art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($item->Art->ArtImages()->first()->IMAGE_PATH) : $item->Art->ArtImages()->first()->IMAGE_PATH }}" alt="Product {{ $item->ORDER_ITEM_ID }}" class="w-12 h-12 rounded shadow-sm">
                                </td>
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
                <div id="noResultsMessage" class="hidden mt-4 text-center text-gray-600">
                    No transactions match the selected filters.
                </div>
            </div>
        </div>
    </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
            const yearFilter = document.getElementById('yearFilter');
            const monthFilter = document.getElementById('monthFilter');
            const salesTable = document.getElementById('salesTable');
            const rows = salesTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            const noResultsMessage = document.getElementById('noResultsMessage');
            const totalEarningsElement = document.getElementById('totalEarnings'); // Element to display total earnings

            function filterTable() {
                const selectedYear = yearFilter.value;
                const selectedMonth = monthFilter.value;
                let visibleRows = 0; // Counter for visible rows
                let totalEarnings = 0; // Variable to store total earnings

                for (let row of rows) {
                    const rowYear = row.getAttribute('data-year');
                    const rowMonth = row.getAttribute('data-month');

                    const yearMatch = selectedYear === 'ALL' || rowYear === selectedYear;
                    const monthMatch = selectedMonth === 'ALL' || rowMonth === selectedMonth;

                    if (yearMatch && monthMatch) {
                        row.style.display = ''; // Show the row
                        visibleRows++; // Increment the visible rows counter

                        // Calculate total earnings
                        const price = parseFloat(row.querySelector('td:nth-child(5)').textContent.replace('Rp ', '').replace(/\./g, ''));
                        totalEarnings += price;
                    } else {
                        row.style.display = 'none'; // Hide the row
                    }
                }

                // Show or hide the "No Results" message
                if (visibleRows === 0) {
                    noResultsMessage.style.display = 'block'; // Show the message
                } else {
                    noResultsMessage.style.display = 'none'; // Hide the message
                }

                // Update the total earnings display
                totalEarningsElement.textContent = formatCurrency(totalEarnings);
            }

            // Helper function to format currency
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'decimal',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            }

            yearFilter.addEventListener('change', filterTable);
            monthFilter.addEventListener('change', filterTable);

            // Reset Filters Button
            document.getElementById('resetFilters').addEventListener('click', function () {
                yearFilter.value = 'ALL';
                monthFilter.value = 'ALL';
                filterTable(); // Reapply the filter logic
            });
        });



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

            function filterTable() {
                let visibleRows = 0;

                for (let row of rows) {
                    const rowYear = row.getAttribute('data-year');
                    const rowMonth = row.getAttribute('data-month');

                    const yearMatch = selectedYear === 'ALL' || rowYear === selectedYear;
                    const monthMatch = selectedMonth === 'ALL' || rowMonth === selectedMonth;

                    if (yearMatch && monthMatch) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                }

                const noResultsMessage = document.getElementById('noResultsMessage');
                if (visibleRows === 0) {
                    noResultsMessage.style.display = 'block';
                } else {
                    noResultsMessage.style.display = 'none';
                }
            }
            
        </script>
</body>
</html>
