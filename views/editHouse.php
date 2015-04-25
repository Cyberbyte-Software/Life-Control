<?php
function updated()
{
    echo "<div class='row'><div class='col-lg-12'>";
    echo "<div class='alert alert-danger alert-dismissable'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<i class='fa fa-info-circle'></i> File updated</div></div></div>";//todo: use $lang['updated']
}

$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["ID"])) 
{
    $hID = $_GET["ID"];

    if (isset($_POST["editType"])) 
	{
        switch ($_POST["editType"]) 
		{
            case "house_inv":
                $hInv = $_POST["hInv"];
                $sql = "UPDATE `houses` SET `inventory`='" . $hInv . "' WHERE `houses`.`id` = '" . $hID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
					updated();
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
            case "house_cont":
				$hCont = $_POST["hCont"];
                $sql = "UPDATE `houses` SET `containers`='".$hCont."' WHERE `houses`.`id` = '" . $hID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
					updated();
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
            case "house_del":
                $sql = "DELETE FROM `houses` WHERE `houses`.`id` = '" . $hID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
					header("location:houses.php");
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
            case "house_details":
				$hPos = $_POST["hPos"];
				$hOwn = $_POST["hOwn"];
				$hOwned = $_POST["hOwned"];
                $sql = "UPDATE `houses` SET `pid`='".$hOwn."',`pos`='".$hPos."',`owned`='".$hOwned."' WHERE `houses`.`id` = '" . $hID . "'";
                if (!$db_connection->connect_errno) {
                    $result_of_query = $db_connection->query($sql);
					updated();
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                break;
        }
    }

    $sql = 'SELECT * FROM `houses` WHERE `id` ="' . $hID . '";';
    $result_of_query = $db_connection->query($sql);
    if ($result_of_query->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result_of_query)) {
?>
            <div class="col-md-4" style="float:left;  padding-top:20px;">
            <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title"><i
                        class="fa fa-child fa-fw"></i><?php echo nameID($row["pid"]) . "'s " . $lang['house']; ?>
                </h2>
            </div>
            <div class="panel-body">
            <center><img src="assets/img/house/1.jpg"/>
            <?php
            echo "<h4>" . $lang['owner'] . ": <a href=\"editPlayer.php?ID=" .uID($row["pid"])."\">" . nameID($row["pid"]) . "</a></h4>";
            echo "<h4>" . $lang['position'] . ": " . $row["pos"] . "</h4>";

            if ($_SESSION['user_level'] >= P_EDIT_HOUSES) echo'
                <div style="float: right;">
                    <a data-toggle="modal" href="#edit_house" class="btn btn-primary btn-xs" style="margin-right:3px">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a data-toggle="modal" href="#del_house" class="btn btn-danger btn-xs" style="margin-right:3px">
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
        echo '<div class="panel panel-default" style="float:left; width:100%; margin:0 auto;">';
            echo '<ul id="myTab" class="nav nav-tabs">';
                echo '<li><a href="#house_inv" data-toggle="tab">'. $lang['inventory'] .'</a></li>';
				echo '<li><a href="#house_cont" data-toggle="tab">'. $lang['containers'] .'</a></li>';
            echo '</ul>';
            ?>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in well" id="house_inv">
                    <h4 style="centred"><?php echo $lang['house'] . " " . $lang['inventory'];?> </h4>
                    <?php
                    $sql = 'SELECT * FROM `houses` WHERE `id` ="' . $hID . '";';
                    $result_of_query = $db_connection->query($sql);
                    while ($row = mysqli_fetch_assoc($result_of_query)) {
                        echo "<textarea class='form-control' readonly rows='5' style='width: 100%' id='civ_gear' name='civ_gear'>" . $row["inventory"] . "</textarea>";
                    }
                    ?>
                    <br>
                    <a data-toggle="modal" href="#edit_house_inv" class="btn btn-primary btn-xs" style="float: right;">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <br>
                </div>
                <div class="tab-pane fade well" id="house_cont">
                    <h4 style="centred"><?php echo $lang['house'] . " " . $lang['containers'];?> </h4>
                    <?php
                    $sql = 'SELECT * FROM `houses` WHERE `id` ="' . $hID . '";';
                    $result_of_query = $db_connection->query($sql);
                    while ($row = mysqli_fetch_assoc($result_of_query)) {
                        echo "<textarea class='form-control' readonly rows='5' style='width: 100%' id='house_cont' name='house_cont'>" . $row["containers"] . "</textarea>";
                    }
                    ?>
                    <br>
                    <a data-toggle="modal" href="#edit_house_cont" class="btn btn-primary btn-xs" style="float: right;">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <br>
                </div>				
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_house_inv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span
                            class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['edit'] . " " . $lang['house'] . " " . $lang['inventory'];?>
                    </h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `houses` WHERE `id` ="' . $hID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>
                    <form method="post" action="editHouse.php?ID=<?php echo $hID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="house_inv"/>

                                <div class="row">
                                    <textarea class="form-control" rows="10"
                                              name="hInv"><?php echo $row['inventory'];?></textarea>
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
	<div class="modal fade" id="edit_house_cont" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
						<span class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['edit'] . " " . $lang['house'] . " " . $lang['containers'];?>
                    </h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `houses` WHERE `id` ="' . $hID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>
                    <form method="post" action="editHouse.php?ID=<?php echo $hID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="house_cont"/>

                                <div class="row">
                                    <textarea class="form-control" rows="10"
                                              name="hCont"><?php echo $row['containers'];?></textarea>
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
    <div class="modal fade" id="del_house" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span
                            class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['DELETE'] . " " . $lang['house'];?>
                    </h4>
                </div>
				<form method="post" action="editHouse.php?ID=<?php echo $hID;?>" role="form">
					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" name="editType" value="house_del"/>

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
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_house" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
						<span class="glyphicon glyphicon-pencil"></span><?php echo " " . $lang['edit'] . " " . $lang['house'];?>
					</h4>
                </div>
                <?php
                $sql = 'SELECT * FROM `houses` WHERE `id` ="' . $hID . '";';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) 
				{

                    ?>

                    <form method="post" action="editHouse.php?ID=<?php echo $hID;?>" role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="editType" value="house_details"/>

                                <div class="row">
                                    <center>
                                        <?php
											echo "<h4>" . $lang['owner'] . ": <input id='hOwn' name='hOwn' type='text' value='" . $row["pid"] . "'></td><br/>";
											echo "<h4>" . $lang['position'] . ": <input id='hPos' name='hPos' type='text' value='" . $row["pos"] . "'readonly></td><br/>";
											echo "<h4>" . $lang['owned'] . ":  ";
											echo "<select id='hOwned' name='hOwned'>";
											echo '<option value="0"' . select('0', $row['owned']) . '>' . $lang['no'] . '</option>';
											echo '<option value="1"' . select('1', $row['owned']) . '>' . $lang['yes'] . '</option>';
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