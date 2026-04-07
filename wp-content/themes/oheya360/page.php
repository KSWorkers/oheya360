<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>

<div class="page-header" id="main-content" tabindex="-1">
  <div class="page-header-bg"></div>
  <div class="container">
    <div class="page-header-content">
      <h1 class="section-title"><?php the_title(); ?></h1>
    </div>
  </div>
</div>

<section class="section section--dark">
  <div class="container container--narrow">
    <div class="post-content reveal">
      <?php the_content(); ?>
    </div>
  </div>
</section>

<?php endwhile; ?>
<?php get_footer(); ?>
