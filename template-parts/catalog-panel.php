<?php
/**
 * Catalog summary panel.
 *
 * @package Cash-custom
 */

if (!defined('ABSPATH')) {
  exit;
}

$panel_args        = is_array($args) ? $args : [];
$offers            = isset($panel_args['offers']) && is_array($panel_args['offers']) ? $panel_args['offers'] : [];
$offers_count      = count($offers);
$panel_title       = isset($panel_args['title']) ? trim((string) $panel_args['title']) : '';
$panel_description = isset($panel_args['description']) ? trim((string) $panel_args['description']) : '';
$all_offers_url    = '';
$menu_locations    = get_nav_menu_locations();

if (!empty($menu_locations['menu-1'])) {
  $menu_items = wp_get_nav_menu_items($menu_locations['menu-1']);

  if (is_array($menu_items)) {
    foreach ($menu_items as $menu_item) {
      if ('Всі МФО' === trim(wp_strip_all_tags($menu_item->title))) {
        $all_offers_url = $menu_item->url;
        break;
      }
    }
  }
}

if (!$all_offers_url) {
  $all_offers_url = home_url('/offers/');
}
?>

<div class="catalog-panel">
  <ul class="catalog-panel__stats" aria-label="Інформація про каталог">
    <li class="catalog-panel__stat">
      <span class="catalog-panel__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none"><path d="M7 3h7l4 4v14H7z" fill="currentColor" opacity=".18"/><path d="M14 3v5h5M10 12h5M10 15h5M10 18h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </span>
      <span><strong class="catalog-panel__offers-count" aria-live="polite" aria-atomic="true"><?php echo esc_html($offers_count); ?></strong><small>пропозицій</small></span>
    </li>
    <li class="catalog-panel__stat">
      <span class="catalog-panel__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none"><path d="M20 7v5h-5M4 17v-5h5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.3 9A7 7 0 0 0 6.1 6.1L4 8m2 7a7 7 0 0 0 11.9 2.9L20 16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </span>
      <span><strong>Оновлено</strong><small>сьогодні</small></span>
    </li>
    <li class="catalog-panel__stat">
      <span class="catalog-panel__icon catalog-panel__icon--gift" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none"><path d="M4 10h16v11H4zM3 7h18v4H3zM12 7v14" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 7H8.5A2.5 2.5 0 1 1 11 4.5V7Zm0 0h3.5A2.5 2.5 0 1 0 13 4.5V7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
      </span>
      <span><strong>Безкоштовне</strong><small>порівняння</small></span>
    </li>
  </ul>

  <div class="catalog-panel__heading" id="offers-title">
    <h2><?php echo esc_html($panel_title ?: 'Найкращі пропозиції'); ?></h2>
    <a href="<?php echo esc_url($all_offers_url); ?>">Дивитись всі <span aria-hidden="true">→</span></a>
  </div>

  <?php if ($panel_description) : ?>
    <p class="catalog-panel__description"><?php echo nl2br(esc_html($panel_description)); ?></p>
  <?php endif; ?>
</div>
