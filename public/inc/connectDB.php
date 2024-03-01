<?php
/*   
 * Training: Connect to a mysql or mariadb database
 * Please define the configuration variables in a `.env` file.
 */
$hostname = 'localhost:80';
$dbname = 'anime-tracker';
$dbuser = 'root';
$dbpass = '';
$dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $dbuser, $dbpass);
