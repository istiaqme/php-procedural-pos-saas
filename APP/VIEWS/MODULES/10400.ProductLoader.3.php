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
                  <h4 class="page-title">SALES INVOICE</h4>
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
                      <div class="col-md-3">
                        <input type="hidden" id="PMLToken" value="<?php echo "$PMLToken";  ?>">
                        <input type="hidden" id="PMLType" value="<?php echo "$PMLType";  ?>">
                        <input type="hidden" id="FromCounter" value="<?php echo "$FromCounter";  ?>">
                        <input type="hidden" id="ToCounter" value="<?php echo "$ToCounter";  ?>">
                        <?php 
                          $CIQ = mysqli_query($DBCON, "SELECT * FROM salescustomerlist_info WHERE PMLToken = '$PMLToken'");
                          $RowCTQ = mysqli_fetch_assoc($CIQ);
                          $CustomerName = $RowCTQ["CustomerName"];
                          $CustomerPhone = $RowCTQ["CustomerPhone"];
                          $CustomerAddress = $RowCTQ["CustomerAddress"];
                        ?>
                        <div class="form-group">
                          <input type="text" id="CustomerName" class="form-control" required placeholder="Name" value="<?php echo $CustomerName; ?>">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <input type="text" id="CustomerPhone" class="form-control" required placeholder="Phone Number" value="<?php echo $CustomerPhone; ?>">
                      </div>
                      <div class="col-md-6">
                        <input type="text" id="CustomerAddress" class="form-control" required placeholder="Address" value="<?php echo $CustomerAddress; ?>">
                      </div>
                    </div>
                  </div>
                  <!-- Customer Info Section -->

                  <!-- Invoice Information Section -->
                  <div class="col-12">
                    <div class="row">
                      <div class="col-md-7">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="m-t-0 header-title"><b>Insert Product</b></h4>
                            <div id="Alert" style="display: none">
                              
                            </div>
                            <div class="row">
                              <div class="col-6">
                              <div class="form-group">
                                <input type="text" class="form-control" id="BarcodeSerial" placeholder="Barcode">
                              </div>
                            </div>
                            <div class="col-3">
                              <div class="form-group">
                                <input type="text" class="form-control" id="Price" placeholder="Sale Price">
                              </div>
                            </div>
                            <div class="col-3">
                              <button class="btn btn-danger btn-block waves-effect waves-light" id="InvoiceEnlist">Enlist</button>
                            </div>
                            </div>
                            <h4 class="m-t-0 header-title"><b>Products In List</b></h4>
                            <!-- <p class="text-muted m-b-20">
                              Search Using The Search Box Below
                            </p> -->
                            <table class="table table-striped m-0" id="InvoiceListTable">
                              
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="m-t-0 header-title"><b>#<?php echo InvoiceNumberByPMLToken($PMLToken); ?></b></h4>
                            <hr>
                            <div class="col-12">
                              <div class="card widget-box-two widget-two-danger">
                                <div class="card-body">
                                  <i class="dripicons-box widget-two-icon"></i>
                                  <div class="wigdet-two-content">
                                    <p class="m-0 text-white text-uppercase font-600 text-overflow" title="Total Amount">TOTAL</p>
                                    <h2 class="text-white" id="TotalBox"><span>0</span> <small></i></small></h2>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <hr>
                            <h4 class="m-t-0 header-title"><b>Detailed Payment</b></h4>
                            <br>
                            <div class="col-12">
                              <?php 
                                $QTT = "SELECT TransactionToken FROM transactionlist_log WHERE Reference = '$PMLToken'";
                                $RQTT = RunQuery($QTT);
                                $RowQTT = Fetch($RQTT);
                                $TransactionToken = $RowQTT["TransactionToken"];
                              ?>
                              <input type="hidden" id="TransactionToken" value="<?php echo $TransactionToken; ?>">
                              <div class="form-group">
                                <label>Payment Method</label>
                                <select class='form-control js-example-basic-single' id='TMLToken' required>
                                  <?php 
                                    $QP1 = "SELECT TGBTitle, TGBToken FROM transactiongroupbook_info WHERE BusinessToken = '$BusinessToken'";
                                    $RQP1 = RunQuery($QP1);
                                    while ($RowQP1 = Fetch($RQP1)) {
                                     $TGBTitle = $RowQP1["TGBTitle"];
                                     $TGBToken = $RowQP1["TGBToken"];
                                     echo "<optgroup label='$TGBTitle'>";
                                     $QP2 = "SELECT TMLToken, TMLTitle FROM transactionmethodlist_info WHERE TGBToken = '$TGBToken'";
                                     $RQP2 = RunQuery($QP2);
                                     while ($RowQP2 = Fetch($RQP2)) {
                                       $TMLTitle = $RowQP2["TMLTitle"];
                                       $TMLToken = $RowQP2["TMLToken"];
                                       echo "<option value='$TMLToken'>$TMLTitle</option>";
                                     }
                                     echo "</optgroup>";
                                    }

                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Amount In BDT</label>
                                <input type="text" id="Amount" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <label>Note</label>
                                <input type="text" id="Note" class="form-control" required>
                              </div>
                              <div class="form-group">
                                <button type="submit" id = 'AddPayment' class="btn btn-info btn-block waves-effect waves-light btn-lg">Add Payment</button>
                              </div>
                              
                            </div>
                            <hr>
                            <h4 class="m-t-0 header-title"><b>Paid By Customer</b></h4>
                            <br>
                            <div class="col-12">
                              <table class="table table-striped m-0" id="PaymentListTable">
                              
                              </table>
                              
                            </div>
                            <hr>
                            <h4 class="m-t-0 header-title"><b>Cash Register</b></h4>
                            <br>
                            <div class="col-12">
                              <div class="form-group">
                                <label>Total Paid</label>
                                <input type="text" id="PaidByCustomer" class="form-control" id="PayableByCustomer" required value="" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Invoice Information Section -->
                  
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

        $('.js-example-basic-single').select2();

        LoadProductsInInvoice();
        LoadPaymentInfo();
        TotalInvoicePaidSum();

        //LoadAllProductsInLoaderWarehousePurchase();

        // ADD NEW PRODUCT ON BUTTON CLICK
        $("#SaveCoustomerInfo").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var CustomerName = $("#CustomerName").val();
          var CustomerPhone = $("#CustomerPhone").val();
          var CustomerAddress = $("#CustomerAddress").val();
          if (CustomerName != '' && CustomerPhone != '' && CustomerAddress != '') {
            UpdateCustomerInfo();
          }
        });

        // ADD PAYMENT
        $("#AddPayment").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var TMLToken = $("#TMLToken").val();
          var Amount = $("#Amount").val();
          var Note = $("#Note").val();
          if (TMLToken != '' && Amount != '' && Note != '') {
            AddPayment();
          }
        });

        $("#LockInvoiceBtn").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var CustomerPayable = $("#CustomerPayable").val();
          var PaidByCustomer = $("#PaidByCustomer").val();
          var RestAmount = $("#RestAmount").val();
          if (CustomerPayable != '' && PaidByCustomer != '' && RestAmount != '') {
            LockInvoice();
          }
        });

        $("#InvoiceEnlist").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var BarcodeSerial = $("#BarcodeSerial").val();
          var Price = $("#Price").val();
          if (BarcodeSerial != '' && Price != '') {
            WarehousePurchaseSendBarcodeData(BarcodeSerial);
            $("#BarcodeSerial").val('');
            $("#Price").val('');
          }
        });

        // LoaderExpnader ON BUTTON CLICK
        $(document).on('click', "button.LoaderExpander", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var SingleProductToken = $(this).attr("id"); 
            $("#SingleProductToken").val(SingleProductToken);
            //ProductTitleInLoaderExpander(SingleProductToken);
            //LoadAllProductsInLoaderExpander();    
        });

        // LoaderDeleter ON BUTTON CLICK
        $(document).on('click', "button.InvoiceItemDeleter", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var DeleteID = $(this).attr("id"); 
            DeleteBarcodeInLoaderExpander(DeleteID);
        });

        // LoaderDeleter ON BUTTON CLICK
        $(document).on('click', "button.DeletePayment", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var DeleteID = $(this).attr("id"); 
            DeletePayment(DeleteID);
        });

      });

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();
      var PMLToken = $("#PMLToken").val();
      var PMLType = $("#PMLType").val();
      var FromCounter = $("#FromCounter").val();
      var ToCounter = $("#ToCounter").val();

      function AddPayment(){
        var Reference = $("#PMLToken").val();
        var TransactionToken = $("#TransactionToken").val();
        var ReferenceType = '1';
        var TransactionType = '1';
        var CounterToken = $("#FromCounter").val();
        var TMLToken = $("#TMLToken").val();
        var Amount = $("#Amount").val();
        var Note = $("#Note").val();
        var PostData = {
          'TransactionToken' : TransactionToken,
          'Reference' : Reference,
          'ReferenceType' : ReferenceType,
          'CounterToken' : CounterToken,
          'TransactionType' : TransactionType,
          'TMLToken' : TMLToken,
          'Amount' : Amount,
          'Note' : Note,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'AddPayment'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $("#Amount").val('');
            $("#Note").val('');
            LoadPaymentInfo();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      function LoadPaymentInfo(){
        var TransactionToken = $("#TransactionToken").val();
        var PostData = {
          'TransactionToken' : TransactionToken,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadPaymentInfo'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#PaymentListTable').html(data);
            
            var PaidByCustomer = TotalInvoicePaidSum();
            $('#PaidByCustomer').val(PaidByCustomer);
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
            LoadProductsInInvoice();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      function DeletePayment(DeleteID){
        var PostData = {
          'DeleteID' : DeleteID,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'DeletePayment'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            LoadPaymentInfo();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

        $("#PaidByCustomer").keyup(function(){
          var Val1 = $('#CustomerPayable').val();
          var Val2 = $('#PaidByCustomer').val();
          var RestAmount = Number(Val1) - Number(Val2);
          $('#RestAmount').val(RestAmount);
        });
      

      function TotalInvoicePriceSum(){
        var sum = 0;
        $('.InvoiceItemPrice').each(function()
        {
            sum += parseFloat($(this).text());
        });
        return sum;
      }
      function TotalInvoicePaidSum(){
        var sum = 0;
        $('.PaymentSingleAmount').each(function()
        {
            sum += parseFloat($(this).text());
        });
        return sum;
      }

      // Lock Invoice
      function LockInvoice(){
        var CustomerPayable = $("#CustomerPayable").val();
        var PaidByCustomer = $("#PaidByCustomer").val();
        var RestAmount = $("#RestAmount").val();
        var PostData = {
          'CustomerPayable' : CustomerPayable,
          'PaidByCustomer' : PaidByCustomer,
          'RestAmount' : RestAmount,
          'FromCounter' : FromCounter,
          'ToCounter' : ToCounter,
          'PMLToken' : PMLToken,
          'PMLType' : PMLType,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LockInvoice'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#LockInvoiceBtn').removeClass('btn-danger').addClass('btn-default');
            $('#LockInvoiceBtn').text('Invoice Locked');
            
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // Load All Barcodes In Loader Expander
      function LoadProductsInInvoice(){
        var PostData = {
          'PMLToken' : PMLToken,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadProductsInInvoice'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $("#InvoiceListTable").html(data);
            var TotalPrice = TotalInvoicePriceSum();
            console.log(TotalPrice);
            $("#TotalBox").text(TotalPrice);
            $("#CustomerPayable").val(TotalPrice);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }


      function UpdateCustomerInfo(){
        var CustomerName = $("#CustomerName").val();
        var CustomerPhone = $("#CustomerPhone").val();
        var CustomerAddress = $("#CustomerAddress").val();
        var PostData = {
          'CustomerName' : CustomerName,
          'CustomerPhone' : CustomerPhone,
          'CustomerAddress' : CustomerAddress,
          'FromCounter' : FromCounter,
          'ToCounter' : ToCounter,
          'PMLToken' : PMLToken,
          'PMLType' : PMLType,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'UpdateCustomerInfo'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            console.log(data);
            $("#CustomerName").val(CustomerName);
            $("#CustomerPhone").val(CustomerPhone);
            $("#CustomerAddress").val(CustomerAddress);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      
     

      // To Add Individual Barcodes
      function WarehousePurchaseSendBarcodeData(BarcodeSerial){
        var RandomNumber = Math.floor(Math.random() * 10);
        var SingleProductToken =  PMLToken+RandomNumber + BarcodeSerial;
        var FromCounter =  $("#FromCounter").val();
        var ToCounter =  $("#ToCounter").val();
        var Price =  $("#Price").val();
        var PostData = {
          'SingleProductToken' : SingleProductToken,
          'BarcodeSerial' : BarcodeSerial,
          'FromCounter' : FromCounter,
          'ToCounter' : ToCounter,
          'PMLToken' : PMLToken,
          'PMLType' : PMLType,
          'Price' : Price,
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
            $('#Alert').html(data);
            $('#Alert').show();
            LoadProductsInInvoice();
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
            LoadProductsInInvoice();
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
              $('#BarcodeSerial').val(barcode);
            }
            
         } // main callback function    
      });


    </script>
  </body>
</html>