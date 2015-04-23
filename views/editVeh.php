<?php
require_once("config/carNames.php");
require_once("config/images.php");

$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["ID"])) {
    $vehID = $_GET["ID"];

    if (isset($_POST["editType"])) {
        switch ($_POST["editType"]) {
            case "veh_inv":
                $vehInv = $_POST["vehInv"];
                $sql = "UPDATE `vehicles` SET `inventory`='" . $vehInv . "' WHERE `vehicles`.`id` = '" . $vehID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
            case "veh_store":
                $sql = "UPDATE `vehicles` SET `alive`='1',`active`='0' WHERE `vehicles`.`id` = '" . $vehID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
            case "veh_del":
                $sql = "DELETE FROM `vehicles` WHERE `vehicles`.`id` = '" . $vehID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
            case "veh_edit":
                $vehClass = $_POST["vehClass"];
                $vehSide = $_POST["vehSide"];
                $vehType = $_POST["vehType"];
                $vehPlate = $_POST["vehPlate"];
                $vehCol = $_POST["vehCol"];
                $sql = "UPDATE `vehicles` SET `side`='" . $vehSide . "',`classname`='" . $vehClass . "',`type`='" . $vehType . "',`plate`='" . $vehPlate . "',`color`='" . $vehCol . "' WHERE `vehicles`.`id` = '" . $vehID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
        }
    }

    $sql = 'SELECT * FROM `vehicles` WHERE `id` ="' . $vehID . '";';
    $result_of_query = $db_connection->query($sql);
    if ($result_of_query->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            ?>
            <div class="col-md-4" style="float:left;  padding-top:20px;">
            <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title"><i
                        class="fa fa-child fa-fw"></i><?php echo nameID($row["pid"]) . "'s " . carName($row["classname"]); ?>
                </h2>
            </div>
            <div class="panel-body">
            <?php $carPic = getPic($row["classname"]); ?>
            <center><img src="assets/img/cars/<?php echo $carPic; ?>.jpg"/>
            <?php
            echo "<h4>" . $lang['owner'] . ": " . nameID($row["pid"]) . "</h4>";
            echo "<h4>" . $lang['class'] . ": " . carName($row["classname"]) . "</h4>";
            echo "<h4>" . $lang['plate'] . ": " . $row["plate"] . "</h4>";

            if ($row["alive"] == false) {
                echo "<h4><span class='label label-danger'>" . $lang["not"] . " " . $lang["alive"] . "</span> ";
            } else {
                echo "<h4><span class='label label-success'>" . $lang["alive"] . "</span> ";
            }

            if ($row["active"] == false) {
                echo " <span class='label label-danger'>" . $lang["not"] . " " . $lang["active"] . "</span></h4>";
            } else {
                echo " <span class='label label-success'>" . $lang["active"] . "</span></h4>";
            }
            if ($_SESSION['user_level'] >= P_EDIT_VEHICLES) echo'
                <div style="float: right;">
                    <a data-toggle="modal" href="#edit_veh" class="btn btn-primary btn-xs" style="margin-right:3px">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a data-toggle="modal" href="#store_veh" class="btn btn-warning btn-xs" style="margin-right:3px">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <a data-toggle="modal" href="#del_veh" class="btn btn-danger btn-xs" style="margin-right:3px">
                        <i class="fa fa-exclamation-triangle"></i>
                    </a>
                </div>';
        }
    } else echo "<h1>".$lang['noRes']."</h1>";
    echo "</center>";
    ?>
    </div>
    </div>
    </div>

    <div class="col-md-8" style="float:right; padding-top:20px;">
        <?php
        $sql = 'SELECT * FROM `vehicles` WHERE `id` ="' . $vehID . '";';
        $result_of_query = $db_connection->query($sql);
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            ?>
            <div class="row mtbox">
                <?php
                switch ($row['side']) {
                    case 'civ':
                        ?>
                        <div class="col-md-2 col-sm-2 col-md-offset-1 box0">
                            <div class="box1">
                                <span class="fa fa-3x fa-car"></span>
                                <h4> <?php echo $lang['side'] . ": " . $lang['civ']; ?> </h4>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'cop':
                        ?>
                        <div class="col-md-2 col-sm-2 col-md-offset-1 box0">
                            <div class="box1">
                                <span class="fa fa-3x fa-taxi"></span>
                                <h4> <?php echo $lang['side'] . ": " . $lang['police']; ?> </h4>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'med':
                        ?>
                        <div class="col-md-2 col-sm-2 col-md-offset-1 box0">
                            <div class="box1">
                                <span class="fa fa-3x fa-ambulance"></span>
                                <h4> <?php echo $lang['side'] . ": " . $lang['medic'];?> </h4>
                            </div>
                        </div>
                        <?php
                        break;
                }

                switch ($row['type']) {
                    case 'Car':
                        ?>
                        <div class="col-md-2 col-sm-2 box0">
                            <div class="box1">
                                <span class="fa fa-3x fa-car"></span>
                                <h4> <?php echo $lang['type'] . ": " . $lang['car']; ?> </h4>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'Air':
                        ?>
                        <div class="col-md-2 col-sm-2 box0">
                            <div class="box1">
                                <span class="fa fa-3x fa-fighter-jet"></span>
                                <h4> <?php echo $lang['type'] . ": " . $lang['air']; ?> </h4>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'Ship':
                        ?>
                        <div class="col-md-2 col-sm-2 box0">
                            <div class="box1">
                                <span class="fa fa-3x fa-ship"></span>
                                <h4> <?php echo $lang['type'] . ": " . $lang['ship']; ?> </h4>
                            </div>
                        </div>
                        <?php
                        break;
                }
            echo '</div>';
        }


        echo '<div class="panel panel-default" style="float:left; width:100%; margin:0 auto;">';
            echo '<ul id="myTab" class="nav nav-tabs">';
                echo '<li><a href="#veh_inv" data-toggle="tab">'. $lang['inventory'] .'</a></li>';
            echo '</ul>';
            ?>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in well" id="civ_inv">
                    <h4 style="centred"><?php echo $lang['vehicle'] . " " . $lang['inventory'];?> </h4>
                    <?php
                    $sql = 'SELECT * FROM `vehicles` WHERE `id` ="' . $vehID . '";';
                    $result_of_query = $db_connection->query($sql);
                    while ($row = mysqli_fetch_assoc($result_of_query)) {
                        echo "<textarea class='form-control' readonly rows='5' style='width: 100%' id='civ_gear' name='civ_gear'>" . $row["inventory"] . "</textarea>";
                    }
                    ?>
                    <br>
                    <a data-toggle="modal" href="#edit_veh_inv" class="btn btn-primary btn-xs" style="float: right;">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_veh_inv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span
                            class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['edit'] . " " . $lang['vehicle'] . " " . $lang['inventory'];?>
                    </h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `vehicles` WHERE `id` ="' . $vehID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>
                    <form method="post" action="editVeh.php?ID=<?php echo $vehID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="veh_inv"/>

                                <div class="row">
                                    <textarea class="form-control" rows="10"
                                              name="vehInv"><?php echo $row['inventory'];?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                            <button class="btn btn-primary" type="submit"><?php echo $lang['subChange']; ?></button>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="del_veh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span
                            class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['DELETE'] . " " . $lang['vehicle'];?>
                    </h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `vehicles` WHERE `id` ="' . $vehID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>
                    <form method="post" action="editVeh.php?ID=<?php echo $vehID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="veh_del"/>

                                <div class="row">
                                    <center><h4>Are you Sure?</h4></center>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="submit"><?php echo $lang['yes']; ?></button>
                            <button class="btn btn-primary" data-dismiss="modal"
                                    type="reset"><?php echo $lang['no']; ?></button>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="store_veh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span
                            class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['store'] . " " . $lang['vehicle'];?>
                    </h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `vehicles` WHERE `id` ="' . $vehID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>
                    <form method="post" action="editVeh.php?ID=<?php echo $vehID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="veh_store"/>

                                <div class="row">
                                    <center><h4>Are you Sure?</h4></center>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="submit"><?php echo $lang['yes']; ?></button>
                            <button class="btn btn-primary" data-dismiss="modal"
                                    type="reset"><?php echo $lang['no']; ?></button>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_veh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Player</h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `vehicles` WHERE `id` ="' . $vehID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {

                    ?>

                    <form method="post" action="editVeh.php?ID=<?php echo $vehID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="veh_edit"/>

                                <div class="row">
                                    <center>
                                        <?php
                                        echo "<h4>" . $lang['class'] . ":   <input id='vehClass' name='vehClass' type='text' value='" . $row["classname"] . "' readonly></td><br/>";
                                        echo "<h4>" . $lang['plate'] . ":    <input id='vehPlate' name='vehPlate' type='number' value='" . $row["plate"] . "'readonly></td><br/>";
                                        echo "<h4>" . $lang['side'] . ":   ";
                                        echo "<select id='vehSide' name='vehSide'>";
                                        echo '<option value="civ"' . select('civ', $row['side']) . '>' . $lang['civ'] . '</option>';
                                        echo '<option value="cop"' . select('cop', $row['side']) . '>' . $lang['cop'] . '</option>';
                                        echo '<option value="med"' . select('med', $row['side']) . '>' . $lang['medic'] . '</option>';
                                        echo "</select>";
                                        echo "<h4>" . $lang['type'] . ":   ";
                                        echo "<select id='vehType' name='vehType'>";
                                        echo '<option value="Car"' . select('Car', $row['type']) . '>' . $lang['car'] . '</option>';
                                        echo '<option value="Air"' . select('Air', $row['type']) . '>' . $lang['air'] . '</option>';
                                        echo '<option value="Ship"' . select('Ship', $row['type']) . '>' . $lang['ship'] . '</option>';
                                        echo "</select>";
                                        echo "<h4>" . $lang['colour'] . ":   <input id='vehCol' name='vehCol' type='number' value='" . $row["color"] . "'></td><br/>";
                                        echo "</center>";
                                        ?>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                            <button class="btn btn-primary" type="submit"><?php echo $lang['subChange']; ?></button>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php
} else {
    include("views/errors/noID.php");
}
?>