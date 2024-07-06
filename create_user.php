<?php

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/config/web.php');
(new yii\web\Application($config))->init();

$users = [
    ['username' => 'hr_manager', 'password' => 'hrmanager', 'role' => 'HR Manager'],
    ['username' => 'manager_pmo', 'password' => 'managerpmo', 'role' => 'Manager PMO'],
    ['username' => 'project_director', 'password' => 'projectdirector', 'role' => 'Project Director'],
];

$dsn = 'mysql:host=localhost;dbname=db_ruth';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
    $dbh = new PDO($dsn, $username, $password, $options);

    foreach ($users as $user) {
        $hashedPassword = Yii::$app->security->generatePasswordHash($user['password']);
        $stmt = $dbh->prepare("INSERT INTO saw_users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindParam(':username', $user['username']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $user['role']);
        $stmt->execute();
    }

    echo "Users created successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$dbh = null;