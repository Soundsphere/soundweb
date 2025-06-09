// Simple table sort by column
function sortTable(table, column, asc = true) {
    const dir = asc ? 1 : -1;
    const rows = Array.from(table.querySelectorAll("tbody tr"));
    rows.sort((a, b) => {
        const aText = a.children[column].textContent.trim();
        const bText = b.children[column].textContent.trim();
        return aText > bText ? dir : aText < bText ? -dir : 0;
    });
    rows.forEach(row => table.tBodies[0].appendChild(row));
    table.querySelectorAll("th").forEach(th => th.classList.remove("sort-asc", "sort-desc"));
    table.querySelectorAll("th")[column].classList.toggle("sort-asc", asc);
    table.querySelectorAll("th")[column].classList.toggle("sort-desc", !asc);
}

window.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("table").forEach(table => {
        table.querySelectorAll("th").forEach((th, index) => {
            th.addEventListener("click", () => {
                const asc = !th.classList.contains("sort-asc");
                sortTable(table, index, asc);
            });
        });
    });
});