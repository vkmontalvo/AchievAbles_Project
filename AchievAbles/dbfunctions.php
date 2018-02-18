<?php

//===========================================================
// Main Database Connection
//===========================================================

function dbconnect() {
    // MySQL connection paramates
    $dbname = "se266_valerie";
    $username = "se266_valerie";
    $pwd = "5503922";
    $dbname2 = "se266_valerie";
    $username2 = "root";
    $pwd2 = "";
    // If the server name is ict.neit.edu, connect using remote configuration. Else, connect using local configuration.
    if (isset($_SERVER['SERVER_NAME']) &&
            $_SERVER['SERVER_NAME'] == 'ict.neit.edu'){
        $config = array(
        'DB_DNS' => "mysql:host=localhost;port=5500;dbname=$dbname;",
        'DB_USER' => $username,
        'DB_PASSWORD' => $pwd
    );
    } else { // Local database configuration
        $config = array(
            'DB_DNS' => "mysql:host=localhost;port=3306;dbname=$dbname2;",
            'DB_USER' => $username2,
            'DB_PASSWORD' => $pwd2
        );
    } 
    // Attempt to connect to the database, if an error occurs, display the error
    try { // Database wrapper and attribute
        $db = new PDO($config['DB_DNS'], $config['DB_USER'], $config['DB_PASSWORD']);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
    // Return the connection
    return $db;
}


//===========================================================
// View-All Functions
//===========================================================

function viewGoals() {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM agoals");
    $results = array();

    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $results;
}

function viewRewards() {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM arewards");
    $results = array();

    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $results;
}

function viewTasks() {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM atasks");
    $results = array();

    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $results;
}

function viewLogins() {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM alogins");
    $results = array();

    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $results;
}

function sortBy($column, $sortBy) {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM labUsage ORDER BY " . $column . " " . $sortBy);
    $results = array();
 
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $results;
}




//===========================================================
// Sign-Up Functions
//===========================================================

function checkUsername($user) {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM ausers WHERE username = :user");
    $binds = array(
        ":user" => $user
            
    );
 
    // If the statement executes and there are over 0 rows, return true
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = true;
    }
    else {
        $results = false;
    }

    return $results;
}

function addUser($user, $email, $pwd, $group){
    // SQL variables
    $db = dbconnect();
    $stmt = $db->prepare("INSERT INTO ausers SET email = :email, username = :user, password = :pwd, user_group = :group");

    // Binds the data
    $binds = array(
        ":email" => $email,
        ":user" => $user,
        ":pwd" => $pwd,
        ":group" => $group
    );

    // If the statement executes according to the binds and the row count if over 0, successfully added. Else, unsuccessful
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $success = true;
    } else {
        $success = false;
    }

    return $success;
}


//===========================================================
// User Records Functions
//===========================================================

function findUserId($user) {
    $db = dbconnect();
    
    $stmt = $db->prepare("SELECT user_id FROM ausers WHERE username = :user");
    $binds = array(
        ":user" => $user
            
    );
 
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return $results;
}

function userLogins($user) {
   $db = dbconnect();
    $user_id = findUserId($user);
    $stmt = $db->prepare("SELECT * FROM alogins WHERE user_id = :user_id");
    $binds = array(
        ":user_id" => $user_id
            
    );
 
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return $results;
}

function userImage($user_id, $image) {
    // SQL variables
    $db = dbconnect();
    $sql = "UPDATE ausers SET user_img = " . $image . " WHERE user_id = " . $user_id;
    $stmt = $db->prepare($sql);


    // If the statement executes according to the binds and the row count if over 0, display success. Else, display error
    $stmt->execute(); 
    if ($stmt->rowCount() > 0) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}


//===========================================================
// Login/Logout Functions
//===========================================================

function loginValidate($user, $pwd){
    // SQL variables
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM ausers WHERE username = :user AND password = :pwd");
    
    // Binds
    $binds = array(
        ":user" => $user,
        ":pwd" => $pwd
    );
    
    // If the statement executes according to the binds and the row count if over 0, display success. Else, display error
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $valid = true;
    } else {
        $valid = false;
    }

    return $valid;
}

function login ($user, $pwd){
    // SQL variables
    $db = dbconnect();
    $user_id_array = findUserId($user);
    $user_id = $user_id_array['user_id'];
    $success = loginValidate($user, $pwd);
    
    if ($success === true) {
        $type = "Successful";
    }
    else {
        $type = "Failed";
    }
    $stmt = $db->prepare("INSERT INTO alogins SET user_id = :user_id, login_date = NOW(), login_type = :type");

    // Binds the data
    $binds = array(
        ":user_id" => $user_id,
        ":type" => $type
    );

    // If the statement executes according to the binds and the row count if over 0, successfully logged. Else, unsuccessful
    $stmt->execute($binds);

    return $success;
}

function groupValidate($user){
    // SQL variables
    $db = dbconnect();
    $stmt = $db->prepare("SELECT user_group FROM ausers WHERE username = :user");
    
    // Binds
    $binds = array(
        ":user" => $user
    );
    
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if ($results['user_group'] === 'Admin')
    {
        $valid = true;
    }
    
    else {
        $valid = false;
    }
    
    return $valid;
}

//===========================================================
// MISC Functions
//===========================================================

function isPost(){
    return ( filter_input (INPUT_SERVER, 'REQUEST_METHOD') === 'POST');
}

function isGet(){
    return ( filter_input (INPUT_SERVER, 'REQUEST_METHOD') === 'GET');
}