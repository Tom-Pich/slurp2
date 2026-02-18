import { fetchResult } from "./game-table-utilities";

// lazy load event listener
function setLazyloadingListeners() {
    const body = document.body;
    body.addEventListener("click", async (e) => {
        //const descriptionWrapper = e.target.closest("details.liste").querySelector("[data-details]");
        const itemWrapper = e.target.closest("details.liste");
        if (!itemWrapper) return;
        const descriptionWrapper = itemWrapper.querySelector("[data-details]");
		if(!descriptionWrapper) return;
        const id = parseInt(descriptionWrapper.dataset.id);
        if (descriptionWrapper.dataset.type === "spell") {
            const spell = await fetchResult("/api/get-spell?id=" + id);
            descriptionWrapper.innerHTML = spell.fullDescription;
        }
        if (descriptionWrapper.dataset.type === "avdesav") {
            const avdesav = await fetchResult("/api/get-avdesav?id=" + id);
            descriptionWrapper.innerHTML = avdesav.description;
        }
        if (descriptionWrapper.dataset.type === "creature") {
            const creature = await fetchResult("/api/get-creature?id=" + id);
			descriptionWrapper.innerHTML = creature.fullDescription;
        }
    });
}

setLazyloadingListeners();
