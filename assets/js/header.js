document.addEventListener("DOMContentLoaded", () => {
  const images = document.querySelectorAll("img");
  images.forEach((img) => {
    if (!img.hasAttribute("width") && !img.hasAttribute("height")) {
      img.setAttribute("width", img.naturalWidth || 'auto');
      img.setAttribute("height", img.naturalHeight || 'auto');
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
