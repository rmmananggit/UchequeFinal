<?php
// Include the database configuration file
session_start();

// Fetch roles from session
$user_roles = isset($_SESSION['roles']) ? $_SESSION['roles'] : [];