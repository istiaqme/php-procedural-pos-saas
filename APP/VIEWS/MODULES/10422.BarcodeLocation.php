<?php 
  if (isset($_GET["BS"])) {
    $BS = $_GET["BS"];
  }
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
                  <h4 class="page-title">Barcode Location</h4>
                  <ol class="breadcrumb p-0 m-0">
                    <div class="form-inline" action="">
                      <div class="form-group m-r-10">
                        
                        
                      </div>
                      
                    </div>
                    
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- PAGE HEADER -->

              <!-- PAGE INFORMATION -->
              <div class="col-12">
                        <div class="row">
                          <div class="col-8">
                            <div class="form-group">
                              <input type="text" id="BarcodeSerial"
                                <?php
                                  if (isset($_GET["BS"])) {
                                    echo "value='$BS'";
                                  }
                                  else{
                                    echo "value=''";
                                  }
                                ?>
                               class="form-control">
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <button class="btn btn-block btn-success" id="CheckBarcode">CHECK</button>
                            </div>
                          </div>
                        </div>
                      </div>
              <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      
                      

                      <table class="table table-striped m-0" id="ShowLocation">
                        
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
        $("#CheckBarcode").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          LoadBarcodeLocation();
        });

      });

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();


      function LoadBarcodeLocation(){
        var BarcodeSerial = $('#BarcodeSerial').val();
        var PostData = {
          'BarcodeSerial' : BarcodeSerial,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadBarcodeLocation'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $('#ShowLocation').html(data);
            console.log(data);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            console.log(errorMsg);
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
            
         }   
      });

      


     
    </script>
  </body>
</html>