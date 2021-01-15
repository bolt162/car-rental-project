<html>
<head><center><b>Car Rental Project by Kartikey Sharma and Sahil Bajaj</b></center>
<title>Car Rentals</title>
</head>
<body>
<script>
function select_plan()
{
    var pl = document.getElementById("plan").value;
    if(pl == 7)
      document.getElementById("week").innerHTML ="Weeks";
    else if(pl == 1)
      document.getElementById("days").innerHTML ="Days";
}
</script>
<form action="customers.php">
    <input type="submit" value="Search for a Customer"/>
</form>
</div>
<form method="post" action="home.php">
    <b>Add a Customer</b><br>
    <label for="name">Enter name: </label>
    <input type="text" id="name" name="name"><br>
    <label for="phone">Enter phone: </label>
    <input type="text" id="phone" name="phone"><br>
    <input type="submit" name="customer"><br>
</form>

<form method="post" action="home.php">
    <b>Add a Vehicle</b><br>
    <label for="id">Vehicle ID: </label>
    <input type="text" id="id" name="id"><br>
    <label for="desc">Description: </label>
    <input type="text" id="desc" name="desc"><br>
    <label for="year">Year: </label>
    <input type="number" id="year" name="year"><br>
    <label for="type">Vehicle Type: </label>
    <input type="number" id="type" name="type"><br>
    <label for="category">Vehicle Category: </label>
    <input type="number" id="category" name="category"><br>
    <input type="submit" name="vehicle"><br><br>
</form>

<form action="home.php" method="post">
    <b>Rent A Car</b><br>
    <label for="cid">Customer ID: </label>
    <input type="number" id="cid" name="cid"><br>
    <label for="type">Select Vehicle Type</label>
    <select id="type" name="type">
         <option value="1">Compact</option>
         <option value="2">Medium</option>
         <option value="3">Large</option>
         <option value="4">SUV</option>
         <option value="5">Truck</option>
         <option value="6">Van</option>
    </select><br>
    <label for="category">Select Vehicle Category</label>
    <select id="category" name="category">
          <option value="0">Basic</option>
          <option value="1">Luxury</option>
    </select><br>
    <label for="plan">Select Vehicle Plan</label>
    <select id="plan" name="plan" onchange="select_plan()">
          <option value="1">Daily</option>
          <option value="7">Weekly</option>
    </select><br>
    <label for="time">Number of <span id="week">Days</span></label>
    <input type="number" id="time" name="time"><br>
    <label for="start">Start Date</label>
    <input type="date" data-date="" data-date-format="YYYY MM DD" id="start" name="start"><br>
    <label for="return">Return Date</label>
    <input type="date" data-date="" data-date-format="YYYY MM DD" id="return" name="return"><br>
    <label for="pay">Select Payment Type</label>
    <select id="pay" name="pay">
          <option value="0">Pay Later</option>
          <option value="1">Pay Now</option>
    </select><br>
    <input type="submit" name="rent"><br><br>
</form>

<form method="post" action="home.php">
    <b>Return a Car</b><br>
    <label for="name">Customer Name: </label>
    <input type="text" id="name" name="name"><br>
    <label for="vehicleID">Vehicle ID: </label>
    <input type="text" id="vehicleID" name="vehicleID"><br>
    <label for="return">Return Date</label>
    <input type="date" data-date="" data-date-format="YYYY MM DD" id="return" name="return"><br>
    <input type="submit" name="r"><br><br>
</form>
</body>
</html>
<?php
    include('query.php');
    date_default_timezone_set('US/Central');
    $date = date('yy-m-d');
    $VehicleID=$_GET['vid'];
    $CustID=$_GET['cid'];
    $returndate=$_GET['return'];
?>
