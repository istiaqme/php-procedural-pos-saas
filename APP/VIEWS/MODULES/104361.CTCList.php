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
                  <h4 class="page-title">CTC Transport | <?php echo $FromCounterTitle; ?></h4>
                  <ol class="breadcrumb p-0 m-0">
                    <div class="form-inline">
                      <div class="form-group m-r-10">
                        <?php 
                          echo "<select class='form-control js-example-basic-single' id='ToCounter' required>";
                          $PTQ = "SELECT * FROM counterlist_info WHERE Existence = '1' AND Suspension = '0' AND CounterType = 'Sales' AND BusinessToken = '$BusinessToken'";
                          $RPTQ = RunQuery($PTQ);
                            while ($RowPTQ = Fetch($RPTQ)) {
                              $CounterToken = $RowPTQ["CounterToken"];
                              $CounterTitle = $RowPTQ["CounterTitle"];
                              if ($CounterToken != $FromCounter) {
                                echo "<option value='$CounterToken'>$CounterTitle</option>";
                              }
                            }
                          echo "</select>";
                        ?>
                      </div>
                      <div class="form-group m-r-10">
                        <input type="hidden" id="PMLType" value='4'>
                        <input type="hidden" id="FromCounter" value='<?php echo $FromCounter ?>'>
                        <input type="text" class="form-control" id="PMLTitle" placeholder="CTC Title" required>
                      </div>
                      <button type="submit" id="AddNewPML" class="btn btn-success waves-effect waves-light">Add New</button>
                    </div>
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
        $('.js-example-basic-single').select2();

        LoadAllPML();


        // ADD NEW PRODUCT ON BUTTON CLICK
        $("#AddNewPML").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var PMLTitle = $("#PMLTitle").val();
          var FromCounter = $("#FromCounter").val();
          var ToCounter = $("#ToCounter").val();
          if (PMLTitle != '' && FromCounter != '' && ToCounter != '') {
            AddNewPML();
          }
        });

      });

      

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();


      function LoadAllPML(){
        var PMLType = $("#PMLType").val();
        var FromCounter = $("#FromCounter").val();
        var ToCounter = $("#ToCounter").val();
        var PostData = {
          'ToCounter' : ToCounter,
          'FromCounter' : FromCounter,
          'PMLType' : PMLType,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadAllPML'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#ShowPMLTable').html(data);
            var x = TotalInvoicePriceSum();
            $('#TotalBox').text(x);
            console.log(x);

            
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      function TotalInvoicePriceSum(){
        var sum = 0;
        $('.Units').each(function()
        {
            sum += parseFloat($(this).text());
        });
        return sum;
      }


      function AddNewPML(){
        var PMLTitle = $("#PMLTitle").val();
        var PMLType = $("#PMLType").val();
        var FromCounter = $("#FromCounter").val();
        var ToCounter = $("#ToCounter").val();
        var PostData = {
          'ToCounter' : ToCounter,
          'FromCounter' : FromCounter,
          'PMLTitle' : PMLTitle,
          'PMLType' : PMLType,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'AddNewPML'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            //$('#Msg').html(data);
            $("#PMLTitle").val('');
            LoadAllPML();
            console.log(data);
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