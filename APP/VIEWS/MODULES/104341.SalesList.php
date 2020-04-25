<?php 
  $FromCounter = $_GET["FromCounter"];
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
                  <h4 class="page-title">Sales List</h4>
                  <ol class="breadcrumb p-0 m-0">
                    <div class="form-inline" action="">
                      <div class="form-group m-r-10">
                        <input type="hidden" id="PMLType" value='3'>
                        <input type="hidden" id="FromCounter" value='<?php echo $FromCounter; ?>'>
                        <input type="hidden" id="ToCounter" value='Sales'>
                        <input type="hidden" id="PMLTitle" value='Untitled'>
                      </div>
                      <button type="submit" id="AddNewPML" class="btn btn-danger waves-effect waves-light">CREATE NEW INVOICE</button>
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
                    <h4 class="m-t-0 header-title"><b>All Purchases</b></h4>
                    <p class="text-muted m-b-20">
                      Search Using The Search Box Below
                    </p>
                    <div class="form-group">
                      <input type="text" id="PMLSearch" class="form-control">
                    </div>
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

        LoadAllPML();

        // ADD NEW PRODUCT ON BUTTON CLICK
        $("#AddNewPML").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var PMLTitle = $("#PMLTitle").val();
          if (PMLTitle != '') {
            AddNewPML();
          }
        });


        $("#PMLSearch").on("keyup", function() {
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

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();


      function TotalOfAColumn(ColumnClass, Target){
        var sum = 0;
        $('.'+ColumnClass).each(function()
        {
            sum += parseFloat($(this).text());
        });
        $('#'+Target).text(sum);
      }


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
            TotalOfAColumn('Units', 'TotalBox');
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
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
            //console.log(data);
            window.location.replace(data);
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