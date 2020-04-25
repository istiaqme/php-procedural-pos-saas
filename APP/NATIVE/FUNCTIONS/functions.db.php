<?php
	# Run Query
	function RunQuery($Query){
		global $DBCON;
		$RQ = mysqli_query($DBCON, $Query);
		return $RQ;
	}
	# Num Rows
	function NumRows($RunQuery){
		global $DBCON;
		$NR = mysqli_num_rows($RunQuery);
		return $NR;
	}
	# Fetch Assoc
	function Fetch($RunQuery){
		global $DBCON;
		$R = mysqli_fetch_assoc($RunQuery);
		return $R;
	}
	# Insert ID
	function InsertedID($DBCON){
		$IID = mysqli_insert_id($DBCON);
		return $IID;
	}
?>