<?php

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST["hID"])) {
    $hID = $_POST["hID"];
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
            <?php echo $lang['house']; ?>
            <small><?php echo " " . $lang['editing']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-wrench"></i><?php echo " " . $lang['houses']; ?>
            </li>
        </ol>
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
            <form method="post" action="edit-actionH.php" name="editform">
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
                echo "<h4>" . $lang['playerID'] . ": <input id='hOwn' name='hOwn' type='text' value='" . $row["pid"] . "'></td><br/>";
                echo "<h4>" . $lang['position'] . ":<input id='hPos' name='hPos' type='text' value='" . $row["pos"] . "'></td><br/>";
                echo "<h4>" . $lang['owned'] . ":   <input id='hOwned' name='hOwned' type='text' value='" . $row["owned"] . "'></td><br/>";
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


