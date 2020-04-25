<?php
  $SPT = $_GET["SPT"];
  $GetInfo = "SELECT * FROM warehousepurchasedproductlist_info WHERE SingleProductToken = '$SPT'";
  $RGetInfo = RunQuery($GetInfo);
  $RowGI = Fetch($RGetInfo);
  $ProductToken = $RowGI["ProductToken"];
  $ProductTitle = ProductTitle($ProductToken);
  $PurchasePrice = $RowGI["PurchasePrice"];
  $PMLToken = $RowGI["PMLToken"];
  $PMLType = $RowGI["PMLType"];
  $CounterToken = $RowGI["CounterToken"];
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
                  <h4 class="page-title">Warehouse Purchase</h4>
                  <ol class="breadcrumb p-0 m-0">
                    <!-- <div class="form-inline" action="">
                      <div class="form-group m-r-10">
                        <input type="hidden" id="PMLType" value='1'>
                        <input type="text" class="form-control" id="PMLTitle" placeholder="Purchase Lot Title" required>
                      </div>
                      <button type="submit" id="AddNewPML" class="btn btn-success waves-effect waves-light">Add New</button>
                    </div> -->
                    <!-- <a href="" id="AddProductInitiator" class="btn btn-success btn-block waves-effect waves-light">Add A New Product</a> -->
                    <!-- <li>
                      <a href="#">Codefox</a>
                    </li>
                    <li>
                      <a href="#">Pages</a>
                    </li>
                    <li class="active">
                      Starter Page
                    </li> -->
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- PAGE HEADER -->

              <!-- PAGE INFORMATION -->
              <div class="col-12">
                <div class="row">
                  <div class="col-8">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="m-t-0 header-title"><b><?php echo $ProductTitle; ?> </b></h4>
                          <p class="text-muted m-b-20">
                            Insert Product
                          </p>
                          <input type="hidden" id="PMLToken" value="<?php echo "$PMLToken";  ?>">
                          <input type="hidden" id="ProductToken" value="<?php echo "$ProductToken";  ?>">
                          <input type="hidden" id="SingleProductToken" value="<?php echo "$SPT";  ?>">
                          <input type="hidden" id="PMLType" value="<?php echo "$PMLType";  ?>">
                          <input type="hidden" id="FromCounter" value="<?php echo "$CounterToken";  ?>">
                          <div class="form-group">
                            <label>Barcode</label>
                            <input type="text" class="form-control" id="BarcodeSerial">
                          </div>

                          
                            <input type="hidden" class="form-control" id="PurchasePrice" value='<?php echo $PurchasePrice; ?>'>
                          
                          <div class="form-group">
                            <button type="submit" id="AddNewBarcode" class="btn btn-success waves-effect waves-light btn-block">Add New</button>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="m-t-0 header-title"><b>All Products</b></h4>
                          <p class="text-muted m-b-20">
                            Search Using The Search Box Below
                          </p>
                          <table class="table table-striped m-0" id="ShowPMLTable">
                            
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="m-t-0 header-title"><b>All Individuals</b></h4>
                        <p class="text-muted m-b-20">
                          Search Using The Search Box Below
                        </p>

                        <table class="table table-striped m-0" id="ShowIndividuals">
                          
                        </table>
                      </div>
                    </div>
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
      var ROOTURL = "http://localhost/BBFinal";
      var APIURL = "http://localhost/BBFinal/index.php?p=WebAPI";
    </script>
    <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/common.scripts.php'); ?>
    <script>
      
      $(document).ready(function(){

        $('.js-example-basic-single').select2();

        LoadAllBarcodes();

        // ADD NEW PRODUCT ON BUTTON CLICK
        $("#AddNewBarcode").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          AddNewBarcode();
        });

      });

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();


      function LoadAllBarcodes(){
        var SingleProductToken = $("#SingleProductToken").val();
        var PostData = {
          'SingleProductToken' : SingleProductToken,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : '11696/03498389'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#ShowPMLTable').html(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }


      function AddNewBarcode(){
        var PMLToken = $("#PMLToken").val();
        var PMLType = $("#PMLType").val();
        var SingleProductToken = $("#SingleProductToken").val();
        var CounterToken = $("#FromCounter").val();
        var ProductToken = $("#ProductToken").val();
        var BarcodeSerial = $("#BarcodeSerial").val();
        var PurchasePrice = $("#PurchasePrice").val();
        var PostData = {
          'CounterToken' : CounterToken,
          'PMLToken' : PMLToken,
          'PMLType' : PMLType,
          'SingleProductToken' : SingleProductToken,
          'ProductToken' : ProductToken,
          'BarcodeSerial' : BarcodeSerial,
          'PurchasePrice' : PurchasePrice,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'AddNewBarcode'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            //$('#Msg').html(data);
            $("#BarcodeSerial").val('');
            //$("#PurchasePrice").val('0');
            
            LoadAllBarcodes();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      $(document).scannerDetection({
        timeBeforeScanTest: 200, // wait for the next character for upto 200ms
        startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
        endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
        avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
        onComplete: function(barcode, qty){
          
            $("#BarcodeSerial").val(barcode);
            //$("#PurchasePrice").val('0'); 

                //$("#BCBox").append('');
         } // main callback function    
      });

    </script>
  </body>
</html>