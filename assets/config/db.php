<?php
$hostname_stepquestforum = "localhost";
$database_stepquestforum = "gyArbete";
$username_stepquestforum = "gyArbete";
$password_stepquestforum = "gyArbete";


try {
  $forum = new PDO("mysql:host=$hostname_stepquestforum;dbname=$database_stepquestforum", $username_stepquestforum, $password_stepquestforum);
  // set the PDO error mode to exception
  $forum->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo ""; // denna rad kan tas bort om allt fungerar
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
