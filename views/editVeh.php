<?php

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST["vehID"])) {
    $vehID = $_POST["vehID"];
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
            <?php echo $lang['vehicle']; ?>
            <small><?php echo " " . $lang['editing']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-wrench"></i><?php echo " " . $lang['vehicles']; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="col-md-4"></div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-child fa-fw"></i><?php echo " " . $lang['vehicle']; ?></h3>
        </div>
        <div class="panel-body">
            <form method="post" action="edit-actionV.php" name="editform">
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
                echo "<h4>" . $lang['owner'] . ": <input id='vehOwner' name='vehOwner' type='text' value='" . $row["pid"] . "'></td><br/>";
                echo "<h4>" . $lang['class'] . ":   <input id='vehClass' name='vehClass' type='text' value='" . $row["classname"] . "'></td><br/>";
                echo "<h4>" . $lang['side'] . ":   <input id='vehSide' name='vehSide' type='text' value='" . $row["side"] . "'></td><br/>";
                echo "<h4>" . $lang['type'] . ":    <input id='vehType' name='vehType' type='text' value='" . $row["type"] . "'></td><br/>";
                echo "<h4>" . $lang['plate'] . ":    <input id='vehPlate' name='vehPlate' type='text' value='" . $row["plate"] . "'></td><br/>";
                echo "<h4>" . $lang['alive'] . ":";
                echo "<select id='vehAlive' name='vehAlive'>";
                echo '<option value="0"';
                if ($row['alive'] == 0) {
                    echo ' selected';
                }
                echo '>0</option>';
                echo '<option value="1"';
                if ($row['alive'] == 1) {
                    echo ' selected';
                }
                echo '>1</option>';
                echo "</select>";
                echo "<h4>" . $lang['active'] . ":";
                echo "<select id='vehAct' name='vehAct'>";
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
                echo "<h4>" . $lang['colour'] . ":   <input id='vehCol' name='vehCol' type='text' value='" . $row["color"] . "'></td><br/>";
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
