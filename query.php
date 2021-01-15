<?php
    
    $servername = "localhost";
    $username = "root";
    $password = null;
    $dbname = "project3";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if(isset($_POST['customer']))
    {
        
        $result=mysqli_query($conn, "INSERT INTO customer(CustID, Name,Phone) VALUES(232, '".$_POST['name'])."', '".$_POST['phone'])."')") or die(mysqli_error($conn));
        $result1=mysqli_query($conn, "SELECT * FROM customer WHERE Name='$name' AND Phone='$phone' LIMIT 1");
        $value = mysqli_fetch_assoc($result1);
        $id=$value['CustID'];
        echo "Your Customer ID is '$id' ";

    }

    if(isset($_POST['vehicle']))
    {
        $result=mysqli_query($conn,"INSERT INTO vehicle(`VehicleID`,`Description`,`Year`,`Type`,`Category`) ('".$_POST['id']."','".$_POST['desc']."','".$_POST['year']."','".$_POST['type']."','".$_POST['category']."')") or die(mysqli_error($conn));
    }

    if(isset($_POST['rent']))
    {
        date_default_timezone_set('US/Central');
        $date = date('yy-m-d');
        $pay=$_POST['pay'];
        $customer=mysqli_query($conn,"SELECT * FROM customer WHERE CustID='".$_POST['cid']."'");
        $cust=mysqli_num_rows($customer);
        
        if($cust==0)
        {
              echo "No customer found!";
        }
        else
        {
            $result=mysqli_query($conn, "SELECT * FROM rate WHERE `type`='".$_POST['type']."' AND `category`='".$_POST['category']."' LIMIT 1");
            $values=mysqli_fetch_assoc($result);
            $daily_rate=$values['daily'];
            $weekly_rate=$values['weekly'];
            $vehicle_id=null;
            $results=mysqli_query($conn, "SELECT * FROM vehicle WHERE `type`='".$_POST['type']."' AND `category`='".$_POST['category']."' LIMIT 1");
            
            foreach($results as $row)
            {
                $value=mysqli_fetch_assoc($row);
                $vehicleID = $value['VehicleID'];
                $results2=mysqli_query($conn, "SELECT * FROM rental WHERE VehicleID='$vehicleID' LIMIT 1 ");
                $cust=mysqli_num_rows($results2);

                if($cust==0)
                {
                    $vehicle_id=$vehicleID;
                    break;
                }
                else
                {
                    $values1=mysqli_fetch_assoc($results2);
                    $ret=$values1['returned'];
                    if($returned==1)
                    {
                        $vehicle_id=$vehicleID;
                        break;
                    }
                }
            }
            if($vehicle_id==null)
            {
                echo "The Vehicle is not available.";
            }
            else
            {
                   if($_POST['plan']==1)
                   {
                       $price = $daily_rate * $_POST['quantity'];
                       if($pay==0)
                       {
                           $query="INSERT INTO rental(`CustID`,`VehicleID`,`StartDate`,`OrderDate`,`RentalType`,`Qty`,`ReturnDate`,`TotalAmount`,`PaymentDate`,`returned`) VALUES(".$_POST['cid'].",'$vehicle_id','".$_POST['start']."','$date','".$_POST['plan']."','".$_POST['quantity']."','".$_POST['return']."','$price',NULL,0)";
                           $run = mysqli_query($conn, $query);
                       }
                       elseif($pay==1)
                       {
                           $query="INSERT INTO rental(`CustID`,`VehicleID`,`StartDate`,`OrderDate`,`RentalType`,`Qty`,`ReturnDate`,`TotalAmount`,`PaymentDate`,`returned`) VALUES(".$_POST['cid'].",'$vehicle_id','".$_POST['start']."','$date','".$_POST['plan']."','".$_POST['quantity']."','".$_POST['return']."','$price','$date',0)";
                           $run = mysqli_query($conn,$query);
                       }
                   }
                   elseif($_POST['plan']==7)
                   {
                        $price = $weekly_rate * $_POST['quantity'];
                        if($pay==0)
                        {
                            $query="INSERT INTO rental(`CustID`,`VehicleID`,`StartDate`,`OrderDate`,`RentalType`,`Qty`,`ReturnDate`,`TotalAmount`,`PaymentDate`,`returned`) VALUES(".$_POST['cid'].",'$vehicle_id','".$_POST['start']."','$date','".$_POST['plan']."','".$_POST['quantity']."','".$_POST['return']."','$price',NULL,0)";
                            $run=mysqli_query($conn,$query);
                        }
                        elseif($pay==1)
                        {
                            $query="INSERT INTO rental(`CustID`,`VehicleID`,`StartDate`,`OrderDate`,`RentalType`,`Qty`,`ReturnDate`,`TotalAmount`,`PaymentDate`,`returned`) VALUES(".$_POST['cid'].",'$vehicle_id','".$_POST['start']."','$date','".$_POST['plan']."','".$_POST['quantity']."','".$_POST['return']."','$price','$date',0)";
                            $run=mysqli_query($conn,$query);
                        }
                   }
            }
        }
    }


    if(isset($_POST['return_search']))
    {
        $name = $_POST['name'];
        $vehicleid = $_POST['vid'];
        $return = $_POST['return'];
        $query="SELECT * FROM customer WHERE Name='A. Parks' LIMIT 1";
        $result=mysqli_query($conn,$query);
        $value=mysqli_fetch_assoc($result);
        $custID=$value['CustID'];
        $query2 ="UPDATE rental SET returned=1, PaymentDate='$date' WHERE CustID='$value[CustID]' AND TotalAmount=$price";
        $result2=mysqli_query($conn,$query2) or die(mysqli_error($conn)) ;


        echo "<div>";
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Customer Id</th>";
        echo "<th>Vehicle ID</th>";
        echo "<th>Total Amount Due</th>";
        echo "<th>Return Date</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>$value['CustID']</td>";
        echo "<td>$vehicleid</td>";
        echo "<td>$price</td>";
        echo "<td>$return</td>";
        echo "</tr>";
        echo "</table>";
        echo "</div>";
    }

    if(isset($_POST['search']))
    {
        $cname=$_POST['name'];
        $custID =$_POST['id'];
        if($custID == null && $cname == null)
        {
            echo "<div>";

            echo "<table border='1'><tr>";
            echo "<th>Customer Id</th>";
            echo "<th>Name</th>";
            echo "<th>Total Amount Due</th>";
            echo "</tr>";
            $query="SELECT * FROM customer";
            $detail = mysqli_query($conn,$query);
            $total =mysqli_num_rows($detail);
        
        
            while($user = $detail->fetch_assoc())
            {
                   
               
                $name=$user['Name'];
                $customer_id=$user['CustID'];
                $sum = 0;
                $query2 = "SELECT * FROM rental WHERE CustID='$customer_id' and PaymentDate IS NULL ";
                $details2 = mysqli_query($conn,$query2);
                $cust=mysqli_num_rows($details2);
                if($cust==0)
                {
                    echo "<tr>";
                    echo "<td>$customer_id</td>";
                    echo "<td>$name</td>";
                    echo "<td> $0 </td>";
                    echo "</tr>";
                }
                elseif($cust == 1)
                {
                    $result= mysqli_fetch_assoc($details2);
                    $paydate=$result['PaymentDate'];
                    $amount =  $result['TotalAmount'];
                    if ($paydate==null)
                    {
                        $amount = 0;
                    }
                    echo "<tr>";
                    echo "<td>$customer_id</td>";
                    echo "<td>$name</td>";
                    echo "<td>$ $amount</td>";
                    echo "</tr>";
                }
                else
                {
                    while($u = $details2->fetch_assoc())
                    {
                        $sum = $sum + $u['TotalAmount'];
                    }
                    echo "<tr>";
                    echo "<td>$customer_id</td>";
                    echo "<td>$name</td>";
                    echo "<td>$ $sum</td>";
                    echo "</tr>";
                }
            
            }
        
            echo "</table>";
            echo "</div>";
            
        }
        elseif($custID!=null)
        {
                echo "<div>";
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>Customer Id</th>";
                echo "<th>Name</th>";
                echo "<th>Total Amount Due</th>";
                echo "</tr>";
                $q = "SELECT * from customer WHERE CustID='$custID' LIMIT 1";
                $d=mysqli_query($conn,$q);
                $user = mysqli_fetch_assoc($d);
                $name=$user['Name'];
                $customer_id=$custID;
                $sum = 0;
                $query2 = "SELECT * FROM rental WHERE CustID='$customer_id' and PaymentDate IS NULL ";
                $details2 = mysqli_query($conn,$query2);
                $cust=mysqli_num_rows($details2);
                if($cust==0)
                {
                    echo "<tr>";
                    echo "<td>$customer_id</td>";
                    echo "<td>$name</td>";
                    echo "<td> $0 </td>";
                    echo "</tr>";
                }
                elseif($cust == 1)
                {
                    $result= mysqli_fetch_assoc($details2);
                    $paydate=$result['PaymentDate'];
                    $amount =  $result['TotalAmount'];
                    if ($paydate==null)
                    {
                        $amount = 0;
                    }
                    echo "<tr>";
                    echo "<td>$customer_id</td>";
                    echo "<td>$name</td>";
                    echo "<td>$ $amount</td>";
                    echo "</tr>";
                }
                else
                {
                    while($u = $details2->fetch_assoc())
                    {
                        $sum = $sum + $u['TotalAmount'];
                    }
                    echo "<tr>";
                    echo "<td>$customer_id</td>";
                    echo "<td>$name</td>";
                    echo "<td>$ $sum</td>";
                    echo "</tr>";
                }
            
            
        
                echo "</table>";
                echo "</div>";
        }

        elseif($custID==null && $cname!=null)
        {
                echo "<div>";
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>Customer Id</th>";
                echo "<th>Name</th>";
                echo "<th>Total Amount Due</th>";
                echo "</tr>";
                $q = "SELECT * from customer WHERE Name='$cname' OR Name LIKE '%$cname'  OR Name LIKE '%$cname%'  OR Name LIKE '$cname%'  LIMIT 1";
                $d=mysqli_query($conn,$q);
                $user = mysqli_fetch_assoc($d);
                $name=$user['Name'];
                $customer_id=$user['CustID'];
                $sum = 0;
                $query2 = "SELECT * FROM rental WHERE CustID='$customer_id' and PaymentDate IS NULL ";
                $details2 = mysqli_query($conn,$query2);
                $cust=mysqli_num_rows($details2);
                if($cust==0)
                {
        
                    echo "<tr>";
                    echo "<td>$customer_id</td>";
                    echo "<td>$name</td>";
                    echo "<td> $0 </td>";
                    echo "</tr>";
                }
                elseif($cust == 1)
                {
                $result= mysqli_fetch_assoc($details2);
                $paydate=$result['PaymentDate'];
                $amount =  $result['TotalAmount'];
                if ($paydate==null)
                {
                $amount = 0;
                }
                echo "<tr>";
                echo "<td>$customer_id</td>";
                echo "<td>$name</td>";
                echo "<td>$ $amount</td>";
                echo "</tr>";
                }
                else
                {
                    while($u = $details2->fetch_assoc())
                    {
                        $sum = $sum + $u['TotalAmount'];
                    }
                    echo "<tr>";
                    echo "<td>$customer_id</td>";
                    echo "<td>$name</td>";
                    echo "<td>$ $sum</td>";
                    echo "</tr>";
                }
            
            
        
            echo "</table>";
            echo "</div>";
        }
    }
?>
