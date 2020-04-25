<?php 
  $CounterToken = $_GET["CounterToken"];
  $ProductToken = $_GET["ProductToken"];
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
                  <h4 class="page-title"> <?php echo CounterTitle($CounterToken); ?></h4>
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
                    <input type="hidden" id="CounterToken" value="<?php echo "$CounterToken"; ?>">
                    <input type="hidden" id="ProductToken" value="<?php echo "$ProductToken"; ?>">
                    <h4 class="m-t-0 header-title"><b><?php echo ProductTitle($ProductToken); ?></b></h4>
                    <p>
                      <span><button class="PLCButton btn btn-info waves-effect waves-light" id="2">In Distribution</button></span> &nbsp;
                      <span><button class="PLCButton btn btn-info waves-effect waves-light" id="3">In Sales</button></span> &nbsp;
                    </p>
                    <!-- <p class="text-muted m-b-20">
                      Search Using The Search Box Below
                    </p> -->
                    <!-- <h3 id="">Show Type</h3> -->
                    <table class="table table-striped m-0" id="ShowPLCTable">
                      
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


        // Button Click Product Life Cycle
        $(document).on('click', "button.PLCButton", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var ShowType = $(this).attr("id"); 
            var CounterToken = $('#CounterToken').val(); 
            var ProductToken = $('#ProductToken').val(); 
            LoadPLCInCounter(ShowType, CounterToken, ProductToken);
        });

      });

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();


      function LoadPLCInCounter(ShowType, CounterToken, ProductToken){
        var PostData = {
          'ShowType' : ShowType,
          'CounterToken' : CounterToken,
          'ProductToken' : ProductToken,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadPLCInCounter'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#ShowPLCTable').html(data);
            console.log(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }


      function AddNewProduct(){
        var ProductTitle = $("#ProductTitle").val();
        var PostData = {
          'ProductTitle' : ProductTitle,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'AddNewProduct'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            //$('#Msg').html(data);
            $("#ProductTitle").val('');
            LoadAllProducts();
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