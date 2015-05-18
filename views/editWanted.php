<?php

function updated()
{
    echo "<div class='row'><div class='col-lg-12'>";
    echo "<div class='alert alert-danger alert-dismissable'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<i class='fa fa-info-circle'></i> File updated</div></div></div>";//todo: use $lang['updated']
}

function stripArray($input)
{
    $array = array();
    $array = explode("],[", $input);
    $array = str_replace('"[[', "", $array);
    $array = str_replace(']]"', "", $array);
    $array = str_replace('`', "", $array);
    return $array;
}

//Thanks PHP Doc's For these two Function (User: biohazard dot ge at gmail dot com ¶ )
function before($this, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this));
};

function after($this, $inthat)
{
    if (!is_bool(strpos($inthat, $this)))
        return substr($inthat, strpos($inthat, $this) + strlen($this));
};

$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["ID"])) {
    $wantedID = $_GET["ID"];

    if (isset($_POST["editType"])) {
        if (!$db_connection->connect_errno) {
            switch ($_POST["editType"]) 
			{
                case "crimes":
                    $crimes_value = $_POST["wantedCrimes"];
					$update = "UPDATE `wanted` SET  `wantedCrimes` = '".$crimes_value."' WHERE `wanted`.`wantedID` = '".$wantedID."'";
                    $result_of_query = $db_connection->query($update);
                    updated();
                    break;
                case "wanted_info":                   
					case 3:
						$wantedName = $_POST["wantedName"];
						$wantedBounty = intval($_POST["wantedBounty"]);
						$active = intval($_POST["active"]);
						$update = "UPDATE `wanted` SET `active` = '".$active."', `wantedName` = '".$wantedName."', `wantedBounty` = '".$wantedBounty."' WHERE `wanted`.`wantedID` = '".$wantedID."'";
						$result_of_query = $db_connection->query($update);
						updated();
						break;
            }

        } else {
            $this->errors[] = "Database connection problem.";
        }
    }

    ?>
    <!-- /.row -->
    <?php
    $sql = 'SELECT * FROM `wanted` WHERE `wantedID` ="' . $wantedID . '";';
    $result_of_query = $db_connection->query($sql);
    if ($result_of_query->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            ?>
            <div class="col-md-3" style="float:left;  padding-top:20px;">
            <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title"><i class="fa fa-child fa-fw"></i><?php echo $row["wantedName"]; ?></h2>
            </div>
            <div class="panel-body">

            <center><img src="assets/img/uniform/Default.jpg"/>
            <?php
				echo "<h4>" . $lang['name'] . ": " . $row["wantedName"] . "</h4>";
            ?>

            <span style="padding-left:15px;" class="fa fa-2x fa-bank">
            <h4> <?php echo $lang['bounty'] . ": " . $row["wantedBounty"]; ?> </h4>
            </span>
            <?php
            if ($row["active"] == 0) {
                echo "<h4><span class='label label-success'>" . $lang["not"] . " " . $lang["active"] . "</span> ";
            } else {
                echo "<h4><span class='label label-danger'>" . $lang["active"] . "</span> ";
            }

            if ($_SESSION['user_level'] >= P_EDIT_PLAYER) {
                echo '<a data-toggle="modal" href="#edit_wanted" class="btn btn-primary btn-xs" style="float: right;">';
                echo '<i class="fa fa-pencil"></i>';
                echo '</a>';
            }
        }
    } else echo "<h1>" . $lang['noPlayer'] . "<h1>";
    echo "</center>";
    ?>
    </div>
    </div>
    </div>

    <div class="col-md-9" style="float:right; padding-top:20px;">
        <div class="panel panel-default" style="float:left; width:100%; margin:0 auto;">
            <ul id="myTab" class="nav nav-tabs">
                <?php 
				if ($_SESSION['user_level'] >= P_VIEW_WANTED) echo'<li><a href="#crimes" data-toggle="tab">'. $lang['crimes'] .'</a></li>';
                ?>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active well" id="crimes">
                    <h4 style="centred"><?php echo $lang['crimes']; ?> </h4>
                    <?php
                    $sql = 'SELECT * FROM `wanted` WHERE `wantedID` ="' . $wantedID . '";';
                    $result_of_query = $db_connection->query($sql);
                    while ($row = mysqli_fetch_assoc($result_of_query)) {
					?>
							<textarea class="form-control" rows="6" name="wantedCrimes"><?php echo $row['wantedCrimes']; ?></textarea>

					<?php
                    }
					if ($_SESSION['user_level'] >= P_EDIT_WANTED)
					{
                    ?>
						<a data-toggle="modal" href="#edit_crimes" class="btn btn-primary btn-xs"
						   style="float: right;">
							<i class="fa fa-pencil"></i>
						</a>
					<?php   } ?>
                </div> 
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_crimes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
					<span class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['edit'] . " " . $lang['crimes'];?>
                    </h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `wanted` WHERE `wantedID` ="' . $wantedID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>
                    <form method="post" action="editWanted.php?ID=<?php echo $row['uid']; ?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="crimes"/>

                                <div class="row">
                                    <textarea class="form-control" rows="10" name="wantedCrimes"><?php echo $row['wantedCrimes']; ?></textarea>
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
    <div class="modal fade" id="edit_wanted" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span
                            class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['edit'] . " " . $lang['player']; ?>
                    </h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `wanted` WHERE `wantedID` ="' . $wantedID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>

                    <form method="post" action="editWanted.php?ID=<?php echo $row['uid']; ?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="player_edit"/>

                                <div class="row">
                                    <center>
                                        <?php
											echo "<center>";
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
    include("views/Errors/noID.php");
}