<?php
$admin = $_SESSION["Statut"] >= 3;
?>
<details class="tablet-phone phone-index">
	<summary class="fw-700">Menu</summary>
	<?php include "content/components/aside-wiki-index.php" ?>
</details>
<?php
// aside left → aside-wiki-index.php called in _pages-data.php
include "content/wikis/" . $page["wiki"] . "/" . $page["current-article-name"] . ".php";
?>