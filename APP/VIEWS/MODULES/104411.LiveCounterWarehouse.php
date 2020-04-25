<?php 
  $CounterToken = $_GET["CounterToken"];
  $CounterTitle = CounterTitle($CounterToken);
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
                  <h4 class="page-title"><?php echo $CounterTitle; ?></h4>
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
                    <h4 class="m-t-0 header-title"><b>All Products</b></h4>
                    <p class="text-muted m-b-20">
                      Search Using The Search Box Below
                    </p>
                    <table class="table table-striped m-0" id="ShowProductListTable">
                        <?php 
                            $Q = "SELECT * FROM productgroup_info WHERE BusinessToken = '$BusinessToken' AND Existence = '1' ORDER BY ProductTitle";
    						$RQ = RunQuery($Q);
    						$SL = 1;
    						echo "<thead class='bg-success text-white'>";
    							echo "<tr>";
    								echo "<th>#</th>";
    								echo "<th>Product</th>";
                    echo "<th>Units</th>";
    								if ($SubRank == '1031') {
                      echo "<th>Stock Value</th>";
                    }
    							echo "</tr>";
    						echo "</thead>";
    						echo "<tbody>";
    						while ($Row = Fetch($RQ)) {
    							$ProductToken = $Row["ProductToken"];
    							$ProductTitle = $Row["ProductTitle"];
    							$UserToken = $Row["UserToken"];
    							$CounterToken = $CounterToken;
                  if ($SubRank == '1031') {
                      $TotalStockValue = CounterProductValue($CounterToken, $ProductToken);
                  }
    							$TotalProductsInWarehouse = TotalProductsInCounter($CounterToken, $ProductToken);
    							echo "<tr>";
    								echo "<th scope='row'>$SL</th>";
    								echo "<td><a href = 'index.php?p=business&m=10424&CounterToken=$CounterToken&ProductToken=$ProductToken' class='btn btn-info waves-effect waves-light btn-block btn-lg'>$ProductTitle</a></td>";
    								echo "<td><button class='InvoiceItemPrice btn btn-success waves-effect waves-light btn-block btn-lg'>$TotalProductsInWarehouse</button></td>";
                    if ($SubRank == '1031') {
                      echo "<td><a href='index.php?p=business&m=10425&PT=$ProductToken&CT=$CounterToken' class='StockValue btn btn-danger waves-effect waves-light btn-block btn-lg'>$TotalStockValue</a></td>";
                    }
    							echo "</tr>";
    							$SL++;
    						}
    						echo "<tbody>"
                        ?> 
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>#</th>
                        <th><button class="btn btn-lg btn-block btn-success" id="TotalBox"></button></th>
                        <?php if ($SubRank == '1031') : ?>
                        <th><button class="btn btn-lg btn-block btn-danger" id="TotalStockValueBox"></button></th>
                        <?php endif; ?>
                      </tr>
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


      var Total = TotalInvoicePriceSum();
      $('#TotalBox').text(Total);

      function TotalStockValue(){
        var sum = 0;
        $('.StockValue').each(function()
        {
            sum += parseFloat(Number($(this).text()));
        });
        return sum;
      }

      var TotalStockValue = TotalStockValue();
      $('#TotalStockValueBox').text(TotalStockValue);

        // ADD NEW PRODUCT ON BUTTON CLICK
        $("#AddNewProduct").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          AddNewProduct();
        });

      });

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();


      function LoadAllProducts(){
        var PostData = {
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'ShowProductList'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#ShowProductListTable').html(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }
    </script>
  </body>
</html>