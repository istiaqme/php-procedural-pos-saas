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
                  <h4 class="page-title">Money Books</h4>
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
                          <h4 class="m-t-0 header-title"><b>Transaction Book</b></h4>
                          <p class="text-muted m-b-20">
                            Create New Transaction Book
                          </p>
                        
                          <!-- PRODUCT SELECTOR -->
                          <div id="TransactionBookInsertPanel">
                            <div class="form-group">
                              <input type="text" id="TGBTitle" class="form-control">
                            </div>
                          </div>
                          <?php 
                              echo "<div class='form-group'>";
                              echo "<button type='submit' id='AddNewTGB' class='btn btn-success waves-effect waves-light btn-block'>Add New</button>";
                              echo "</div>";
                            ?>
 
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="m-t-0 header-title"><b>All Books</b></h4>
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
                            <h4 class="m-t-0 header-title"><b>METHODS:&nbsp;</b><span id="ExpanderTitle"></span></h4>
                            <input type="hidden" name="TGBToken" value="">
                            <div class="form-group">
                                <input type="text" id="TMLTitle" class="form-control" placeholder = 'New Method Title'>
                            </div>
                            <div class="form-group">
                                <button class='btn btn-block btn-danger' id='AddNewTMLTitle'>ADD NEW</button>
                            </div>
                            <p class="text-muted m-b-20">
                              Search Using The Search Box Below
                            </p>
                            <div class="form-group">
                                <input type="text" id="MethodSearch" class="form-control">
                            </div>
                            <input type="hidden" id="TGBToken" value="">
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

        LoadAllTGB();

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
        $("#MethodSearch").on("keyup", function() {
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
        $("#AddNewTMLTitle").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var TMLTitle = $("#TMLTitle").val();
          if (TMLTitle != '') {
              var TMLTitle = TMLTitle;
              AddNewTransactionMethod()
              $("#TMLTitle").val('');
          }
        });

        // ADD NEW PRODUCT ON BUTTON CLICK
        $("#AddNewTGB").click(function(e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var TGBTitle = $("#TGBTitle").val();
          if (TGBTitle != '') {
            AddNewTGB();
          }
        });


        // LoaderExpnader ON BUTTON CLICK
        $(document).on('click', "button.Expander", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var TGBToken = $(this).attr("id"); 
            $("#TGBToken").val(TGBToken);
            TGBTitleInExpander(TGBToken);
            LoadAllMethodsInExpander();    
        });

      });

      // PREDEFINED VALUES
      var UserToken = $("#UserToken").val();
      var BusinessToken = $("#BusinessToken").val();
      var Rank = $("#Rank").val();
      var SubRank = $("#SubRank").val();
      var Warehouse = $("#Warehouse").val();


      // Add New TGB
      function AddNewTGB(){
        var TGBTitle = $("#TGBTitle").val();
        var PostData = {
          'TGBTitle' : TGBTitle,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'AddNewTGB'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            //$('#Msg').html(data);
            $("#TGBTitle").val('');
            LoadAllTGB();
            console.log(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // ALL ALL TGB
      function LoadAllTGB(){
        var PostData = {
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadAllTGB'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            //$('#Msg').html(data);
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
      function TGBTitleInExpander(TGBToken){
        var PostData = {
          'TGBToken' : TGBToken,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'TGBTitleInExpander'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $("#ExpanderTitle").text(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // Add New Transaction Method
      function AddNewTransactionMethod(){
        var TMLTitle = $("#TMLTitle").val();
        var TGBToken = $("#TGBToken").val();
        var PostData = {
          'TMLTitle' : TMLTitle,
          'TGBToken' : TGBToken,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'AddNewTransactionMethod'
        }
        $.ajax({
          url: APIURL,
          type: 'post',
          data: PostData,
          success: function(data){
            $("#TMLTitle").val('');
            LoadAllMethodsInExpander()
            console.log(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            $('#Msg').html(errorMsg);
          }
        });
      }

      // Load All Methods In Expander
      function LoadAllMethodsInExpander(){
        var TGBToken = $("#TGBToken").val();
        var PostData = {
          'TGBToken' : TGBToken,
          'UserToken' : UserToken,
          'BusinessToken' : BusinessToken,
          'Rank' : Rank,
          'SubRank' : SubRank,
          'Request' : 'LoadAllMethodsInExpander'
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


    </script>
  </body>
</html>