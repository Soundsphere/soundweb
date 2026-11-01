// Hide table rows that don't contain the search text.
function filterTable(tableId, query) {
    const filter = query.toLowerCase();
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
}

// Wire up every search box that names its table via data-table.
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input.table-search[data-table]').forEach(input => {
        input.addEventListener('input', () => filterTable(input.dataset.table, input.value));
    });
});
