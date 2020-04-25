<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Login | Bonik Bondhu</title>
    <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/common.meta.php'); ?>
  </head>
  <body class="bg-transparent">
    <!-- HOME -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="wrapper-page">
              <div class="m-t-40 account-pages">
                <div class="text-center account-logo-box">
                  <h2 class="text-uppercase">
                    <a href="<?php echo $ROOTURL; ?>" class="text-success">
                    <span><img src="<?php echo "$ASSETS"; ?>/images/logo_dark.png" alt="" height="60"></span>
                    </a>
                  </h2>
                  <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                </div>
                <div class="account-content">
                  <form class="form-horizontal" action="<?php echo"$LoginAction"; ?>" method="POST">
                    <div class="form-group m-b-25">
                      <div class="col-12">
                        <label>Mobile Number</label>
                        <input class="form-control input-lg" type="text" required="" placeholder="01711908070" name="PhoneNumber">
                      </div>
                    </div>
                    <div class="form-group m-b-25">
                      <div class="col-12">
                        <label>Password</label>
                        <input class="form-control input-lg" type="password" required="" placeholder="********" name="Password">
                      </div>
                    </div>
                    <div class="form-group m-b-20">
                      <div class="col-12">
                        <!-- <div class="checkbox checkbox-custom">
                          <label>
                          <input type="checkbox" value="">
                          <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                          Remember me
                          </label>
                        </div> -->
                      </div>
                    </div>
                    <div class="form-group account-btn text-center m-t-10">
                      <div class="col-12">
                        <button class="btn w-lg btn-lg btn-primary waves-effect waves-light" type="submit" name="SignInButton">Sign In</button>
                      </div>
                    </div>
                  </form>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- end card-box-->
              <!-- <div class="row m-t-50">
                <div class="col-sm-12 text-center">
                  <p class="text-muted">Don't have an account? <a href="page-register.html" class="text-dark m-l-5">Sign Up</a></p>
                </div>
              </div> -->
            </div>
            <!-- end wrapper -->
          </div>
        </div>
      </div>
    </section>
    <!-- END HOME -->
    <script>
      var resizefunc = [];
    </script>
    <?php require(APP_ROOT.'/APP/VIEWS/INCLUDES/common.meta.php'); ?>
  </body>
</html>