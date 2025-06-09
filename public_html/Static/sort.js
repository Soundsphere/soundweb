// public_html/Static/sort.js

// Sort table rows on column click. Numbers are sorted numerically.
function sortTable(table, column, asc = true) {
    const dir = asc ? 1 : -1;
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    rows.sort((a, b) => {
        const aText = a.children[column].textContent.trim();
        const bText = b.children[column].textContent.trim();

        // Numeric comparison if both values are numbers
        const aNum = parseFloat(aText);
        const bNum = parseFloat(bText);
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return (aNum - bNum) * dir;
        }

        // Fallback to text comparison
        return aText.localeCompare(bText) * dir;
    });

    rows.forEach(row => table.tBodies[0].appendChild(row));
    table.querySelectorAll('th').forEach(th => th.classList.remove('sort-asc', 'sort-desc'));
    table.querySelectorAll('th')[column].classList.toggle('sort-asc', asc);
    table.querySelectorAll('th')[column].classList.toggle('sort-desc', !asc);
}

window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('table').forEach(table => {
        table.querySelectorAll('th').forEach((th, index) => {
            th.addEventListener('click', () => {
                const asc = !th.classList.contains('sort-asc');
                sortTable(table, index, asc);
            });
        });
    });
});
