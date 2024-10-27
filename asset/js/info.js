function setupShowMoreLess() {
    // Show More functionality for descriptions
    document.querySelectorAll('.show-more').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const cardText = link.parentElement;
            const fullText = cardText.getAttribute('data-full-text');
            cardText.innerHTML = fullText + '<br><a href="#" class="show-less">Show Less</a>';
            setupShowLess(); // Set up the show less link again
        });
    });

    // Show Less functionality for descriptions
    function setupShowLess() {
        document.querySelectorAll('.show-less').forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const cardText = link.parentElement;
                const shortText = cardText.getAttribute('data-short-text');
                cardText.innerHTML = shortText + '...<br><a href="#" class="show-more">Show More</a>';
                setupShowMoreLess(); // Set up the show more link again
            });
        });
    }

    // Show More functionality for solutions
    document.querySelectorAll('.show-more-solution').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const cardText = link.parentElement;
            const fullText = cardText.getAttribute('data-full-text');
            cardText.innerHTML = fullText + '<br><a href="#" class="show-less-solution">Show Less</a>';
            setupShowLessSolution(); // Set up the show less solution again
        });
    });

    // Show Less functionality for solutions
    function setupShowLessSolution() {
        document.querySelectorAll('.show-less-solution').forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const cardText = link.parentElement;
                const shortText = cardText.getAttribute('data-short-text');
                cardText.innerHTML = shortText + '...<br><a href="#" class="show-more-solution">Show More</a>';
                setupShowMoreLess(); // Set up the show more solution again
            });
        });
    }
}

setupShowMoreLess(); // Initialize the show more/less setup
