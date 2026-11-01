// public_html/Static/sort.js

// Only cells that are entirely a number are compared numerically, so
// titles like "2001: A Space Odyssey" still sort as text.
const NUMBER = /^-?\d+(\.\d+)?$/;

// Sort table rows on column click or Enter/Space on a focused header.
function sortTable(table, column, asc = true) {
    const dir = asc ? 1 : -1;
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    rows.sort((a, b) => {
        const aText = a.children[column].textContent.trim();
        const bText = b.children[column].textContent.trim();

        if (NUMBER.test(aText) && NUMBER.test(bText)) {
            return (parseFloat(aText) - parseFloat(bText)) * dir;
        }

        // numeric: true keeps "Vol. 2" before "Vol. 10"
        return aText.localeCompare(bText, undefined, { numeric: true, sensitivity: 'base' }) * dir;
    });

    rows.forEach(row => table.tBodies[0].appendChild(row));
    table.querySelectorAll('th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
        th.removeAttribute('aria-sort');
    });
    const th = table.querySelectorAll('th')[column];
    th.classList.add(asc ? 'sort-asc' : 'sort-desc');
    th.setAttribute('aria-sort', asc ? 'ascending' : 'descending');
}

window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('table').forEach(table => {
        // Skip tables marked with the 'no-sort' class
        if (table.classList.contains('no-sort')) {
            return;
        }
        table.querySelectorAll('th').forEach((th, index) => {
            // Skip individual columns such as the row number
            if (th.classList.contains('no-sort')) {
                return;
            }
            const sort = () => sortTable(table, index, !th.classList.contains('sort-asc'));
            th.classList.add('sortable');
            th.tabIndex = 0;
            th.addEventListener('click', sort);
            th.addEventListener('keydown', event => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    sort();
                }
            });
        });
    });
});
