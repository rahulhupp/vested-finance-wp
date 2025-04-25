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
                <?php
                $post_ids = [];
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 8,
                    'post_status' => 'publish',
                );
                $initial_query = new WP_Query($args);
                if ($initial_query->have_posts()) :
                    while ($initial_query->have_posts()) : $initial_query->the_post();
                        $post_ids[] = get_the_ID(); ?>
                        <div id="post-<?php the_ID(); ?>" class="post-card display" data-id="<?php the_ID(); ?>">
                            <div class="featured-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('full'); ?>
                                </a>
                            </div>
                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="meta-info">
                                <span class="post-author"><?php the_author(); ?></span>
                                <span class="post-date"><?php echo get_the_date('M j, Y'); ?></span>
                            </div>
                        </div>
                <?php endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <div class="load-more-btn">
                <button id="loadMoreBtn">
                <span class="btn-text">Load More</span>
                <span class="spinner"></span>
                </button>
            </div>
        </div>
    </section>
    <section class="newsletter-section">
        <?php get_template_part('template-parts/newsletter'); ?>
    </section>
</div>
<style>
#loadMoreBtn {
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
}
.spinner {
    width: 20px;
    height: 20px;
    border: 2px solid #FFF;
    border-bottom-color: transparent;
    border-radius: 50%;
    display: none;
    margin-left: 10px;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
} 
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadBtn = document.getElementById('loadMoreBtn');
    const btnText = loadBtn.querySelector('.btn-text');
    const spinner = loadBtn.querySelector('.spinner');
    const container = document.getElementById('postContainer');

    loadBtn.addEventListener('click', function () {
        let loadedIds = [...document.querySelectorAll('.post-card')].map(el => el.dataset.id);
        btnText.textContent = 'Loading...';
        spinner.style.display = 'inline-block';
        loadBtn.disabled = true;

        fetch('<?php echo admin_url("admin-ajax.php"); ?>?action=load_more_posts&exclude=' + loadedIds.join(','))
            .then(res => res.text())
            .then(data => {
                if (data.trim()) {
                    container.insertAdjacentHTML('beforeend', data);
                    btnText.textContent = 'Load More';
                    spinner.style.display = 'none';
                    loadBtn.disabled = false;
                } else {
                    btnText.textContent = 'No more posts';
                    spinner.style.display = 'none';
                }
            });
    });
});
</script>
<?php get_footer(); ?>