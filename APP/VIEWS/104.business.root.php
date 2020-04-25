<?php 

	# INITIATE LOGIN VERIFICATION

	if (!isset($_SESSION["LOGGED_IN"])) {
		header("Location: $LoginPage");
	}
	else{
		# RECEIVE ALL SESSIONS
		$LOGGED_IN = $_SESSION["LOGGED_IN"];
		$UserToken = $_SESSION["UserToken"];
		$FirstName = $_SESSION["FirstName"];
		$LastName = $_SESSION["LastName"];
		$PhoneNumber = $_SESSION["PhoneNumber"];
		$Rank = $_SESSION["Rank"];
		$BusinessToken = $_SESSION["BusinessToken"];
		$SubRank = $_SESSION["SubRank"];
		$BusinessName = $_SESSION["BusinessName"];
		$Warehouse = $_SESSION["Warehouse"];
		$StartDate = $_SESSION["StartDate"];



		# INITIATE MODULE ROUTING
		if (isset($_GET["m"])) {
			$ModuleToken = $_GET["m"];
			if (!empty($ModuleToken)) {
				$MQ = "SELECT * FROM modulelist_static WHERE ModuleToken = '$ModuleToken'";
				$MRQ = RunQuery($MQ);
				$NumRowsMQ = NumRows($MRQ);
				if ($NumRowsMQ == 1) {
					# Check Module Access
					if (ModuleAccess() == TRUE) {
						$RowsMQ = Fetch($MRQ);
						$ModuleTitle = $RowsMQ["ModuleTitle"];
						$ModuleFile = $RowsMQ["ModuleFile"];
						include(APP_ROOT.'/APP/VIEWS/MODULES/'.$ModuleFile);
					}
					else{
						//echo "No Mod Access";
						header("Location: $FatalErrorPage");
					}
				}
				else{
					header("Location: $NotFoundPage");
				}
			}
			else{
				//echo "EMPTY";
				header("Location: $FatalErrorPage");
			}
		}
		else{
			# SET BUSINESS MANAGER HOME DASHBOARD
			$ModuleTitle = $BusinessName;
			require(APP_ROOT.'/APP/VIEWS/MODULES/1041.business.dashboard.php');
		}
		
	}

?>