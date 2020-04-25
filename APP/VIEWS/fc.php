<?php
	/*function BarcodeExistsInSource($Barcode, $CounterToken, $PMLType){
		if ($PMLType == '2') {
			$NewPMLType = '1';
		}
		global $DBCON;
		$Q = "SELECT PMIID FROM productmovementinsertion_details WHERE ToCounter = '$CounterToken' AND BarcodeSerial = '$Barcode' AND Existence = '1' AND WorkFlowStatus = '3' AND PMLType = '$NewPMLType'";
		$RQ = RunQuery($DBCON);
		$NumRows = NumRows($RQ);
		if ($NumRows == 1) {
			return "Nai";
		}
		else{
			return "Ase";
		}
	}*/

	ini_set('display_errors', 'On');
	ini_set('html_errors', 0);

	// ----------------------------------------------------------------------------------------------------
	// - Error Reporting
	// ----------------------------------------------------------------------------------------------------
	error_reporting(-1);

	/*function WarehouseHistoryTotalProductsInCounter($CounterToken, $ProductToken, $FromDate, $ToDate){
	    # GET INSERTION 
	    $Q = "SELECT PMIID FROM productmovementinsertion_details WHERE BDDT BETWEEN '$FromDate' AND '$ToDate' AND ToCounter = '$CounterToken' AND ProductToken = '$ProductToken' AND Existence = '1' AND WorkFlowStatus = '3'" ;
	    $RQ = RunQuery($Q);
	    $NRQ = NumRows($RQ);
	    
	    # GET OUT
	    $Q1 = "SELECT PMIID FROM productmovementinsertion_details WHERE BDDT BETWEEN '$FromDate' AND '$ToDate' AND FromCounter = '$CounterToken' AND ProductToken = '$ProductToken' AND Existence = '1' AND WorkFlowStatus = '3'";
	    $RQ1 = RunQuery($Q1);
	    $NRQ1 = NumRows($RQ1);
	    
	    $Total = $NRQ - $NRQ1;
	    return $Total;
	}*/


	$F = "2019-01-01";
	$T = "2019-02-01";
	$C = "B1WC1";
	$P = "500001734";
	$X = WarehouseHistoryTotalProductsInCounter($C, $P, $F, $T);
	echo "$X";
	
?>