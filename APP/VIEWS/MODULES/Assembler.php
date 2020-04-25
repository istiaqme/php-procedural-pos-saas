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
                  <h4 class="page-title">Product List</h4>
                  <ol class="breadcrumb p-0 m-0">
                    <div class="form-inline" action="">
                      <div class="form-group m-r-10">
                        <input type="text" class="form-control" id="Title" placeholder="Assembler Title" required>
                      </div>
                      <button type="submit" id="AddNewAssembler" class="btn btn-success waves-effect waves-light">Add New</button>
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
                    <h4 class="m-t-0 header-title"><b>Assembler List</b></h4>
                    <table class="table table-striped m-0" id="ShowAssemblerListTable">
                      
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

        LoadAllAssemblers();

        // ADD NEW PRODUCT ON BUTTON CLICK
        $("#AddNewAssembler").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          AddNewAssembler();
        });

      });

      function LoadAllAssemblers(){
        var PostData = {
          'Request' : 'LoadAllAssemblers'
        }
        $.ajax({
          url: TempAPIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#ShowAssemblerListTable').html(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }


      function AddNewAssembler(){
        var Title = $("#Title").val();
        var PostData = {
          'Title' : Title,
          'Request' : 'AddNewAssembler'
        }
        $.ajax({
          url: TempAPIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $("#Title").val('');
            LoadAllAssemblers();
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