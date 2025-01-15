<?php
$admin = $_SESSION["Statut"] >= 3;
include "content/wikis/" . $page["wiki"] . "/" . $page["current-article-name"] . ".php";
?>