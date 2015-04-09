<?php
// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

require __DIR__ . '/SourceQuery/SourceQuery.class.php';

// Edit this ->
define('SQ_TIMEOUT', 1);
define('SQ_ENGINE', SourceQuery :: SOURCE);
// Edit this <-

$Timer = MicroTime(true);

$Query = new SourceQuery();

$Info = Array();
$Rules = Array();
$Players = Array();

try {
    $Query->Connect(SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE);
    //$Query->SetRconPassword( $SQ_RCON_Pass );

    $Info = $Query->GetInfo();
    $Players = $Query->GetPlayers();
    $Rules = $Query->GetRules();
} catch (Exception $e) {
    $Exception = $e;
}

$Query->Disconnect();

$Timer = Number_Format(MicroTime(true) - $Timer, 4, '.', '');


?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $lang['players']; ?>
            <small><?php echo " " . $lang['overview']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-child"></i><?php echo " " . $lang['players']; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-child fa-fw"></i><?php echo " " . $lang['players']; ?>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th><?php echo $lang['name']; ?></th>
                        <th><?php echo $lang['time']; ?></th>
                        <!-- <th>Kick</th>
                        <th>Ban</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (Is_Array($Players)): ?>
                        <?php foreach ($Players as $Player): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($Player['Name']); ?></td>
                                <td><?php echo $Player['TimeF']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No players received</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
