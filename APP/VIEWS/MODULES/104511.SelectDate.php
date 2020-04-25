<?php 
  $FromCounter = $_GET["CounterToken"];
  $FromCounterTitle = CounterTitle($FromCounter);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title><?php echo "$ModuleTitle"; ?></title>
    <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/common.meta.php'); ?>
  </head>
  <body>
    <!-- Begin page -->
    <div id="wrapper">
      <!-- Top Bar Start -->
      <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/business.top.bar.php'); ?>
      <!-- Top Bar End -->
      <!-- ========== Left Sidebar Start ========== -->
      <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/business.left.side.bar.php'); ?>
      <!-- Left Sidebar End -->
      <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/business.module.hidden.data.php'); ?>
      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
      <div class="content-page">
        <!-- Start content -->
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <!-- PAGE HEADER -->
              <div class="col-12">
                <div class="page-title-box">
                  <h4 class="page-title">Sales By Date | <?php echo $FromCounterTitle; ?></h4>
                  <ol class="breadcrumb p-0 m-0">
                    
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- PAGE HEADER -->

              <!-- PAGE INFORMATION -->
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="m-t-0 header-title"><b>List</b></h4>
                    <p class="text-muted m-b-20">
                      Search Using The Search Box Below
                    </p>
                    <table class="table table-striped m-0" id="ShowPMLTable">
                    	<thead class='bg-success text-white'>
                    		<tr>
                          <th>SL</th>
                    			<th>Date</th>
                    			<th>Show By Customer</th>
                    			<th>Show By Product</th>
                    		</tr>
                    		<?php
													// Set timezone
													date_default_timezone_set('UTC');

													// Start date
													$date = $_SESSION["StartDate"];
													// End date
													$end_date = $BDDATEDBFORMAT;
                          $SL = 1;
                          echo "<tbody>";
													while (strtotime($date) <= strtotime($end_date)) {
														$EndDate = BDDATE($end_date);
														echo "<tr>";
                              echo "<td>$SL</td>";
															echo "<td><a class='btn btn-danger waves-effect waves-light' href = ''>$EndDate</a></td>";
															echo "<td><a class='btn btn-info waves-effect waves-light' href = 'index.php?p=business&m=104512&CounterToken=B1SC2&Date=$end_date&Type=ShowByCustomer'>VIEW</a></td>";
															echo "<td><a class='btn btn-success waves-effect waves-light' href = 'index.php?p=business&m=104512&CounterToken=B1SC2&Date=$end_date&Type=ShowByProduct'>VIEW</a></td>";
														echo "</tr>";
												                //echo "$date\n";
												                $end_date = date ("Y-m-d", strtotime("-1 day", strtotime($end_date)));

                          $SL++;
													}
													echo "</tbody>";

												?>
                    	</thead>
                      
                    </table>
                  </div>
                </div>
              </div>
              <!-- PAGE INFORMATION -->
            </div>
            <!-- end row -->
            <div class="row">
              <div class="col-sm-12">
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- container-fluid -->
        </div>
        <!-- content -->
        <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/business.footer.php'); ?>
      </div>
      <!-- ============================================================== -->
      <!-- End Right content here -->
      <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <script>
      var resizefunc = [];
    </script>
    <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/common.scripts.php'); ?>
    <script>
      
    </script>
  </body>
</html>