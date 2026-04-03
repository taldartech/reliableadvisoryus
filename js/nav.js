(function () {
  var page = document.body.getAttribute("data-page");
  if (!page) return;
  document.querySelectorAll("[data-nav]").forEach(function (link) {
    if (link.getAttribute("data-nav") === page) {
      link.classList.add("active");
    }
  });
})();
