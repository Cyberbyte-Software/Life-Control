<?php
require_once("config/carNames.php");

// create a database connection, using the constants from config/config.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$page_rows = results_per_page;
// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $page_rows;
$max = 'LIMIT ' . $start_from . ',' . $page_rows;

if (isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];

    if (isset($_POST['pid'])) {
        $sql = "SELECT * FROM `vehicles` WHERE `pid` LIKE '%" . $searchText . "%' " . $max . " ;";
    } else {
        $sql = "SELECT * FROM `vehicles` WHERE `classname` LIKE '%" . $searchText . "%' " . $max . " ;";
    }
} else {
    $sql = "SELECT * FROM `vehicles` " . $max . " ;";
}
$result_of_query = $db_connection->query($sql);
if ($result_of_query->num_rows > 0) {
    ?>
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $lang['vehicles']; ?>
                <small><?php echo " " . $lang['overview']; ?></small>
            </h1>
        </div>
    </div>
    <!-- /.row -->

    <div class="col-md-12">
        <div class="content-panel">
                <h4>
                    <i class="fa fa-car"></i>
                    <?php echo " " . $lang['vehicles']; ?>
                    <div class="col-lg-5 pull-right">
                        <form style="float:right;" method='post'
                              action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
                              name='searchPlayer'>
                            <input id='searchText' type='text' name='searchText'>
                            <input class='btn btn-sm btn-primary' type='submit' name='pid'
                                   value='<?php echo $lang['search'] . " " . $lang['PID']; ?>'>
                            <input class='btn btn-sm btn-primary' type='submit' name='class'
                                   value='<?php echo $lang['search'] . " " . $lang['class']; ?>'>
                        </form>
                    </div>
                </h4>
                <hr>
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th><i class="fa fa-eye"></i><?php echo " " . $lang['owner'] ?></th>
                    <th><i class="fa fa-car"></i><?php echo " " . $lang['class']; ?></th>
                    <th><i class="fa fa-car"></i><?php echo " " . $lang['type']; ?></th>
                    <th><i class="fa fa-car"></i><?php echo " " . $lang['plate']; ?></th>
                    <th><i class="fa fa-car"></i><?php echo " " . $lang['alive']; ?></th>
                    <th><i class="fa fa-info"></i><?php echo " " . $lang['active']; ?></th>
                    <?php if ($_SESSION['user_level'] >= P_EDIT_VEHICLES) echo '<th><i class="fa fa-pencil"> '. $lang['edit'] .'</th>'; ?>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    $vehID = $row["id"];
                    echo "<tr>";
                    echo "<td>" . nameID($row["pid"]) . "</td>";
                    echo "<td>" . carName($row["classname"]) . "</td>";
                    echo "<td>" . carType($row["type"], $lang) . "</td>";
                    echo "<td>" . $row["plate"] . "</td>";
                    echo "<td>" . yesNo($row["alive"], $lang) . "</td>";
                    echo "<td>" . yesNo($row["active"], $lang) . "</td>";
                    if ($_SESSION['user_level'] >= P_EDIT_VEHICLES){ echo "<td><a class='btn btn-primary btn-xs' href='editVeh.php?ID=" . $row["id"] . "'>";
                    echo "<i class='fa fa-pencil'></i></a></td>";}
                    echo "</tr>";
                };
                echo "</tbody></table>";

                $sql = "SELECT * FROM `vehicles`;";
                $result_of_query = $db_connection->query($sql);
                $total_records = mysqli_num_rows($result_of_query);
                $total_pages = ceil($total_records / $page_rows);
                if ($total_pages > 1)
                {
                    if (isset($_GET['ID']))
                    {
                        $fixingthis = $_GET['ID'];
                        echo "<center><a class='btn btn-primary' href='vehicles.php?page=1&ID=" . $fixingthis . "'>" . $lang['first'] . "</a> ";
                        ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <?php echo $lang['page'] . " " ?><span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu scrollable-menu" role="menu">
                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li><?php echo "<a href='vehicles.php?page=" . $i . "&ID=" . $fixingthis . "'>" . $i . "</a> "; ?></li>
                                <?php }; ?>
                            </ul>
                        </div>

                        <?php
                        echo "<a class='btn btn-primary' href='vehicles.php?page=$total_pages&ID=" . $fixingthis . "'>" . $lang['last'] . "</a></center>";
                    }
                    else
                    {
                        echo "<center><a class='btn btn-primary' href='vehicles.php?page=1'>" . $lang['first'] . "</a> ";
                        ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <?php echo $lang['page'] . " " ?><span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu scrollable-menu" role="menu">
                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li><?php echo "<a href='vehicles.php?page=" . $i . "'>" . $i . "</a> "; ?></li>
                                <?php }; ?>
                            </ul>
                        </div>

                        <?php
                        echo "<a class='btn btn-primary' href='vehicles.php?page=$total_pages'>" . $lang['last'] . "</a></center>";
                    }
                }
                ?>
                <br>
                </tbody>
            </table>
        </div>
    </div>
<?php
} else include("/views/Errors/noRecords.php");