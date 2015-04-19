<?php
require_once("config/carNames.php");

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_GET["ID"])) {
    $vehID = $_GET["ID"];
} else {
    echo "<center><h1 style='color:red'>" . $lang['idNotSet'] . "</h1></center>";
}

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_POST["vehID"]))
{
	//vehOwner vehClass vehSide vehType vehPlate vehAlive vehAct vehCol vehInv
	$carID   = $_POST["vehID"];
	$vehOwner = $_POST["vehOwner"];
	$vehClass = $_POST["vehClass"];
	$vehSide = $_POST["vehSide"];
	$vehType = $_POST["vehType"];
	$vehPlate = $_POST["vehPlate"];
	$vehAlive = $_POST["vehAlive"];
	$vehAct = $_POST["vehAct"];
	$vehCol = $_POST["vehCol"];
	$vehInv = $_POST["vehInv"];
	if (!$db_connection->connect_errno) 
	{
		if (isset($_POST['drop'])) 
		{
			$sql = "DELETE FROM `vehicles` WHERE `vehicles`.`id` = '".$carID."'";
		} 
		else 
		{
			$sql = "UPDATE `vehicles` SET `side`='".$vehSide."',`classname`='".$vehClass."',`type`='".$vehType."',`alive`='".$vehAlive."',`active`='".$vehAct."',`plate`='".$vehPlate."',`color`='".$vehCol."',`inventory`='".$vehInv."' WHERE `vehicles`.`id` = '".$carID."'";
		}		

		$result_of_query = $db_connection->query($sql);	
	}	
}

?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $lang['vehicles']; ?>
            <small><?php echo " " . $lang['editing']; ?></small>
        </h1>
    </div>
</div>
<!-- /.row -->
<div class="col-md-4"></div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-taxi fa-fw"></i><?php echo " " . $lang['vehicles']; ?></h3>
        </div>
        <div class="panel-body">
            <form method="post" action="editVeh.php?ID=<?php echo $vehID; ?>" name="editform">
                <?php
                if (!$db_connection->connect_errno)
                {
                $sql = 'SELECT * FROM `vehicles` WHERE `id` ="' . $vehID . '";';
                $result_of_query = $db_connection->query($sql);
                if ($result_of_query->num_rows > 0)
                {
                while ($row = mysqli_fetch_assoc($result_of_query))
                {
                echo "<center>";
                echo "<h4>" . $lang['owner'] . ": <input id='vehOwner' name='vehOwner' type='number' value='" . nameID($row["pid"]) . "' readonly></td><br/>";
                echo "<h4>" . $lang['playerID'] . ": <input id='vehOwner' name='vehOwner' type='number' value='" . $row["pid"] . "' readonly></td><br/>";
                echo "<h4>" . $lang['class'] . ":   <input id='vehClass' name='vehClass' type='text' value='" . carName($row["classname"]) . "' readonly></td><br/>";
                echo "<h4>" . $lang['plate'] . ":    <input id='vehPlate' name='vehPlate' type='number' value='" . $row["plate"] . "'readonly></td><br/>";
                echo "<h4>" . $lang['side'] . ":   ";
                echo "<select id='vehSide' name='vehSide'>";
                echo '<option value="civ"'.select('civ',$row['side']).'>'.$lang['civ'].'</option>';
                echo '<option value="cop"'.select('cop',$row['side']).'>'.$lang['cop'].'</option>';
                echo '<option value="med"'.select('med',$row['side']).'>'.$lang['medic'].'</option>';
                echo "</select>";
                echo "<h4>" . $lang['type'] . ":   ";
                echo "<select id='vehType' name='vehType'>";
                echo '<option value="Car"'.select('Car',$row['type']).'>'.$lang['car'].'</option>';
                echo '<option value="Air"'.select('Air',$row['type']).'>'.$lang['air'].'</option>';
                echo "</select>";
                echo "<h4>" . $lang['alive'] . ":";
                echo "<select id='vehAlive' name='vehAlive'>";
                echo '<option value="0"'.select('0',$row['alive']).'>'.$lang['no'].'</option>';
                echo '<option value="1"'.select('1',$row['alive']).'>'.$lang['yes'].'</option>';
                echo "</select>";
                echo "<h4>" . $lang['active'] . ":";
                echo "<select id='vehAct' name='vehAct'>";
                echo '<option value="0"'.select('0',$row['active']).'>'.$lang['no'].'</option>';
                echo '<option value="1"'.select('1',$row['active']).'>'.$lang['yes'].'</option>';
                echo "</select>";
                echo "<h4>" . $lang['colour'] . ":   <input id='vehCol' name='vehCol' type='number' value='" . $row["color"] . "'></td><br/>";
                echo "</center>";
                ?>
        </div>
    </div>
</div>
    <div class='col-lg-12'>
        <div class='panel panel-default'>
            <div class='panel-heading'>
                <h3 class='panel-title'><i class='fa fa-suitcase  fa-fw'></i><?php echo " " . $lang['inventory'];?></h3>
            </div>
            <div class="panel-body">
                <div class="col-md-4" style="padding-left:425px;">
                    <?php
                    echo "<textarea id='vehInv' name='vehInv' cols='100' rows='5'>" . $row["inventory"] . "</textarea>";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <center>
            <?php
            echo "<input id='playerId' type='hidden' name='vehID' value='" . $row["id"] . "'>";
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
