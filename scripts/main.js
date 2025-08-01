const navItems = document.querySelector(".nav_items");
const openNavBtn = document.querySelector("#open_nav-btn");
const closeNavBtn = document.querySelector("#close_nav-btn");
// !open navbar
const openNav = () => {
  navItems.style.display = "flex";
  openNavBtn.style.display = "none";
  closeNavBtn.style.display = "inline-block";
};

// !close navbar

const closeNav = () => {
  navItems.style.display = "none";
  closeNavBtn.style.display = "none";
  openNavBtn.style.display = "inline-block";
};

openNavBtn.addEventListener("click", openNav);
closeNavBtn.addEventListener("click", closeNav);

const sidebar = document.querySelector("aside");
const showSidebarBtn = document.querySelector("#show_sidebar-btn");
const hideSidebarBtn = document.querySelector("#hide_sidebar-btn");

// !show sidebar
const showSidebar = () => {
  sidebar.style.left = "0";
  showSidebarBtn.style.display = "none";
  hideSidebarBtn.style.display = "inline-block";
};

// !hide sidebar
const hideSidebar = () => {
  sidebar.style.left = "-100%";
  showSidebarBtn.style.display = "inline-block";
  hideSidebarBtn.style.display = "none";
};

showSidebarBtn.addEventListener("click", showSidebar);
hideSidebarBtn.addEventListener("click", hideSidebar);
