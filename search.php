
<html>
<head><title>Search For Customers</title>
</head>
<body>
<form action="search.php" method="post">
    <label for="id">Enter your customer ID</label>
    <input type="number" name="id" id="id">
    &nbsp;
    <label for="name">Enter your Name</label>
    <input type="text" name="name" id="name">
    &nbsp;
    <input type="submit" name="search" value="search">
</form>
</body>
</html>
<?php
    include('query.php');
?>
