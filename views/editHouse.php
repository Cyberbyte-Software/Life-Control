<?php
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["ID"])) {
    $hID = $_GET["ID"];
} else {
    echo "<center><h1 style='color:red'>" . $lang['idNotSet'] . "</h1></center>";
}

if (isset($_POST["hID"]))
{
	$hID   = $_POST["hID"];
	$hOwn = $_POST["hOwn"];
	$hPos = $_POST["hPos"];
	$hOwned = $_POST["hOwned"];
	$hCont = $_POST["hCont"];
	$hInv = $_POST["hInv"];

	if (!$db_connection->connect_errno) 
	{
		if (isset($_POST['drop'])) 
		{
			$sql = "DELETE FROM `houses` WHERE `houses`.`id` = '".$hID."'";
		} 
		else 
		{
			$sql = "UPDATE `houses` SET `pid`='".$hOwn."',`pos`='".$hPos."',`owned`='".$hOwned."',`inventory`='".$hInv."',`containers`='".$hCont."' WHERE `houses`.`id` = '".$hID."'";
		}		

		$result_of_query = $db_connection->query($sql);

	}
}

?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $lang['house']; ?>
            <small><?php echo " " . $lang['editing']; ?></small>
        </h1>
    </div>
</div>
<!-- /.row -->
<div class="col-md-4"></div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-home fa-fw"></i><?php echo " " . $lang['house']; ?></h3>
        </div>
        <div class="panel-body">
            <form method="post" action="editHouse.php?ID=<?php echo $hID; ?>" name="editform">
                <?php
                if (!$db_connection->connect_errno)
                {
                $sql = 'SELECT * FROM `houses` WHERE `id` ="' . $hID . '";';
                $result_of_query = $db_connection->query($sql);
                if ($result_of_query->num_rows > 0)
                {
                while ($row = mysqli_fetch_assoc($result_of_query))
                {
                echo "<center>";
                echo "<h4>" . $lang['player'] . ": " . nameID($row["pid"]) . "</td><br/>";
                echo "<h4>" . $lang['playerID'] . ": <input id='hOwn' name='hOwn' type='text' value='" . $row["pid"] . "'></td><br/>";
                echo "<h4>" . $lang['position'] . ": <input id='hPos' name='hPos' type='text' value='" . $row["pos"] . "'readonly></td><br/>";
                echo "<h4>" . $lang['owned'] . ":  ";
                echo "<select id='hOwned' name='hOwned'>";
                echo '<option value="0"' . select('0', $row['owned']) . '>' . $lang['no'] . '</option>';
                echo '<option value="1"' . select('1', $row['owned']) . '>' . $lang['yes'] . '</option>';
                echo "</select>";
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
                    echo "<textarea id='hInv' name='hInv' cols='100' rows='5'>" . $row["inventory"] . "</textarea>";
                    ?>
                </div>
            </div>
        </div>
        <div class='panel panel-default'>
            <div class='panel-heading'>
                <h3 class='panel-title'><i class='fa fa-suitcase  fa-fw'></i><?php echo " " . $lang['containers'];?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="col-md-4" style="padding-left:425px;">
                    <?php
                    echo "<textarea id='hCont' name='hCont' cols='100' rows='5'>" . $row["containers"] . "</textarea>";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <center>
            <?php
            echo "<input id='hID' type='hidden' name='hID' value='" . $row["id"] . "'>";
            echo "<input class='btn btn-lg btn-primary'  type='submit'  name='update' value='" . $lang['subChange'] . "'>  ";
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


