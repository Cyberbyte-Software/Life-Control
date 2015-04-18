<?php
// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if(isset($_POST['kick']))
{
    $Query = new SourceQuery( );
    try
    {
        $Query->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE );

        $Query->SetRconPassword(SQ_SERVER_PASSWORD);

        var_dump( $Query->Rcon( 'say hello' ) );
    }
    catch( Exception $e )
    {
        echo $e->getMessage( );
    }
    $Query->Disconnect( );
}

if (isset($_GET["IP"])) {
	
	require __DIR__ . '/SourceQuery/SourceQuery.class.php';
	define('SQ_TIMEOUT', 1);
	define('SQ_ENGINE', SourceQuery :: SOURCE);
	
	$serverIp = $_GET["IP"];
	$serverPort = $_GET["Port"];

	$Timer = MicroTime(true);
	$Query = new SourceQuery();

	$Info = Array();
	$Rules = Array();
	$Players = Array();

	try {
		$Query->Connect($serverIp , $serverPort, SQ_TIMEOUT, SQ_ENGINE);
		//$Query->SetRconPassword( SQ_RCON_Pass );

		$Info = $Query->GetInfo();
		$Players = $Query->GetPlayers();
		$Rules = $Query->GetRules();
	} catch (Exception $e) {
		$Exception = $e;
	}

	$Query->Disconnect();
	$Timer = Number_Format(MicroTime(true) - $Timer, 4, '.', '');	
}

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
			</h4>
			<hr>
			<thead>
				<tr>
					<th><i class="fa fa-user"></i><?php echo " ". $lang['name']; ?></th>
					<th><i class="fa fa-clock-o"></i><?php echo " ". $lang['time']; ?></th>
                    <th><?php echo $lang['Kick']; ?></th>
				</tr>
			</thead>
                    <tbody>
                    <?php if (Is_Array($Players)): ?>
                        <?php foreach ($Players as $Player): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($Player['Name']); ?></td>
                                <td><?php echo $Player['TimeF']; ?></td>
                                <td><?php echo $Player['Id']; ?></td>
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
