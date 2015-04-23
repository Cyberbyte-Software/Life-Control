<?php

// create a database connection, using the constants from config/config.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_GET["ID"])) {
    $wantedID = $_GET["ID"];
	
	if (isset($_POST["wantedID"]))
	{
		//vehOwner vehClass vehSide vehType vehPlate vehAlive vehAct vehCol vehInv
		$wantedID   = $_POST["wantedID"];
		$wantedName = $_POST["wantedName"];
		$wantedCrimes = $_POST["wantedCrimes"];
		$wantedBounty = $_POST["wantedBounty"];
		$active = $_POST["active"];
	
		if (!$db_connection->connect_errno) 
		{
			if (isset($_POST['drop'])) 
			{
				$sql = "DELETE FROM `wanted` WHERE `wanted`.`wantedID` = '".$wantedID."'";
			} 
			else 
			{
				$sql = "UPDATE `wanted` SET `active` = '".$active."', `wantedName` = '".$wantedName."', `wantedBounty` = '".$wantedBounty."', `wantedCrimes` = '".$wantedCrimes."' WHERE `wanted`.`wantedID` = '".$wantedID."'";
			}		

			$result_of_query = $db_connection->query($sql);
		}
	}	
} else {
    echo "<center><h1 style='color:red'>" . $lang['idNotSet'] . "</h1></center>";
}

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $lang['wanted']; ?>
            <small><?php echo " " . $lang['editing']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-wrench"></i><?php echo " " . $lang['wanted']; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="col-md-4"></div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-child fa-fw"></i> <?php echo " " . $lang['wanted']; ?></h3>
        </div>
        <div class="panel-body">
            <form method="post" action="editWanted.php?ID=<?php echo $wantedID; ?>" name="editform">
                <?php
                if (!$db_connection->connect_errno)
                {
                $sql = 'SELECT * FROM `wanted` WHERE `wantedID` ="' . $wantedID . '";';
                $result_of_query = $db_connection->query($sql);
                if ($result_of_query->num_rows > 0)
                {
                while ($row = mysqli_fetch_assoc($result_of_query))
                {
                echo "<center>";
                echo "<h4>" . $lang['wID'] . ": <input id='wantedID' name='wantedID' type='text' value='" . $row["wantedID"] . "'></td><br/>";
                echo "<h4>" . $lang['name'] . ":   <input id='wantedName' name='wantedName' type='text' value='" . $row["wantedName"] . "'></td><br/>";
                echo "<h4>" . $lang['bounty'] . ":    <input id='wantedBounty' name='wantedBounty' type='text' value='" . $row["wantedBounty"] . "'></td><br/>";
                echo "<h4>" . $lang['active'] . ":";
                echo "<select id='active' name='active'>";
                echo '<option value="0"';
                if ($row['active'] == 0) {
                    echo ' selected';
                }
                echo '>0</option>';
                echo '<option value="1"';
                if ($row['active'] == 1) {
                    echo ' selected';
                }
                echo '>1</option>';
                echo "</select>";
                echo "</center>";
                ?>
        </div>
    </div>
</div>
    <div class='col-lg-12'>
        <div class='panel panel-default'>
            <div class='panel-heading'>
                <h3 class='panel-title'><i class='fa fa-suitcase  fa-fw'></i><?php echo " " . $lang['crimes'];?></h3>
            </div>
            <div class="panel-body">
                <div class="col-md-4" style="padding-left:425px;">
                    <?php
                    echo "<textarea id='wantedCrimes' name='wantedCrimes' cols='100' rows='5'>" . $row["wantedCrimes"] . "</textarea>";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <center>
            <?php
            echo "<input class='btn btn-lg btn-primary'  type='submit'  name='update' value='" . $lang['subChanges'] . "'>  ";
            echo "<input class='btn btn-lg btn-danger'  type='submit'  name='drop' value='" . $lang['DELETE'] . "'>";
            ?>
            <br/>
        </center>
    </div>
<?php
};
}
else {
    echo "<center><h1 style='color:red'>ERROR NO RESULTS</h1></center>";
}

}
else {
    $this->errors[] = "Database connection problem.";
}
?>
</form>
