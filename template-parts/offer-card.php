<?php
/**
 * Offer card for the catalog page.
 *
 * @package Cash-custom
 */

if (!defined('ABSPATH')) {
  exit;
}

$url             = get_field('referral_link');
$idName          = esc_attr(sanitize_title(get_the_title()));
$badge_logo_id   = get_field('badge_info');
$badge_info_text = trim((string) get_field('badge_info_text'));
$logo_id         = get_field('logo');
$is_first_offer  = !empty($args['is_first_offer']);
$offer_icon_base = isset($args['icon_base_url'])
  ? (string) $args['icon_base_url']
  : get_template_directory_uri() . '/assets/img/offer/';
$variant          = isset($args['variant']) && in_array($args['variant'], ['soft', 'outline'], true)
  ? $args['variant']
  : 'soft';
$category_slugs   = wp_list_pluck(get_the_category(), 'slug');
?>

<div
  class="offer offer--<?php echo esc_attr($variant); ?>"
  id="offer-<?php echo $idName ?>"
  data-percent=""
  data-max="<?php the_field('data_max'); ?>"
  data-name="<?php echo $idName ?>"
  data-order-default="<?php echo esc_attr((int) get_field('offer_order')); ?>"
  data-order-zero-percent="<?php echo esc_attr((int) get_field('offer_order_zero_percent')); ?>"
  data-order-top="<?php echo esc_attr((int) get_field('offer_order_top')); ?>"
  data-order-bez-dzvinkiv="<?php echo esc_attr((int) get_field('offer_order_bez_dzvinkiv')); ?>"
  data-order-pogana-ki="<?php echo esc_attr((int) get_field('offer_order_pogana_ki')); ?>"
  data-order-novi="<?php echo esc_attr((int) get_field('offer_order_novi')); ?>"
  data-categories="<?php echo esc_attr(implode(',', $category_slugs)); ?>">

  <?php if ($badge_logo_id || $badge_info_text) : ?>
    <div class="offer_badge_info<?php echo $badge_logo_id ? '' : ' offer_badge_info--text'; ?>">
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
      } else {
        echo esc_html($badge_info_text);
      }
      ?>
    </div>
  <?php endif; ?>

  <div class="offer-card__main">
    <div class="offer-card__brand">

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
      <div class="offer-card__rating" aria-label="Рейтинг <?php echo esc_attr(get_field('rate')); ?> з 5">
        <span class="offer-card__rating-star" aria-hidden="true">&#9733;</span>
        <span class="offer-card__rating-value"><?php the_field('rate') ?></span>
        <span class="offer-card__rating-scale">/ 5</span>
      </div>
    </div>

    <div class="offer-card__amount">
      <span class="offer-card__label">Сума позики</span>
      <div class="offer-card__amount-value">
        <strong><span class="offer-card__prefix">до</span> <?php the_field('loan_sum') ?></strong>
        <span class="offer-card__currency">₴</span>
      </div>
    </div>

    <div class="offer-card__conditions">
      <div class="offer-card__condition">
        <strong>від <?php the_field('percent') ?>%</strong>
        <span class="offer-card__label">Ставка</span>
      </div>
      <div class="offer-card__condition">
        <strong><?php the_field('term') ?> <small>днів</small></strong>
        <span class="offer-card__label">Термін</span>
      </div>
    </div>

    <div class="offer-card__apr">
      <span class="offer-card__label">РРПС</span>
      <strong><?php the_field('apr') ?>%</strong>
    </div>

    <a
      id="<?php echo $idName ?>"
      class="btn btn_offer-request btn_offer offer-card__apply"
      href="<?php echo esc_url($url); ?>"
      target="_blank"
      rel="sponsored nofollow noopener"
      data-base-url="<?php echo esc_url($url); ?>">
      Подати заявку</a>

    <div class="offer-card__links">
      <a
        href="<?php the_field('characteristics_of_the_service') ?>"
        target="_blank"
        aria-label="<?php echo esc_attr('Істотні характеристики послуги — ' . get_the_title()); ?>"
        class="offer__term-link">Істотні характеристики</a>
      <a
        href="<?php the_field('warning_of_possible_consequences') ?>"
        target="_blank"
        aria-label="<?php echo esc_attr('Попередження про можливі наслідки — ' . get_the_title()); ?>"
        class="offer__term-link">Попередження про наслідки</a>
    </div>

    <button class="offer__trigger offer__trigger_up" type="button">
      Детальніше
    </button>
  </div>

  <div class="offer__wrapper">
    <div class="offer-card__company-meta">
      <div><strong>Ліцензія:</strong> <?php the_field('license') ?></div>
      <div><strong>Робочий час:</strong> <?php the_field('work_time') ?></div>
    </div>

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
