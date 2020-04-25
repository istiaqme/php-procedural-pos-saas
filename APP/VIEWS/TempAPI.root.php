<?php 
	if (isset($_POST["Request"])) {
		$Request = $_POST["Request"];
		if ($Request == "AddNewAssembler") {
			$Title = $_POST["Title"];
			echo "$Title";
			$Q = "INSERT INTO temp_assemblerlist (Title) VALUES ('$Title')";
			$RQ = RunQuery($Q);
		}
		elseif($Request == "LoadAllAssemblers"){
			$Q = "SELECT * FROM temp_assemblerlist";
			$RQ = RunQuery($Q);
			$SL = 1;
			echo "<thead class='bg-success text-white'>";
				echo "<tr>";
					echo "<th>#</th>";
					echo "<th>Title</th>";
					echo "<th>VIEW</th>";
					echo "<th>VIEW</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($Row = Fetch($RQ)) {
				$ALID = $Row["ALID"];
				$Title = $Row["Title"];
				echo "<tr>";
					echo "<th scope='row'>$SL</th>";
					echo "<td>$Title</td>";
					echo "<td><a class='btn btn-danger waves-effect waves-light' href = 'index.php?p=business&m=AssemblerEnlist&id=$ALID'>Enlist</a></td>";
					echo "<td><a class='btn btn-info waves-effect waves-light'  href = 'index.php?p=business&m=AssemblerFullList&id=$ALID'>Full List</a></td>";
					echo "</tr>";
			$SL++;
			}
			echo "<tbody>";
		}



		# ALL ELSE IF INSIDE THIS
		else{

		}
	}
?>