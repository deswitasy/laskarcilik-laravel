document.addEventListener("DOMContentLoaded", function () {
  const tombolKembali = document.getElementById("tombolKembali");
  if (tombolKembali) {
    tombolKembali.addEventListener("click", function () {
      window.history.back();
    });
  }

  const tombolCetak = document.getElementById("tombolCetakPDF");
  if (tombolCetak) {
    tombolCetak.addEventListener("click", function() {

      console.log("PDF akan di-download...");
    });
  }


});