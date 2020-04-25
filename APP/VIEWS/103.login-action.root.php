<?php 
	if (isset($_POST["SignInButton"])) {
		$PhoneNumber = $_POST["PhoneNumber"];
		$Password = $_POST["Password"];
		$HashedPassword = hash('sha512', $Password);
		$Proceed = 1;
		$Q = "SELECT * FROM $TableUserList WHERE PhoneNumber = '$PhoneNumber' AND Password = '$HashedPassword' AND Existence = '1'";
		$RQ = RunQuery($Q);
		$NumRows = NumRows($RQ);
		if ($NumRows != 1) {
			echo "Wrong Information";
		}
		else{
			$LOGGED_IN = "YES";
			$Row = Fetch($RQ);
			$UserToken = $Row["UserToken"]; 
			$FirstName = $Row["FirstName"]; 
			$LastName = $Row["LastName"]; 
			$PhoneNumber = $Row["PhoneNumber"]; 
			$Rank = $Row["Rank"];
			if ($Rank == 103) {
				# GET BUSINESS INFO
				$Q = "SELECT BusinessToken, SubRank FROM userandbusiness_rel WHERE UserToken = '$UserToken' AND Existence = '1'";
				$RQ = RunQuery($Q);
				$NumRows = NumRows($RQ);
				if ($NumRows != '1') {
					echo "No Business Associated";
				}
				else{
					# Get Business Token & Sub Rank
					$Row = Fetch($RQ);
					$BusinessToken = $Row["BusinessToken"];
					$SubRank = $Row["SubRank"];
					# Business Related Info
					$Q = "SELECT BusinessName, StartDate FROM businesslist_info WHERE BusinessToken = '$BusinessToken' AND Existence = '1'";
					$RQ = RunQuery($Q);
					$NumRows = NumRows($RQ);
					if ($NumRows != 1) {
						echo "Business if Off";
					}
					else{
						# Get Business Related Info
						$Row = Fetch($RQ);
						$BusinessName = $Row["BusinessName"];
						$StartDate = $Row["StartDate"];
						# Get Warehouse
						$WQ = "SELECT CounterToken, CounterTitle FROM counterlist_info WHERE BusinessToken = '$BusinessToken' AND CounterType = 'Warehouse'";
						$RWQ = RunQuery($WQ);
						$RowWQ = Fetch($RWQ);
						$CounterToken = $RowWQ["CounterToken"];
						# SET THEM ALL IN SESSION
						//echo "Everything Okay";
						$_SESSION["LOGGED_IN"] = $LOGGED_IN;
						$_SESSION["UserToken"] = $UserToken;
						$_SESSION["FirstName"] = $FirstName;
						$_SESSION["LastName"] = $LastName;
						$_SESSION["PhoneNumber"] = $PhoneNumber;
						$_SESSION["Rank"] = $Rank;
						$_SESSION["BusinessToken"] = $BusinessToken;
						$_SESSION["SubRank"] = $SubRank;
						$_SESSION["BusinessName"] = $BusinessName;
						$_SESSION["StartDate"] = $StartDate;
						$_SESSION["Warehouse"] = $CounterToken;
						header("Location: index.php?p=business&m=10421");
					}
				}
			}
			else{
				# GET BUSINESS INFO
			}

		}
	}
	else{
		require(APP_ROOT.'/APP/VIEWS/000.404.root.php');
	}

?>