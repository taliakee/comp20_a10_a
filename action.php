<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
<title>Action</title>
</head>
<body>
    <?php
        function getPickupTime(){
            date_default_timezone_set('US/Eastern');
            $expTimeSecs = time() + (60 * 15);
            $expTime = date('h:i A' , $expTimeSecs);
            return $expTime;
        }
        function getDeliveryTime(){
            date_default_timezone_set('US/Eastern');
            $expTimeSecs = time() + (60 * 30);
            $expTime = date('h:i A', $expTimeSecs);
            return $expTime;
        }
    ?>
    <?php
    extract ($_GET);
    if ($validated != "valid"){
        $rlink = "<a href='https://talia-kee-comp20-a2.000webhostapp.com/'> https://talia-kee-comp20-a2.000webhostapp.com/</a>";
        echo "Invalid order. Try again: $rlink";
    }
    else {
        $method = $p_or_d;
        $msg = $time = $orderMethod = "";
        /* Creating email text */
        if ($method == "pickup"){
            $time = getPickupTime();
            $orderMethod = "Pickup at:";
            $msg = "Thanks for ordering!
                    Total: $ $total
                    First Name: $fname 
                    Last Name: $lname 
                    Phone: $phone 
                    Email: $email 
                    Pickup at: $time";
        }
        elseif ($method == "delivery"){
            $time = getDeliveryTime();
            $orderMethod = "Delivered at:";
            $msg = "Thanks for ordering!
                Total: $ $total
                First Name: $fname 
                Last Name: $lname 
                Street: $street 
                City: $city 
                Phone: $phone 
                Email: $email 
                Delivered by: $time";
        }
    
        mail($email, "Order Information", $msg);
    
        /* Creating order confirmation text in redirect */
        $myfile = fopen("order.php", "w") or die("Unable to open file!");
        $txt = "<h2>Thank you for ordering! </h2><br/> <p> ORDER SUMMARY <br/> <br/> $quan0 Chicken Chop Suey <br/> $quan1
        Sweet and Sour Pork <br/> $quan2  Shrimp Lo Mein <br/> $quan3 Moo Shi Chicken <br/> 
        $quan4 Fried Rice </p> <br/> Subtotal: $$subtotal <br/> Tax: $$tax <br/>
        Total: $$total <br/> <br/> $orderMethod $time";
        fwrite($myfile, $txt);
        fclose($myfile);
        $link = "<script>window.open('order.php')</script>";
        echo $link;
    }

    ?>
</body>
</html>