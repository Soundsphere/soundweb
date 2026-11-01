<?php

/**
 * Escape a value for safe output in HTML.
 */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Print a query result as a searchable, sortable table.
 *
 * @param mysqli_result $result      Rows to display
 * @param string        $id          Table id, also used by the search box
 * @param array         $columns     Result column => header label
 * @param bool          $numbered    Prepend a row number column
 * @param string        $searchLabel Text in front of the search box
 */
function render_table($result, $id, array $columns, $numbered = false, $searchLabel = 'Search:')
{
    echo "<label>" . e($searchLabel) . " <input type='search' class='table-search' data-table='" . e($id) . "'></label>\n";
    echo "<div class='table-wrap'>\n";
    echo "<table id='" . e($id) . "'" . ($numbered ? " class='numbered'" : '') . ">\n";
    echo "<thead><tr>";
    if ($numbered) {
        echo "<th class='no-sort'>Number</th>";
    }
    foreach ($columns as $label) {
        echo "<th>" . e($label) . "</th>";
    }
    echo "</tr></thead>\n<tbody>\n";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        if ($numbered) {
            echo "<td class='row-num'></td>";
        }
        foreach (array_keys($columns) as $field) {
            echo "<td>" . e($row[$field]) . "</td>";
        }
        echo "</tr>\n";
    }

    echo "</tbody>\n</table>\n</div>\n";
}
