<?php
$title = "Grid List";
include 'include/header.php';
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grid List</title>
    <style>
        .listbody { font-family: Arial, sans-serif; }
        .grid-list { list-style-type: none; padding: 0; }
        .grid-item { display: flex; align-items: center; margin-bottom: 10px; }
        .grid-link { margin-left: 10px; }
        .search-bar { margin-bottom: 20px; }
    </style>
    <script>
        async function loadGrids() {
            const response = await fetch('include/gridlist.csv'); // include/gridlist.csv
            const data = await response.text();
            const lines = data.split('\n').slice(1); // Erste Zeile ignorieren (Header)
            const gridList = document.getElementById('gridList');

            lines.forEach(line => {
                const [gridName, loginURI] = line.split(',');
                if (!gridName || !loginURI) return; // Leere Zeilen ignorieren

                const li = document.createElement('li');
                li.className = 'grid-item';

                const btn = document.createElement('button');
                btn.className = 'grid-link';
                btn.textContent = ' Grid Link ';
                btn.onclick = () => window.location.href = `secondlife:///app/gridmanager/addgrid/${loginURI.trim()}`;

                const span = document.createElement('span');
                span.textContent = gridName.trim();

                li.appendChild(btn);
                li.appendChild(span);
                gridList.appendChild(li);
            });
        }

        function filterGrids() {
            const input = document.getElementById('searchInput').value.toUpperCase();
            document.querySelectorAll('.grid-item').forEach(item => {
                item.style.display = item.textContent.toUpperCase().includes(input) ? "" : "none";
            });
        }

        document.addEventListener('DOMContentLoaded', loadGrids);
    </script>
</head>
<listbody>

    <h1>Grid List</h1>
    <div class="search-bar">
        <input type="text" id="searchInput" onkeyup="filterGrids()" placeholder="Search for grids...">
    </div>
    <ul id="gridList" class="grid-list"></ul>

</listbody>
</html>
