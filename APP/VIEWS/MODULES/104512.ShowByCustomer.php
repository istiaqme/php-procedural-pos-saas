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
                  <h4 class="page-title">Sales By Date | <?php echo $CounterTitle; ?> | <?php echo BDDATE($ShowDate); ?></h4>
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
                    <div class="form-group">
                      <input type="text" id="SearchInTable" class="form-control">
                    </div>
                    <table class="table table-striped m-0" id="ShowPMLTable">
                    	<thead class='bg-success text-white'>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><button class='btn btn-danger waves-effect waves-light' id="TotalBox"></button></td>
                        </tr>
                    		<tr>
                          <th>SL</th>
                    			<th>Invoice</th>
                    			<th>Customer Name</th>
                          <th>Customer Phone</th>
                          <th>Customer Address</th>
                    			<th>Total Units</th>
                    		</tr>
                    		<?php
                          echo "<tbody>";
													# GET PML OF THE DATE
                          $Q = "SELECT PMLToken, PMLTitle, BDDT FROM productmovementlist_log WHERE BusinessToken = '$BusinessToken' AND FromCounter = '$CounterToken' AND PMLType = '3' AND DATE(BDDT) = '$ShowDate' AND Existence = '1'";
                          $RQ = RunQuery($Q);
                          $SL = 1;
                          while($RowQ = Fetch($RQ)){
                            $PMLTitle = $RowQ["PMLTitle"];
                            $PMLToken = $RowQ["PMLToken"];
                            $DBBDDT = $RowQ["BDDT"];
                            $BDDATETOWORK = BDDATETOWORK($DBBDDT);
                            //echo "$BDDATETOWORK <br>";
                              # GET INVOICE INFO
                              $Q2 = "SELECT * FROM salescustomerlist_info WHERE PMLToken = '$PMLToken'";
                              $RQ2 = RunQuery($Q2);
                              while ($RowQ2 = Fetch($RQ2)) {
                                $InvoiceNumber = $RowQ2["InvoiceNumber"];
                                $CustomerPhone = $RowQ2["CustomerPhone"];
                                $CustomerAddress = $RowQ2["CustomerAddress"];
                                $UserToken = $RowQ2["UserToken"];
                                //$UserTitle = UserTitle($UserToken);
                                $TotalUnits = TotalIndividualsInPML($PMLToken);
                                echo "<tr>";
                                  echo "<td scope='row'>$SL</td>";
                                  echo "<td><a class='btn btn-info waves-effect waves-light' href = 'index.php?p=business&m=10400&PMLToken=$PMLToken'>#$InvoiceNumber</a></td>";
                                  echo "<td>$PMLTitle</td>";
                                  echo "<td>$CustomerPhone</td>";
                                  echo "<td>$CustomerAddress</td>";
                                  echo "<td><a class='IndividualTotalUnits btn btn-danger waves-effect waves-light' href = ''>$TotalUnits</a></td>";
                                echo "</tr>";
                              }
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

      function TotalInvoicePriceSum(){
        var sum = 0;
        $('.IndividualTotalUnits').each(function()
        {
            sum += parseFloat($(this).text());
        });
        return sum;
      }

      $(document).ready(function(){
        var Total = TotalInvoicePriceSum();
        console.log(Total);
        $('#TotalBox').text(Total);
        $("#SearchInTable").on("keyup", function() {
            var value = $(this).val().toUpperCase();

            $("#ShowPMLTable tr").each(function(index) {
                if (index !== 0) {

                    $row = $(this);

                    var id = $row.text().toUpperCase();

                    if (id.indexOf(value) !== -1) {
                        $row.show();    
                    }
                    else {
                        $row.hide();    
                    }
                }
            });
        });
      });
      
    </script>
  </body>
</html>