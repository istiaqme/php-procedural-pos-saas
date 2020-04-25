<?php
	ob_flush();
	session_start();
	# INCLUDE ROOT
	require "root.php";
	# REQUIRE DATABSE LINK
	require(APP_ROOT.'/APP/NATIVE/HELPERS/dbcon.php');
	# REQUIRE DB TABLES
	require(APP_ROOT.'/APP/NATIVE/HELPERS/dbtables.php');
	# REQUIRE DB FUNCTIONS
	require(APP_ROOT.'/APP/NATIVE/FUNCTIONS/functions.db.php');
	# REQUIRE COMMON FUNCTIONS
	require(APP_ROOT.'/APP/NATIVE/FUNCTIONS/functions.common.php');
	# REQUIRE APP FUNCTIONS
	require(APP_ROOT.'/APP/NATIVE/FUNCTIONS/functions.app.php');

	# APP NATIVE GLOBAL VARIABLES
	$BDDT = BDDT();
	$BDDATEDBFORMAT = BDDATEDBFORMAT();
	$BDDATEPLAIN = BDDATEPLAIN($BDDT);

	/* DIRECTORIES */
	$ROOTURL = "http://localhost/BBFinalNew";
	$APIURL = "$ROOTURL/index.php?p=WebAPI";
	$PUBLICDIR = "$ROOTURL/PUBLIC";
	$ASSETS = "$PUBLICDIR/ASSETS";
	$IMAGES = "$PUBLICDIR/IMAGES";
	$PLUGINS = "$PUBLICDIR/PLUGINS";
	/* DIRECTORIES */

	/* URLS */
	$BusinessPage = "$ROOTURL/index.php?p=business";
	$LoginPage = "$ROOTURL/index.php?p=login";
	$LoginAction = "$ROOTURL/index.php?p=loginaction";


	$NotFoundPage = "$ROOTURL/index.php?p=not-found";
	$FatalErrorPage = "$ROOTURL/index.php?p=fatal-error";
	$AuthenticationErrorPage = "$ROOTURL/index.php?p=authentication-error";
	/* URLS */



	if (isset($_GET["p"])) {
		$p = $_GET["p"];
		if (!empty($p)) {
			if ($p == "login") {
				require(APP_ROOT.'/APP/VIEWS/102.login.root.php');
			}
			elseif ($p == "loginaction") {
				require(APP_ROOT.'/APP/VIEWS/103.login-action.root.php');
			}
			elseif ($p == "dashboard") {
				require(APP_ROOT.'/APP/VIEWS/103.dashboard.root.php');
			}
			elseif ($p == "business") {
				require(APP_ROOT.'/APP/VIEWS/104.business.root.php');
			}
			elseif ($p == "WebAPI") {
				require(APP_ROOT.'/APP/VIEWS/105.WebAPI.root.php');
			}
			elseif ($p == "TempAPI") {
				require(APP_ROOT.'/APP/VIEWS/TempAPI.root.php');
			}
			elseif ($p == "not-found") {
				require(APP_ROOT.'/APP/VIEWS/000.404.root.php');
			}
			elseif ($p == "authentication-error") {
				require(APP_ROOT.'/APP/VIEWS/001.authentication.error.root.php');
			}
			elseif ($p == "fatal-error") {
				require(APP_ROOT.'/APP/VIEWS/002.fatal.error.root.php');
			}
			elseif ($p == "fc") {
				require(APP_ROOT.'/APP/VIEWS/fc.php');
			}
			else{
				# INDEX
				require(APP_ROOT.'/APP/VIEWS/101.index.root.php');
			}
		}
		else{
			require(APP_ROOT.'/APP/VIEWS/000.404.root.php');
		}
	}
	else{
		# LOGIN PAGE
		require(APP_ROOT.'/APP/VIEWS/102.login.root.php');
	}


	ob_end_flush();
?>