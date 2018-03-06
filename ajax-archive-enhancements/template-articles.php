<?php
/*
Template Name: Articles */

add_action('genesis_before_content', 'articles_filterable_area');
function articles_filterable_area() {
  ?>
  <!-- Filter Area -->
  <div class="section section-filter-articles">
    <div class="container">
      <h2 class="ctr">Choose a Filter Below</h2>
      <div class="article-filters">
        <form id="filter">
          <?php
            $args = array(
              'include' => array(3, 4, 28, 35, 353),
              'orderby' => 'name',
              'order' => 'ASC',
              'posts_per_page' => -1
            );

                  $categories = get_categories($args);
                    foreach( $categories as $cat ) {
                      $cat_id = get_cat_ID( $cat->name );

                      echo '<span>
                              <input class="checkbox-custom" type="checkbox" id="check'. $cat_id .'" name="category-checks" value="' . $cat_id . '">
                              <label class="checkbox-custom-label" for="check'. $cat_id .'">' . $cat->name . '</label>
                            </span>';
                    }

                    wp_reset_postdata();
                ?>
        </form>
        <div class="ad-wrapper">
          <a href="http://connect.dare2share.org/3-evangelism-myths">
            <img src="https://www.dare2share.org/wp-content/uploads/2017/11/d2s-articles-evangelism-myths.jpg" alt="3 Evangelism Myths eBook - Download Now!" />
          </a>
        </div>
      </div>
      <div class="filter-section">
        <?php
          $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'category__in' => array(3, 4, 28, 35, 353),
            'posts_per_page' => 9,
            'orderby' => 'date',
            'order' => 'DESC',
          );

          $filter_posts = new WP_Query($args);
          if ( $filter_posts->have_posts() ) : while ( $filter_posts->have_posts() ) : $filter_posts->the_post();
        ?>

          <article class="article-card">
            <header class="card-header">
              <div class="card-img" style="background: url('<?php echo the_post_thumbnail_url( 'small' ); ?>') no-repeat center center; width: 100%; background-size: cover;"></div>
              <a href="<?php the_permalink(); ?>" class="article-title">
                <?php the_title( "<h4>", "</h4>" ) ?>
              </a>
              <p class="article-author">By
                <?php the_author(); ?>
              </p>
            </header>
            <div class="card-content">
              <p>
                <?php echo wp_trim_words(get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true), 15, '...'); ?>
              </p>
            </div>
            <footer class="card-footer">
              <a href="<?php the_permalink(); ?>" class="btn btn-article" role="button">Read Now</a>
            </footer>
          </article>

          <?php
            endwhile; endif;

            wp_reset_query();

          ?>

      </div>
    </div>
  </div>
  <?php
      }