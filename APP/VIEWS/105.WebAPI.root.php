<?php
	if (!isset($_SESSION["LOGGED_IN"])) {
		//header("Location: $LoginPage");
	}
	else{
		if (isset($_POST["Request"])) {
			if (!empty($_POST["Request"])) {
				$Request= $_POST["Request"];
				$UserToken= $_POST["UserToken"];
				$BusinessToken= $_POST["BusinessToken"];
				$Rank= $_POST["Rank"];
				$SubRank= $_POST["SubRank"];
				if (1 == 1) {
					# PRODUCT INSERTION
					if ($Request == "AddNewProduct") {
						$ProductTitle = $_POST["ProductTitle"];
						$Q = 	"
										INSERT INTO productgroup_info
										(ProductTitle, BusinessToken, UserToken, Existence, Suspension, BDDT)
										VALUES
										('$ProductTitle', '$BusinessToken', '$UserToken', '1', '0', '$BDDT')
									";
						$RQ = RunQuery($Q);
						$PGID = InsertedID($DBCON);
						$Initial = "52";
						$ProductToken = "$Initial$BusinessToken$BDDATEPLAIN$PGID";
						$UQ = "UPDATE productgroup_info SET ProductToken = '$ProductToken' WHERE PGID = '$PGID'";
						$RUQ = RunQuery($UQ);
					}
					# SHOW PRODUCT LIST
					elseif ($Request == "ShowProductList") {
						$Q = "SELECT * FROM productgroup_info WHERE BusinessToken = '$BusinessToken' AND Existence = '1' ORDER BY PGID DESC";
						$RQ = RunQuery($Q);
						$SL = 1;
						echo "<thead class='bg-success text-white'>";
							echo "<tr>";
								echo "<th>#</th>";
								echo "<th>Product</th>";
								echo "<th>Edit</th>";
								echo "<th>Suspend</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						while ($Row = Fetch($RQ)) {
							$ProductToken = $Row["ProductToken"];
							$ProductTitle = $Row["ProductTitle"];
							$UserToken = $Row["UserToken"];
							$Suspension = $Row["Suspension"];
							echo "<tr>";
								echo "<th scope='row'>$SL</th>";
								echo "<td>$ProductTitle</td>";
								echo "<td><button class='EditProduct btn btn-info waves-effect waves-light' id='$ProductToken'>EDIT</button></td>";
								echo "<td><button class='SuspendProduct btn btn-warning waves-effect waves-light' id='$ProductToken'>Suspend</button></td>";
							echo "</tr>";
							$SL++;
						}
						echo "<tbody>";
					}
					# SHOW PML LIST
					elseif ($Request == "LoadAllPML") {
						$PMLType = $_POST["PMLType"];
						$FromCounter = $_POST["FromCounter"];
						$ToCounter = $_POST["ToCounter"];
						if ($PMLType == '1') {
							$Q = "SELECT * FROM productmovementlist_log WHERE BusinessToken = '$BusinessToken' AND FromCounter = '$FromCounter' AND PMLType = '$PMLType' AND  Existence = '1' ORDER BY PMLID DESC";
							$RQ = RunQuery($Q);
							$SL = 1;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Title</th>";
									echo "<th>Total</th>";
									echo "<th>Status</th>";
									echo "<th>Action</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMLToken = $Row["PMLToken"];
								$PMLTitle = $Row["PMLTitle"];
								$ToCounter = $Row["ToCounter"];
								$WorkFlowStatus = $Row["WorkFlowStatus"];
								$BDDT = $Row["BDDT"];
								$EntryDate = BDDATE($BDDT);
								$TotalInPML = TotalIndividualsInPML($PMLToken);
								if ($WorkFlowStatus == '1') {
									$WFS = "Saved";
								}
								elseif ($WorkFlowStatus == '2') {
									$WFS = "Sent";
								}
								elseif ($WorkFlowStatus == '3') {
									$WFS = "Locked";
								}
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$EntryDate</td>";
									echo "<td>$PMLTitle</td>";
									echo "<td><button class='Units btn btn-danger waves-effect waves-light btn-block'>$TotalInPML</button></td>";
									echo "<td><button class='btn btn-info waves-effect waves-light'>$WFS</button></td>";
									echo "<td><a href = 'index.php?p=business&m=10400&PMLToken=$PMLToken' class='btn btn-success waves-effect waves-light' id='$PMLToken'>View</a></td>";
								echo "</tr>";
								$SL++;
							}
							echo "<tr>";
									echo "<th></th>"; 
									echo "<th></th>";
									echo "<th></th>";
									echo "<th><button class='btn btn-danger waves-effect waves-light btn-block' id='TotalBox'></button></th>";
									echo "<th></th>";
									echo "<th></th>";
								echo "</tr>";
							echo "<tbody>";
						}
						elseif ($PMLType == '2') {
							$Q = "SELECT * FROM productmovementlist_log WHERE BusinessToken = '$BusinessToken' AND FromCounter = '$FromCounter' AND ToCounter = '$ToCounter' AND PMLType = '$PMLType' AND  Existence = '1' ORDER BY PMLID DESC";
							$RQ = RunQuery($Q);
							$SL = 1;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Title</th>";
									echo "<th>Total</th>";
									echo "<th>Status</th>";
									echo "<th>Action</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMLToken = $Row["PMLToken"];
								$PMLTitle = $Row["PMLTitle"];
								$ToCounter = $Row["ToCounter"];
								$WorkFlowStatus = $Row["WorkFlowStatus"];
								$BDDT = $Row["BDDT"];
								$EntryDate = BDDATE($BDDT);
								$TotalInPML = TotalIndividualsInPML($PMLToken);
								if ($WorkFlowStatus == '1') {
									$WFS = "Saved";
								}
								elseif ($WorkFlowStatus == '2') {
									$WFS = "Sent";
								}
								elseif ($WorkFlowStatus == '3') {
									$WFS = "Locked";
								}
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$EntryDate</td>";
									echo "<td>$PMLTitle</td>";
									echo "<td><button class='Units btn btn-danger waves-effect waves-light btn-block'>$TotalInPML</button></td>";
									echo "<td><button class='btn btn-info waves-effect waves-light'>$WFS</button></td>";
									echo "<td><a href = 'index.php?p=business&m=10400&PMLToken=$PMLToken' class='btn btn-success waves-effect waves-light' id='$PMLToken'>View</a></td>";
								echo "</tr>";
								$SL++;
							}
							echo "<tr>";
									echo "<th></th>"; 
									echo "<th></th>";
									echo "<th></th>";
									echo "<th><button class='btn btn-danger waves-effect waves-light btn-block' id='TotalBox'></button></th>";
									echo "<th></th>";
									echo "<th></th>";
								echo "</tr>";
							echo "<tbody>";
						}
						elseif ($PMLType == '3') {
							$Q = "SELECT * FROM productmovementlist_log WHERE BusinessToken = '$BusinessToken' AND FromCounter = '$FromCounter' AND ToCounter = '$ToCounter' AND PMLType = '$PMLType' AND  Existence = '1' ORDER BY PMLID DESC";
							$RQ = RunQuery($Q);
							$NumRows = NumRows($RQ);
							$SL = $NumRows;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Invoice</th>";
									echo "<th>Title</th>";
									echo "<th>Phone</th>";
									echo "<th>Total</th>";
									echo "<th>Status</th>";
									echo "<th>Action</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMLToken = $Row["PMLToken"];
								$PMLTitle = $Row["PMLTitle"];
								$ToCounter = $Row["ToCounter"];
								$WorkFlowStatus = $Row["WorkFlowStatus"];
								$BDDT = $Row["BDDT"];
								$EntryDate = BDDATE($BDDT);
								$CustomerPhone = CustomerPhoneNumberByPMLToken($PMLToken);
								$InvoiceNumber = InvoiceNumberByPMLToken($PMLToken);
								$TotalInPML = TotalIndividualsInPML($PMLToken);
								if ($WorkFlowStatus == '1') {
									$WFS = "Saved";
								}
								elseif ($WorkFlowStatus == '2') {
									$WFS = "Sent";
								}
								elseif ($WorkFlowStatus == '3') {
									$WFS = "Locked";
								}
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$EntryDate</td>";
									echo "<td><b>#$InvoiceNumber</b></td>";
									echo "<td>$PMLTitle</td>";
									echo "<td>$CustomerPhone</td>";
									echo "<td><button class='Units btn btn-danger waves-effect waves-light btn-block'>$TotalInPML</button></td>";
									echo "<td><button class='btn btn-info waves-effect waves-light'>$WFS</button></td>";
									echo "<td><a href = 'index.php?p=business&m=10400&PMLToken=$PMLToken' class='btn btn-success waves-effect waves-light' id='$PMLToken'>View</a></td>";
								echo "</tr>";
								$SL--;
							}
							echo "<tr>";
									echo "<th></th>"; 
									echo "<th></th>";
									echo "<th></th>";
									echo "<th></th>";
									echo "<th></th>";
									echo "<th><button class='btn btn-danger waves-effect waves-light btn-block' id='TotalBox'></button></th>";
									echo "<th></th>";
									echo "<th></th>";
								echo "</tr>";
							echo "<tbody>";
						}


						
					}
					# PML INSERTION
					if ($Request == "AddNewPML") {
						$FromCounter = $_POST["FromCounter"];
						$ToCounter = $_POST["ToCounter"];
						$PMLTitle = $_POST["PMLTitle"];
						$PMLType = $_POST["PMLType"];
						$WorkFlowStatus = '1';
						$Proceed = 1;
						if ($Proceed == 1) {
							$Q = 	"
										INSERT INTO productmovementlist_log
										(PMLTitle, PMLType, WorkFlowStatus, BusinessToken, FromCounter, ToCounter, UserToken, Existence, BDDT)
										VALUES
										('$PMLTitle', '$PMLType', '$WorkFlowStatus', '$BusinessToken', '$FromCounter', '$ToCounter','$UserToken','1', '$BDDT')
									";
							$RQ = RunQuery($Q);
							$PMLID = InsertedID($DBCON);
							if ($PMLType == 1) {
								# Warehouse Purchase
								$Initial = "61";
							}
							elseif ($PMLType == 2) {
								# Transfer From Warehouse To Counter
								$Initial = "62";
							}
							elseif ($PMLType == 3) {
								# Sales
								$Initial = "63";
							}
							
							$PMLToken = "$Initial$BusinessToken$BDDATEPLAIN$PMLID";
							$UQ = "UPDATE productmovementlist_log SET PMLToken = '$PMLToken' WHERE PMLID = '$PMLID'";
							$RUQ = RunQuery($UQ);
							if ($PMLType == 3) {
								$QIX = "
												INSERT INTO salesinvoicelist_log 
												(BusinessToken, CounterToken, PMLToken, UserToken, BDDT) 
												VALUES 
												('$BusinessToken', '$FromCounter', '$PMLToken', '$UserToken', '$BDDT')
											";
								$RQI = mysqli_query($DBCON, $QIX);
								
								$SILID = InsertedID($DBCON);
								$Initial = BDDATEFORINVOICENUMBER($BDDT);
								$Rand = mt_rand(10,100);
								$InvoiceNumber = "$Initial$SILID";
								$UQI = "UPDATE salesinvoicelist_log SET InvoiceNumber = '$InvoiceNumber' WHERE SILID = '$SILID'";
								$RUQI = RunQuery($UQI);
								$QIXX = "
												INSERT INTO salescustomerlist_info 
												(BusinessToken, CounterToken, PMLToken, InvoiceNumber, UserToken, BDDT) 
												VALUES 
												('$BusinessToken', '$FromCounter', '$PMLToken', '$InvoiceNumber', '$UserToken', '$BDDT')
											";
								$RQI = mysqli_query($DBCON, $QIXX);
								# ADD TRANSACTION LOG
								$QTL = "INSERT INTO transactionlist_log 
												(BusinessToken, Reference, ReferenceType, CounterToken, TransactionTitle, UserToken, WorkFlowStatus, Existence, BDDT) 
												VALUES 
												('$BusinessToken', '$PMLToken', '1', '$FromCounter', 'Sales : $InvoiceNumber', '$UserToken', '1', '1', '$BDDT')";
								$RQTL = RunQuery($QTL);
								$TLID = InsertedID($DBCON);
								$TLInit = '9910';
								$TransactionToken = "$TLInit$BusinessToken$TLID";
								$QTLU = "UPDATE transactionlist_log SET TransactionToken = '$TransactionToken' WHERE TLID = '$TLID'";
								$RQTLU = RunQuery($QTLU);



								$RURL = "$ROOTURL/index.php?p=business&m=10400&PMLToken=$PMLToken";
								echo $RURL;
							}
							else{
								return "Successfully New Entry Generated";
							}
						}
					}
					# PRODUCT INSERTION IN WAREHOUSE PURCHASE
					if ($Request == "AddNewInProductLoaderWarehousePurchase") {
						$FromCounter = $_POST["FromCounter"];
						$ToCounter = $_POST["ToCounter"];
						$PMLToken = $_POST["PMLToken"];
						$PMLType = $_POST["PMLType"];
						$ProductToken = $_POST["ProductToken"];
						$PurchasePrice = $_POST["PurchasePrice"];
						$Proceed = 1;
						if ($Proceed == 1) {
							$Q = 	"
										INSERT INTO productmovementproductlist_info
										(ProductToken, Price, PMLToken, PMLType, BusinessToken, CounterToken, UserToken, Existence, BDDT)
										VALUES
										('$ProductToken', '$PurchasePrice', '$PMLToken', '$PMLType', '$BusinessToken', '$ToCounter','$UserToken', '1', '$BDDT')
									";
							$RQ = RunQuery($Q);
							$PMPLID = InsertedID($DBCON);
							$Initial = "521";
							$SingleProductToken = "$Initial$ProductToken$BDDATEPLAIN$PMPLID";
							$UQ = "UPDATE productmovementproductlist_info SET SingleProductToken = '$SingleProductToken' WHERE PMPLID = '$PMPLID'";
							$RUQ = RunQuery($UQ);
						}
					}
					# PRODUCT SELECTOR
					elseif($Request == "LoadProductSelector"){
						$PMLType = $_POST["PMLType"];
						$WorkFlowStatus = $_POST["WorkFlowStatus"];
						if ($PMLType == 1) {
							if ($WorkFlowStatus == 1) {
								echo "<div class='form-group'>";
									echo "<label>SELECT PRODUCT</label>";
									echo "<select class='form-control js-example-basic-single' id='ProductToken' required>";
									$PTQ = "SELECT * FROM productgroup_info WHERE Existence = '1' AND Suspension = '0'";
                  $RPTQ = RunQuery($PTQ);
                  	while ($RowPTQ = Fetch($RPTQ)) {
                    	$ProductToken = $RowPTQ["ProductToken"];
                    	$ProductTitle = $RowPTQ["ProductTitle"];
                    	echo "<option value='$ProductToken'>$ProductTitle</option>";
                  	}
									echo "</select>";
								echo "</div>";

								echo "<div class='form-group'>";
									echo "<label>Purchase Price</label>";
									echo "<input type='text' class='form-control' id='PurchasePrice'>";
								echo "</div>";
							}
							else{
								echo "
											<div class='alert alert-danger alert-dismissible fade show' role='alert'>
 												<strong>This Purchase Is Locked | </strong> You Can Not Edit This.
											</div>
								";
							}
						}
						elseif ($PMLType == 2) {
							if ($WorkFlowStatus == 1) {
								echo "<div class='form-group'>";
									echo "<label>SELECT PRODUCT</label>";
									echo "<select class='form-control js-example-basic-single' id='ProductToken' required>";
									$PTQ = "SELECT * FROM productgroup_info WHERE Existence = '1' AND Suspension = '0'";
                  $RPTQ = RunQuery($PTQ);
                  	while ($RowPTQ = Fetch($RPTQ)) {
                    	$ProductToken = $RowPTQ["ProductToken"];
                    	$ProductTitle = $RowPTQ["ProductTitle"];
                    	echo "<option value='$ProductToken'>$ProductTitle</option>";
                  	}
									echo "</select>";
								echo "</div>";

								echo "<div class='form-group'>";
									echo "<label>Sale Price</label>";
									echo "<input type='text' class='form-control' id='PurchasePrice'>";
								echo "</div>";

							}
							else{
								echo "
											<div class='alert alert-danger alert-dismissible fade show' role='alert'>
 												<strong>This Purchase Is Locked | </strong> You Can Not Edit This.
											</div>
								";
							}
							
						
						}
						elseif ($PMLType == 4) {
							if ($WorkFlowStatus == 1) {
								echo "<div class='form-group'>";
									echo "<label>SELECT PRODUCT</label>";
									echo "<select class='form-control js-example-basic-single' id='ProductToken' required>";
									$PTQ = "SELECT * FROM productgroup_info WHERE Existence = '1' AND Suspension = '0'";
                  $RPTQ = RunQuery($PTQ);
                  	while ($RowPTQ = Fetch($RPTQ)) {
                    	$ProductToken = $RowPTQ["ProductToken"];
                    	$ProductTitle = $RowPTQ["ProductTitle"];
                    	echo "<option value='$ProductToken'>$ProductTitle</option>";
                  	}
									echo "</select>";
								echo "</div>";

								echo "<div class='form-group'>";
									echo "<label>Sale Price</label>";
									echo "<input type='text' class='form-control' id='PurchasePrice'>";
								echo "</div>";

							}
							else{
								echo "
											<div class='alert alert-danger alert-dismissible fade show' role='alert'>
 												<strong>This Purchase Is Locked | </strong> You Can Not Edit This.
											</div>
								";
							}
							
						
						}
					}
					# SHOW PRODUCT LIST
					elseif ($Request == "LoadAllProductsInLoaderWarehousePurchase") {
						$PMLToken = $_POST["PMLToken"];
						$FromCounter = $_POST["FromCounter"];
						$ToCounter = $_POST["ToCounter"];
						$WorkFlowStatus = $_POST["WorkFlowStatus"];
						$Q = "SELECT * FROM productmovementproductlist_info WHERE PMLToken = '$PMLToken' AND  Existence = '1' ORDER BY PMPLID DESC";
						$RQ = RunQuery($Q);
						$SL = 1;
						echo "<thead class='bg-success text-white'>";
							echo "<tr>";
								echo "<th>#</th>";
								echo "<th>Title</th>";
								echo "<th>Total</th>";
								echo "<th>Price</th>";
								echo "<th>Details</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						while ($Row = Fetch($RQ)) {
							$SingleProductToken = $Row["SingleProductToken"];
							$ProductToken = $Row["ProductToken"];
							$ProductTitle = ProductTitle($ProductToken);
							$PurchasePrice = $Row["Price"];
							$SingleProductTotal = SingleProductTotal($SingleProductToken);
							echo "<tr>";
								echo "<th scope='row'>$SL</th>";
								echo "<td>$ProductTitle</td>";
								echo "<td><button class='btn btn-danger waves-effect waves-light'>$SingleProductTotal</button></td>";
								echo "<td>$PurchasePrice</td>";
								echo "<td><button class='LoaderExpander btn btn-info waves-effect waves-light' id='$SingleProductToken'>View</button></td>";
							echo "</tr>";
							$SL++; 
						}
						echo "<tbody>";
					}
					# SHOW INDIVIDUAL LIST IN LOADER EXPANDER
					elseif ($Request == "LoadAllProductsInLoaderExpander") {
						$SingleProductToken = $_POST["SingleProductToken"];
						$PMLType = $_POST["PMLType"];
						$WorkFlowStatus = $_POST["WorkFlowStatus"];
						$Q = "SELECT * FROM productmovementinsertion_details WHERE SingleProductToken = '$SingleProductToken' AND  Existence = '1' ORDER BY PMIID DESC";
						$RQ = RunQuery($Q);
						$NumRows = NumRows($RQ);
						$SL = $NumRows;
						if ($WorkFlowStatus == 3) {
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Code</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMIID = $Row["PMIID"];
								$BarcodeSerial = $Row["BarcodeSerial"];
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td><a class='btn btn-info' href = 'index.php?p=business&m=10422&BS=$BarcodeSerial'>$BarcodeSerial</a></td>";
								echo "</tr>";
								$SL--;
							}
							echo "<tbody>";
						}
						else{
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Code</th>";
									echo "<th>X</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMIID = $Row["PMIID"];
								$BarcodeSerial = $Row["BarcodeSerial"];
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td><a class='btn btn-info' href = 'index.php?p=business&m=10422&BS=$BarcodeSerial'>$BarcodeSerial</a></td>";
									echo "<td><button class='LoaderExpanderDeleter btn btn-danger waves-effect waves-light' id='$PMIID'>X</button></td>";
								echo "</tr>";
								$SL--;
							}
							echo "</tbody>";
						}
					}
					# PRODUCT TITLE IN PRODUCT LOADER
					elseif ($Request == "ProductTitleInLoaderExpander") {
						$SingleProductToken = $_POST["SingleProductToken"];
						$ProductToken = ProductTokenBySingleProductToken($SingleProductToken);
						$ProductTitle = ProductTitle($ProductToken);
						echo $ProductTitle;
					}
					# Warehouse Purchase Send Barcode Data
					elseif($Request == "WarehousePurchaseSendBarcodeData"){
						$SingleProductToken = $_POST["SingleProductToken"];
						$PMLType = $_POST["PMLType"];
						$BarcodeSerial = $_POST["BarcodeSerial"];
						$FromCounter = $_POST["FromCounter"];
						$ToCounter = $_POST["ToCounter"];
						if ($PMLType == 2) {
							if (BarcodeExistsInSource($BarcodeSerial, $FromCounter, $PMLType)) {
								if (BarcodeExistsInDestination($BarcodeSerial, $ToCounter, $PMLType) == FALSE) {
									if (BarcodeExistsInSamePMLType($BarcodeSerial, $PMLType) == FALSE) {
										$GQ = "SELECT * FROM productmovementproductlist_info WHERE SingleProductToken = '$SingleProductToken' AND Existence = '1'";
										$RGQ = RunQuery($GQ);
										$Row = Fetch($RGQ);
										$PMLToken = $Row["PMLToken"];
										$PMLType = $Row["PMLType"];
										$NewProductToken = $Row["ProductToken"];
										$RootProductToken = RootProductToken($BarcodeSerial);
										$Price = $Row["Price"];
										if ($NewProductToken == $RootProductToken) {
											$IQ = "
															INSERT INTO productmovementinsertion_details
															(
																PMLToken,
																PMLType,
																BusinessToken,
																FromCounter,
																ToCounter,
																SingleProductToken,
																ProductToken,
																BarcodeSerial,
																Price,
																WorkFlowStatus,
																UserToken,
																Existence,
																BDDT
															)
															VALUES
															(
																'$PMLToken',
																'$PMLType',
																'$BusinessToken',
																'$FromCounter',
																'$ToCounter',
																'$SingleProductToken',
																'$NewProductToken',
																'$BarcodeSerial',
																'$Price',
																'3',
																'$UserToken',
																'1',
																'$BDDT'
															)
														";
												$RIQ = RunQuery($IQ);
												if ($IQ == TRUE) {
													# BARCODE EXISTS IN SAME PML TYPE
													echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          					<span aria-hidden='true'>&times;</span>
                        					</button>
                        					<strong>Barcode Inserted</strong> 
                      					</div>";
												}
												else{
													# FATAL ERROR
													echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          					<span aria-hidden='true'>&times;</span>
                        					</button>
                        					<strong>System Error. Contact The Developer</strong> 
                      					</div>";
												}
										}
										else{
											# BARCODE EXISTS IN SAME PML TYPE
											echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          			<span aria-hidden='true'>&times;</span>
                        			</button>
                        			<strong>Product Group Did Not Match</strong> 
                      			</div>";
										}
									}
									else{
										# BARCODE EXISTS IN SAME PML TYPE
										echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        	<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          	<span aria-hidden='true'>&times;</span>
                        	</button>
                        	<strong>Already Transported</strong> 
                      	</div>";
									}
								}
								else{
									# BARCODE ALREADY EXISTS IN DESTINATION
									echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        	<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          	<span aria-hidden='true'>&times;</span>
                        	</button>
                        	<strong>Already Exists In Destination</strong> 
                      	</div>";
								}
							}
							else{
								# BARCODE DOESN'T EXIST IN SOURCE
								echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                        <strong>Doesn't Exist In Source</strong> 
                      </div>";
							}
						}
						elseif ($PMLType == 4) {
							if (BarcodeExistsInSource($BarcodeSerial, $FromCounter, $PMLType)) {
								$GQ = "SELECT * FROM productmovementproductlist_info WHERE SingleProductToken = '$SingleProductToken' AND Existence = '1'";
								$RGQ = RunQuery($GQ);
								$Row = Fetch($RGQ);
								$PMLToken = $Row["PMLToken"];
								$PMLType = $Row["PMLType"];
								$ProductToken = $Row["ProductToken"];
								$Price = $Row["Price"];
								$IQ = "
												INSERT INTO productmovementinsertion_details
												(
													PMLToken,
													PMLType,
													BusinessToken,
													FromCounter,
													ToCounter,
													SingleProductToken,
													ProductToken,
													BarcodeSerial,
													Price,
													WorkFlowStatus,
													UserToken,
													Existence,
													BDDT
												)
												VALUES
												(
													'$PMLToken',
													'$PMLType',
													'$BusinessToken',
													'$FromCounter',
													'$ToCounter',
													'$SingleProductToken',
													'$ProductToken',
													'$BarcodeSerial',
													'$Price',
													'3',
													'$UserToken',
													'1',
													'$BDDT'
												)
											";
								$RIQ = RunQuery($IQ);
							}
							else{
								# BARCODE DOESN'T EXIST IN SOURCE
								echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                        <strong>Doesn't Exist In Source</strong> 
                      </div>";
							}
						}
						elseif ($PMLType == 3) {
							# CHECK IF PRODUCT EXISTS IN RESOURCE & DESTINATION COUNTER
							if (BarcodeExistsInSource($BarcodeSerial, $FromCounter, $PMLType)) {
								# GET PRODUCT TOKEN BY BARCODE FROM INSERTION DETAILS
								$SPTQ = "SELECT ProductToken FROM productmovementinsertion_details WHERE BarcodeSerial = '$BarcodeSerial' AND ToCounter = '$FromCounter' AND WorkFlowStatus = '3' AND Existence = '1'";
								$RSPTQ = RunQuery($SPTQ);
								$RowSPTQ = Fetch($RSPTQ);
								$ProductToken = $RowSPTQ["ProductToken"];
								$PMLToken = $_POST["PMLToken"];
								$Price = $_POST["Price"];
								# INSERT NEW SINGLE PRODUCT TOKEN
								$SPTQI = 	"	INSERT INTO
														productmovementproductlist_info
														(
															BusinessToken,
															CounterToken,
															PMLToken,
															PMLType,
															SingleProductToken,
															ProductToken,
															Price,
															UserToken,
															BDDT,
															Existence
														)
														VALUES
														(
															'$BusinessToken',
															'$ToCounter',
															'$PMLToken',
															'$PMLType',
															'$SingleProductToken',
															'$ProductToken',
															'$Price',
															'$UserToken',
															'$BDDT',
															'1'
														)

													";
								$RSPTQI = RunQuery($SPTQI);
								if ($RSPTQI == TRUE) {
									$IQ = "
												INSERT INTO productmovementinsertion_details
												(
													PMLToken,
													PMLType,
													BusinessToken,
													FromCounter,
													ToCounter,
													SingleProductToken,
													ProductToken,
													BarcodeSerial,
													Price,
													WorkFlowStatus,
													UserToken,
													Existence,
													BDDT
												)
												VALUES
												(
													'$PMLToken',
													'$PMLType',
													'$BusinessToken',
													'$FromCounter',
													'$ToCounter',
													'$SingleProductToken',
													'$ProductToken',
													'$BarcodeSerial',
													'$Price',
													'3',
													'$UserToken',
													'1',
													'$BDDT'
												)
											";
									$RIQ = RunQuery($IQ);
									if ($RIQ == TRUE) {
										echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        	<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          	<span aria-hidden='true'>&times;</span>
                        	</button>
                        	<strong>PRODUCT ENLISTED</strong> 
                      	</div>";
									}
									else{
										# FATAL ERROR
										echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        	<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          	<span aria-hidden='true'>&times;</span>
                        	</button>
                        	<strong>FATAL ERROR :: CONTACT TO THE DEVELOPER</strong> 
                      	</div>";
									}
								}
								else{
									# FATAL ERROR
									echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        	<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          	<span aria-hidden='true'>&times;</span>
                        	</button>
                        	<strong>FATAL ERROR :: CONTACT TO THE DEVELOPER</strong> 
                      	</div>";
								}
							}
							else{
								# BARCODE DOESN'T EXIST IN SOURCE
								echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                        <strong>Either This Product Doesn't Exist In Your Inventory Or Not Authenticated</strong> 
                      </div>";
							}
						}
						else{
							# PMLType 1
							if (BarcodeExistsInDestination($BarcodeSerial, $ToCounter, $PMLType) == FALSE) {
								if (BarcodeExistsInSamePMLType($BarcodeSerial, $PMLType) == FALSE) {
									$GQ = "SELECT * FROM productmovementproductlist_info WHERE SingleProductToken = '$SingleProductToken' AND Existence = '1'";
									$RGQ = RunQuery($GQ);
									$Row = Fetch($RGQ);
									$PMLToken = $Row["PMLToken"];
									$PMLType = $Row["PMLType"];
									$ProductToken = $Row["ProductToken"];
									$Price = $Row["Price"];
									if (BarcodeExistsInSamePML($PMLToken, $BarcodeSerial) == FALSE) {
										$IQ = "
											INSERT INTO productmovementinsertion_details
											(
												PMLToken,
												PMLType,
												BusinessToken,
												FromCounter,
												ToCounter,
												SingleProductToken,
												ProductToken,
												BarcodeSerial,
												Price,
												WorkFlowStatus,
												UserToken,
												Existence,
												BDDT
											)
											VALUES
											(
												'$PMLToken',
												'$PMLType',
												'$BusinessToken',
												'$FromCounter',
												'$ToCounter',
												'$SingleProductToken',
												'$ProductToken',
												'$BarcodeSerial',
												'$Price',
												'3',
												'$UserToken',
												'1',
												'$BDDT'
											)
										";
										$RIQ = RunQuery($IQ);
										if ($RIQ == TRUE) {
											# BARCODE ALREADY EXISTS IN THIS LIST
											echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          			<span aria-hidden='true'>&times;</span>
                        			</button>
                        			<strong>Barcode Inserted</strong> 
                      			</div>";
										}
										else{
											# BARCODE ALREADY EXISTS IN THIS LIST
											echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          			<span aria-hidden='true'>&times;</span>
                        			</button>
                        			<strong>Fatal Error. Contact The Developer</strong> 
                      			</div>";
										}
									}
									else{
										# BARCODE ALREADY EXISTS IN THIS LIST
										echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          		<span aria-hidden='true'>&times;</span>
                        		</button>
                        		<strong>Already In This List</strong> 
                      		</div>";
									}
								}
								else{
									# BARCODE ALREADY EXISTS IN DESTINATION
									echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        	<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          	<span aria-hidden='true'>&times;</span>
                        	</button>
                        	<strong>Already Purchased Before</strong> 
                      	</div>";
								}
							}
						  else{
						  	# BARCODE DOESN'T EXIST IN SOURCE
								echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                        <strong>Already In The Destination</strong> 
                      </div>";
						  }
							
						}
						# END OF SEND BARCODE DATA
					}
					# DELETE BARCODE INDIVIDUAL
					elseif ($Request == "DeleteBarcodeInLoaderExpander") {
						$DeleteID = $_POST["DeleteID"];
						$Q = "UPDATE productmovementinsertion_details SET Existence = '0' WHERE PMIID = '$DeleteID'";
						$RQ = RunQuery($Q);
					}
					# SHOW Counters In Transport
					elseif ($Request == "LoadAllSalesCounters") {
						$For = $_POST["For"];
						$Q = "SELECT * FROM counterlist_info WHERE BusinessToken = '$BusinessToken' AND  Existence = '1' AND CounterType = 'Sales' ORDER BY CLID DESC";
						$RQ = RunQuery($Q);
						$SL = 1;
						echo "<thead class='bg-success text-white'>";
							echo "<tr>";
								echo "<th>#</th>";
								echo "<th>Counter Name</th>";
								echo "<th>Action</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						while ($Row = Fetch($RQ)) {
							$CLID = $Row["CLID"];
							$CounterTitle = $Row["CounterTitle"];
							$CounterToken = $Row["CounterToken"];
							if ($For == "Transport") {
								$URL = "index.php?p=business&m=104331&ToCounter=$CounterToken";
							}
							elseif ($For == "Sales") {
								$URL = "index.php?p=business&m=104341&FromCounter=$CounterToken";
							}
							elseif ($For == "TransportListByCounter") {
								$URL = "index.php?p=business&m=104351&ToCounter=$CounterToken";
							}
							elseif ($For == "CounterWarehouse") {
								$URL = "index.php?p=business&m=104411&CounterToken=$CounterToken";
							}
							elseif ($For == "CTCInitiate") {
								$URL = "index.php?p=business&m=104361&CounterToken=$CounterToken";
							}
							elseif ($For == "SalesReportByDate") {
								$URL = "index.php?p=business&m=104511&CounterToken=$CounterToken";
							}
							elseif ($For == "DayClosing") {
								$URL = "index.php?p=business&m=1042011&CounterToken=$CounterToken";
							}
							elseif ($For == "CounterWarehouseHistory") {
								$URL = "index.php?p=business&m=1044211&CounterToken=$CounterToken";
							}
							if (CounterAccess($UserToken, $CounterToken) == TRUE) {
								echo "<tr>";
								echo "<th scope='row'>$SL</th>";
								echo "<td>$CounterTitle</td>";
								echo "<td><a href= '$URL' class='btn btn-warning waves-effect waves-light'>View</a></td>";
							echo "</tr>";
							$SL++;
							}
						}
						echo "<tbody>";
					}
					# UPDATE CUSTOMER INFO IN INVOICE
					elseif ($Request == "UpdateCustomerInfo") {
						$PMLToken = $_POST["PMLToken"];
						$CustomerName = $_POST["CustomerName"];
						$CustomerPhone = $_POST["CustomerPhone"];
						$CustomerAddress = $_POST["CustomerAddress"];
						$Q = mysqli_query($DBCON, "UPDATE salescustomerlist_info SET CustomerName = '$CustomerName', CustomerPhone = '$CustomerPhone', CustomerAddress = '$CustomerAddress' WHERE PMLToken = '$PMLToken'");
						$Q1 = mysqli_query($DBCON, "UPDATE productmovementlist_log SET PMLTitle = '$CustomerName' WHERE PMLToken = '$PMLToken'");
						/*if ($Q == TRUE) {
							echo "OK";
						}
						else{
							echo "NOT OK";
						}*/
					}
					# Lock Invoice
					elseif ($Request == "LockPML") {
						$PMLToken = $_POST["PMLToken"];
						$Q = "UPDATE productmovementlist_log SET WorkFlowStatus = '3' WHERE PMLToken = '$PMLToken'";
						$RQ = RunQuery($Q);
						if ($RQ == TRUE) {
							$Q1 = "UPDATE productmovementinsertion_details SET WorkFlowStatus = '3' WHERE PMLToken = '$PMLToken' AND Existence = '1'";
							$RQ1 = RunQuery($Q1);
							if ($RQ1 == TRUE) {
								
							}
						}
						
					}
					# Lock Invoice
					elseif ($Request == "LockInvoice") {
						$PMLToken = $_POST["PMLToken"];
						$CustomerPayable = $_POST["CustomerPayable"];
						$InvoiceTotal = $CustomerPayable;
						$PaidByCustomer = $_POST["PaidByCustomer"];
						$RestAmount = $_POST["RestAmount"];
						$Q = mysqli_query($DBCON, "UPDATE salesinvoicelist_log SET InvoiceTotal = '$InvoiceTotal' , PayableByCustomer = '$CustomerPayable', RestAmount = '$RestAmount', PaidByCustomer = '$PaidByCustomer' WHERE PMLToken = '$PMLToken'");
						/*if ($Q == TRUE) {
							echo "OK";
						}
						else{
							echo "NOT OK";
						}*/
					}
					# SHOW INDIVIDUAL LIST IN LOADER EXPANDER
					elseif ($Request == "LoadProductsInInvoice") {
						$PMLToken = $_POST["PMLToken"];
						$Q = "SELECT * FROM productmovementinsertion_details WHERE PMLToken = '$PMLToken' AND  Existence = '1' ORDER BY PMIID DESC";
						$RQ = RunQuery($Q);
						$SL = 1;
						echo "<thead class='bg-success text-white'>";
							echo "<tr>";
								echo "<th>#</th>";
								echo "<th>Title</th>";
								echo "<th>Code</th>";
								echo "<th>Sale Price</th>";
								echo "<th>X</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						while ($Row = Fetch($RQ)) {
							$PMIID = $Row["PMIID"];
							$BarcodeSerial = $Row["BarcodeSerial"];
							$ProductToken = $Row["ProductToken"];
							$Price = $Row["Price"];
							$ProductTitle = ProductTitle($ProductToken);
							echo "<tr>";
								echo "<th scope='row'>$SL</th>";
								echo "<td>$ProductTitle</td>";
								echo "<td><a class='btn btn-info' href = 'index.php?p=business&m=10422&BS=$BarcodeSerial'>$BarcodeSerial</a></td>";
								echo "<td class='InvoiceItemPrice'>$Price</td>";
								echo "<td><button class='InvoiceItemDeleter btn btn-danger waves-effect waves-light' id='$PMIID'>X</button></td>";
							echo "</tr>";
							$SL++;
						}
						echo "<tbody>";
					}
					# PRODUCT LIFE CYCLE LIST IN LOADER EXPANDER
					elseif ($Request == "LoadPLC") {
						$ProductToken = $_POST["ProductToken"];
						$ShowType = $_POST["ShowType"];
						if ($ShowType == 1) {
							$Q = "SELECT * FROM productmovementinsertion_details WHERE ProductToken = '$ProductToken' AND PMLType = '$ShowType' AND  Existence = '1' AND WorkFlowStatus = '3' AND BusinessToken = '$BusinessToken' ORDER BY PMIID DESC";
							$RQ = RunQuery($Q);
							$NumRows = NumRows($RQ);
							$SL = 1;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<td><button class='btn btn-danger btn-block'>$NumRows</button></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Title</th>";
									echo "<th>Code</th>";
									echo "<th>Price</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMIID = $Row["PMIID"];
								$BarcodeSerial = $Row["BarcodeSerial"];
								$PMLToken = $Row["PMLToken"];
								$Price = $Row["Price"];
								$DBBDDT = $Row["BDDT"];
								$DBBDDATE = BDDATE($DBBDDT);
								$PMLTitle = PMLTitle($PMLToken);
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$DBBDDATE</td>";
									echo "<td>$PMLTitle</td>";
									echo "<td>$BarcodeSerial</td>";
									echo "<td class='InvoiceItemPrice'>$Price</td>";
								echo "</tr>";
								$SL++;
							}
							
							echo "<tbody>";
						}
						elseif ($ShowType == 2) {
							$Q = "SELECT * FROM productmovementinsertion_details WHERE ProductToken = '$ProductToken' AND PMLType = '$ShowType' AND  Existence = '1' AND WorkFlowStatus = '3' AND BusinessToken = '$BusinessToken' ORDER BY PMIID DESC";
							$RQ = RunQuery($Q);
							$NumRows = NumRows($RQ);
							$SL = 1;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<td><button class='btn btn-danger btn-block'>$NumRows</button></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Title</th>";
									echo "<th>Code</th>";
									echo "<th>To</th>";
									echo "<th>Price</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMIID = $Row["PMIID"];
								$BarcodeSerial = $Row["BarcodeSerial"];
								$PMLToken = $Row["PMLToken"];
								$ToCounter = $Row["ToCounter"];
								$Price = $Row["Price"];
								$DBBDDT = $Row["BDDT"];
								$DBBDDATE = BDDATE($DBBDDT);
								$PMLTitle = PMLTitle($PMLToken);
								$CounterTitle = CounterTitle($ToCounter);
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$DBBDDATE</td>";
									echo "<td>$PMLTitle</td>";
									echo "<td>$BarcodeSerial</td>";
									echo "<td>$CounterTitle</td>";
									echo "<td class='InvoiceItemPrice'>$Price</td>";
								echo "</tr>";
								$SL++;
							}
							
							echo "<tbody>";
						}
						elseif ($ShowType == 3) {
							$Q = "SELECT * FROM productmovementinsertion_details WHERE ProductToken = '$ProductToken' AND PMLType = '$ShowType' AND  Existence = '1' AND WorkFlowStatus = '3' AND BusinessToken = '$BusinessToken' ORDER BY PMIID DESC";
							$RQ = RunQuery($Q);
							$NumRows = NumRows($RQ);
							$SL = 1;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<td><button class='btn btn-danger btn-block'>$NumRows</button></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Sold To</th>";
									echo "<th>Code</th>";
									echo "<th>From</th>";
									echo "<th>Price</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMIID = $Row["PMIID"];
								$BarcodeSerial = $Row["BarcodeSerial"];
								$PMLToken = $Row["PMLToken"];
								$FromCounter = $Row["FromCounter"];
								$Price = $Row["Price"];
								$DBBDDT = $Row["BDDT"];
								$DBBDDATE = BDDATE($DBBDDT);
								$PMLTitle = PMLTitle($PMLToken);
								$CounterTitle = CounterTitle($FromCounter);
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$DBBDDATE</td>";
									echo "<td>$PMLTitle</td>";
									echo "<td>$BarcodeSerial</td>";
									echo "<td>$CounterTitle</td>";
									echo "<td class='InvoiceItemPrice'>$Price</td>";
								echo "</tr>";
								$SL++;
							}
							
							echo "<tbody>";
						}
					}
					# PRODUCT LIFE CYCLE LIST 
					elseif ($Request == "LoadPLCInCounter") {
						$CounterToken = $_POST["CounterToken"];
						$ProductToken = $_POST["ProductToken"];
						$ShowType = $_POST["ShowType"];
						if ($ShowType == 2) {
							$Q = "SELECT * FROM productmovementinsertion_details WHERE ProductToken = '$ProductToken' AND PMLType = '$ShowType' AND  Existence = '1' AND WorkFlowStatus = '3' AND BusinessToken = '$BusinessToken' AND ToCounter = '$CounterToken' ORDER BY PMIID DESC";
							$RQ = RunQuery($Q);
							$NumRows = NumRows($RQ);
							$SL = 1;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<td><button class='btn btn-danger btn-block'>$NumRows</button></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Title</th>";
									echo "<th>Code</th>";
									echo "<th>Price</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMIID = $Row["PMIID"];
								$BarcodeSerial = $Row["BarcodeSerial"];
								$PMLToken = $Row["PMLToken"];
								$ToCounter = $Row["ToCounter"];
								$Price = $Row["Price"];
								$DBBDDT = $Row["BDDT"];
								$DBBDDATE = BDDATE($DBBDDT);
								$PMLTitle = PMLTitle($PMLToken);
								$CounterTitle = CounterTitle($ToCounter);
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$DBBDDATE</td>";
									echo "<td>$PMLTitle</td>";
									echo "<td>$BarcodeSerial</td>";
									echo "<td class='InvoiceItemPrice'>$Price</td>";
								echo "</tr>";
								$SL++;
							}
							
							echo "<tbody>";
						}
						elseif ($ShowType == 3) {
							$Q = "SELECT * FROM productmovementinsertion_details WHERE ProductToken = '$ProductToken' AND PMLType = '$ShowType' AND  Existence = '1' AND WorkFlowStatus = '3' AND BusinessToken = '$BusinessToken' AND FromCounter = '$CounterToken' ORDER BY PMIID DESC";
							$RQ = RunQuery($Q);
							$NumRows = NumRows($RQ);
							$SL = 1;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<td><button class='btn btn-danger btn-block'>$NumRows</button></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
								echo "</tr>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Sold To</th>";
									echo "<th>Code</th>";
									echo "<th>From</th>";
									echo "<th>Price</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMIID = $Row["PMIID"];
								$BarcodeSerial = $Row["BarcodeSerial"];
								$PMLToken = $Row["PMLToken"];
								$FromCounter = $Row["FromCounter"];
								$Price = $Row["Price"];
								$DBBDDT = $Row["BDDT"];
								$DBBDDATE = BDDATE($DBBDDT);
								$PMLTitle = PMLTitle($PMLToken);
								$CounterTitle = CounterTitle($FromCounter);
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$DBBDDATE</td>";
									echo "<td>$PMLTitle</td>";
									echo "<td>$BarcodeSerial</td>";
									echo "<td>$CounterTitle</td>";
									echo "<td class='InvoiceItemPrice'>$Price</td>";
								echo "</tr>";
								$SL++;
							}
							
							echo "<tbody>";
						}
					}
					# SHOW INDIVIDUAL LIST IN LOADER EXPANDER
					elseif ($Request == "LoadBarcodeLocation") {
						$BarcodeSerial = $_POST["BarcodeSerial"];
						if ($SubRank == 1031 || $SubRank == 1032) {
							$Q = "SELECT * FROM productmovementinsertion_details WHERE BusinessToken = '$BusinessToken' AND BarcodeSerial = '$BarcodeSerial' AND  Existence = '1' ORDER BY PMIID";
							echo "$Q";
							$RQ = RunQuery($Q);
							$SL = 1;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Title</th>";
									echo "<th>Type</th>";
									echo "<th>Product</th>";
									echo "<th>SPT</th>";
									echo "<th>From</th>";
									echo "<th>To</th>";
									echo "<th>Price</th>";
									echo "<th>WFS</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMIID = $Row["PMIID"];
								$PMLType = $Row["PMLType"];
								$FromCounter = $Row["FromCounter"];
								$ToCounter = $Row["ToCounter"];
								$SingleProductToken = $Row["SingleProductToken"];
								$ProductToken = $Row["ProductToken"];
								$PMLToken = $Row["PMLToken"];
								$Price = $Row["Price"];
								$WorkFlowStatus = $Row["WorkFlowStatus"];
								$UserToken = $Row["UserToken"];
								$BDDT = $Row["BDDT"];
								$BDDATE = BDDATE($BDDT);
								$ProductTitle = ProductTitle($ProductToken);
								$PMLTitle = PMLTitle($PMLToken);
								if ($PMLType == 1) {
									$PMLType = 'Purchase';
								}
								elseif ($PMLType == 2) {
									$PMLType = 'Transfer';
								}
								elseif ($PMLType == 3) {
									$PMLType = 'Sales';
								}
								elseif ($PMLType == 4) {
									$PMLType = 'CTC Transfer';
								}

								if ($WorkFlowStatus == 1) {
									$WFS = "Saved";
								}
								elseif ($WorkFlowStatus == 3) {
									$WFS = "Locked";
								}

								if ($FromCounter == 'Purchase') {
									$FromCounter = "Purchase";
								}
								else{
									$FromCounter = CounterTitle($FromCounter);
								}
								
								if ($ToCounter == 'Sales') {
									$ToCounter = 'Sales';
								}
								else{
									$ToCounter = CounterTitle($ToCounter);
								}
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$BDDATE</td>";
									echo "<td><a class='btn btn-info waves-effect waves-light' href='index.php?p=business&m=10400&PMLToken=$PMLToken'>$PMLTitle</a></td>";
									echo "<td>$PMLType</td>";
									echo "<td>$ProductTitle</td>";
									echo "<td>$SingleProductToken</td>";
									echo "<td>$FromCounter</td>";
									echo "<td>$ToCounter</td>";
									echo "<td>$Price</td>";
									echo "<td>$WFS</td>";
									
								echo "</tr>";
								$SL++;
							}
							echo "<tbody>";
						}
						elseif ($SubRank == 1033) {
							$Q = "SELECT * FROM productmovementinsertion_details WHERE BusinessToken = '$BusinessToken' AND PMLType != '1' AND BarcodeSerial = '$BarcodeSerial' AND  Existence = '1' ORDER BY PMIID";
							echo "$Q";
							$RQ = RunQuery($Q);
							$SL = 1;
							echo "<thead class='bg-success text-white'>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Date</th>";
									echo "<th>Title</th>";
									echo "<th>Type</th>";
									echo "<th>Product</th>";
									echo "<th>SPT</th>";
									echo "<th>From</th>";
									echo "<th>To</th>";
									echo "<th>Price</th>";
									echo "<th>WFS</th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
							while ($Row = Fetch($RQ)) {
								$PMIID = $Row["PMIID"];
								$PMLType = $Row["PMLType"];
								$FromCounter = $Row["FromCounter"];
								$ToCounter = $Row["ToCounter"];
								$SingleProductToken = $Row["SingleProductToken"];
								$ProductToken = $Row["ProductToken"];
								$PMLToken = $Row["PMLToken"];
								$Price = $Row["Price"];
								$WorkFlowStatus = $Row["WorkFlowStatus"];
								$UserToken = $Row["UserToken"];
								$BDDT = $Row["BDDT"];
								$BDDATE = BDDATE($BDDT);
								$ProductTitle = ProductTitle($ProductToken);
								$PMLTitle = PMLTitle($PMLToken);
								if ($PMLType == 2) {
									$PMLType = 'Transfer';
								}
								elseif ($PMLType == 3) {
									$PMLType = 'Sales';
								}

								if ($WorkFlowStatus == 1) {
									$WFS = "Saved";
								}
								elseif ($WorkFlowStatus == 3) {
									$WFS = "Locked";
								}

								if ($ToCounter == 'Sales') {
									$ToCounter = 'Sales';
								}
								else{
									$ToCounter = CounterTitle($ToCounter);
								}
								
								echo "<tr>";
									echo "<th scope='row'>$SL</th>";
									echo "<td>$BDDATE</td>";
									echo "<td><a class='btn btn-info waves-effect waves-light' href='index.php?p=business&m=10400&PMLToken=$PMLToken'>$PMLTitle</a></td>";
									echo "<td>$PMLType</td>";
									echo "<td>$ProductTitle</td>";
									echo "<td>$SingleProductToken</td>";
									echo "<td>$FromCounter</td>";
									echo "<td>$ToCounter</td>";
									echo "<td>$Price</td>";
									echo "<td>$WFS</td>";
									
								echo "</tr>";
								$SL++;
							}
							echo "<tbody>";
						}	
					}
					# ADD NEW TGB
					if ($Request == "AddNewTGB") {
						$TGBTitle = $_POST["TGBTitle"];
						$Q = 	"
										INSERT INTO transactiongroupbook_info
										(BusinessToken, TGBTitle, UserToken, Existence, Suspension, BDDT)
										VALUES
										('$BusinessToken', '$TGBTitle', '$UserToken', '1', '0', '$BDDT')
									";
						$RQ = RunQuery($Q);
						$TGBID = InsertedID($DBCON);
						$Initial = "99";
						$TGBToken = "$Initial$BusinessToken$TGBID";
						$UQ = "UPDATE transactiongroupbook_info SET TGBToken = '$TGBToken' WHERE TGBID = '$TGBID'";
						$RUQ = RunQuery($UQ);
					}
					# SHOW ALL TGB
					elseif ($Request == "LoadAllTGB") {
						$Q = "SELECT * FROM transactiongroupbook_info WHERE BusinessToken = '$BusinessToken' AND Existence = '1' ORDER BY TGBID DESC";
						$RQ = RunQuery($Q);
						$SL = 1;
						echo "<thead class='bg-success text-white'>";
							echo "<tr>";
								echo "<th>#</th>";
								echo "<th>Title</th>";
								echo "<th>View</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						while ($Row = Fetch($RQ)) {
							$TGBToken = $Row["TGBToken"];
							$TGBTitle = $Row["TGBTitle"];
							$UserToken = $Row["UserToken"];
							$Suspension = $Row["Suspension"];
							echo "<tr>";
								echo "<th scope='row'>$SL</th>";
								echo "<td>$TGBTitle</td>";
								echo "<td><button class='Expander btn btn-info waves-effect waves-light' id='$TGBToken'>View</button></td>";
							echo "</tr>";
							$SL++;
						}
						echo "<tbody>";
					}
					# TGB Title In Expander
					elseif ($Request == "TGBTitleInExpander") {
						$TGBToken = $_POST["TGBToken"];
						$Q = "SELECT TGBTitle FROM transactiongroupbook_info WHERE TGBToken = '$TGBToken'";
						$RQ = RunQuery($Q);
						$RowQ = Fetch($RQ);
						$TGBTitle = $RowQ["TGBTitle"];
						
						echo $TGBTitle;
					}
					# SHOW ALL Transaction Methods
					elseif ($Request == "LoadAllMethodsInExpander") {
						$TGBToken = $_POST["TGBToken"];
						$Q = "SELECT * FROM transactionmethodlist_info WHERE BusinessToken = '$BusinessToken' AND TGBToken = '$TGBToken' AND Existence = '1'";
						$RQ = RunQuery($Q);
						$SL = 1;
						echo "<thead class='bg-success text-white'>";
							echo "<tr>";
								echo "<th>#</th>";
								echo "<th>Title</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						while ($Row = Fetch($RQ)) {
							$TMLTitle = $Row["TMLTitle"];
							$TMLToken = $Row["TMLToken"];
							echo "<tr>";
								echo "<th scope='row'>$SL</th>";
								echo "<td>$TMLTitle</td>";
							echo "</tr>";
							$SL++;
						}
						echo "<tbody>";
					}
					# ADD NEW Transaction Method
					elseif ($Request == "AddNewTransactionMethod") {
						$TMLTitle = $_POST["TMLTitle"];
						$TGBToken = $_POST["TGBToken"];
						$Q = 	"
										INSERT INTO transactionmethodlist_info
										(BusinessToken, TGBToken, TMLTitle, UserToken, Existence, BDDT)
										VALUES
										('$BusinessToken', '$TGBToken', '$TMLTitle', '$UserToken', '1', '$BDDT')
									";
						$RQ = RunQuery($Q);
						$TMLID = InsertedID($DBCON);
						$Initial = "991";
						$TMLToken = "$Initial$BusinessToken$TMLID";
						$UQ = "UPDATE transactionmethodlist_info SET TMLToken = '$TMLToken' WHERE TMLID = '$TMLID'";
						$RUQ = RunQuery($UQ);
					}
					# ADD NEW PAYMENT
					elseif ($Request == "AddPayment") {
						$Reference = $_POST["Reference"];
						$ReferenceType = $_POST["ReferenceType"];
						$TransactionToken = $_POST["TransactionToken"];
						$TransactionType = $_POST["TransactionType"];
						$CounterToken = $_POST["CounterToken"];
						$TMLToken = $_POST["TMLToken"];
						$Amount = $_POST["Amount"];
						$Note = $_POST["Note"];
						$Q = 	"
										INSERT INTO transactiondetails_info
										(BusinessToken, Reference, ReferenceType, TransactionToken, TransactionType, TMLToken, CounterToken, Amount, Note, UserToken, WorkFlowStatus, Existence, BDDT)
										VALUES
										('$BusinessToken', '$Reference', '$ReferenceType', '$TransactionToken', '$TransactionType', '$TMLToken', '$CounterToken', '$Amount', '$Note', '$UserToken', '3', '1', '$BDDT')
									";
						$RQ = RunQuery($Q);
					}
					# SHOW ALL Transaction Methods
					elseif ($Request == "LoadPaymentInfo") {
						$TransactionToken = $_POST["TransactionToken"];
						$Q = "SELECT * FROM transactiondetails_info WHERE TransactionToken = '$TransactionToken' AND Existence = '1'";
						$RQ = RunQuery($Q);
						$SL = 1;
						echo "<thead class='bg-success text-white'>";
							echo "<tr>";
								echo "<th>#</th>";
								echo "<th>By</th>";
								echo "<th>Note</th>";
								echo "<th>Amt</th>";
								echo "<th>X</th>";
							echo "</tr>";
						echo "</thead>";
						echo "<tbody>";
						while ($Row = Fetch($RQ)) {
							$TMLToken = $Row["TMLToken"];
							$Amount = $Row["Amount"];
							$Note = $Row["Note"];
							$TDID = $Row["TDID"];
							$TMLTitle = TMLTitle($TMLToken);
							echo "<tr>";
								echo "<th scope='row'>$SL</th>";
								echo "<td>$TMLTitle</td>";
								echo "<td>$Note</td>";
								echo "<td><button class='PaymentSingleAmount btn btn-info btn-block waves-light waves-effect'>$Amount</button></td>";
								echo "<td><button class='DeletePayment btn btn-danger btn-block waves-light waves-effect' id='$TDID'>X</button></td>";
							echo "</tr>";
							$SL++;
						}
						echo "<tbody>";
					}
					# DELETE PAYMENT
					elseif ($Request == "DeletePayment") {
						$DeleteID = $_POST["DeleteID"];
						$Q = "UPDATE transactiondetails_info SET Existence = '0' WHERE TDID = '$DeleteID'";
						$RQ = RunQuery($Q);
					}
					elseif ($Request == "InitiateClosing") {
						$ClosingDate = $_POST["ClosingDate"];
						$CounterToken = $_POST["CounterToken"];
						$Q = "SELECT DCID FROM dailyclosing_info WHERE ClosingDate = '$ClosingDate' AND CounterToken = '$CounterToken'";
						$RQ = RunQuery($Q);
						$NumRows = NumRows($RQ);
						if ($NumRows != 1) {
							$Q1 = 	"
										INSERT INTO dailyclosing_info
										(ClosingDate, BusinessToken, CounterToken, UserToken, BDDT)
										VALUES
										('$ClosingDate', '$BusinessToken', '$CounterToken', '$UserToken', '$BDDT')
									";
							$RQ = RunQuery($Q1);
							$DCID = InsertedID($DBCON);
							echo "$DCID";
						}
					}
					elseif ($Request == "LoadWarehouseHistory") {
						$CounterToken = $_POST["CounterToken"];
						$FromDate = $_POST["FromDate"];
						$ToDate = $_POST["ToDate"];
						$BDDATEFromDate = BDDATE($FromDate);
						$BDDATEToDate = BDDATE($ToDate);
						$Q = "SELECT * FROM productgroup_info WHERE BusinessToken = '$BusinessToken' AND Existence = '1' ORDER BY ProductTitle";
            $RQ = RunQuery($Q);
            $SL = 1;
            echo "<thead class='bg-success text-white'>";
              echo "<tr>";
                echo "<th>#</th>";
                echo "<th>Product</th>";
                echo "<th>Units</th>";
                //echo "<th>Stock Value</th>";
              echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($Row = Fetch($RQ)) {
              $ProductToken = $Row["ProductToken"];
             	$ProductTitle = $Row["ProductTitle"];
              $UserToken = $Row["UserToken"];
              $TotalProductsInWarehouse = WarehouseHistoryTotalProductsInCounter($CounterToken, $ProductToken, $ToDate);
             	//$TotalStockValue = WarehouseHistoryCounterProductValue($CounterToken, $ProductToken, $FromDate, $ToDate);
              echo "<tr>";
               	echo "<th scope='row'>$SL</th>";
                echo "<td><a href='index.php?p=business&m=10423&ProductToken=$ProductToken' class='btn btn-block btn-lg btn-info waves-effect waves-light'>$ProductTitle</a></td>";
                echo "<td><button class='InvoiceItemPrice btn btn-danger waves-effect waves-light btn-block btn-lg'>$TotalProductsInWarehouse</button></td>";
                //echo "<td><a href='index.php?p=business&m=10425&PT=$ProductToken' class='StockValue btn btn-danger waves-effect waves-light btn-block btn-lg'>$TotalStockValue</a></td>";
              echo "</tr>";
              $SL++;
            }
            echo "</tbody>";
					}






					/*ALL REQUEST BEFORE THIS*/



					else{
						//echo "Access Problem";
					}
				}
				else{
					echo "No API Access";
				}
			}
			else{
				//header("Location: $NotFoundPage");
			}
		}
		else{
			//header("Location: $NotFoundPage");
		}
	}
?>