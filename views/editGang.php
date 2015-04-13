<?php
// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST["gID"])) {
    $gID = $_POST["gID"];
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
            <?php echo $lang['gang']; ?>
            <small><?php echo " " . $lang['editing']; ?></small>
        </h1>
    </div>
</div>
<!-- /.row -->
<div class="col-md-4"></div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-child fa-fw"></i><?php echo " " . $lang['player']; ?></h3>
        </div>
        <div class="panel-body">
            <form method="post" action="edit-actionG.php" name="editform">
                <?php
                if (!$db_connection->connect_errno)
                {
                $sql = 'SELECT * FROM `gangs` WHERE `id` ="' . $gID . '";';
                $result_of_query = $db_connection->query($sql);
                if ($result_of_query->num_rows > 0)
                {
                while ($row = mysqli_fetch_assoc($result_of_query))
                {
                $gID = $row["id"];
                echo "<center>";
                echo "<h3>" . $lang['name'] . ":    <input id='gname' name='gname' type='text' value='" . $row["name"] . "'></td><br/>";
                echo "<h4>" . $lang['owner'] . ":    <input id='gowner' name='gowner' type='text' value='" . $row["owner"] . "'></td><br/>";
                echo "<h4>" . $lang['maxMembers'] . ":    <input id='gMM' name='gMM' type='text' value='" . $row["maxmembers"] . "'></td><br/>";
                echo "<h4>" . $lang['bank'] . ":     <input id='gbank' name='gbank' type='text' value='" . $row["bank"] . "'></td><br/>";
                echo "<h4>" . $lang['active'] . ":   <input id='gAct' name='gAct' type='text' value='" . $row["active"] . "'></td><br/>";
                echo "</center>";
                ?>
        </div>
    </div>
</div>
<div class='col-lg-12'>
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <h3 class='panel-title'><i class='fa fa-users fa-fw'></i><?php echo " " . $lang['members'];?></h3>
        </div>
        <div class="panel-body">
            <div class="col-md-4" style="padding-left:425px;">
                <?php
                echo "<textarea id='gMem' name='gMem' cols='100' rows='5'>" . $row["members"] . "</textarea>";
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <center>
            <?php
            echo "<input id='gID' type='hidden' name='gID' value='" . $gID . "'>";
            echo "<input class='btn btn-lg btn-primary'  type='submit'  name='edit' value='" . $lang['subChange'] . "'>  ";
            echo "<input class='btn btn-lg btn-danger'  type='submit'  name='drop' value='" . $lang['DELETE'] . "'>";
            ?>
            <br/>
        </center>
    </div>
    <?php
    };
    }
    else {
        echo "<center><h1 style='color:red'>" . $lang['noRes'] . "</h1></center>";
    }

    }
    else {
        $this->errors[] = "Database connection problem.";
    }
    ?>
    </form>
</div>