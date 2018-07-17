<?php
  include "../connection.php";
	$page = $_GET["page"];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/favicon.png">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/knockout-3.4.2.js"></script>
    <script src="../assets/js/knockout.mapping-latest.js"></script>
     
    <!-- Icons -->
    <script src="../assets/js/feather.min.js"></script>
    <script src="../assets/js/chart.min.js"></script>
    <style type="text/css">
      .form > .row{
        margin-bottom:3px;
      }
    </style>
  </head>

  <body>
  	<script type="text/javascript">
  		var model = {
  			page_title:"<?=$page?>",
        page_subtitle:ko.observable(""),
  		}
      model.get_parameter = function(table,data,exclude){
        var tmp = ko.mapping.toJS(data);
        var fields = [];
        var values = [];
        for(var i in tmp){
          if(exclude.indexOf(i)<0){
            fields.push(i);
            values.push("'"+tmp[i]+"'");
          }
        }
        var parm = {
          table:table,
          field:"("+fields.join(",")+")",
          value:"("+values+")"
        }
        return parm;
      }
  	</script>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Astra Honda Motor</a>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="#">Sign out</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid" id="content">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
             <!--  <li class="nav-item">
                <a data-bind="attr:{'class':page_title=='dashboard'?'nav-link active':'nav-link'}" href="get.php?page=dashboard">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only" data-bind="visible:page_title=='dashboard'">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bind="attr:{'class':page_title=='orders'?'nav-link active':'nav-link'}" href="get.php?page=orders">
                  <span data-feather="file"></span>
                  Orders <span class="sr-only" data-bind="visible:page_title=='orders'">(current)</span>
                </a>
              </li> -->
              <li class="nav-item">
                <a data-bind="attr:{'class':page_title=='products'?'nav-link active':'nav-link'}" href="get.php?page=products">
                  <span data-feather="shopping-cart"></span>
                  Products <span class="sr-only" data-bind="visible:page_title=='products'">(current)</span>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a data-bind="attr:{'class':page_title=='customers'?'nav-link active':'nav-link'}" href="get.php?page=customers">
                  <span data-feather="users"></span>
                  Customers <span class="sr-only" data-bind="visible:page_title=='customers'">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bind="attr:{'class':page_title=='reports'?'nav-link active':'nav-link'}" href="get.php?page=reports">
                  <span data-feather="bar-chart-2"></span>
                  Reports <span class="sr-only" data-bind="visible:page_title=='reports'">(current)</span>
                </a>
              </li>
               -->
            </ul>

          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <h1 class="h2 page-title">
              <span data-bind="text:page_title"></span>
              <span data-bind="visible:page_subtitle()!=='',text:'- '+page_subtitle()"></span>
            </h1>
         	<?php
         	switch ($page) {
         		case 'dashboard':
         			include ("dashboard.php");
         			break;
         		case 'orders':
         			include ("orders.php");
         			break;
         		case 'products':
         			include ("products.php");
         			break;
         		case 'customers':
         			include ("customers.php");
         			break;
         		case 'reports':
         			include ("reports.php");
         			break;
         		default:
         			break;
         	}
         	?>
        </main>
      </div>
    </div>
    <script type="text/javaScript">
      feather.replace()
    	var content = $("#content");
    	

      ko.applyBindings(model);
    </script>
  </body>
</html>
<?php

  $conn->close();

?>
