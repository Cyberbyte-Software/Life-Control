<?php

// create a database connection, using the constants from config/config.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$page_rows = results_per_page;
// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (!$db_connection->connect_errno) {
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
            $sql = "SELECT * FROM `players` WHERE `playerid` LIKE '%" . $searchText . "%' " . $max . " ;";
        } else {
            $sql = "SELECT * FROM `players` WHERE `name` LIKE '%" . $searchText . "%' " . $max . " ;";
        }
    } else {
        $sql = "SELECT * FROM `players` " . $max . " ;";
    }

    $result_of_query = $db_connection->query($sql);
    if ($result_of_query->num_rows > 0) {
        ?>

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo $lang['players']; ?>
                    <small><?php echo " " . $lang['overview']; ?></small>
                </h1>

            </div>
        </div>
        <!-- /.row -->

        <div class="col-md-12">
        <div class="content-panel">
        <table class="table table-striped table-advance table-hover">
        <h4>
            <i class="fa fa-child fa-fw"></i><?php echo " " . $lang['players']; ?>
            <div class="col-lg-5 pull-right">
                <form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
                      name='searchPlayer'>
                    <input id='searchText' type='text' name='searchText'>
                    <input class='btn btn-sm btn-primary' type='submit' name='pid'
                           value='<?php echo $lang['search'] . " " . $lang['PID']; ?>'>
                    <input class='btn btn-sm btn-primary' type='submit' name='name'
                           value='<?php echo $lang['search'] . " " . $lang['name']; ?>'>
                </form>
            </div>
        </h4>
        <hr>
        <thead>
        <tr>
            <th><i class="fa fa-user"></i><?php echo " " . $lang['name']; ?></th>
            <th><i class="fa fa-eye"></i><?php echo " " . $lang['playerID']; ?></th>
            <th class="hidden-xs"><i class="fa fa-money"></i><?php echo " " . $lang['cash']; ?></th>
            <th class="hidden-xs"><i class="fa fa-bank"></i><?php echo " " . $lang['bank']; ?></th>
            <th class="hidden-xs"><i class="fa fa-taxi"></i><?php echo " " . $lang['cop']; ?></th>
            <th class="hidden-xs"><i class="fa fa-ambulance"></i><?php echo " " . $lang['medic']; ?></th>
            <th class="hidden-xs"><i class="fa fa-cogs"></i><?php echo " " . $lang['admin']; ?></th>
            <?php if ($_SESSION['user_level'] >= P_EDIT_PLAYER) echo '<th class="hidden-xs"><i class="fa fa-pencil"> ' .
                $lang['edit'] . '</th>'; else  echo '<th class="hidden-xs"><i class="fa fa-eye"> ' . $lang['view'] . '</th>';
            if ($_SESSION['user_level'] >= P_VIEW_STEAM) echo '<th class="hidden-xs"><i class="fa fa-steam"></i> Steam</th>'
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            $playersID = $row["playerid"];
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $playersID . "</td>";
            echo "<td class='hidden-xs'>" . $row["cash"] . "</td>";
            echo "<td class='hidden-xs'>" . $row["bankacc"] . "</td>";
            echo "<td class='hidden-xs'>" . $row["coplevel"] . "</td>";
            echo "<td class='hidden-xs'>" . $row["mediclevel"] . "</td>";
            echo "<td class='hidden-xs'>" . $row["adminlevel"] . "</td>";
            if ($_SESSION['user_level'] >= P_EDIT_PLAYER) {
                echo "<td><a class='btn btn-primary btn-xs' href='editPlayer.php?ID=" . $row["uid"] . "'>";
                echo "<i class='fa fa-pencil'></i></a></td>";
            }
            if ($_SESSION['user_level'] >= P_VIEW_STEAM) {
                echo "<td class='hidden-xs'><a href='http://steamcommunity.com/profiles/" . $row["playerid"] . "' ";
                echo "class='btn btn-primary btn-xs'><i class='fa fa-steam'></i></a></td>";
            }
            echo "</tr>";

        }
    ;
        echo "</tbody></table>";

        $sql = "SELECT * FROM `players`";
        $result_of_query = $db_connection->query($sql);
        $total_records = mysqli_num_rows($result_of_query);
        $total_pages = ceil($total_records / $page_rows);
        if ($total_pages > 1) {
            echo "<center><a class='btn btn-primary' href='players.php?page=1'>" . $lang['first'] . "</a> ";
            ?>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <?php echo $lang['page'] . " " ?><span class="caret"></span>
                </button>
                <ul class="dropdown-menu scrollable-menu" role="menu">
                    <?php
                    for ($i = 1; $i <= $total_pages; $i++) {
                        ?>
                        <li><?php echo "<a href='players.php?page=" . $i . "'>" . $i . "</a> "; ?></li>
                    <?php }; ?>
                </ul>
            </div>

            <?php
            echo "<a class='btn btn-primary' href='players.php?page=$total_pages'>" . $lang['last'] . "</a></center>";
        }
    } else {
        $this->errors[] = "Database connection problem.";
    }
    ?>
    <br>
    </div>
    </div>
<?php
} else include("/views/Errors/noRecords.php");