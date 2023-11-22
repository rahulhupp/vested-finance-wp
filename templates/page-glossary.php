<?php
/*
Template name: Glossary Page
Template Post Type: module
*/
get_header(); ?>

<div class="glossary_page">
    <section class="acadamy_banner_section">
        <div class="container">
            <div class="acadamy_banner_content">
                <div class="acadamy_banner_heading">
                    <h1>
                        <?php if (get_field('banner_heading')) :
                            the_field('banner_heading');
                        else :
                            the_title();
                        endif;
                        ?>
                    </h1>
                    <p class="sub_heading"><?php the_field('banner_sub_heading'); ?></p>
                </div>
                <div class="acadamy_banner_image_col">
                    <div class="acadamy_banner_img">
                        <img src="<?php the_field('banner_image'); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="glossary_sec">
        <div class="container">
            <div class="glossary_wrap">
                <div class="search_box">
                    <input type="text" id="searchInput" placeholder="Search Glossary...">
                    <i class="icon-search"></i>
                </div>

                <div class="alphabet-list">

                </div>
                <?php if (have_rows('glossary_list')) : ?>
                    <div class="headings">
                        <?php while (have_rows('glossary_list')) : the_row(); ?>
                            <div class="single_glossary">
                                <h2 class="single_glossary_heading"><?php the_sub_field('glossary_heading') ?></h2>
                                <?php the_sub_field('glossary_description') ?>
                            </div>
                        <?php endwhile; ?>

                    </div>
                <?php endif; ?>

                <h3 id="noResultsMessage">
                    </h3>

            </div>
        </div>
    </section>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alphabetLinks = document.querySelector(".alphabet-list");
        const headingsContainer = document.querySelector(".headings");
        const singleGlossaryElements = document.querySelectorAll(".single_glossary");

        // Store the initial sorted order of glossaries
        const initialSortedGlossaries = [];

        function displayHeadings(alphabet) {
            headingsContainer.innerHTML = "";
            const sortedGlossaries = [];

            // Use initialSortedGlossaries for sorting
            initialSortedGlossaries.forEach(glossary => {
                const headingText = glossary.querySelector(".single_glossary_heading").textContent;
                if (alphabet === "ALL" || headingText.toLowerCase().startsWith(alphabet.toLowerCase())) {
                    sortedGlossaries.push(glossary.cloneNode(true));
                }
            });

            sortedGlossaries.forEach(glossary => {
                glossary.style.display = "block";
                headingsContainer.appendChild(glossary);
            });
        }

        function generateAlphabetLinks() {
            const uniqueStartingLetters = new Set();
            singleGlossaryElements.forEach(glossary => {
                const headingText = glossary.querySelector(".single_glossary_heading").textContent;
                const firstLetter = headingText[0].toUpperCase();
                if (/^[A-Z]$/.test(firstLetter)) {
                    uniqueStartingLetters.add(firstLetter);
                }

                // Populate initialSortedGlossaries
                initialSortedGlossaries.push(glossary.cloneNode(true));
            });

            Array.from(uniqueStartingLetters).sort().forEach(letter => {
                const alphabetLink = document.createElement("a");
                alphabetLink.href = "#";
                alphabetLink.textContent = letter;
                alphabetLink.addEventListener("click", function(event) {
                    event.preventDefault();
                    alphabetLinks.querySelectorAll('a').forEach(link => {
                        link.classList.remove('active');
                    });
                    alphabetLink.classList.add('active');
                    displayHeadings(letter);
                });
                alphabetLinks.appendChild(alphabetLink);
            });

            const allAlphabetLink = document.createElement("a");
            allAlphabetLink.href = "#";
            allAlphabetLink.classList.add('all_alphabet');
            allAlphabetLink.textContent = "ALL";
            allAlphabetLink.classList.add('active');
            allAlphabetLink.addEventListener("click", function(event) {
                event.preventDefault();
                alphabetLinks.querySelectorAll('a').forEach(link => {
                    link.classList.remove('active');
                });
                allAlphabetLink.classList.add('active');
                displayHeadings("ALL");
            });
            alphabetLinks.appendChild(allAlphabetLink);
        }

        generateAlphabetLinks();

        // Store initialSortedGlossaries for search
        initialSortedGlossaries.forEach(glossary => {
            headingsContainer.appendChild(glossary.cloneNode(true));
        });

        // Search functionality
        const searchInput = document.querySelector("#searchInput");
        searchInput.addEventListener("input", function() {
            const noResultsMessage = document.querySelector("#noResultsMessage");
            const alphabetLinks = document.querySelectorAll('.alphabet-list a');
            alphabetLinks.forEach(link => {
                link.classList.remove('active');
            });
            const query = searchInput.value.toLowerCase();

            headingsContainer.innerHTML = ""; // Clear existing results
            let resultsFound = false;
            initialSortedGlossaries.forEach(glossary => {
                const headingText = glossary.querySelector(".single_glossary_heading").textContent.toLowerCase();
                if (headingText.includes(query)) {
                    glossary.style.display = "block";
                    headingsContainer.appendChild(glossary.cloneNode(true));
                    resultsFound = true;
                }
            });
            if (searchInput.value.length < 1) {
                document.querySelector('.all_alphabet').classList.add('active');
            }
            if (!resultsFound) {
                noResultsMessage.style.display = "block";
                noResultsMessage.innerHTML = 'Not Found !!!';
            } else {
                noResultsMessage.style.display = "none";
                noResultsMessage.innerHTML = '';
            }
        });
    });
</script>
<?php get_footer(); ?>