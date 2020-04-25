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
                  <h4 class="page-title"><?php $ProductToken = $_GET["PT"]; echo ProductTitle($ProductToken); ?></h4>
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
                    <h4 class="m-t-0 header-title"><b>All Barcodes</b></h4>
                    <p class="text-muted m-b-20">
                      Search Using The Search Box Below
                    </p>
                    <table class="table table-striped m-0" id="ShowProductListTable">
              						<thead class='bg-success text-white'>
              							<tr>
              								<th>#</th>
              								<th>Date</th>
              								<th>Barcode</th>
              								<th>Price</th>
              						  </tr>
              						</thead>
              						<tbody>
    						          <?php
              						$ProductToken = $_GET["PT"];
              						if(isset($_GET["CT"])){
              						    $CounterToken = $_GET["CT"];
              						}
              						else{
              						    $CounterToken = $Warehouse;
              						}
              						
              						$Q1 = "SELECT BarcodeSerial, Price, BDDT FROM productmovementinsertion_details WHERE ToCounter = '$CounterToken' AND ProductToken = '$ProductToken' AND WorkFlowStatus = '3' AND Existence = '1' ORDER BY BDDT";
                              		$RQ1 = RunQuery($Q1);
                              		$NRQ1 = NumRows($RQ1);
                              		$SL = 0;
                              	    while($RowQ1 = Fetch($RQ1)){
                              				$BarcodeSerial = $RowQ1["BarcodeSerial"];
                              				$InPrice = $RowQ1["Price"];
                              				$DBBDDT = $RowQ1["BDDT"];
                              				$DBBDDATE = BDDATE($DBBDDT);
                              				# GET IF THIS PRODUCT IS OUT OR NOT
                              				$Q2 = "SELECT PMIID FROM productmovementinsertion_details WHERE FromCounter = '$CounterToken' AND BarcodeSerial = '$BarcodeSerial' AND WorkFlowStatus = '3' AND Existence = '1'";
                              				$RQ2 = RunQuery($Q2);
                              				$NRQ2 = mysqli_num_rows($RQ2);
                                        
                              				if ($NRQ2 == 0) {
                              				    echo "<tr>";
                                                  echo "<td>$SL</td>";
                                                  echo "<td>$DBBDDATE</td>";
                                                  echo "<td><a href= 'index.php?p=business&m=10422&BS=$BarcodeSerial' class='btn btn-info waves-effect waves-light'>$BarcodeSerial</a></td>";
                                                  echo "<td>$InPrice</td>";
                                                echo "</tr>";
                              				}
                              		    $SL++;
                              		}
              						echo "</tbody>";
                        ?> 
                      <tfoot>
                    </tfoot>
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
      
      $(document).ready(function(){

      function TotalInvoicePriceSum(){
        var sum = 0;
        $('.InvoiceItemPrice').each(function()
        {
            sum += parseFloat($(this).text());
        });
        return sum;
      }

      var Total = TotalInvoicePriceSum();
      $('#TotalBox').text(Total);

      
    </script>
  </body>
</html>