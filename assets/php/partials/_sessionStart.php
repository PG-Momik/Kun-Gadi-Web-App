<?php
session_start();
$_SESSION['admin'] = "xyz";
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['prev_url'] = $actual_link;
