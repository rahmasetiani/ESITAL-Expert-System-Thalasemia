document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const toggleExpand = document.getElementById('toggleExpand');
    const toggleCollapse = document.getElementById('toggleCollapse');

    // Collapse sidebar
    toggleCollapse.addEventListener('click', function () {
        sidebar.classList.add('collapsed'); // Add collapsed class
        content.classList.add('collapsed'); // Adjust content margin
        toggleExpand.style.display = 'block'; // Show expand button
        toggleCollapse.style.display = 'none'; // Hide collapse button
    });

    // Expand sidebar
    toggleExpand.addEventListener('click', function () {
        sidebar.classList.remove('collapsed'); // Remove collapsed class
        content.classList.remove('collapsed'); // Reset content margin
        toggleCollapse.style.display = 'block'; // Show collapse button
        toggleExpand.style.display = 'none'; // Hide expand button
    });

    // Optional: Handle window resize to ensure proper state
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768 && sidebar.classList.contains('collapsed')) {
            sidebar.classList.remove('collapsed');
            content.classList.remove('collapsed');
        }
    });
});

//halpengguna
function changeLimit(value) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('limit', value);
    urlParams.set('page', 1); // Reset to first page on limit change
    window.location.search = urlParams.toString();
}

function searchUser() {
    const searchInput = document.getElementById('searchInput').value;
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('search', searchInput);
    urlParams.set('page', 1); // Reset to first page on search
    window.location.search = urlParams.toString();
}


//halpenyakit
function changeLimit(limit) {
    const url = new URL(window.location.href);
    url.searchParams.set('limit', limit);
    window.location.href = url.toString();
}

function searchPenyakit() {
    const query = document.getElementById('searchInput').value;
    const url = new URL(window.location.href);
    url.searchParams.set('search', query);
    window.location.href = url.toString();
}

//halgejala
function changeLimit(limit) {
    const search = document.getElementById('searchInput').value;
    window.location.href = `?limit=${limit}&page=1&search=${encodeURIComponent(search)}`;
}

function searchGejala() {
    const search = document.getElementById('searchInput').value;
    window.location.href = `?limit=<?php echo $limit; ?>&page=1&search=${encodeURIComponent(search)}`;
}