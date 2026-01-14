<?php
// Start and Check for Valid Session
require_once(__DIR__ . "/../includes/session.inc.php");

// Include Functions
require_once(__DIR__ . "/../includes/functions.inc.php");


// Suppress all error messages
error_reporting(0);
ini_set('display_errors', 0);
$error_text = "\r";

// Variable Include
require_once(__DIR__ . "/../includes/variables.inc.php");

// Connect to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
	or die('Error connecting to database server');

// Graph Preprocessing
$numCustomers = countNumCustomers($dbc);
$creditLimitArray = fillCreditLimitArray($dbc);
$graphArray = fillGraphArray($creditLimitArray);
$graphName = "../charts/charts-$numCustomers.png";
$graphFilePath = __DIR__ . "/../charts/charts-$numCustomers.png";
$graphScale = makeGraphScale($numCustomers);
drawBarGraph(500, 400, $graphArray, $graphScale, $graphFilePath);
?>

<!DOCTYPE HTML>
<html>

<!-- HTML Head Include -->
<?php require_once(__DIR__ . "/../includes/memberhtmlhead.inc.php"); ?>

<body>
	<div id="main">

		<!-- Page Header -->
		<div id="header">

			<!-- Page Logo -->
			<?php require_once(__DIR__ . "/../includes/logo.inc.php"); ?>

			<!-- Page Navigation -->
			<div id="menubar">
				<ul id="menu">
					<li><a href="index.php">Home</a></li>
					<li><a href="addcustomer.php">Add Customer</a></li>
					<li class="selected"><a href="creditlimits.php">Credit Limit Report</a></li>
					<li><a href="inventory.php">Product Inventory Report</a></li>
					<li><a href="logout.php">Log Out</a></li>
				</ul>
			</div>

		</div>

		<div id="site_content">

			<!-- Page Content -->
			<div id="content">
				<h2 class="graph">Customer Credit Limit Distribution Report</h2>
				<p class="graph"><img src="<?= $graphName ?>" alt="Credit Limit Distribution Report"></p>
			</div>

		</div>

		<!-- Page Footer -->
		<?php require_once(__DIR__ . "/../includes/footer.inc.php"); ?>

	</div>
</body>

</html>

<?php
// Close Database Connection
mysqli_close($dbc);
?>