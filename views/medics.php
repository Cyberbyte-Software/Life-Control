<?php

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
if (!$db_connection->connect_errno) {
    $start_from = ($page - 1) * $page_rows;
    $max = 'LIMIT ' . $start_from . ',' . $page_rows;

    $sql = "SELECT `name`,`mediclevel`,`playerid`,`uid` FROM `players` WHERE `mediclevel` >= '1' ORDER BY `mediclevel` " . $max . " ;";
    $result_of_query = $db_connection->query($sql);
    if ($result_of_query->num_rows > 0) {
        ?>
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo $lang['medic']; ?>
                    <small><?php echo " " . $lang['overview']; ?></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="col-md-12">
            <div class="content-panel">
                <table class="table table-striped table-advance table-hover">
                    <h4>
                        <i class="fa fa-ambulance fa-fw"></i>
                        <?php echo " " . $lang['medics']; ?>
                    </h4>
                    <hr>
                    <thead>
                    <tr>
                        <th><i class="fa fa-user"></i><?php echo " " . $lang['name']; ?></th>
                        <th><i class="fa fa-eye"></i><?php echo " " . $lang['playerID']; ?></th>
                        <th><i class="fa fa-user"></i><?php echo " " . $lang['rank']; ?></th>
                        <?php if ($_SESSION['user_level'] >= P_EDIT_PLAYER) echo '<th><i class="fa fa-pencil"> ' . $lang['edit'] . '</th>'; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result_of_query)) {
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["playerid"] . "</td>";
                        echo "<td>" . $row["mediclevel"] . "</td>";
                        if ($_SESSION['user_level'] >= P_EDIT_PLAYER) {
                            echo "<td><a class='btn btn-primary btn-xs' href='editPlayer.php?ID=" . $row["uid"] . "'>";
                            echo "<i class='fa fa-pencil'></i></a></td>";
                        }
                        echo "</tr>";
                    };
                    echo "</tbody></table>";

                    $sql = "SELECT * FROM `players` WHERE `mediclevel` >= '1'";
                    $result_of_query = $db_connection->query($sql);
                    $total_records = mysqli_num_rows($result_of_query);
                    $total_pages = ceil($total_records / $page_rows);
                    if ($total_pages > 1) {
                        echo "<center><a class='btn btn-primary' href='medics.php?page=1'>" . $lang['first'] . "</a> ";
                        ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <?php echo $lang['page'] . " " ?><span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu scrollable-menu" role="menu">
                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li><?php echo "<a href='medics.php?page=" . $i . "'>" . $i . "</a> "; ?></li>
                                <?php }; ?>
                            </ul>
                        </div>
                        <?php
                        echo "<a class='btn btn-primary' href='medics.php?page=" . $total_pages . "'>" . $lang['last'] . "</a></center>";
                    }
                    ?>
                    </tbody>
                    <br>
                </table>
            </div>
        </div>
    <?php
    } else include("/views/Errors/noRecords.php");
} else {
    $this->errors[] = "Database connection problem.";
}