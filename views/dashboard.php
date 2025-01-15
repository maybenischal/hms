<?php
session_start();
require 'auth.php';

// Redirect to register if the user is not authenticated
requireAuth();

echo "<h1>Welcome, " . $_SESSION['user']['username'] . "!</h1>";
