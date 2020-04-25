<?php 
	function ModuleAccess(){
		return TRUE;
	}
	function BusinessAccess(){
		return TRUE;
	}
	function CounterAccess($UserToken, $CounterToken){
		$Q = "SELECT UACID FROM userandcounter_rel WHERE UserToken = '$UserToken' AND CounterToken = '$CounterToken' AND Existence = '1'";
		$RQ = RunQuery($Q);
		$NR = NumRows($RQ);
		if ($NR != 1) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	function APIACCESS(){
		return TRUE;
	}
	function PMLTitle($PMLToken){
		$Q = "SELECT PMLTitle FROM productmovementlist_log WHERE PMLToken = '$PMLToken'";
		$RQ = RunQuery($Q);
		$Row = Fetch($RQ);
		$PMLTitle = $Row["PMLTitle"];
		return $PMLTitle;
	}
	function CounterTitle($CounterToken){
		$Q = "SELECT CounterTitle FROM counterlist_info WHERE CounterToken = '$CounterToken'";
		$RQ = RunQuery($Q);
		$Row = Fetch($RQ);
		$CounterTitle = $Row["CounterTitle"];
		return $CounterTitle;
	}
	function ProductTitle($ProductToken){
		$Q = "SELECT ProductTitle FROM productgroup_info WHERE ProductToken = '$ProductToken'";
		$RQ = RunQuery($Q);
		$Row = Fetch($RQ);
		$ProductTitle = $Row["ProductTitle"];
		return $ProductTitle;
	}
	/*DEPRICATED*/
	function BarcodeExistsInCounter($Barcode, $CounterToken){
		$Q = "SELECT PMIID FROM productmovementinsertion_details WHERE ToCounter = '$CounterToken' AND BarcodeSerial = '$Barcode' AND Existence = '1' AND WorkFlowStatus = '3'";
		$RQ = RunQuery($Q);
		$NumRows = NumRows($RQ);
		if ($NumRows == 1) {
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*DEPRICATED*/
	function BarcodeExistsInSource($Barcode, $CounterToken, $PMLType){
		if ($PMLType == '2') {
			$NewPMLType = '1';
		}
		elseif ($PMLType == '3') {
			$NewPMLType = '2';
		}
		elseif ($PMLType == '4') {
			$NewPMLType = '2';
		}

		/*PREVIOUS TO COUNTER IS THE FROM COUNTER*/
		$Q = "SELECT PMIID FROM productmovementinsertion_details WHERE ToCounter = '$CounterToken' AND BarcodeSerial = '$Barcode' AND Existence = '1' AND WorkFlowStatus = '3' AND PMLType = '$NewPMLType'";
		$RQ = RunQuery($Q);
		$NumRows = NumRows($RQ);
		if ($NumRows == 1) {
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	function BarcodeExistsInDestination($Barcode, $CounterToken, $PMLType){
		/*NEW TO COUNTER IS THE TO COUNTER HERE*/
		$Q = "SELECT PMIID FROM productmovementinsertion_details  WHERE ToCounter = '$CounterToken' AND BarcodeSerial = '$Barcode' AND Existence = '1' AND WorkFlowStatus = '3' AND PMLType = '$PMLType'";
		$RQ = RunQuery($Q);
		$NumRows = NumRows($RQ);
		if ($NumRows == 1) {
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	function BarcodeExistsInSamePML($PMLToken, $BarcodeSerial){
		$Q = "SELECT PMIID FROM productmovementinsertion_details WHERE BarcodeSerial = '$BarcodeSerial' AND Existence = '1'";
		$RQ = RunQuery($Q);
		$NumRows = NumRows($RQ);
		if ($NumRows == 0) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	function BarcodeExistsInSamePMLType($BarcodeSerial, $PMLType){
		$Q = "SELECT PMIID FROM productmovementinsertion_details WHERE PMLType = '$PMLType' AND BarcodeSerial = '$BarcodeSerial' AND Existence = '1' AND WorkFlowStatus = '3'";
		$RQ = RunQuery($Q);
		$NumRows = NumRows($RQ);
		if ($NumRows == 0) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	function RootProductToken($BarcodeSerial){
		$Q = "SELECT ProductToken FROM productmovementinsertion_details WHERE PMLType = '1' AND BarcodeSerial = '$BarcodeSerial' AND Existence = '1' AND WorkFlowStatus = '3'";
		$RQ = RunQuery($Q);
		$RowQ = Fetch($RQ);
		$ProductToken = $RowQ["ProductToken"];
		return $ProductToken;
	}
	function ProductTokenBySingleProductToken($SingleProductToken){
		$Q = "SELECT ProductToken FROM productmovementproductlist_info WHERE SingleProductToken = '$SingleProductToken'";
		$RQ = RunQuery($Q);
		$Row = Fetch($RQ);
		$ProductToken = $Row["ProductToken"];
		return $ProductToken;
	}
	function SingleProductTotal($SingleProductToken){
	    $Q = "SELECT PMIID FROM productmovementinsertion_details WHERE SingleProductToken = '$SingleProductToken' AND Existence = '1'";
	    $RQ = RunQuery($Q);
	    $NumRows = NumRows($RQ);
	    return $NumRows;
	}
	function TotalProductsInCounter($CounterToken, $ProductToken){
	    # GET INSERTION 
	    $Q = "SELECT PMIID FROM productmovementinsertion_details WHERE ToCounter = '$CounterToken' AND ProductToken = '$ProductToken' AND Existence = '1' AND WorkFlowStatus = '3'" ;
	    $RQ = RunQuery($Q);
	    $NRQ = NumRows($RQ);
	    
	    # GET OUT
	    $Q1 = "SELECT PMIID FROM productmovementinsertion_details WHERE FromCounter = '$CounterToken' AND ProductToken = '$ProductToken' AND Existence = '1' AND WorkFlowStatus = '3'";
	    $RQ1 = RunQuery($Q1);
	    $NRQ1 = NumRows($RQ1);
	    
	    $Total = $NRQ - $NRQ1;
	    return $Total;
	}
	function WarehouseHistoryTotalProductsInCounter($CounterToken, $ProductToken, $ToDate){
	    $StartDate = $_SESSION["StartDate"];
	    # GET INSERTION 
	    $Q = "SELECT PMIID FROM productmovementinsertion_details WHERE DATE(BDDT) BETWEEN '$StartDate' AND '$ToDate' AND ToCounter = '$CounterToken' AND ProductToken = '$ProductToken' AND Existence = '1' AND WorkFlowStatus = '3'" ;
	    $RQ = RunQuery($Q);
	    $NRQ = NumRows($RQ);
	    
	    # GET OUT
	    $Q1 = "SELECT PMIID FROM productmovementinsertion_details WHERE DATE(BDDT) BETWEEN '$StartDate' AND '$ToDate' AND FromCounter = '$CounterToken' AND ProductToken = '$ProductToken' AND Existence = '1' AND WorkFlowStatus = '3'";
	    $RQ1 = RunQuery($Q1);
	    $NRQ1 = NumRows($RQ1);
	    
	    $Total = $NRQ - $NRQ1;
	    return $Total;
	}
	function InvoiceNumberByPMLToken($PMLToken){
		$Q = "SELECT InvoiceNumber FROM salesinvoicelist_log WHERE PMLToken = '$PMLToken'";
		$RQ =RunQuery($Q);
		$Row = Fetch($RQ);
		$InvoiceNumber = $Row["InvoiceNumber"];
		return $InvoiceNumber;
	}
	function TotalIndividualsInPML($PMLToken){
		$Q = "SELECT PMIID FROM productmovementinsertion_details WHERE PMLToken = '$PMLToken' AND Existence = '1'";
		$RQ = RunQuery($Q);
		$NR = NumRows($RQ);
		return $NR;
	}
	function TMLTitle($TMLToken){
		$Q = "SELECT TMLTitle FROM transactionmethodlist_info WHERE TMLToken = '$TMLToken'";
		$RQ = RunQuery($Q);
		$Row = Fetch($RQ);
		$TMLTitle = $Row["TMLTitle"];
		return $TMLTitle;
	}
	function AssemblerTitle($ALID){
		$Q = "SELECT Title FROM temp_assemblerlist WHERE ALID = '$ALID'";
		$RQ = RunQuery($Q);
		$Row = Fetch($RQ);
		$Title = $Row["Title"];
		return $Title;
	}
	function CounterProductValue($CounterToken, $ProductToken){
		# GET BARCODE FROM ToCounter
		$Q1 = "SELECT BarcodeSerial, Price FROM productmovementinsertion_details WHERE ToCounter = '$CounterToken' AND ProductToken = '$ProductToken' AND WorkFlowStatus = '3' AND Existence = '1'";
		$RQ1 = RunQuery($Q1);
		$NRQ1 = NumRows($RQ1);
			$FinalPrice = "0";
			while($RowQ1 = Fetch($RQ1)){
				$BarcodeSerial = $RowQ1["BarcodeSerial"];
				$InPrice = $RowQ1["Price"];
				$FinalPrice = $FinalPrice + $InPrice;
				# GET IF THIS PRODUCT IS OUT OR NOT
				$Q2 = "SELECT Price FROM productmovementinsertion_details WHERE FromCounter = '$CounterToken' AND BarcodeSerial = '$BarcodeSerial' AND WorkFlowStatus = '3' AND Existence = '1'";
				$RQ2 = RunQuery($Q2);
				$NRQ2 = mysqli_num_rows($RQ2);
				if ($NRQ2 != 0) {
				    $FinalPrice = $FinalPrice - $InPrice;
				}
			}
			return $FinalPrice;
	}
	function CustomerPhoneNumberByPMLToken($PMLToken){
		$Q = "SELECT CustomerPhone FROM salescustomerlist_info WHERE PMLToken = '$PMLToken'";
		$RQ = RunQuery($Q);
		$Row = Fetch($RQ);
		$CustomerPhone = $Row["CustomerPhone"];
		return $CustomerPhone;
	}
	function TotalInInvoiceByPMLToken($PMLToken){
		$Q = "SELECT SUM(Price) AS TotalPrice FROM productmovementinsertion_details WHERE PMLToken = '$PMLToken' AND WorkFlowStatus = '3' AND Existence = '1'";
		$RQ = RunQuery($Q);
		$RowQ = Fetch($RQ);
		$TotalPrice = $RowQ["TotalPrice"];
		if ($TotalPrice == NULL) {
			$TotalPrice = 0;
			return $TotalPrice;
		}
		else{
			return $TotalPrice;
		}
	}
	function TotalPaidInInvoiceByPMLToken($PMLToken){
		$Q = "SELECT SUM(Amount) AS TotalAmount FROM transactiondetails_info WHERE Reference = '$PMLToken'AND Existence = '1'";
		$RQ = RunQuery($Q);
		$RowQ = Fetch($RQ);
		$TotalAmount = $RowQ["TotalAmount"];
		if ($TotalAmount == NULL) {
			$TotalAmount = 0;
			return $TotalAmount;
		}
		else{
			return $TotalAmount;
		}
	}
?>