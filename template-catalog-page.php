<?php
/*
Template Name: Catalog Page Template
*/
?>

<?php
get_header();
?>

<main id="primary" class="site-main catalog-page">

  <?php
  if (have_posts()) :
    while (have_posts()) : the_post();
  ?>



      <section class="promo">
        <div class="container">
          <div class="promo__wrapper">
            <div class="calculator">
              <div class="calculator__title"><?php the_field('filter_header_fields') ?>
              </div>
              <div class="calculator__sum">
                <div class="calculator__controls">
                  <button class="btn btnEdit minus" value="-500" data-controls>
                    -
                  </button>
                  <input
                    class="calculator__area calculator__area_sum"
                    type="number"
                    min="500"
                    max="15000"
                    step="500"
                    value="1500" />
                  <button class="btn btnEdit plus" value="500" data-controls>
                    +
                  </button>
                </div>
                <input
                  class="calculator__range"
                  type="range"
                  min="500"
                  max="50000"
                  step="500"
                  value="1500" />
              </div>
              <div class="calculator__day">
                <div class="calculator__controls">
                  <button class="btn btnEdit minus" value="1">-</button>
                  <input
                    class="calculator__area calculator__area_day"
                    type="number"
                    min="1"
                    max="31"
                    value="14" />
                  <button class="btn btnEdit plus" value="1">+</button>
                </div>
                <input
                  class="calculator__range"
                  type="range"
                  min="1"
                  max="31"
                  step="1"
                  value="14" />
              </div>
            </div>
            <div class="promo__descr">
              <h1><?php the_field('title_fields') ?></h1>
              <div class="promo__subtitle">
                <?php the_field('sub_title_fields') ?>
              </div>
              <ul class="promo__list">
                <li class="promo__item"><?php the_field('list_1_fields') ?>
                </li>
                <li class="promo__item"><?php the_field('list_2_fields') ?>
                </li>
                <li class="promo__item"><?php the_field('list_3_fields') ?>

                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>



      <section class="catalog">
        <div class="wrapper">
          <div class="container">
            <h2><?php the_field('offers_title_fields') ?></h2>
            <p class="offers-title-text"><?php echo nl2br(esc_html(get_field('offers_title_text_fields'))); ?></p>

          </div>

          <div class="container">


            <div class="catalog__list catalog__list--cards" id="offers">

              <?php

              $current_slug = get_post_field('post_name', get_queried_object_id());
              $current_slug = trim($current_slug, '/');

              $novi_mfo_slugs = [
                'novi-mfo',
                'credit-online',
                'online-credit-na-kartu',
              ];

              if (in_array($current_slug, $novi_mfo_slugs, true)) {
                $order_field = 'offer_order_novi_mfo';
              } elseif ($current_slug === 'kredit-na-kartu') {
                $order_field = 'offer_order_kredit_na_kartu';
              } else {
                $order_field = 'offer_order';
              }

              $args = [
                'post_type'              => 'post',
                'posts_per_page'         => -1,
                'category_name'          => 'offers',
                'meta_key'               => $order_field,
                'orderby'                => 'meta_value_num',
                'order'                  => 'ASC',
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'meta_query'             => [
                  'relation' => 'AND',

                  [
                    'key'     => $order_field,
                    'value'   => '',
                    'compare' => '!=',
                  ],

                  [
                    'relation' => 'OR',
                    [
                      'key'     => 'hidden_offer',
                      'compare' => 'NOT EXISTS',
                    ],
                    [
                      'key'     => 'hidden_offer',
                      'value'   => '0',
                      'compare' => '=',
                    ],
                  ],
                ],
              ];

              $query = new WP_Query($args);

              $offers_posts = $query->posts;
              $offer_icon_base = get_template_directory_uri() . '/assets/img/offer/';

              if ($query->have_posts()) :
                while ($query->have_posts()) :
                  $query->the_post();
              ?>

                  <?php
                  $order = (int) get_field($order_field);

                  get_template_part(
                    'template-parts/offer-card-soft',
                    null,
                    [
                      'is_first_offer' => $order === 1,
                      'icon_base_url'  => $offer_icon_base,
                    ]
                  );
                  ?>

              <?php
                endwhile;
                wp_reset_postdata();
              endif;
              ?>

            </div>


          </div>
        </div>
      </section>

      <div class="category-filters-container">
        <div class="container">
          <p class="offers-counter-text"></p>
        </div>

        <div class="more-offers-button">
          <a
            class="btn btn_offer-request"
            style="text-align: center;"
            href="<?php the_field('offer_button_more_link_fields') ?>"><?php the_field('offer_button_more_fields') ?></a>
        </div>
      </div>

      <?php
      get_template_part('template-parts/advertising-banners');
      ?>

      <section class="steps" id="steps">
        <h2><?php the_field('how_its_work_fields') ?>
        </h2>
        <div class="steps__wrapper">
          <div id="first" class="steps__item">
            <div class="item-wrapper show">
              <div class="steps__logo">&#xe900;</div>
              <div class="steps__title"><?php the_field('step_1_title_1_fields') ?>
              </div>
              <div class="divider"></div>
              <ul class="steps__descr">
                <li><?php the_field('step_descr_1_fields') ?>
                </li>
                <li><?php the_field('step_descr_2_fields') ?>
                </li>
                <li><?php the_field('step_descr_3_fields') ?>
                </li>
              </ul>
            </div>
            <div class="item-wrapper_sec">
              <div class="steps__title"><?php the_field('step_1_title_2_fields') ?>
              </div>
              <div class="divider"></div>
              <ul class="steps__descr">
                <li><?php the_field('step_descr_4_fields') ?>
                </li>
                <li><?php the_field('step_descr_5_fields') ?>
                </li>
                <li><?php the_field('step_descr_6_fields') ?>
                </li>
                <li><?php the_field('step_descr_7_fields') ?>
                </li>
                <li><?php the_field('step_descr_8_fields') ?>
                </li>
              </ul>
            </div>
          </div>
          <div id="second" class="steps__item">
            <div class="item-wrapper show">
              <div class="steps__logo">&#xe93f;</div>
              <div class="steps__title"><?php the_field('step_2_title_1_fields') ?>
              </div>
              <div class="divider"></div>
              <ul class="steps__descr">
                <li><?php the_field('step_2_descr_1_fields') ?>
                </li>
                <li><?php the_field('step_2_descr_2_fields') ?>
                </li>
                <li><?php the_field('step_2_descr_3_fields') ?>
                </li>
              </ul>
            </div>
            <div class="item-wrapper_sec">
              <div class="steps__title"><?php the_field('step_2_title_2_fields') ?>
              </div>
              <div class="divider"></div>
              <ul class="steps__descr">
                <li><?php the_field('step_2_descr_4_fields') ?>
                </li>
                <li>
                  <?php the_field('step_2_descr_5_fields') ?>
                </li>
                <li><?php the_field('step_2_descr_6_fields') ?>
                </li>
                <li><?php the_field('step_2_descr_7_fields') ?>
                </li>
              </ul>
            </div>
          </div>
          <div id="third" class="steps__item">
            <div class="item-wrapper show">
              <div class="steps__logo">&#xe901;</div>
              <div class="steps__title"><?php the_field('step_3_title_1_fields') ?>
              </div>
              <div class="divider"></div>
              <ul class="steps__descr">
                <li><?php the_field('step_3_descr_1_fields') ?>
                </li>
                <li><?php the_field('step_3_descr_2_fields') ?>
                </li>
                <li><?php the_field('step_3_descr_3_fields') ?>
                </li>
              </ul>
            </div>
            <div class="item-wrapper_sec">
              <div class="steps__title"><?php the_field('step_3_title_2_fields') ?>
              </div>
              <div class="divider"></div>
              <ul class="steps__descr">
                <li><?php the_field('step_3_descr_4_fields') ?>
                </li>
                <li><?php the_field('step_3_descr_5_fields') ?>
                </li>
                <li><?php the_field('step_3_descr_6_fields') ?>
                </li>
                <li><?php the_field('step_3_descr_7_fields') ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <section class="text">
        <div class="container">
          <div class="text__wrapper">
            <?php the_content(); ?>
          </div>
        </div>
      </section>

      <section class="questions" id="questions">
        <div class="container">
          <h2><?php the_field('faq_title_fields') ?>
          </h2>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_1_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_1_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_2_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_2_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_3_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_3_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_4_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_4_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_5_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_5_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_6_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_6_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_7_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_7_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_8_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_8_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_9_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_9_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_10_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_10_fields') ?>
              </div>
            </div>
          </div>
          <div class="questions__wrapper">
            <div class="questions__x"></div>
            <div class="questions__y"></div>
            <div class="questions__quest">
              <?php the_field('faq_quest_11_fields') ?>
              <div class="questions__ans">
                <?php the_field('faq_answ_11_fields') ?>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="information" id="legal">
        <div class="container">
          <h2><?php the_field('legal_title_fields') ?>
          </h2>

          <div class="mfo-contacts">
            <?php
            if (!empty($offers_posts)) :
              foreach ($offers_posts as $post) :
                setup_postdata($post);
            ?>
                <ul class="mfo-contacts__item">
                  <li><?php the_title(); ?> - <?php the_field('llc'); ?></li>
                  <li>Адреса: <?php the_field('address'); ?></li>
                  <li>Телефон: <?php the_field('phone'); ?></li>
                  <li>e-mail: <?php the_field('email'); ?></li>
                  <li><?php the_field('legal'); ?></li>
                </ul>
            <?php
              endforeach;
              wp_reset_postdata();
            endif;
            ?>

          </div>
        </div>
      </section>

  <?php
    endwhile;
  endif;
  ?>

</main>

<?php
get_footer();
?>
