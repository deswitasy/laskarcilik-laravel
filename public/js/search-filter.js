function setupLiveSearch(searchInputId, tableId) {
    const searchInput = document.getElementById(searchInputId);
    const table = document.getElementById(tableId);

    if (!searchInput || !table) return;

    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();

        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();

            row.style.display =
                text.includes(keyword) ? '' : 'none';
        });
    });
}