const toggle = document.getElementById("menuToggle");
  const menu = document.getElementById("menuMobile");
  toggle.addEventListener("click", () => {
    menu.classList.toggle("hidden");
  });

  // Dropdown Desktop Toggle
  const dropdownBtn = document.getElementById("dropdownBtn");
  const dropdownMenu = document.getElementById("dropdownMenu");
  dropdownBtn.addEventListener("click", () => {
    dropdownMenu.classList.toggle("hidden");
  });

  // Dropdown Mobile Toggle
  const dropdownBtnMobile = document.getElementById("dropdownBtnMobile");
  const dropdownMenuMobile = document.getElementById("dropdownMenuMobile");
  dropdownBtnMobile.addEventListener("click", () => {
    dropdownMenuMobile.classList.toggle("hidden");
  });