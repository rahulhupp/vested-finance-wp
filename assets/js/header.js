document.addEventListener("DOMContentLoaded", () => {
  const images = document.querySelectorAll("img");
  images.forEach((img) => {
    if (!img.hasAttribute("width") && !img.hasAttribute("height")) {
      img.setAttribute("width", img.naturalWidth || 1);
      img.setAttribute("height", img.naturalHeight || 1);
    }
    if (!img.hasAttribute("loading")) {
      img.setAttribute("loading", "lazy");
    }
  });
});

jQuery(document).ready(function () {
  jQuery(
    "header .inner-header .site-primary-header-wrap .logo-menu .humburger"
  ).click(function () {
    jQuery("body").toggleClass("menu-open");
  });
});
