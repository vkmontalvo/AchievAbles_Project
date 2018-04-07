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
            $_SERVER['SERVER_NAME'] == 'ict.neit.edu') {
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
    } else {
        $results = false;
    }

    return $results;
}

function addUser($email, $user, $sha, $group) {
    // SQL variables
    $db = dbconnect();
    $img = 'images/user.png';
    $stmt = $db->prepare("INSERT INTO ausers (email, username, password, user_group, user_img, points, account_created) VALUES (:email, :user, :sha, :group, :img, :points, NOW())");

    // Binds the data
    $binds = array(
        ":email" => $email,
        ":user" => $user,
        ":sha" => $sha,
        ":group" => $group,
        ":img" => $img,
        ":points" => 0
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

function userInfo ($user) {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM ausers WHERE username = :user");
    $binds = array(
        ":user" => $user
    );

    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $results;
}

function updateUser ($user, $email, $pwd, $img) {
    $db = dbconnect();
    $salt = 'B3li3v3';
    $sha = sha1($salt . $pwd);
    $stmt = $db->prepare("UPDATE ausers SET email = :email, password = :pass, user_img = :img WHERE username = :user");
    $binds = array (
        ":email" => $email,
        ":pass" => $sha,
        ":img" => $img,
        ":user" => $user     
    );
    
// If the statement executes and there are over 0 rows, return true
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = true;
    } else {
        $results = false;
    }

    return $results;
}

function userLogins($user) {
    $db = dbconnect();
    $findId = findUserId($user);
    $user_id = $findId['user_id'];
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

function getPoints($user) {
    //SQL variables
    $db = dbconnect();
    $stmt = $db->prepare("SELECT points FROM ausers WHERE username = :user");

    $binds = array(
        ":user" => $user
    );

    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $results;
}

function userPoints($user, $points, $function) {
    $db = dbconnect();
    $userpoints = getPoints($user);

    if ($function === 'add') {

        $newvalue = $userpoints['points'] + $points;
    } else if ($function === 'subtract') {

        $newvalue = $userpoints['points'] - $points;
    }

    $stmt = $db->prepare("UPDATE ausers SET points = :newvalue WHERE username = :user");

    $binds = array(
        ":newvalue" => $newvalue,
        ":user" => $user
    );
    $stmt->execute($binds);
        

    return $newvalue;
}

function addGoal($user, $goalTitle, $goalCat, $goalImg, $goalDesc) {
    $db = dbconnect();
    $findId = findUserId($user);
    $userId = $findId['user_id'];

    $stmt = $db->prepare("INSERT INTO agoals SET user_id = :user, goal_title = :title, category = :cat, goal_img = :img, goal_descrip = :desc,"
            . "progress = :progress, complete = :complete");

    $binds = array(
        ":user" => $userId,
        ":title" => $goalTitle,
        ":cat" => $goalCat,
        ":img" => $goalImg,
        ":desc" => $goalDesc,
        ":progress" => 0.0,
        ":complete" => "No"
    );
    $stmt->execute($binds);
        
}

function findImg ($user) {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT user_img FROM ausers WHERE username = :user");
    
    $binds = array (
        ":user" => $user
    );
    
     // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $results;
}

function lastLogin ($user) {
    $db = dbconnect();
    $findId = findUserId($user);
    $userId = $findId['user_id'];
    
    $stmt = $db->prepare("SELECT MAX(login_date) FROM alogins WHERE user_id = :userId AND login_type = 'Successful'");
    
    $binds = array (
        ":userId" => $userId
    );
    
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $results;
}

function countTasks ($goal_id){
    $db = dbconnect();
    $stmt = $db->prepare("SELECT COUNT(*) AS count FROM atasks WHERE goal_id = :id");
    
    $binds = array (
        ":id" => $goal_id
    );
    
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $results;
}

function updateProgress ($id){
    $db = dbconnect();
    $count = countTasks($id);
    $count2 = $count['count'];
    
    if ($count2 > 1){
       $progress = 100/$count2;
       $stmt = $db->prepare("UPDATE agoals SET progress = :progress, complete = 'No' WHERE goal_id = :id");
       
        $binds = array(
        ":progress" => $progress,
        ":id" => $id
    );
    
    $stmt->execute($binds);
    }
    
    else if ($count2 === 1){
        $progress = 90;
        
        $stmt = $db->prepare("UPDATE agoals SET progress = :progress, complete = 'No' WHERE goal_id = :id");
        
            $binds = array(
        ":progress" => $progress,
        ":id" => $id
    );
    
    $stmt->execute($binds);
    }
    else if ($count2 === 0){
        $progress = 100;
        
        $stmt = $db->prepare("UPDATE agoals SET progress = :progress, complete = 'Yes' WHERE goal_id = :id");
        
            $binds = array(
        ":progress" => $progress,
        ":id" => $id
    );
    
    $stmt->execute($binds);
    }
    

}

function countGoals ($user, $function) {
    $db = dbconnect();
    $findId = findUserId($user);
    $userId = $findId['user_id'];
    
    if ($function === 'complete'){
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM agoals WHERE user_id = :userId AND complete = 'Yes'");
    }
    
    elseif ($function === 'inprogress') {
       $stmt = $db->prepare("SELECT COUNT(*) AS count FROM agoals WHERE user_id = :userId AND complete = 'No'"); 
    }
    
    $binds = array (
        ":userId" => $userId
    );
    
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $results;
}

function userRewards($user) {
    $db = dbconnect();
    $findId = findUserId($user);
    $userId = $findId['user_id'];
    $stmt = $db->prepare("SELECT * FROM arewards WHERE user_id = :userId");
    $binds = array (
        ":userId" => $userId
    );

    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
    else {
        $noresult = true;
         return $noresult;
    }
}

function addReward ($user, $cost, $descrip, $img){
    $db = dbconnect();
    $findId = findUserId($user);
    $userId = $findId['user_id'];
    $stmt = $db->prepare("INSERT INTO arewards SET user_id = :user, cost = :cost, reward_descrip = :descrip, reward_img = :img");
    $binds = array (
       ":user" => $userId,
        ":cost" => $cost,
        ":descrip" => $descrip,
        ":img" => $img
    );
    
    $stmt->execute($binds);
}

function deleteReward($id) {
        $db = dbconnect();
    $stmt = $db->prepare("DELETE FROM arewards WHERE reward_id = :id");
    
    $binds = array (
        ":id" => $id
    );
    
    $stmt->execute($binds);
}
    
    function userGoals($user) {
    $db = dbconnect();
    $findId = findUserId($user);
    $userId = $findId['user_id'];
    $stmt = $db->prepare("SELECT * FROM agoals WHERE user_id = :userId");
    $binds = array (
        ":userId" => $userId
    );

    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }
    
    else {
        $noresult = true;
         return $noresult;
    }

    
}

function sortBy($user, $column) {
    $db = dbconnect();
    $findId = findUserId($user);
    $userId = $findId['user_id'];
    $stmt = $db->prepare("SELECT * FROM agoals WHERE user_id = " . $userId . " ORDER BY " . $column . " ASC");
    $results = array();
 
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $results;
}

function sortByReward($user, $column) {
    $db = dbconnect();
    $findId = findUserId($user);
    $userId = $findId['user_id'];
    $stmt = $db->prepare("SELECT * FROM arewards WHERE user_id = " . $userId . " ORDER BY " . $column . " ASC");
    $results = array();
 
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $results;
}

function viewGoal ($id) {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM agoals WHERE goal_id = :id");
    
    $binds = array(
        ":id" => $id
    );
 
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $results;
}

function updateGoal ($id,$goalTitle,$category,$goalImg,$description) {
    $db = dbconnect();
    $stmt = $db->prepare("UPDATE agoals SET goal_title = :title, category = :category, goal_img = :img, goal_descrip = :desc WHERE goal_id = :id");
    
    $binds = array(
        ":title" => $goalTitle,
        ":category" => $category,
        ":img" => $goalImg,
        ":desc" => $description,
        ":id" => $id
    );
    
    $stmt->execute($binds);
}

function goalTasks ($id) {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM atasks WHERE goal_id = :id");
    
    $binds = array(
        ":id" => $id
    );
 
    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
    }else {
        $notasks = true;
        
        return $notasks;
    }
}

function addTask ($id, $points, $desc, $user){
    $db = dbconnect();
    $findId = findUserId($user);
    $userId = $findId['user_id'];
        $stmt = $db->prepare("INSERT INTO atasks SET goal_id = :goal, points = :pts, task_descrip = :desc, complete = :complete, user_id = :user");
        
        $binds = array (
            ":goal" => $id,
            ":pts" => $points,
            ":desc" => $desc,
            ":complete" => "No",
            ":user" => $userId
        );
        
        $stmt->execute($binds);
}

function deleteTask ($id){
    $db = dbconnect();
    $stmt = $db->prepare("DELETE FROM atasks WHERE task_id = :id");
    
    $binds = array (
        ":id" => $id
    );
    
    $stmt->execute($binds);
}

//===========================================================
// Login/Logout Functions
//===========================================================

function loginValidate($user, $sha) {
    // SQL variables
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM ausers WHERE username = '" . $user . "' AND password = '" . $sha . "'");
    $stmt->execute();
    // If the statement executes according to the binds and the row count is 1, display success. Else, display error
    if ($stmt->rowCount() === 1) {
        $valid = true;
    } else {
        $valid = false;
    }

    return $valid;
}

function login($user, $sha) {
    // SQL variables
    $db = dbconnect();
    $user_id_array = findUserId($user);
    $user_id = $user_id_array['user_id'];
    $success = loginValidate($user, $sha);

    if ($success === true) {
        $type = "Successful";
    } else {
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

function groupValidate($user) {
    // SQL variables
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM ausers WHERE username = '" . $user . "'");

    // If the statement executes and there are over 0 rows, fetch the data
    if ($stmt->execute() && $stmt->rowCount() === 1) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $admin = $results ['user_group'];

    if ($admin === 'Admin') {
        $valid = true;
    } else {
        $valid = false;
    }

    return $valid;
}

function checkEmail($email) {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM ausers WHERE email = :email");
    $binds = array(
        ":email" => $email
    );

    // If the statement executes and there are over 0 rows, return true
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = true;
    } else {
        $results = false;
    }

    return $results;
}

function checkUserPass($email) {
    $db = dbconnect();
    $stmt = $db->prepare("SELECT * FROM ausers WHERE email = :email");
    $binds = array(
        ":email" => $email
    );

    // If the statement executes and there are over 0 rows, return results
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $results;
}

//===========================================================
// Account Deletion Function
//===========================================================

function deleteAccount($user) {
    $db = dbconnect();
    $userId = findUserId($user);
    $stmt = $db->prepare("DELETE FROM ausers WHERE username = :user");
    
    $binds = array (
        ":user" => $user
    );
    
    // If the statement executes and there are over 0 rows, return results
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $stmt2 = $db->prepare("DELETE FROM agoals WHERE user_id = :userId");
        $stmt3 = $db->prepare("DELETE FROM arewards WHERE user_id = :userId");
        $stmt4 = $db->prepare("DELETE FROM atasks WHERE user_id = :userId");
        
        $binds2 = array (
            ":userId" => $userId
        );
        
        $stmt2->execute($binds2);
        $stmt3->execute($binds2);
        $stmt4->execute($binds2);
        
        $results = true;
    }
    
    else {
        $results = false;
    }

    return $results;
}

//===========================================================
// MISC Functions
//===========================================================

function isPost() {
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST');
}

function isGet() {
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET');
}
