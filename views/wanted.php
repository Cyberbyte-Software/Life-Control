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
        $sql = "SELECT * FROM `wanted` WHERE `wantedBounty` LIKE '%" . $searchText . "%' " . $max . " ;";
    } else {
        $sql = "SELECT * FROM `wanted` " . $max . " ;";
    }
    $result_of_query = $db_connection->query($sql);
    if ($result_of_query->num_rows > 0) {
        ?>

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo $lang['navProfile']; ?>
                    <small><?php echo " " . $lang['overview']; ?></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="col-md-12">
        <div class="content-panel">
        <table class="table table-striped table-advance table-hover">
        <h4>
            <i class="fa fa-sitemap"></i>
            <?php echo " " . $lang['wantList']; ?>
            <div class="col-lg-4 pull-right">
                <form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
                      name='searchPlayer'>
                    <input id='searchText' type='text' name='searchText'>
                    <input class='btn btn-sm btn-primary' type='submit' name='class' value='Search Bounty'>
                </form>
            </div>
        </h4>
        <hr>
        <thead>
        <tr>
            <th><i class="fa fa-eye"></i><?php echo " " . $lang['id']; ?></th>
            <th><i class="fa fa-user"></i><?php echo " " . $lang['name']; ?></th>
            <th><i class="fa fa-user"></i><?php echo " " . $lang['crimes']; ?></th>
            <th><i class="fa fa-user"></i><?php echo " " . $lang['bounty']; ?></th>
            <th><i class="fa fa-user"></i><?php echo " " . $lang['active']; ?></th>
            <th><i class="fa fa-pencil"></i><?php echo " " . $lang['edit']; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result_of_query)) {
            $wantedID = $row["wantedID"];
            echo "<tr>";
            echo "<td>" . $row["wantedID"] . "</td>";
            echo "<td>" . $row["wantedName"] . "</td>";
            echo "<td>" . $row["wantedCrimes"] . "</td>";
            echo "<td>" . $row["wantedBounty"] . "</td>";
            echo "<td>" . $row["active"] . "</td>";
            echo "<td><a class='btn btn-primary btn-xs' href='editWanted.php?ID=" . $row["wantedID"] . "'>";
            echo "<i class='fa fa-pencil'></i></a></td>";
            echo "</tr>";
        };
        echo "</tbody></table>";

        $sql = "SELECT * FROM `wanted`;";
        $result_of_query = $db_connection->query($sql);
        $total_records = mysqli_num_rows($result_of_query);
        $total_pages = ceil($total_records / $page_rows);
        echo "<center><a class='btn btn-primary' href='wanted.php?page=1'>" . 'First Page' . "</a> ";
        ?>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php echo $lang['page'] . " " ?><span class="caret"></span>
            </button>
            <ul class="dropdown-menu scrollable-menu" role="menu">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    ?>
                    <li><?php echo "<a href='wanted.php?page=" . $i . "'>" . $i . "</a> "; ?></li>
                <?php }; ?>
            </ul>
        </div>

        <?php
        echo "<a class='btn btn-primary' href='wanted.php?page=$total_pages'>" . 'Last Page' . "</a></center>";

    } else {
        $this->errors[] = "Database connection problem.";
    }
    ?>
    </tbody>
    <br>
    </table>
    </div>
    </div>
<?php
} else include ("/views/Errors/noRecords.php");