<?php 
  $FromCounter = $_GET["CounterToken"];
  $FromCounterTitle = CounterTitle($FromCounter);
  $ShowDate = $_GET["Date"];
  $ShowBDDATE = BDDATE($ShowDate);
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
                  <h4 class="page-title">Daily Report | <?php echo $FromCounterTitle; ?> | <?php echo "$ShowBDDATE"; ?></h4>
                  <input type="hidden" id="ClosingDate" value="<?php echo "$ShowDate"; ?>">
                  <input type="hidden" id="CounterToken" value="<?php echo "$FromCounter"; ?>">
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
                    			<th>Invoice</th>
                          <th>Customer</th>
                          <th>Phone</th>
                          <th>Units</th>
                          <th>Total</th>
                          <th>Paid</th>
                    			<th>Due</th>
                    		</tr>
                    	</thead>
                      <tbody>
                        <?php
                        $Q = "SELECT PMLToken, PMLTitle FROM productmovementlist_log WHERE PMLType = '3' AND FromCounter = '$FromCounter' AND ToCounter = 'Sales' AND Existence = '1' AND BusinessToken = '$BusinessToken' AND DATE(BDDT) = '$ShowDate'";
                        $RQ = RunQuery($Q);
                        $SL= 1;
                        while ($RowQ = Fetch($RQ)) {
                          $PMLToken = $RowQ["PMLToken"];
                          $PMLTitle = $RowQ["PMLTitle"];
                          $InvoiceNumber = InvoiceNumberByPMLToken($PMLToken);
                          $TotalUnits = TotalIndividualsInPML($PMLToken);
                          $CustomerPhoneNumber = CustomerPhoneNumberByPMLToken($PMLToken);
                          $TotalInInvoice = TotalInInvoiceByPMLToken($PMLToken);
                          $TotalPaidInInvoice = TotalPaidInInvoiceByPMLToken($PMLToken);
                          $DueInInvoice = $TotalInInvoice - $TotalPaidInInvoice;
                          echo "<tr>";
                            echo "<td>$SL</td>";
                            echo "<td><b>#$InvoiceNumber</b></td>";
                            echo "<td><a class='btn btn-warning waves-effect waves-light' href='index.php?p=business&m=10400&PMLToken=$PMLToken'>$PMLTitle</a></td>";
                            echo "<td>$CustomerPhoneNumber</td>";
                            echo "<td><a class='TotalUnits btn btn-info waves-effect waves-light' href = ''>$TotalUnits</a></td>";
                            echo "<td><a class='TotalInInvoice btn btn-primary waves-effect waves-light' href = ''>$TotalInInvoice</a></td>";
                            echo "<td><a class='TotalPaidInInvoice btn btn-success waves-effect waves-light' href = ''>$TotalPaidInInvoice</a></td>";
                            echo "<td><a class='DueInInvoice btn btn-danger waves-effect waves-light' href = ''>$DueInInvoice</a></td>";
                          echo "</tr>";
                          $SL++;
                        }

                      ?>
                      </tbody>
                      <thead>
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <thead>
                        <tr>
                          <th></th>
                          <th>Total</th>
                          <th></th>
                          <th></th>
                          <th><button id="TotalBoxOfTotalUnits" class="btn btn-info waves-effect waves-light btn-block"></button></th>
                          <th><button id="TotalBoxOfTotalInInvoice" class="btn btn-primary waves-effect waves-light btn-block"></button></th>
                          <th><button id="TotalBoxOfTotalPaidInInvoice" class="btn btn-success waves-effect waves-light btn-block"></button></th>
                          <th><button id="TotalBoxOfDueInInvoice" class="btn btn-danger waves-effect waves-light btn-block"></button></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
              <!-- PAGE INFORMATION -->
            </div>
            <!-- <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <button type="submit" class="InitiateClosing btn btn-info btn-block waves-effect waves-light btn-lg">Initiate Closing</button>
                </div>
              </div>
            </div> -->
            <!-- end row -->
            <div class="row" id="InputPanel">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="m-t-0 header-title"><b>TOTAL COLLECTION: <button id="TotalCollection" class="btn btn-success waves-effect waves-light"></button></b></h4>
                        <h4 class="m-b-20 m-t-20">COLLECTION DETAILS</h4>
                        <br>
                        <table class="table table-striped m-0" id="ShowPMLTable">
                          <thead class='bg-success text-white'>
                            <tr>
                              <th>SL</th>
                              <th>Method</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $Q = "SELECT TMLToken, SUM(Amount) AS TotalAmount FROM transactiondetails_info WHERE CounterToken = '$FromCounter' AND ReferenceType = '1' AND  Existence = '1' AND BusinessToken = '$BusinessToken' AND DATE(BDDT) = '$ShowDate' GROUP BY TMLToken";
                            $RQ = RunQuery($Q);
                            $SL= 1;
                            while ($RowQ = Fetch($RQ)) {
                              $TMLToken = $RowQ["TMLToken"];
                              $TotalAmount = $RowQ["TotalAmount"];
                              $TMLTitle = TMLTitle($TMLToken);
                              
                              echo "<tr>";
                                echo "<td>$SL</td>";
                                echo "<td><b>$TMLTitle</b></td>";
                                echo "<td>$TotalAmount</td>";
                              echo "</tr>";
                              $SL++;
                            }

                          ?>
                          </tbody>
                        </table>
                      </div>
                    </div>  
                  </div>
                  <div class="col-sm-6">
                    
                  </div>
                </div>
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

        $(document).on('click', "button.InitiateClosing", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var ClosingDate = $('#ClosingDate').val();
            InitiateClosing(ClosingDate);
        });

        $("#AddAmount").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var DCID = $('#DCID').val();
          var Amount = $("#Amount").val();
          if (DCID != '' && Amount != '') {
            AddAmount();
          }
        });


        function TotalInInvoice(){
          var sum = 0;
          $('.TotalInInvoice').each(function()
          {
              sum += parseFloat(Number($(this).text()));
          });
          return sum;
        }

        var TotalInInvoice = TotalInInvoice();
        $('#TotalBoxOfTotalInInvoice').text(TotalInInvoice);


        function TotalPaidInInvoice(){
          var sum = 0;
          $('.TotalPaidInInvoice').each(function()
          {
              sum += parseFloat(Number($(this).text()));
          });
          return sum;
        }

        var TotalPaidInInvoice = TotalPaidInInvoice();
        $('#TotalBoxOfTotalPaidInInvoice').text(TotalPaidInInvoice);
        $('#TotalCollection').text(TotalPaidInInvoice);


        function DueInInvoice(){
          var sum = 0;
          $('.DueInInvoice').each(function()
          {
              sum += parseFloat(Number($(this).text()));
          });
          return sum;
        }

        var DueInInvoice = DueInInvoice();
        $('#TotalBoxOfDueInInvoice').text(DueInInvoice);

        function TotalUnits(){
          var sum = 0;
          $('.TotalUnits').each(function()
          {
              sum += parseFloat(Number($(this).text()));
          });
          return sum;
        }

        var TotalUnits = TotalUnits();
        $('#TotalBoxOfTotalUnits').text(TotalUnits);

      });

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();

      function InitiateClosing(ClosingDate){
        var CounterToken = $('#CounterToken').val();
        var PostData = {
          'CounterToken' : CounterToken,
          'ClosingDate' : ClosingDate,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'InitiateClosing'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('.InitiateClosing').hide();
            $('#InputPanel').show();
            $('#DCID').val(data);
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