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
    $array = explode(",", $input);
    $array = str_replace('"[', "", $array);
    $array = str_replace(']"', "", $array);
	$array = str_replace('`', "", $array);
	
    return $array;
}


$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["ID"])) {
	$gID = $_GET["ID"];

    if (isset($_POST["editType"])) {
        switch ($_POST["editType"]) {
            case "edit_members":
                $gMem = $_POST["gMem"];
                $sql = "UPDATE `gangs` SET `members`='" . $gMem . "' WHERE `gangs`.`id` = '" . $gID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
					updated();
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
            case "del_gang":
                $sql = "DELETE FROM `gangs` WHERE `gangs`.`id` = '" . $gID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
					updated();
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
            case "gang_edit":
				$gID = $_GET["ID"];
				$gname = $_POST["gname"];
				$gowner = $_POST["gowner"];
				$gMM = $_POST["gMM"];
				$gbank = $_POST["gbank"];
				$gAct = $_POST["gAct"];
				$sql = "UPDATE `gangs` SET `owner`='" . $gowner . "',`name`='" . $gname . "',`maxmembers`='" . $gMM . "',`bank`='" . $gbank . "',`active`='" . $gAct . "' WHERE `gangs`.`id` = '" . $gID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
					updated();
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
        }
    }

    $sql = 'SELECT * FROM `gangs` WHERE `id` ="' . $gID . '";';
    $result_of_query = $db_connection->query($sql);
    if ($result_of_query->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            ?>
            <div class="col-md-3" style="float:left;  padding-top:20px;">
            <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title"><i
                        class="fa fa-child fa-fw"></i><?php echo nameID($row["owner"]) . "'s " . $lang['gang']; ?>
                </h2>
            </div>
            <div class="panel-body">
            <center><img src="assets/img/uniform/U_BG_Guerilla2_3.jpg"/>
            <?php
            echo "<h4>" . $lang['owner'] . ": <a href=\"editPlayer.php?ID=" .uID($row["owner"])."\">" . nameID($row["owner"]) . "</a></h4>";
            echo "<h4>" . $lang['name'] . ": " . $row["name"] . "</h4>";
			?>
            <span style="padding-left:15px;" class="fa fa-2x fa-bank">
				<h4> <?php echo $lang['bank'] . ": " . $row["bank"]; ?> </h4>
            </span>			
			<?php
			if ($row["active"] == 0) {
                echo "<h4><span class='label label-danger'>" . $lang["not"] . " " . $lang["active"] . "</span> ";
            } else {
                echo "<h4><span class='label label-success'>" . $lang["active"] . "</span> ";
            }
            if ($_SESSION['user_level'] >= P_EDIT_GANGS) {
                echo '<a data-toggle="modal" href="#edit_gang" class="btn btn-primary btn-xs" style="float: right; margin-right:3px;">';
					echo '<i class="fa fa-pencil"></i>';
                echo '</a>';
                echo '<a data-toggle="modal" href="#gang_del" class="btn btn-danger btn-xs" style="float: right; margin-right:3px;">';
					echo '<i class="fa fa-warning"></i>';
                echo '</a>';				
            }			
        }
    } else echo "<h1>".$lang['noRes']."</h1>";
    echo "</center>";
    ?>
    </div>
    </div>
    </div>

    <div class="col-md-9" style="float:right; padding-top:20px;">
        <?php
        $sql = 'SELECT * FROM `gangs` WHERE `id` ="' . $gID . '";';
        $result_of_query = $db_connection->query($sql);
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            ?>
            <div class="row mtbox">
				<div class="col-md-2 col-sm-2 col-md-offset-1 box0">
					<div class="box1">
						<span class="fa fa-3x fa-users"></span>
						<h4> <?php echo $lang['maxMembers'] . ": " . $row["maxmembers"];?> </h4>
					</div>
				</div>
			</div>
		<?php            
        }
		?>

        <div class="panel panel-default" style="float:left; width:100%; margin:0 auto;">
            <ul id="myTab" class="nav nav-tabs">
                <li><a href="#gang_members" data-toggle="tab"><?php echo $lang['members']; ?></a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in well" id="civ_inv">
                    <h4 style="centred"><?php echo $lang['gang'] . " " . $lang['members'];?> </h4>
                    <?php
                    $sql = 'SELECT * FROM `gangs` WHERE `id` ="' . $gID . '";';
                    $result_of_query = $db_connection->query($sql);
                    while ($row = mysqli_fetch_assoc($result_of_query)) {
						
						$return = stripArray($row["members"]);

						foreach ($return as $value) {
							echo "<span class='label label-success' style='margin-right:3px; line-height:2;'>" . nameID($value) . "</span> ";
						}	                        
                    }
                    ?>
                    <br>
                    <a data-toggle="modal" href="#edit_gang_members" class="btn btn-primary btn-xs" style="float: right;">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_gang_members" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span
                            class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['edit'] . " " . $lang['gang'] . " " . $lang['members'];?>
                    </h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `gangs` WHERE `id` ="' . $gID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>
                    <form method="post" action="editGang.php?ID=<?php echo $gID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="edit_members"/>

                                <div class="row">
									<textarea id='gMem' name='gMem' class="form-control" rows="10"><?php echo $row['members'];?></textarea>
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
    <div class="modal fade" id="gang_del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
						<span class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['DELETE'] . " " . $lang['gang'];?>
                    </h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `gangs` WHERE `id` ="' . $gID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>
                    <form method="post" action="editGang.php?ID=<?php echo $gID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="del_gang"/>

                                <div class="row">
                                    <center><h4>Are you Sure?</h4></center>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="submit"><?php echo $lang['yes']; ?></button>
                            <button class="btn btn-primary" data-dismiss="modal" type="reset"><?php echo $lang['no']; ?></button>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_gang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['edit'] . " " . $lang['gang'];?></h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `gangs` WHERE `id` ="' . $gID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {

                    ?>

                    <form method="post" action="editGang.php?ID=<?php echo $gID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="gang_edit"/>

                                <div class="row">
                                    <center>
										<?php
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