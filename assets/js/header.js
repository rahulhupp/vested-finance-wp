document.addEventListener("DOMContentLoaded", () => {
  const allImages = document.querySelectorAll("img");
  allImages.forEach((img) => {
    const setDimensions = () => {
      if (!img.hasAttribute("width") && !img.hasAttribute("height")) {
        const naturalWidth = img.naturalWidth;
        const naturalHeight = img.naturalHeight;
        if (naturalWidth && naturalHeight) {
          img.setAttribute("width", naturalWidth);
          img.setAttribute("height", naturalHeight);
        }
      }
    };
    if (img.complete) {
      setDimensions();
    } else {
      img.addEventListener("load", setDimensions);
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
