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
            <?php echo $lang['houses']; ?>
            <small><?php echo " " . $lang['overview']; ?></small>
        </h1>
        <div class="col-lg-4" style="top:3px;float:right;">
            <form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
                  name='searchPlayer'>
                <input id='searchText' type='text' name='searchText'>
                <input class='btn btn-sm btn-primary' type='submit' name='pid'
                       value='<?php echo $lang['search'] . " " . $lang['PID']; ?>'>
                <input class='btn btn-sm btn-primary' type='submit' name='pos'
                       value='<?php echo $lang['search'] . " " . $lang['position']; ?>'>
            </form>
        </div>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-home"></i><?php echo " " . $lang['houses']; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-home fa-fw"></i><?php echo " " . $lang['houses']; ?>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th><?php echo $lang['owner'] . " " . $lang['playerID']; ?></th>
                        <th><?php echo $lang['position']; ?></th>
                        <th><?php echo $lang['owned']; ?></th>
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

                        $sql = "SELECT * FROM `houses`;";

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

                            if (isset($_POST['pos'])) {
                                $sql = "SELECT * FROM `houses` WHERE `pos` LIKE '%" . $searchText . "%' " . $max . " ;";
                            } else {
                                $sql = "SELECT * FROM `houses` WHERE `pid` LIKE '%" . $searchText . "%' " . $max . " ;";
                            }
                        } else {
                            $sql = "SELECT * FROM `houses` " . $max . " ;";
                        }
                        $result_of_query = $db_connection->query($sql);
                        while ($row = mysqli_fetch_assoc($result_of_query)) {
                            $hID = $row["id"];
                            echo "<tr>";
                            echo "<td>" . $row["pid"] . "</td>";
                            echo "<td>" . $row["pos"] . "</td>";
                            echo "<td>" . $row["owned"] . "</td>";
                            echo "<td><form method='post' action='editHouse.php' name='PlayerEdit'>";
                            echo "<input id='hID' type='hidden' name='hID' value='" . $hID . "'>";
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
