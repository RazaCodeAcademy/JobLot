const formInput = document.querySelector(".header-filter-box input");
const dropDown = document.querySelector(".header-search-dropdown");
const shadow = document.querySelector(".shadow");
const profileBox = document.querySelector(".nav-tooltip-box");
const profileNav = document.querySelector(".nav-avatar");
const overlay = document.querySelector(".overlay");

if (formInput) {
	formInput.addEventListener("focus", () => {
		dropDown.classList.add("open");
		overlay.classList.add("show-overlay")
	});

	overlay.addEventListener("click", () => {
		dropDown.classList.remove("open");
		overlay.classList.remove("show-overlay")
		console.log('khlkshlk');
	});
}

profileNav.addEventListener("click", (e) => {
	profileBox.classList.toggle("visible-nav");
});

document.body.addEventListener("click", (e) => {
	// if (e.target.closest(".nav-profile-box")) {
	// 	// check if the user clicked on dropdown then do nothing
	// 	return;
	// } else {
	// 	// if user clicked outside then remove the dropdown class
	// 	profileBox.classList.remove("visible-nav");
	// }

	// shorter logic
	if (!e.target.closest(".nav-profile-box")) {
		profileBox.classList.remove("visible-nav");
	}
});
