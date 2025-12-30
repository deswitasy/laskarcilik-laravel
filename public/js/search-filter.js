function setupLiveSearch(searchInputId, searchUrl) {
  const searchInput = document.getElementById(searchInputId);
  if (!searchInput) return;

  let timeout = null;

  searchInput.addEventListener('input', function() {
    clearTimeout(timeout);
    
    timeout = setTimeout(() => {
      const searchTerm = this.value;
      
    }, 500);
  });
}
