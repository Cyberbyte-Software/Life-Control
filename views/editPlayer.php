<?php
require_once("config/carNames.php");

$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["ID"])) {
    $uID = $_GET["ID"];

    $temp = "";
    $pGID = $uID;
    for ($i = 0; $i < 8; $i++) {
        $temp .= chr($pGID & 0xFF);
        $pGID >>= 8;
    }
    $pGID = md5('BE' . $temp);

    $sql = "SELECT `playerid` FROM `players` WHERE `uid` = '" . $uID . "'";
    $result_of_query = $db_connection->query($sql);
    while ($row = mysqli_fetch_assoc($result_of_query)) {
        $pID = $row["playerid"];
    }

    if (isset($_POST["playerId"])) {
        $pID = $_POST["playerId"];
        $pCash = $_POST["player_cash"];
        $pBank = $_POST["player_bank"];
        $pCopLvl = $_POST["player_coplvl"];
        $pMedLvl = $_POST["player_medlvl"];
        $pAdminLvl = $_POST["player_adminlvl"];
        $pDonLvl = $_POST["player_donlvl"];
        $pcopLic = $_POST["cop_lic"];
        $pcopG = $_POST["cop_gear"];
        $pcivLic = $_POST["civ_lic"];
        $pcivG = $_POST["civ_gear"];
        $pmedLic = $_POST["med_lic"];
        $pmedG = $_POST["med_gear"];

        if (!$db_connection->connect_errno) {
            $sql = "UPDATE `players` SET `cash`='" . $pCash . "',`bankacc`='" . $pBank . "',`coplevel`='" . $pCopLvl . "'
        ,`cop_licenses`='" . $pcopLic . "',`civ_licenses`='" . $pcivLic . "',`med_licenses`='" . $pmedLic . "',`cop_gear`
        ='" . $pcopG . "',`med_gear`='" . $pmedG . "',`mediclevel`='" . $pMedLvl . "',`adminlevel`='" . $pAdminLvl . "',
        `donatorlvl`='" . $pDonLvl . "',`civ_gear`='" . $pcivG . "' WHERE `playerid` = '" . $pID . "'";
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
                <?php echo $lang['player']; ?>
                <small><?php echo " " . $lang['editing']; ?></small>
            </h1>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-child fa-fw"></i><?php echo " " . $lang['player']; ?></h3>
            </div>
            <div class="panel-body">
                <form method="post" action="editPlayer.php?ID=<?php echo $uID; ?>" name="editform">
                    <?php
                    $sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
                    $result_of_query = $db_connection->query($sql);
                    if ($result_of_query->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result_of_query)) {
                            $playersID = $row["playerid"];
                            echo "<center>";
                            echo "<h3>" . $lang['name'] . ": " . $row["name"] . "</h3>";
                            echo "<h4>" . $lang['aliases'] . ": " . $row["aliases"] . "</h4>";
                            echo "<h4>" . $lang['playerID'] . ": " . $pID . "</h4>";
                            echo "<h4>" . $lang['GUID'] . ": " . $pGID . "</h4>";
                            if ($_SESSION['user_level'] >= 2) {
                                echo "<h4>" . $lang['cash'] . ":    <input id='player_cash' name='player_cash' type='number' value='" . $row["cash"] . "'></td><br/>";
                                echo "<h4>" . $lang['bank'] . ":    <input id='player_bank' name='player_bank' type='number' value='" . $row["bankacc"] . "'></td><br/>";
                            } else {
                                echo "<input id='player_cash' type='hidden' name='player_cash' value='" . $row["cash"] . "'>";
                                echo "<input id='player_bank' type='hidden' name='player_bank' value='" . $row["bankacc"] . "'>";
                                echo "<h4>" . $lang['cash'] . ": " . $row["cash"] . "</h4>";
                                echo "<h4>" . $lang['bank'] . ": " . $row["bankacc"] . "</h4>";
                            }
                            echo "<h4>" . $lang['cop'] . ": ";
                            echo "<select id='player_coplvl' name='player_coplvl'>";

                            for ($lvl = 0; $lvl <= lvlcop; $lvl = $lvl + 1) {
                                echo '<option value="' . $lvl . '"' . select($lvl, $row['coplevel']) . '>' . $lvl . '</option>';
                            }
                            echo "</select>";

                            echo "<h4>" . $lang['medic'] . ": ";
                            echo "<select id='player_medlvl' name='player_medlvl'>";
                            for ($lvl = 0; $lvl <= lvlmed; $lvl = $lvl + 1) {
                                echo '<option value="' . $lvl . '"' . select($lvl, $row['mediclevel']) . '>' . $lvl . '</option>';
                            }

                            echo "</select>";
                            if ($_SESSION['user_level'] >= 3) {
                                echo "<h4>" . $lang['admin'] . ": ";
                                echo "<select id='player_adminlvl' name='player_adminlvl'>";

                                for ($lvl = 0; $lvl <= lvladmin; $lvl = $lvl + 1) {
                                    echo '<option value="' . $lvl . '"' . select($lvl, $row['adminlevel']) . '>' . $lvl . '</option>';
                                }

                                echo "</select>";
                            } else {
                                echo "<input id='player_adminlvl' type='hidden' name='player_adminlvl' value='" . $row["adminlevel"] . "'>";
                                echo "<h4>" . $lang['admin'] . ": " . $row["adminlevel"] . "</h4>";
                            }
                            if ($_SESSION['user_level'] >= 2) {
                                echo "<h4>" . $lang['donator'] . ": ";
                                echo "<select id='player_donlvl' name='player_donlvl'>";
                                for ($lvl = 0; $lvl <= lvldonator; $lvl = $lvl + 1) {
                                    echo '<option value="' . $lvl . '"' . select($lvl, $row['donatorlvl']) . '>' . $lvl . '</option>';
                                }
                                echo "</select>";

                            } else {
                                echo "<input id='player_donlvl' type='hidden' name='player_donlvl' value='" . $row["donatorlvl"] . "'>";
                                echo "<h4>" . $lang['donator'] . ": " . $row['donatorlvl'] . "</h4>";
                            }
                        }
                    } else echo "<h1>" . $lang['noPlayer'] . "<h1>";
                    echo "</center>";
                    ?>
            </div>
        </div>
    </div>
    <?php
    if ($_SESSION['user_level'] >= 2) {
        ?>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i
                            class="fa fa-car fa-fw"></i><?php echo " " . $lang['vehicles'] . " " . $lang['quickLook']; ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php
                        if ($_SESSION['user_level'] >= 2) {
                            $sql = "SELECT * FROM `vehicles` WHERE `pid` = '" . $pID . "' ORDER BY `id` DESC LIMIT 8";
                            $result_of_query = $db_connection->query($sql);
                            if ($result_of_query->num_rows > 0) {
                                ?>
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th><?php echo $lang['class']; ?></th>
                                        <th><?php echo $lang['type']; ?></th>
                                        <th><?php echo $lang['plate']; ?></th>
                                        <th><?php echo $lang['edit']; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result_of_query)) {
                                        $vehID = $row["id"];
                                        echo "<tr>";
                                        echo "<td>" . carName($row["classname"]) . "</td>";
                                        echo "<td>" . carType($row["type"], $lang) . "</td>";
                                        echo "<td>" . $row["plate"] . "</td>";
                                        echo "<td><a class='btn btn-primary btn-xs' href='editVeh.php?ID=" . $row["id"] . "'>";
                                        echo "<i class='fa fa-pencil'></i></a></td>";
                                        echo "</tr>";
                                    };

                                    ?>
                                    </tbody>
                                </table>
                            <?php
                            } else echo '<h1>' . $lang['noCar'] . '</h1>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="col-lg-4">
        <?php
        if ($_SESSION['user_level'] >= 2) {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i
                            class="fa fa-home fa-fw"></i><?php echo " " . $lang['houses'] . " " . $lang['quickLook']; ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php
                        $sql = "SELECT `pos`,`id` FROM `houses` WHERE `pid` = '" . $pID . "' ORDER BY `id` DESC LIMIT 8";
                        $result_of_query = $db_connection->query($sql);
                        if ($result_of_query->num_rows > 0) {
                            ?>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th><?php echo $lang['position']; ?></th>
                                    <th><?php echo $lang['edit']; ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_of_query)) {
                                    echo "<tr>";
                                    echo "<td>" . $row["pos"] . "</td>";
                                    echo "<td><a class='btn btn-primary btn-xs' href='editHouse.php?ID=" . $row["id"] . "'>";
                                    echo "<i class='fa fa-pencil'></i></a></td>";
                                    echo "</tr>";
                                };
                                ?>
                                </tbody>
                            </table>
                        <?php } else echo '<h1>' . $lang['noHouse'] . '</h1>' ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <!-- /.row -->

    <div class='col-lg-12'>
        <?php
        $sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
        $result_of_query = $db_connection->query($sql);
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            if (isset($row["cop_licenses"])) { ?>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'><i class='fa fa-taxi fa-fw'></i><?php echo " " . $lang['police']; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <?php
                            if ($_SESSION['user_level'] >= 2) {
                                echo "<h4>" . $lang['cop'] . " " . $lang['licenses'] . ":</h4> <textarea rows='5' style='width: 100%' id='cop_lic' name='cop_lic'>" . $row["cop_licenses"] . "</textarea>";
                            } else {
                                echo "<h4>" . $lang['cop'] . " " . $lang['licenses'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='cop_lic' name='cop_lic'>" . $row["cop_licenses"] . "</textarea>";
                            }
                            ?>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <?php
                            if ($_SESSION['user_level'] >= 2) {
                                echo "<h4>" . $lang['cop'] . " " . $lang['gear'] . ":</h4> <textarea rows='5' style='width: 100%' id='cop_gear' name='cop_gear'>" . $row["cop_gear"] . "</textarea>";
                            } else {
                                echo "<h4>" . $lang['cop'] . " " . $lang['gear'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='cop_gear' name='cop_gear'>" . $row["cop_gear"] . "</textarea>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php }
            if (isset($row["civ_licenses"])) { ?>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'><i class='fa fa-child fa-fw'></i><?php echo " " . $lang['civil']; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <?php
                            if ($_SESSION['user_level'] >= 2) {
                                echo "<h4>" . $lang['civ'] . " " . $lang['licenses'] . ":</h4> <textarea rows='5' style='width: 100%' id='civ_lic' name='civ_lic'>" . $row["civ_licenses"] . "</textarea>";
                            } else {
                                echo "<h4>" . $lang['civ'] . " " . $lang['licenses'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='civ_lic' name='civ_lic'>" . $row["civ_licenses"] . "</textarea>";
                            }
                            ?>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <?php
                            if ($_SESSION['user_level'] >= 2) {
                                echo "<h4>" . $lang['civ'] . " " . $lang['gear'] . ":</h4> <textarea rows='5' style='width: 100%' id='civ_gear' name='civ_gear'>" . $row["civ_gear"] . "</textarea>";
                            } else {
                                echo "<h4>" . $lang['civ'] . " " . $lang['gear'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='civ_gear' name='civ_gear'>" . $row["civ_gear"] . "</textarea>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php }
            if (isset($row["med_licenses"])) { ?>
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'><i class='fa fa-ambulance fa-fw'></i><?php echo " " . $lang['medic']; ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <?php
                            if ($_SESSION['user_level'] >= 2) {
                                echo "<h4>" . $lang['medic'] . " " . $lang['licenses'] . ":</h4> <textarea rows='5' style='width: 100%' id='med_lic' name='med_lic'>" . $row["med_licenses"] . "</textarea>";
                            } else {
                                echo "<h4>" . $lang['medic'] . " " . $lang['licenses'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='med_lic' name='med_lic'>" . $row["med_licenses"] . "</textarea>";
                            }
                            ?>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <?php
                            if ($_SESSION['user_level'] >= 2) {
                                echo "<h4>" . $lang['medic'] . " " . $lang['gear'] . ":</h4> <textarea rows='5' style='width: 100%' id='med_gear' name='med_gear'>" . $row["med_gear"] . "</textarea>";
                            } else {
                                echo "<h4>" . $lang['medic'] . " " . $lang['gear'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='med_gear' name='med_gear'>" . $row["med_gear"] . "</textarea>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php }
            if (sql_smartPhone == TRUE && $_SESSION['user_level'] >= 2) {
                include("views/modules/sqlSmartPhone/module.php");
            }
        }
        ?>
    </div>

    <div class="col-md-4">
        <center>
            <?php
            echo "<input id='playerId' type='hidden' name='playerId' value='" . $pID . "'>";
            echo "<input class='btn btn-lg btn-primary'  type='submit'  name='edit' value='" . $lang['subChange'] . "'>";
            ?>
            <br/>
        </center>
    </div>
<?php
} else {
    include("views/errors/noID.php");
}
?>
</form>
