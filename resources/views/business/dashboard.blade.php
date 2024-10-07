<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-100">
    
    <!-- Header Section (Employee Dashboard) -->
    <x-navbar />


    <!-- Sidebar and Dashboard Content -->
    <div class="flex h-screen ">
        <!-- Sidebar -->
        <x-sidebar />


        <!-- Main Dashboard Content -->
        <main class="flex-1 p-8 px-10">
            <!-- Surveys Section -->
            <section>
                <h2 class="text-2xl font-bold text-gray-700 mb-6">Dashboard</h2>
                <div class="px-10 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Employee Engagement Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="font-bold text-gray-800 mb-2">Respondent Engagement</h3>
                        <canvas id="engagementChart" class="w-full h-40"></canvas>
                    </div>

                    <!-- Employee Engagement Line Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="font-bold text-gray-800 mb-2">Total Survey Responses by Hour</h3>
                        <canvas id="responsesByHourChart" class="w-full h-40"></canvas>
                    </div>
                </div>
            </section>

            <!-- Distribution Section -->
            <section class="mt-8">
                <h2 class="text-2xl font-bold text-gray-700 mb-6">Distribution</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Distribution Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="font-bold text-gray-800 mb-2">Distribution</h3>
                        <div class="flex justify-between items-center">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-800">18%</div>
                                <div class="text-sm text-gray-600">Detractors</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-800">33%</div>
                                <div class="text-sm text-gray-600">Passives</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-800">49%</div>
                                <div class="text-sm text-gray-600">Promoters</div>
                            </div>
                        </div>
                    </div>

                    <!-- Trending Pointers Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="font-bold text-gray-800 mb-2">Trending Pointers</h3>
                        <canvas id="trendingChart" class="w-full h-40"></canvas>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Chart.js Configuration -->
    <script>
        // Employee Engagement Doughnut Chart
        var ctx = document.getElementById('engagementChart').getContext('2d');
        var engagementChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Engaged', 'Not Engaged'],
                datasets: [{
                    data: [78, 22],
                    backgroundColor: ['#4F46E5', '#E5E7EB'],
                }]
            },
            options: {
                cutoutPercentage: 80,
                responsive: true
            }
        });

        // Total Survey Responses by Hour Line Chart
        var lineCtx = document.getElementById('responsesByHourChart').getContext('2d');
        var responsesByHourChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['12 AM', '1 AM', '2 AM', '3 AM', '4 AM', '5 AM', '6 AM', '7 AM', '8 AM', '9 AM', '10 AM', '11 AM'],
                datasets: [{
                    label: 'Total Responses',
                    data: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60], // Sample data for total responses
                    fill: false,
                    borderColor: '#4F46E5',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Trending Pointers Pie Chart
        var trendingCtx = document.getElementById('trendingChart').getContext('2d');
        var trendingChart = new Chart(trendingCtx, {
            type: 'pie',
            data: {
                labels: ['Recognition', 'Engagement', 'Communication', 'Career Progression', 'Empowerment'],
                datasets: [{
                    data: [36, 15, 20, 21, 8],
                    backgroundColor: ['#4F46E5', '#E11D48', '#F59E0B', '#10B981', '#3B82F6'],
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

</body>
</html>
