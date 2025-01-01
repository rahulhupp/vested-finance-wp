document.addEventListener("DOMContentLoaded", () => {
  const allImages = document.querySelectorAll("img");
  allImages.forEach((img) => {
    if (!img.hasAttribute("width") && !img.hasAttribute("height")) {
      img.setAttribute("width", img.naturalWidth || "auto");
      img.setAttribute("height", img.naturalHeight || "auto");
    }
    if (!img.hasAttribute("alt") || img.getAttribute("alt").trim() === "") {
      const src = img.getAttribute("src");
      if (src) {
        const filename = src.split("/").pop().split(".")[0];
        img.setAttribute("alt", filename.replace(/[-_]/g, " "));
      }
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
