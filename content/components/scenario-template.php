<div class="flex p-2 bg-background gap-1-2">
	<div class="flow fl-1">
		<h1><?= $page["title"] ?></h1>
		<p class="fs-450 italic"><?= $page["description"] ?></p>
	</div>
	<div>
		<button class="btn btn-primary" data-role="open-details">Tout ouvrir</button>
		<button class="btn btn-primary mt-½" data-role="close-details">Tout femer</button>
	</div>
</div>



<div class="grid scenario-body mt-2 gap-1-2">
	<?php include "content/scenarii/" . $this->page["file"] . ".php"; ?>
</div>

<script>
	const openBtn = document.querySelector("[data-role=open-details]")
	const closeBtn = document.querySelector("[data-role=close-details]")
	const details = document.querySelectorAll("details")
	openBtn.addEventListener("click", (e) => {
		details.forEach(detail => detail.open = true)
	})
	closeBtn.addEventListener("click", (e) => {
		details.forEach(detail => detail.open = false)
	})
</script>