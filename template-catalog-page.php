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


            <div class="catalog__list" id="offers">

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

                  $url = get_field('referral_link');

                  $idName = esc_attr(sanitize_title(get_the_title()));

                  $badge_logo_id = get_field('badge_info');
                  $logo_id        = get_field('logo');

                  $order = (int) get_field($order_field);
                  $is_first_offer = $order === 1;

                  ?>

                  <div
                    class="offer"
                    id="offer-<?php echo $idName ?>"
                    data-percent=""
                    data-max="<?php the_field('data_max'); ?>"
                    data-name="<?php echo $idName ?>">

                    <div class="offer_badge_info">
                      <?php
                      if ($badge_logo_id) {
                        $badge_args = [
                          'class'    => 'offer_badge_info_img',
                          'alt'      => '',
                          'decoding' => 'async',
                          'loading'  => $is_first_offer ? 'eager' : 'lazy',
                        ];

                        if (!$is_first_offer) {
                          $badge_args['fetchpriority'] = 'low';
                        }

                        echo wp_get_attachment_image(
                          $badge_logo_id,
                          'offer_badge_small',
                          false,
                          $badge_args
                        );
                      }
                      ?>
                    </div>

                    <div class="offer__header">
                      <div class="offer__logo-wrapper">

                        <?php
                        if ($logo_id) {

                          $img_args = [
                            'class'    => 'offer__logo',
                            'alt'      => get_the_title() . ' — кеш кредит',
                            'decoding' => 'async',
                            'loading'  => $is_first_offer ? 'eager' : 'lazy',
                          ];

                          if ($is_first_offer) {
                            $img_args['fetchpriority'] = 'high';
                          } else {
                            $img_args['fetchpriority'] = 'low';
                          }

                          echo '<a href="' . esc_url($url) . '" id="logo-' . esc_attr($idName) . '" class="offer__logo-link btn_offer" target="_blank" rel="sponsored nofollow noopener" data-base-url="' . esc_url($url) . '">';

                          echo wp_get_attachment_image(
                            $logo_id,
                            'medium',
                            false,
                            $img_args
                          );

                          echo '</a>';
                        }
                        ?>
                        <div style='margin-top: 10px;'>
                          Рейтинг <?php the_field('rate') ?> (<span class="star">&#9733; &#9733; &#9733; &#9733; &#9733;</span>)
                        </div>
                        <div>Ліцензія <?php the_field('license') ?></div>
                        <div>Робочий час: <?php the_field('work_time') ?></div>
                      </div>

                      <div class="offer__term-wrapper">
                        <div class="offer__term-loan">
                          <div class="offer__term-index">
                            Сума позики до
                            <span class="offer__term-num"><?php the_field('loan_sum') ?></span> грн. <br />
                            <span class="offer__term-text">Перший кредит</span>
                          </div>
                          <div class="offer__term-index">
                            Відсоток від <span class="offer__term-num"><?php the_field('percent') ?></span> %
                            <br />
                            <span class="offer__term-text">Ставка в день</span>
                          </div>
                          <div class="offer__term-index">
                            Термін до <span class="offer__term-num"><?php the_field('term') ?></span> днів
                            <br />
                            <span class="offer__term-text">Строк позики</span>
                          </div>
                        </div>

                        <div class="offer__term-info">
                          <div class="offer__rrps">
                            <span class="offer__term-num">
                              <?php the_field('apr') ?> </span>% <br />
                            <span class="offer__term-text">Реальна річна процентна ставка</span>
                          </div>

                          <div class="offer__term-links">
                            <a
                              href="<?php the_field('characteristics_of_the_service') ?>"
                              target="_blank"
                              aria-label="<?php echo esc_attr('Істотні характеристики послуги — ' . get_the_title()); ?>"
                              class="offer__term-link">Істотні характеристики послуги</a>
                            <a
                              href="<?php the_field('warning_of_possible_consequences') ?>"
                              target="_blank"
                              aria-label="<?php echo esc_attr('Попередження про можливі наслідки — ' . get_the_title()); ?>"
                              class="offer__term-link">Попередження про можливі наслідки</a>
                          </div>
                        </div>
                      </div>

                      <div class="offer__button">
                        <a
                          id="<?php echo $idName ?>"
                          class="btn btn_offer-request btn_offer"
                          href="<?php echo esc_url($url); ?>"
                          target="_blank"
                          rel="sponsored nofollow noopener"
                          data-base-url="<?php echo esc_url($url); ?>">
                          Подати заявку</a>
                        <div class="offer__trigger offer__trigger_up">
                          Детальніше
                        </div>
                      </div>
                    </div>

                    <div class="offer__wrapper">
                      <div class="offer__second-loan">
                        <strong>Повторний кредит:</strong> <br />
                        до <strong> <?php the_field('second_loan_sum') ?> </strong> грн., ставка в день
                        <strong> <?php the_field('second_loan_percent') ?>%</strong>, на термін до
                        <strong><?php the_field('second_loan_term') ?></strong> днів
                      </div>

                      <div class="offer__footer">
                        <div class="offer__requirements">
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'user.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="wrapper">
                              <div class="offer__requirements-title">Вік</div>
                              <div class="offer__requirements-text"><?php the_field('age') ?></div>
                            </div>
                          </div>
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'drivers-license-o.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="wrapper">
                              <div class="offer__requirements-title">
                                Необхідні документи
                              </div>
                              <div class="offer__requirements-text">
                                Паспорт громадянина України
                              </div>
                              <div class="offer__requirements-text">ІПН</div>
                            </div>
                          </div>
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'briefcase.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="wrapper">
                              <div class="offer__requirements-title">
                                Працевлаштування
                              </div>
                              <div class="offer__requirements-text">
                                Не обов'язково
                              </div>
                            </div>
                          </div>
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'meter.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="wrapper">
                              <div class="offer__requirements-title">
                                Кредитна історія
                              </div>
                              <div class="offer__requirements-text">
                                Можна з поганою кредитною історією
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="offer__requirements">
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'credit-card.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="wrapper">
                              <div class="offer__requirements-title">Отримання</div>
                              <div class="offer__requirements-text">
                                Онлайн на карту
                              </div>
                            </div>
                          </div>
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'clipboard.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="wrapper">
                              <div class="offer__requirements-title">
                                Дострокове погашення
                              </div>
                              <div class="offer__requirements-text">Можливе</div>
                            </div>
                          </div>
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'calendar.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="wrapper">
                              <div class="offer__requirements-title">
                                Пролонгація
                              </div>
                              <div class="offer__requirements-text">Можлива</div>
                            </div>
                          </div>
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'stopwatch.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="wrapper">
                              <div class="offer__requirements-title">Розгляд</div>
                              <div class="offer__requirements-text">15 хвилин</div>
                            </div>
                          </div>
                        </div>

                        <div class="offer__requirements">
                          <div class="offer__requirements-title">
                            Способи погашення кредиту:
                          </div>

                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'file-text.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="offer__requirements-text">
                              За банківськими реквізитами
                            </div>
                          </div>
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'display.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image offer__requirements-image_online" />
                            </div>
                            <div class="offer__requirements-text">
                              Онлайн в особистому кабінеті фінансової компанії або через
                              інтернет-банкінг
                            </div>
                          </div>
                          <div class="offer__requirements-item">
                            <div class="offer__requirements-logo">
                              <img
                                src="<?php echo esc_url($offer_icon_base . 'classic-computer.svg'); ?>"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                decoding="async"
                                class="offer__requirements-image" />
                            </div>
                            <div class="offer__requirements-text">
                              Через термінали самообслуговування
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

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