<?php

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$page_rows = results_per_page;
// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}
?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $lang['navProfile']; ?>
            <small><?php echo " " . $lang['overview']; ?></small>
        </h1>
        <div class="col-lg-4" style="top:3px;float:right;">
            <form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
                  name='searchPlayer'>
                <input id='searchText' type='text' name='searchText'>
                <input class='btn btn-sm btn-primary' type='submit' name='class' value='Search Bounty'>
            </form>
        </div>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-list-ul"></i><?php echo " " . $lang['navProfile']; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-car fa-fw"></i><?php echo " " . $lang['wantList']; ?>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th><?php echo $lang['id']; ?></th>
                        <th><?php echo $lang['name']; ?></th>
                        <th><?php echo $lang['crimes']; ?></th>
                        <th><?php echo $lang['bounty']; ?></th>
                        <th><?php echo $lang['active']; ?></th>
                        <th><?php echo $lang['edit']; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!$db_connection->connect_errno) {

                        if (!(isset($_POST['pagenum']))) {
                            $pagenum = 1;
                        } else {
                            $pagenum = $_POST['pagenum'];
                        }

                        $sql = "SELECT * FROM `wanted`;";

                        $result_of_query = $db_connection->query($sql);
                        $rows = mysqli_num_rows($result_of_query);

                        $last = ceil($rows / $page_rows);

                        if ($pagenum < 1) {
                            $pagenum = 1;
                        } elseif ($pagenum > $last) {
                            $pagenum = $last;
                        }

                        $max = 'limit ' . ($pagenum - 1) * $page_rows . ',' . $page_rows;

                        if (isset($_POST['searchText'])) {
                            $searchText = $_POST['searchText'];
                            $sql = "SELECT * FROM `wanted` WHERE `wantedBounty` LIKE '%" . $searchText . "%' " . $max . " ;";
                        } else {
                            $sql = "SELECT * FROM `wanted` " . $max . " ;";
                        }
                        $result_of_query = $db_connection->query($sql);
                        while ($row = mysqli_fetch_assoc($result_of_query)) {
                            $wantedID = $row["wantedID"];
                            echo "<tr>";
                            echo "<td>" . $row["wantedID"] . "</td>";
                            echo "<td>" . $row["wantedName"] . "</td>";
                            echo "<td>" . $row["wantedCrimes"] . "</td>";
                            echo "<td>" . $row["wantedBounty"] . "</td>";
                            echo "<td>" . $row["active"] . "</td>";
                            echo "<td><form method='post' action='editWanted.php' name='PlayerEdit'>";
                            echo "<input id='wantedID' type='hidden' name='wantedID' value='" . $wantedID . "'>";
                            echo "<input class='btn btn-sm btn-primary'  type='submit'  name='edit' value='" . $lang['edit'] . "'>";
                            echo "</form></td>";
                            echo "</tr>";
                        };
                        echo "</tbody></table>";
                        echo "<table><thead>";
                        echo "<br>";
                        if ($pagenum == 1) {
                        } else {
                            echo "<th><form method='post' action='" . $_SERVER['PHP_SELF'] . "' name='Gpagenum'>";
                            echo "<input id='Gpagenum' type='hidden' name='Gpagenum' value='1'>";
                            echo "<input type='submit' value=' <<-" . $lang['first'] . "  '>";
                            echo "</form></th>";
                            $previous = $pagenum - 1;
                            echo "<th><form style='float:right;' method='post' action='" . $_SERVER['PHP_SELF'] . "' name='Gpagenum'>";
                            echo "<input id='Gpagenum' type='hidden' name='Gpagenum' value='" . $previous . "'>";
                            echo "<input type='submit' value=' <-" . $lang['previous'] . "  '>";
                            echo "</form></th>";
                        }
                        //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
                        if ($pagenum == $last) {
                        } else {
                            $next = $pagenum + 1;
                            echo "<th><form method='post' action='" . $_SERVER['PHP_SELF'] . "' name='Gpagenum'>";
                            echo "<input id='Gpagenum' type='hidden' name='Gpagenum' value='" . $next . "'>";
                            echo "<input type='submit' value=' " . $lang['next'] . " ->  '>";
                            echo "</form></th>";
                            echo " ";
                            echo "<th><form method='post' action='" . $_SERVER['PHP_SELF'] . "' name='Gpagenum'>";
                            echo "<input id='Gpagenum' type='hidden' name='Gpagenum' value='" . $last . "'>";
                            echo "<input type='submit' value=' " . $lang['last'] . " ->>  '>";
                            echo "</form></th>";
                        }
                        echo "</thead></table>";
                    } else {
                        $this->errors[] = "Database connection problem.";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
