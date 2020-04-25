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
                  <h4 class="page-title">CHOOSE DATE</h4>
                  <ol class="breadcrumb p-0 m-0">
                    
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- PAGE HEADER -->

              <!-- PAGE INFORMATION -->
              <div class="col-12">
                <div class="row">
                  <!-- Customer Info Section -->
                  <div class="col-12">
                    <div class="row">
                      <div class="col-md-6">
                        <input type="hidden" id="CounterToken" value = "<?php echo $CounterToken; ?>">
                        <div class="form-group">
                          <input type="date" id="ToDate" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <button class="btn btn-danger btn-block waves-effect waves-light" id="ViewHistory">VIEW HISTORY</button>
                      </div>
                    </div>
                  </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="m-t-0 header-title"><b><span id="Dates"></span></b></h4>
                    <p class="text-muted m-b-20">
                      Search Using The Search Box Below
                    </p>
                    <table class="table table-striped m-0" id="ShowProductListTable">
                      
                    </table>
                    <table class="table table-striped m-0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>#</th>
                          <th><button class="btn btn-lg btn-block btn-success" id="TotalBox"></button></th>
                        </tr>
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
      
      $(document).ready(function(){

        

        // ADD NEW PRODUCT ON BUTTON CLICK
        $("#AddNewProduct").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          AddNewProduct();
        });

        $("#ViewHistory").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var CounterToken = $('#CounterToken').val();
          var ToDate = $('#ToDate').val();
          var SpanHTML = "Warehouse Status: "+ ToDate;
          $('#Dates').html(SpanHTML);
          LoadWarehouseHistory(CounterToken, ToDate);
        });

      });

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

      /*function TotalStockValue(){
        var sum = 0;
        $('.StockValue').each(function()
        {
            sum += parseFloat(Number($(this).text()));
        });
        return sum;
      }

      var TotalStockValue = TotalStockValue();
      $('#TotalStockValueBox').text(TotalStockValue);*/

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();


      function LoadWarehouseHistory(CounterToken, ToDate){
        var PostData = {
          'CounterToken' : CounterToken,
          'ToDate' : ToDate,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadWarehouseHistory'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#ShowProductListTable').html(data);
            var Total = TotalInvoicePriceSum();
            $('#TotalBox').text(Total);
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