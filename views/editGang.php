<?php
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["ID"])) {
    $gID = $_GET["ID"];
} else {
    echo "<center><h1 style='color:red'>" . $lang['idNotSet'] . "</h1></center>";
}

if (isset($_POST["gID"])) {
    $gID = $_POST["gID"];
    $gname = $_POST["gname"];
    $gowner = $_POST["gowner"];
    $gMM = $_POST["gMM"];
    $gbank = $_POST["gbank"];
    $gAct = $_POST["gAct"];
    $gMem = $_POST["gMem"];

    if (!$db_connection->connect_errno) {
        if (isset($_POST['drop'])) {
            $sql = "DELETE FROM `gangs` WHERE `gangs`.`id` = '" . $gID . "'";
        } else {
            $sql = "UPDATE `gangs` SET `owner`='" . $gowner . "',`name`='" . $gname . "',`members`='" . $gMem . "',`maxmembers`='" . $gMM . "',`bank`='" . $gbank . "',`active`='" . $gAct . "' WHERE `gangs`.`id` = '" . $gID . "'";
        }
        $result_of_query = $db_connection->query($sql);

    } else {
        $this->errors[] = "Database connection problem.";
    }
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
            <form method="post" action="editGang.php" name="editform">
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
                echo "<h4>" . $lang['owner'] . ":    <input id='gowner' name='gowner' type='number' value='" . $row["owner"] . "'></td><br/>";
                echo "<h4>" . $lang['maxMembers'] . ":    <input id='gMM' name='gMM' type='number' value='" . $row["maxmembers"] . "'></td><br/>";
                echo "<h4>" . $lang['bank'] . ":     <input id='gbank' name='gbank' type='number' value='" . $row["bank"] . "'></td><br/>";
                echo "<h4>" . $lang['active'] . ":   ";
                echo "<select id='gAct' name='gAct'>";
                echo '<option value="0"' . select('0', $row['active']) . '>' . $lang['no'] . '</option>';
                echo '<option value="1"' . select('1', $row['active']) . '>' . $lang['yes'] . '</option>';
                echo "</select>";
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