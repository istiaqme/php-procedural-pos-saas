<?php 
  $ProductToken = $_GET["PT"];
  $ProductTitle = ProductTitle($ProductToken);
  $FromCounter = $_GET["CounterToken"];
  $FromCounterTitle = CounterTitle($FromCounter);
  $ShowDate = $_GET["Date"];
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
                  <h4 class="page-title">Sales By Date | <?php echo $FromCounterTitle; ?> | In Invoice | <?php echo $ProductTitle; ?> | <?php echo BDDATE($ShowDate); ?></h4>
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
                    <table class="table table-striped m-0" id="ShowPMLTable">
                    	<thead class='bg-success text-white'>
                    		<tr>
                          <th>SL</th>
                    			<th>Invoice Number</th>
                          <th>Customer Name</th>
                          <th>Phone Number</th>
                          <th>Price</th>
                    			<th>VIEW</th>
                    		</tr>
                    		<?php
                          echo "<tbody>";
													# GET PML OF THE DATE
                          $Q = "SELECT  PMLToken, Price FROM productmovementinsertion_details  WHERE BusinessToken = '$BusinessToken' AND FromCounter = '$FromCounter' AND PMLType = '3' AND ProductToken = '$ProductToken' AND WorkFlowStatus = '3' AND DATE(BDDT) = '$ShowDate' AND Existence = '1'";
                          $RQ = RunQuery($Q);
                          $SL = 1;
                          while($RowQ = Fetch($RQ)){
                            
                            $PMLToken = $RowQ["PMLToken"];
                            $CustomerPhoneNumber = CustomerPhoneNumberByPMLToken($PMLToken);
                            $PMLTitle = PMLTitle($PMLToken);
                            $InvoiceNumber = InvoiceNumberByPMLToken($PMLToken);
                            $Price = $RowQ["Price"];
                            $ProductTitle = ProductTitle($ProductToken);
                              echo "<tr>";
                              echo "<td scope = 'row'>$SL</td>";
                              echo "<td>$InvoiceNumber</td>";
                              echo "<td>$PMLTitle</td>";
                              echo "<td>$CustomerPhoneNumber</td>";
                              echo "<td><a class='btn btn-danger waves-effect waves-light'>$Price</a></td>";
                              echo "<td><a class='btn btn-success waves-effect waves-light' href='index.php?p=business&m=10400&PMLToken=$PMLToken'>VIEW</a></td>";
                              echo "</tr>";
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
        $('.SingleProductIndividuals').each(function()
        {
            sum += parseFloat($(this).text());
        });
        return sum;
      }

      function TotalInvoicePriceSum2(){
        var sum = 0;
        $('.SingleProductTotalPrice').each(function()
        {
            sum += parseFloat($(this).text());
        });
        return sum;
      }


      $(document).ready(function(){
        var Total = TotalInvoicePriceSum();
        $('#TotalIndividualBox').text(Total);
        var TotalPrice = TotalInvoicePriceSum2();
        $('#TotalSingleProductPriceBox').text(TotalPrice);

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