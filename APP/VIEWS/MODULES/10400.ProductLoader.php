<?php 
	if (!isset($_GET["PMLToken"])) {
		//header("Location: $AuthenticationErrorPage");
	}
	else{
		if (!empty($_GET["PMLToken"])) {
			$PMLToken = $_GET["PMLToken"];
			$PMLQ = "SELECT * FROM productmovementlist_log WHERE PMLToken = '$PMLToken' AND BusinessToken = '$BusinessToken' AND Existence = '1'";
			$RPMLQ = RunQuery($PMLQ);
			$RowPMLQ = Fetch($RPMLQ);
			$PMLType = $RowPMLQ["PMLType"];
			$WorkFlowStatus = $RowPMLQ["WorkFlowStatus"];
			$FromCounter = $RowPMLQ["FromCounter"];
			$ToCounter = $RowPMLQ["ToCounter"];
			$UserToken = $RowPMLQ["UserToken"];
			if ($PMLType == 1) {
				require(APP_ROOT.'/APP/VIEWS/MODULES/10400.ProductLoader.1.php');
			}
			elseif ($PMLType == 2) {
				require(APP_ROOT.'/APP/VIEWS/MODULES/10400.ProductLoader.2.php');
			}
			elseif ($PMLType == 3) {
				require(APP_ROOT.'/APP/VIEWS/MODULES/10400.ProductLoader.3.php');
			}
			elseif ($PMLType == 4) {
				require(APP_ROOT.'/APP/VIEWS/MODULES/10400.ProductLoader.4.php');
			}
		}
		else{
			header("Location: $FatalErrorPage");
		}
	}
?>