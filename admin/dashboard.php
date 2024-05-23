<?php
require '../php/dbconnection.php';
include '../php/sessioncheck.php';
check_user_role(2);

// Fetch total number of cats
$cat_query = "SELECT COUNT(catID) AS total_cats FROM cats";
$cat_result = $conn->query($cat_query);
$total_cats = $cat_result->fetch_assoc()['total_cats'];

// Fetch total number of donations
$donation_query = "SELECT COUNT(donationID) AS total_donations FROM donation";
$donation_result = $conn->query($donation_query);
$total_donations = $donation_result->fetch_assoc()['total_donations'];

// Fetch total number of adoptions
$adoption_query = "SELECT COUNT(adoptionID) AS total_adoptions FROM adoption";
$adoption_result = $conn->query($adoption_query);
$total_adoptions = $adoption_result->fetch_assoc()['total_adoptions'];

// Fetch monthly donations
$monthly_donations_query = "SELECT MONTH(donationDate) AS month, COUNT(donationID) AS count FROM donation GROUP BY MONTH(donationDate)";
$monthly_donations_result = $conn->query($monthly_donations_query);
$monthly_donations = [];
while ($row = $monthly_donations_result->fetch_assoc()) {
    $monthly_donations[] = $row;
}

// Fetch monthly adoptions
$monthly_adoptions_query = "SELECT MONTH(adoptionDate) AS month, COUNT(adoptionID) AS count FROM adoption GROUP BY MONTH(adoptionDate)";
$monthly_adoptions_result = $conn->query($monthly_adoptions_query);
$monthly_adoptions = [];
while ($row = $monthly_adoptions_result->fetch_assoc()) {
    $monthly_adoptions[] = $row;
}

// Fetch donation types
$donation_types_query = "SELECT donationType, COUNT(donationID) AS count FROM donation GROUP BY donationType";
$donation_types_result = $conn->query($donation_types_query);
$donation_types = [];
while ($row = $donation_types_result->fetch_assoc()) {
    $donation_types[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | AdU Cats</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- LINKS -->
    <link rel="stylesheet" href="../style/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aoboshi+One&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- NAVIGATION BAR -->
    <nav>
        <ul class="nav_link">
            <div class="nav-links">
                <div class="logo">
                <img src="../img/Cat-1.png" alt="logo_cat" class="logo-cat">
                <h1>AduCats</h1>
                </div>
                <a href="cat-overview.php"><li>Cat Profiles</li></a>
                <a href="adoptionRequest.php"><li>Adoption Requests</li></a>
                <a href="donationForm.php"><li>Donation Forms</li></a>
                <div class="btn">
                <button class="customer-btn"><a href="../homepage.php">Customer Side</a></button>
                <button class="logout-btn"><a href="../php/logout.php">Logout</a></button>
                </div>
            </div>
        </ul>
    </nav>

    <!-- CONTENT -->
    <section class="dashboard">
        <!-- ROW 1: QUICK STATS -->
        <div class="row">
            <!-- CATS -->
            <div class="dashboard-box">
                <div class="total">
                <h3>Total No. of Campus Cats</h3>
                <p><?php echo $total_cats; ?></p>
                </div>
            </div>

            <!-- DONATIONS -->
            <div class="dashboard-box">
                <div class="total">
                <h3>Total No. of Donations</h3>
                <p><?php echo $total_donations; ?></p>
                </div>
            </div>

            <!-- ADOPTIONS -->
            <div class="dashboard-box">
                <div class="total">
                <h3>Total No. of Adoptions</h3>
                <p><?php echo $total_adoptions; ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-lower">
        <!-- ROW 2: DONATION -->
        <div class="row-donation">
            <!-- MONTHLY DONATION GRAPH -->
            <div class="donation">
                <div class="chart-donations">
                <h3>Donations</h3>
                <canvas id="monthlyDonationsChart"></canvas>
                </div>
            </div>

            <!-- KINDS OF DONATION -->
            <div class="donation-kinds">
                <div class="chart-kinds">
                <h3>Donation Kinds</h3>
                <canvas id="donationTypesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- ROW 3: ADOPTION -->
        <div class="row-adoption">
            <!-- MONTHLY ADOPTION GRAPH -->
            <div class="adoption">
                <h3>Adoption</h3>
                <div class="chart-container">
                <canvas id="monthlyAdoptionsChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Prepare data for monthly donations chart
        const monthlyDonationsLabels = <?php echo json_encode(array_map(function($month) {
            return date('F', mktime(0, 0, 0, $month, 1));
        }, array_column($monthly_donations, 'month'))); ?>;
        const monthlyDonationsData = <?php echo json_encode(array_column($monthly_donations, 'count')); ?>;

        const ctxDonations = document.getElementById('monthlyDonationsChart').getContext('2d');
        const monthlyDonationsChart = new Chart(ctxDonations, {
            type: 'line',
            data: {
                labels: monthlyDonationsLabels,
                datasets: [{
                    label: 'Monthly Donations',
                    data: monthlyDonationsData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        stepSize: 1
                    }
                }
            }
        });

        // Prepare data for monthly adoptions chart
        const monthlyAdoptionsLabels = <?php echo json_encode(array_map(function($month) {
            return date('F', mktime(0, 0, 0, $month, 1));
        }, array_column($monthly_adoptions, 'month'))); ?>;
        const monthlyAdoptionsData = <?php echo json_encode(array_column($monthly_adoptions, 'count')); ?>;

        const ctxAdoptions = document.getElementById('monthlyAdoptionsChart').getContext('2d');
        const monthlyAdoptionsChart = new Chart(ctxAdoptions, {
            type: 'line',
            data: {
                labels: monthlyAdoptionsLabels,
                datasets: [{
                    label: 'Monthly Adoptions',
                    data: monthlyAdoptionsData,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        stepSize: 1
                    }
                }
            }
        });

        // Prepare data for donation types chart
        const donationTypesLabels = <?php echo json_encode(array_column($donation_types, 'donationType')); ?>;
        const donationTypesData = <?php echo json_encode(array_column($donation_types, 'count')); ?>;

        const ctxTypes = document.getElementById('donationTypesChart').getContext('2d');
        const donationTypesChart = new Chart(ctxTypes, {
            type: 'pie',
            data: {
                labels: donationTypesLabels,
                datasets: [{
                    label: 'Donation Types',
                    data: donationTypesData,
                    backgroundColor: [
                        'rgba(255, 42, 0, 0.8)', //red
                        'rgba(0, 143, 233, 0.8)' //blue
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)', //red
                        'rgba(54, 162, 235, 1)' //blue
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function(context) {
                            return donationTypesLabels[context.dataIndex];
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

