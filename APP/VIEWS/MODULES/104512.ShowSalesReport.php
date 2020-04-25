<?php
	if (isset($_GET["Date"]) && isset($_GET["Type"])) {
		$ShowDate = $_GET["Date"];
		$Type = $_GET["Type"];
		$CounterToken = $_GET["CounterToken"];
		$CounterTitle = CounterTitle($CounterToken);
		if ($Type == 'ShowByCustomer') {
			require(APP_ROOT.'/APP/VIEWS/MODULES/104512.ShowByCustomer.php');
		}
		elseif ($Type == 'ShowByProduct') {
			require(APP_ROOT.'/APP/VIEWS/MODULES/104512.ShowByProduct.php');
		}
	}
?>