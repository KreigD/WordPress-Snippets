<?php
/**
 *
 * I set a height on the carousel to see the images because I used this for a fullscreen carousel landing page on my own site.
 *
 */

?>

<main class="site-main" id="main" role="main">

  <?php
    $args = array(
      'post_type' => 'post',
    );
    $the_query = new WP_Query($args);
  ?>

    <!--Carousel Wrapper-->
    <div id="carousel-bootstrap" class="carousel slide carousel-fade" data-ride="carousel" data-interval="false" style="height:100vh;">
      <!--Indicators-->
      <ol class="carousel-indicators">
        <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <li data-target="#carousel-bootstrap" data-slide-to="<?php echo $the_query->current_post; ?>" class="<?php if ( $the_query->current_post == 0 ) : ?>active<?php endif; ?>"></li>
        <?php endwhile; endif; ?>
      </ol>
      <!--/Indicators-->

      <?php rewind_posts(); ?>

      <!--Slides-->
      <div class="carousel-inner" role="listbox">
        <?php
          if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();

          $thumbnail_id = get_post_thumbnail_id();
          $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full-size', true );
          $thumbnail_meta = get_post_meta( $thumbnail_id, '_wp_attatchment_image_alt', true );
        ?>
          <!--Slide-->
          <div class="carousel-item <?php if ( $the_query->current_post == 0 ) : ?>active<?php endif; ?>" style="background: url('<?php echo $thumbnail_url[0]; ?>') no-repeat center center; background-size: cover;">
            <!-- Caption -->
            <div class="carousel-caption d-none d-md-block">
              <h5><?php the_title(); ?></h5>
              <p><?php the_excerpt(); ?></p>
            </div>
          </div>
          <!--/.Slide-->
          <?php endwhile; endif; wp_reset_postdata(); ?>
      </div>
      <!--/Slides-->

      <!--Controls-->
      <a class="carousel-control-prev" href="#carousel-bootstrap" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carousel-bootstrap" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
      <!--/.Controls-->
    </div>
    <!--/Carousel Wrapper-->

</main>
<!-- #main -->