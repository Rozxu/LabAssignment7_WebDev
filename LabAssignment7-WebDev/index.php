<?php
// Database connection details
$host = "localhost";
$user = "root"; 
$password = ""; 
$dbname = "domesticexpenditure";

// Create database connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Table 1 data (Expenditure by Visitors)
$query1 = "SELECT component, year2010, year2011 FROM ExpenditureVisitors2011";
$result1 = $conn->query($query1);
$data1 = [];
while ($row = $result1->fetch_assoc()) {
    $data1[] = $row;
}

// Fetch Table 2 data (Expenditure by Tourists)
$query2 = "SELECT component, year2010, year2011 FROM ExpenditureTourists2011";
$result2 = $conn->query($query2);
$data2 = [];
while ($row = $result2->fetch_assoc()) {
    $data2[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenditure Graphs</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <h1>Expenditure by Domestic Visitors & Tourists (2011)</h1>
    </header>

    <main>
        <!-- Visitor Bar Chart -->
        <section class="chart-section">
            <h2>Bar Chart: Visitor Expenditure Comparison (2010 vs. 2011)</h2>
            <canvas id="barChart"></canvas>
        </section>

        <!-- Visitor Pie Chart -->
        <section class="chart-section">
            <h2>Pie Chart: Visitor Expenditure Breakdown (2011)</h2>
            <canvas id="pieChart"></canvas>
        </section>

        <!-- Tourist Bar Chart -->
        <section class="chart-section">
            <h2>Bar Chart: Tourist Expenditure Comparison (2010 vs. 2011)</h2>
            <canvas id="barChart2"></canvas>
        </section>

        <!-- Tourist Pie Chart -->
        <section class="chart-section">
            <h2>Pie Chart: Tourist Expenditure Breakdown (2011)</h2>
            <canvas id="pieChart2"></canvas>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Domestic Expenditure Analysis</p>
    </footer>

    <script>
		// Bar Chart for Visitors
		const barData1 = {
			labels: <?= json_encode(array_column($data1, 'component')) ?>,
			datasets: [
				{
					label: '2010 (RM million)',
					data: <?= json_encode(array_column($data1, 'year2010')) ?>,
					backgroundColor: 'rgba(54, 162, 235, 0.6)',
				},
				{
					label: '2011 (RM million)',
					data: <?= json_encode(array_column($data1, 'year2011')) ?>,
					backgroundColor: 'rgba(255, 99, 132, 0.6)',
				}
			]
		};

		const barConfig1 = {
			type: 'bar',
			data: barData1,
			options: {
				responsive: true,
				maintainAspectRatio: true,
				aspectRatio: 3, 
				plugins: { legend: { position: 'top' } },
			},
		};
		new Chart(document.getElementById('barChart'), barConfig1);

		// Pie Chart for Visitors
		const pieData1 = {
			labels: <?= json_encode(array_column($data1, 'component')) ?>,
			datasets: [
				{
					data: <?= json_encode(array_column($data1, 'year2011')) ?>,
					backgroundColor: [
						'rgba(255, 99, 132, 0.6)',
						'rgba(54, 162, 235, 0.6)',
						'rgba(255, 206, 86, 0.6)',
						'rgba(75, 192, 192, 0.6)',
						'rgba(153, 102, 255, 0.6)',
						'rgba(255, 159, 64, 0.6)'
					],
				}
			]
		};

		const pieConfig1 = {
			type: 'pie',
			data: pieData1,
			options: {
				responsive: true,
				maintainAspectRatio: true,
				aspectRatio: 3, 
			},
		};
		new Chart(document.getElementById('pieChart'), pieConfig1);

		// Bar Chart for Tourists
		const barData2 = {
			labels: <?= json_encode(array_column($data2, 'component')) ?>,
			datasets: [
				{
					label: '2010 (RM million)',
					data: <?= json_encode(array_column($data2, 'year2010')) ?>,
					backgroundColor: 'rgba(75, 192, 192, 0.6)',
				},
				{
					label: '2011 (RM million)',
					data: <?= json_encode(array_column($data2, 'year2011')) ?>,
					backgroundColor: 'rgba(153, 102, 255, 0.6)',
				}
			]
		};

		const barConfig2 = {
			type: 'bar',
			data: barData2,
			options: {
				responsive: true,
				maintainAspectRatio: true,
				aspectRatio: 3, 
				plugins: { legend: { position: 'top' } },
			},
		};
		new Chart(document.getElementById('barChart2'), barConfig2);

		// Pie Chart for Tourists
		const pieData2 = {
			labels: <?= json_encode(array_column($data2, 'component')) ?>,
			datasets: [
				{
					data: <?= json_encode(array_column($data2, 'year2011')) ?>,
					backgroundColor: [
						'rgba(255, 99, 132, 0.6)',
						'rgba(54, 162, 235, 0.6)',
						'rgba(255, 206, 86, 0.6)',
						'rgba(75, 192, 192, 0.6)',
						'rgba(153, 102, 255, 0.6)',
						'rgba(255, 159, 64, 0.6)'
					],
				}
			]
		};

		const pieConfig2 = {
			type: 'pie',
			data: pieData2,
			options: {
				responsive: true,
				maintainAspectRatio: true,
				aspectRatio: 3, 
			},
		};
		new Chart(document.getElementById('pieChart2'), pieConfig2);

    </script>
</body>
</html>
