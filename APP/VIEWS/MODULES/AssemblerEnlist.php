<?php 
  $ALID = $_GET["id"];
  $AssemblerTitle = AssemblerTitle($ALID);
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
                  <h4 class="page-title">Enlist In Assembler</h4>
                  <ol class="breadcrumb p-0 m-0">
                    
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
                          <h4 class="m-t-0 header-title"><b><?php echo $AssemblerTitle; ?></b></h4>
                          <p class="text-muted m-b-20">
                            Insert Product
                          </p>
                          <?php 
                              echo "<div class='form-group'>";
                              echo "<button type='submit' id='AddNewColumn' class='btn btn-success waves-effect waves-light btn-block'>Add New</button>";
                              echo "</div>";
                            ?>
 
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="m-t-0 header-title"><b>All Columns</b></h4>
                          <p class="text-muted m-b-20">
                            Search Using The Search Box Below
                          </p>
                          <div class="form-group">
                            <input type="text" id="SingleProductSearch" class="form-control">
                          </div>
                          <div class="SingleProductsScrollBox">
                            <table class="table table-striped m-0" id="ShowPMLTable">
                            
                          </table>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="m-t-0 header-title"><b>Barcodes:&nbsp;</b><span id="LoaderExpanderProductTitle"></span></h4>
                            <div class="form-group">
                                <input type="text" id="WriteBarcode" class="form-control" placeholder = 'Write Barcode Here'>
                            </div>
                            <div class="form-group">
                                <button class='btn btn-block btn-danger' id='WriteBarcodeButton'>SEND</button>
                            </div>
                            <p class="text-muted m-b-20">
                              Search Using The Search Box Below
                            </p>
                            <div class="form-group">
                                <input type="text" id="BarcodeSearch" class="form-control">
                            </div>
                            <input type="hidden" id="ARID" value="">
                            <table class="table table-striped m-0" id="LoaderExpanderTable">
                              
                            </table>
                          </div>
                        </div>
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
    </script>
    <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/common.scripts.php'); ?>
    <script>
      
      $(document).ready(function(){

        

        LoadProductSelector();



        LoadAllProductsInLoaderWarehousePurchase();

        PMLLocker();



        // SEARCH SINGLE PRODUCT TABLE
        $("#SingleProductSearch").on("keyup", function() {
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

        // SEARCH BARCODES IN EXPANDER
        $("#BarcodeSearch").on("keyup", function() {
            var value = $(this).val().toUpperCase();

            $("#LoaderExpanderTable tr").each(function(index) {
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

        // WRITE BARCODE
        $("#WriteBarcodeButton").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var WriteBarcode = $("#WriteBarcode").val();
          if (WriteBarcode != '') {
              var BarcodeSerial = WriteBarcode;
           WarehousePurchaseSendBarcodeData(BarcodeSerial);
           $("#WriteBarcode").val('');
          }
        });

        // ADD NEW PRODUCT ON BUTTON CLICK
        $("#AddNewInProductLoader").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var PurchasePrice = $("#PurchasePrice").val();
          if (PurchasePrice != '') {
            AddNewInProductLoaderWarehousePurchase();
          }
        });

        // LOCKER BUTTON
        $("#LockerButton").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var PMLToken = $("#PMLToken").val();
          LockPML(PMLToken);
        });

        // LoaderExpnader ON BUTTON CLICK
        $(document).on('click', "button.LoaderExpander", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var SingleProductToken = $(this).attr("id"); 
            $("#SingleProductToken").val(SingleProductToken);
            ProductTitleInLoaderExpander(SingleProductToken);
            LoadAllProductsInLoaderExpander();    
        });

        // LoaderDeleter ON BUTTON CLICK
        $(document).on('click', "button.LoaderExpanderDeleter", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var DeleteID = $(this).attr("id"); 
            DeleteBarcodeInLoaderExpander(DeleteID);
        });

      });


      function PMLLocker(){
        var WorkFlowStatus = $('#WorkFlowStatus').val();
        if (WorkFlowStatus == 1) {
          $('#PMLLocker').show();
        }
        else{
          $('#LockerButton').attr('id', 'NothingWillWork');
          $('#PMLLocker').hide();
        }
      }

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();

      // Load Product Selector
      function LoadProductSelector(){
        var PMLType = $("#PMLType").val();
        var WorkFlowStatus = $("#WorkFlowStatus").val();
        var PostData = {
          'WorkFlowStatus' : WorkFlowStatus,
          'PMLType' : PMLType,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadProductSelector'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#ProductSelector').html(data);
            $('.js-example-basic-single').select2();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // All Products Loading In Warehouse Purchase
      function LoadAllProductsInLoaderWarehousePurchase(){
        var PMLToken = $("#PMLToken").val();
        var PMLType = $("#PMLType").val();
        var FromCounter = $("#FromCounter").val();
        var ToCounter = $("#ToCounter").val();
        var WorkFlowStatus = $("#WorkFlowStatus").val();
        var PostData = {
          'WorkFlowStatus' : WorkFlowStatus,
          'FromCounter' : FromCounter,
          'ToCounter' : ToCounter,
          'PMLToken' : PMLToken,
          'PMLType' : PMLType,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadAllProductsInLoaderWarehousePurchase'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#ShowPMLTable').html(data);
            console.log(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // Show Title in Loader Expander
      function LockPML(PMLToken){
        var PostData = {
          'PMLToken' : PMLToken,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LockPML'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#WorkFlowStatus').val('3');
            PMLLocker();
            LoadProductSelector();
            LoadAllProductsInLoaderExpander();
            $("#LoaderExpanderProductTitle").text(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // Show Title in Loader Expander
      function ProductTitleInLoaderExpander(SingleProductToken){
        var PostData = {
          'SingleProductToken' : SingleProductToken,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'ProductTitleInLoaderExpander'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $("#LoaderExpanderProductTitle").text(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // Load All Barcodes In Loader Expander
      function LoadAllProductsInLoaderExpander(){
        var SingleProductToken = $("#SingleProductToken").val();
        var PMLType = $("#PMLType").val();
        var WorkFlowStatus = $("#WorkFlowStatus").val();
        var PostData = {
          'SingleProductToken' : SingleProductToken,
          'PMLType' : PMLType,
          'WorkFlowStatus' : WorkFlowStatus,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadAllProductsInLoaderExpander'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $("#LoaderExpanderTable").html(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // Add New Product In Product Loader
      function AddNewInProductLoaderWarehousePurchase(){
        var PMLToken = $("#PMLToken").val();
        var PMLType = $("#PMLType").val();
        var FromCounter = $("#FromCounter").val();
        var ToCounter = $("#ToCounter").val();
        var ProductToken = $("#ProductToken").val();
        var PurchasePrice = $("#PurchasePrice").val();
        var WorkFlowStatus = $("#WorkFlowStatus").val();
        var PostData = {
          'FromCounter' : FromCounter,
          'ToCounter' : ToCounter,
          'WorkFlowStatus' : WorkFlowStatus,
          'PMLToken' : PMLToken,
          'PMLType' : PMLType,
          'ProductToken' : ProductToken,
          'PurchasePrice' : PurchasePrice,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'AddNewInProductLoaderWarehousePurchase'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            //$('#Msg').html(data);
            $("#PurchasePrice").val('');
            LoadAllProductsInLoaderWarehousePurchase();
            console.log(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // To Add Individual Barcodes
      function WarehousePurchaseSendBarcodeData(BarcodeSerial){
        var SingleProductToken =  $("#SingleProductToken").val();
        var FromCounter =  $("#FromCounter").val();
        var ToCounter =  $("#ToCounter").val();
        var PMLType = $("#PMLType").val();
        var PostData = {
          'SingleProductToken' : SingleProductToken,
          'PMLType' : PMLType,
          'BarcodeSerial' : BarcodeSerial,
          'FromCounter' : FromCounter,
          'ToCounter' : ToCounter,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'WarehousePurchaseSendBarcodeData'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            LoadAllProductsInLoaderExpander();
            console.log(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      function DeleteBarcodeInLoaderExpander(DeleteID){
        var PostData = {
          'DeleteID' : DeleteID,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'DeleteBarcodeInLoaderExpander'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            LoadAllProductsInLoaderExpander();
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
            if (barcode != '') {
              WarehousePurchaseSendBarcodeData(barcode);
            }
            
         } // main callback function    
      });


    </script>
  </body>
</html>