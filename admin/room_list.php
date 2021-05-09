<?php  
session_start();  
if(!isset($_SESSION["user"]))
{
 header("location:index.php");
}
?> 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HA NOI HOTEL</title>

	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- Morris Chart Styles-->
     <link rel="stylesheet" href="./css/admin_style.css">
    <script src="./resources/ckeditor/ckeditor.js"></script>
   
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
        
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php"><?php echo $_SESSION["user"]; ?> </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="usersetting.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="home.php"><i class="fa fa-dashboard"></i> Status</a>
                    </li>
                    <li>
                        <a class="active-menu" href="messages.php"><i class="fa fa-desktop"></i> News Letters</a>
                    </li>
					<li>
                        <a href="roombook.php"><i class="fa fa-bar-chart-o"></i>Room Booking</a>
                    </li>
                    <li>
                        <a href="room_list.php"><i class="fa fa-bar-chart-o"></i>Room list</a>
                    </li>
                    <li>
                        <a href="Payment.php"><i class="fa fa-qrcode"></i> Payment</a>
                    </li>
                    <li>
                        <a  href="profit.php"><i class="fa fa-qrcode"></i> Profit</a>
                    </li>
                    <li>
                        <a href="logout.php" ><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                     
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
   
        <style>
        body{
            font-family: arial;
        }
        .container{
            width: 1200px;
            margin: 0 auto;
        }
        h1{
            text-align: center;
        }

        .product-items{
            border: 1px solid #ccc;
            padding: 30px;
        }
        .room-item{
            float: left;
            width: 23%;
            margin: 1%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            line-height: 26px;
        }
        .room-item label{
            font-weight: bold;
        }
        .room-item{
            width: 200px;
            height: 290px;
        }
        .room-item p{
            margin: 0;
            line-height: 26px;
            max-height: 52px;
            overflow: hidden;
            
        }
        .room-price{
            color: red;
            font-weight: bold;
        }
        .room-img{
            padding: 5px;
            border: 1px solid #ccc;
            margin-bottom: 5px;
        }
        .room-item img{
            max-width: 100%;
        }
        .room-item ul{
            margin: 0;
            padding: 0;
            border-right: 1px solid #ccc;
        }
        .product-item ul li{
            float: left;
            width: 33.3333%;
            list-style: none;
            text-align: center;
            border: 1px solid #ccc;
            border-right: 0;
            box-sizing: border-box;
        }
        .clear-both{
            clear: both;
        }
        a{
            text-decoration: none;
        }
        .buy-button{
            text-align: right;
            margin-top: 10px;
        }
        .buy-button a{
            background: #444;
            padding: 5px;
            color: #fff;
        }
        #pagination{
            text-align: right;
            margin-top: 15px;
        }
        .room-item{
            border: 1px solid #ccc;
            padding: 5px 9px;
            color: #000;
        }
        .current-page{
            background: #000;
            color: #FFF;
        }
</style>
 
   <!-- /. NAV SIDE  -->
   <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           Room List
                        </h1>
                    </div>
                </div>

<?php

    include './db.php';
    if (!empty($_SESSION['current_user'])) {
            $item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 5;
            $current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
            $offset = ($current_page - 1) * $item_per_page;
            $totalRecords = mysqli_query($con, "SELECT * FROM `room_list`");
            $totalRecords = $totalRecords->num_rows;
            $totalPages = ceil($totalRecords / $item_per_page);
            $products = mysqli_query($con, "SELECT * FROM `room_list` ORDER BY `id` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
            mysqli_close($con);
 ?>
        
        <div class="main-content">
            <div class="product-items">
                <!-- <div class="buttons">
                    <a href="./product_editing.php">Add Room</a>
                </div> -->
                <ul id="room-container">
                <?php
                
                    while ($row = mysqli_fetch_array($products)) {
                        ?>
                        <div class="room-item" id="<?= $row['id'] ?>">
                            <div class="room-img"><img src="../<?= $row['image'] ?>" alt="<?= $row['name'] ?>" title="<?= $row['name'] ?>" /></div>
                            <strong><?= $row['name'] ?></strong><br/>
                            <p><?= $row['content'] ?></p>
                            <div class="status" >Phòng trống</div>
                            <button class="btn btn-success status-button">Status</button>
                            <button class="btn btn-success" style="background: #6d90d0"><a href="./detail_room.php" style="color:black">Detail</a></button>     
                        </div>
                    <?php } ?>
                    <div class="clear-both"></div>
                    <?php
                        include './pagination.php';
                    ?>
                <div class="clear-both"></div>
            </div>
        </div>
    <?php } ?>
 <!-- /. ROW  -->
            
 </div>
               
               </div>
           
                  
       </div>
                <!-- /. PAGE INNER  -->
               </div>
            <!-- /. PAGE WRAPPER  -->
        <!-- /. WRAPPER  -->
       <!-- JS Scripts-->
       <!-- jQuery Js -->
       <script src="assets/js/jquery-1.10.2.js"></script>
         <!-- Bootstrap Js -->
       <script src="assets/js/bootstrap.min.js"></script>
       <!-- Metis Menu Js -->
       <script src="assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
       <script src="assets/js/dataTables/jquery.dataTables.js"></script>
       <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
           <script>
               $(document).ready(function () {
                   $('#dataTables-example').dataTable();
               });
       </script>
            <!-- Custom Js -->
       <script src="assets/js/custom-scripts.js"></script>
       
      
   </body>
   </html>
   