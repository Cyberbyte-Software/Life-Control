<div class='panel panel-default'>
    <div class='panel-heading'>
        <h3 class='panel-title'><i class='fa fa-envelope-o fa-fw'></i>Notes </h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>Note Owner</th>
                    <th><?php echo $lang['message']; ?></th>
                    <th><?php echo $lang['time']; ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = 'SELECT * FROM `notes` WHERE `uid` = "' . $uID . '" ORDER BY `note_updated` DESC LIMIT 10';
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    echo "<tr>";
                    echo "<td>" . $row["staff_name"] . "</td>";
                    echo "<td>" . $row["note_text"] . "</td>";
                    echo "<td>" . $row["message"] . "</td>";
                    echo "<td>" . $row["note_updated`"] . "</td>";
                    echo "</tr>";
                };
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
