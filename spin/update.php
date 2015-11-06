<?php
    // request related
    $request_bet;
    $request_won;
    $request_signature;

    // player related
    $player_id;
    $player_name;
    $player_credit;
    $player_salt_value;
    $player_lifetime_spins;
    $player_lifetime_deposit;

    // sql related
    $db_server = 'localhost';
    $db_username = 'sg_db_user';
    $db_password = 'P@$$w0rd';
    $db_name = 'sg';

    // check request
    // won could be zero, therefore using isset
    if (empty($_GET['id']) || empty($_GET['bet']) || !isset($_GET['won']) || empty($_GET['sig'])) {
        echo 'Bad request';
        die();
    } else {
        // assign values
        $player_id = $_GET['id'];
        $request_bet = intval($_GET['bet']);
        $request_won = intval($_GET['won']);
        $request_signature = $_GET['sig'];
    }

    // sanity check 
    // check player id
    if (empty($player_id) || $player_id <= 0) {
        echo 'Bad player id';
        die();
    }

    // check bet amount (initial check)
    if (empty($request_bet) || $request_bet <= 0) {
        echo 'Bad bet amount';
        die();
    }

    if (!isset($request_won)) {
        // todo: validate win/loss amount depending on details of the game
        // e.g. amount should be within max possible pay/loss
        echo 'Bad win amount';
        die();
    }

    // check signature (initial check)
    // signature is 512 bits therefore should be 128 HEX digits
    if (empty($request_signature) || strlen($request_signature) !== 128) {
        echo 'Bad signature';
        die();
    }      

    // connect to database to fetch salt and credit 
    $connection = mysqli_connect($db_server, $db_username, $db_password, $db_name);
    if ($connection === false) {
        echo 'Error connecting to database';
        die();
    } 

    // get player
    $sql1 = "SELECT * FROM Player WHERE PlayerID = $player_id";
    $result = mysqli_query($connection, $sql1);
    if (mysqli_num_rows($result) !== 1) {
        echo "Error getting player";
        die();
    } 

    // get values
    $row = mysqli_fetch_array($result);
    $player_name = $row['Name'];
    $player_credit = $row['Credits'];
    $player_salt_value = $row['SaltValue'];
    $player_lifetime_spins = $row['LifetimeSpins'];
    $player_lifetime_deposit = $row['LifetimeDeposit'];

    // perform further validation based on salt and credits
    // bet amount shouldn't exceed player's credit
    if ($request_bet > $player_credit) {
        echo 'Bad bet amount';
        die();
    }

    // signature should match
    // signature is the sha512 hash of (salt, id, bet, won)
    $verify_data = $player_salt_value . $player_id . $request_bet . $request_won;
    $verify_signature = hash('sha512', $verify_data, false);
    if ($request_signature != $verify_signature) {
        echo 'Bad request';
        die();
    }

    // update data
    $player_lifetime_spins += 1;
    $player_credit += $request_won;
    $sql2 = "UPDATE Player SET LifetimeSpins = $player_lifetime_spins, Credits = $player_credit WHERE PlayerID = $player_id";
    $result2 = mysqli_query($connection, $sql2);
    if (mysqli_affected_rows($connection) !== 1) {
        echo "Error updating table";
        die();
    }

    // generate json
    $lifetime_average_return = ($player_credit - $player_lifetime_deposit) / $player_lifetime_spins;
    $json_data = array(
        array('PlayerID', $player_id),
        array('Name', $player_name),
        array('Credits', $player_credit),
        array('LifetimeSpins', $player_lifetime_spins),
        array('LifetimeAverageReturn',  $lifetime_average_return)
    );
    $json = json_encode($json_data);
    echo $json;

    // close the connection
    mysqli_close($connection);
 ?>