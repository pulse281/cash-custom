<?php
/** Responsive promo, using the current page's existing ACF fields. */
defined('ABSPATH') || exit;
$promo_title = get_field('offers_title_fields');
$calculator_title = get_field('filter_header_fields');
$promo_subtitle = get_field('offers_title_text_fields');
$benefit_defaults = ['Перевірені компанії', 'Актуальні умови', 'Зручне порівняння'];
?>
<section class="promo-hero" aria-labelledby="promo-heading">
  <div class="promo-hero__inner">
    <div class="promo-hero__intro">
      <p class="promo-hero__badge">Швидко <span>•</span> Зручно <span>•</span> Надійно</p>
      <h1 id="promo-heading"><?php echo esc_html($promo_title ?: get_the_title()); ?></h1>
      <div class="promo-hero__subtitle"><?php echo wp_kses_post($promo_subtitle ?: 'Порівнюйте пропозиції, обирайте найкращі умови та подавайте заявку онлайн.'); ?></div>
      <span class="promo-hero__hint" aria-hidden="true">
        <span>Знайдіть<br />свій варіант</span>
        <svg viewBox="0 0 80 65" fill="none" focusable="false">
          <path d="M61 5C64 27 43 45 17 54M17 54l8-13M17 54l16-1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
    </div>
    <div class="promo-hero__calculator">
      <div class="promo-hero__label-row">
        <label for="promo-amount"><?php echo esc_html($calculator_title ?: 'Бажана сума позики'); ?></label>
        <span>500 – 25 000 грн</span>
      </div>
      <div class="promo-hero__controls">
        <button type="button" class="btnEdit" value="-500" aria-label="Зменшити суму на 500 гривень">−</button>
        <div class="promo-hero__amount">
          <input id="promo-amount" class="calculator__area_sum" type="number" inputmode="numeric" min="500" max="25000" step="500" value="1500" />
          <span aria-hidden="true">грн</span>
        </div>
        <button type="button" class="btnEdit" value="500" aria-label="Збільшити суму на 500 гривень">+</button>
      </div>
      <input class="calculator__range" type="range" min="500" max="25000" step="500" value="1500" aria-label="Бажана сума позики у гривнях" />
    </div>
    <ul class="promo-hero__benefits">
      <?php foreach (['list_1_fields', 'list_2_fields', 'list_3_fields'] as $index => $field) : ?>
        <li>
          <span class="promo-hero__icon promo-hero__icon--<?php echo (int) $index; ?>" aria-hidden="true">
            <?php if (0 === $index) : ?>
              <svg viewBox="0 0 32 32" fill="none"><path d="M16 3 27 8v8c0 7-11 13-11 13S5 23 5 16V8Z" fill="currentColor"/><path d="m10 16 4 4 8-9" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <?php elseif (1 === $index) : ?>
              <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="3"><circle cx="16" cy="16" r="12"/><path d="M16 8v9h7" stroke-linecap="round"/></svg>
            <?php else : ?>
              <svg viewBox="0 0 32 32" fill="currentColor"><rect x="3" y="20" width="6" height="9" rx="2"/><rect x="13" y="12" width="6" height="17" rx="2"/><rect x="23" y="3" width="6" height="26" rx="2"/></svg>
            <?php endif; ?>
          </span>
          <span><?php echo wp_kses_post(get_field($field) ?: $benefit_defaults[$index]); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="promo-hero__actions">
      <a class="promo-hero__submit" href="#offers-title">Підібрати пропозиції <span aria-hidden="true">→</span></a>
      <a class="promo-hero__help" href="#questions">Як це працює?</a>
    </div>
  </div>
</section>
