<?php
/*
Template name: Page - Articles
*/
get_header(); ?>

<div class="custom_breadcrumb">
    <div class="container">
        <ul>
            <li><a href="<?php echo get_home_url(); ?>/blog">Blog</a></li>
            <li class="active"><a href="#">All Articles</a></li>
        </ul>
    </div>
</div>

<div id="content" role="main" class="sub-category-page">
    <section>
        <div class="container">
            <header class="page-header">
                <div class="heading">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if (category_description()) : ?>
                        <div class="category-description"><?php echo category_description(); ?></div>
                    <?php endif; ?>
                </div>
                <div class="search">
                    <?php echo do_shortcode('[ivory-search id="4323" title="AJAX Search Form"]'); ?>
                </div>
            </header>
            <div class="post-item" id="postContainer">
            </div>

            <div class="load-more-btn">
                <a href="#" id="loadMore" data-paged="1">Load More</a>
            </div>
        </div>
    </section>
    <section class="newsletter-section">
        <?php get_template_part('template-parts/newsletter'); ?>
    </section>
</div>

<script>
    jQuery(document).ready(function($) {
        let currentPage = 1;
        let postsPerPage = 8;
        let isLoading = false;

        function loadPosts(initial = false) {
            if (isLoading) return;
            isLoading = true;

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: currentPage,
                    posts_per_page: postsPerPage,
                },
                beforeSend: function() {
                    if (!initial) {
                        $('#loadMore').text('Loading...');
                    }
                },
                success: function(response) {
                    if (response.success && response.data) {
                        $('#postContainer').append(response.data);
                        currentPage++;
                        $('#loadMore').text('Load More');
                    } else {
                        $('#loadMore').text('No more posts');
                        $('#loadMore').prop('disabled', true);
                    }
                    isLoading = false;
                },
                error: function() {
                    $('#loadMore').text('Error loading posts');
                    isLoading = false;
                }
            });
        }

        // Initial load
        loadPosts(true);

        // Load more on click
        $('#loadMore').on('click', function(e) {
            e.preventDefault();
            loadPosts();
        });
    });
</script>

<?php get_footer(); ?>