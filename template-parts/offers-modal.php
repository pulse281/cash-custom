<?php
/** Selected ACF offers, independent of the catalog filter. */
defined('ABSPATH') || exit;

$modal_offers = [];
$modal_page_id = get_queried_object_id();
for ($index = 0; $index < 5; $index++) {
  $suffix = $index ? '_' . $index : '';
  $image = get_field('modal_offer_img' . $suffix, $modal_page_id);
  $link = get_field('modal_offer_link' . $suffix, $modal_page_id);
  $url = is_array($link) ? ($link['url'] ?? '') : $link;
  $url = is_string($url) ? esc_url($url, ['http', 'https']) : '';
  if (!$url || !preg_match('~^https?://~i', $url) || !$image) {
    continue;
  }

  $image_id = is_array($image) ? ($image['ID'] ?? $image['id'] ?? 0) : (is_numeric($image) ? (int) $image : 0);
  $alt = is_array($image) ? ($image['alt'] ?? '') : '';
  $image_html = '';
  if ($image_id) {
    $image_html = wp_get_attachment_image($image_id, 'medium', false, [
      'class' => 'offers-modal__logo',
      'loading' => 'lazy',
      'decoding' => 'async',
    ]);
  }
  if (!$image_html) {
    $image_url = is_array($image) ? ($image['url'] ?? '') : (is_string($image) && !is_numeric($image) ? $image : '');
    $image_url = esc_url($image_url, ['http', 'https']);
    if ($image_url) {
      $image_html = '<img class="offers-modal__logo" src="' . $image_url . '" alt="' . esc_attr($alt) . '" loading="lazy" decoding="async">';
    }
  }
  if ($image_html) {
    $modal_offers[] = ['url' => $url, 'image' => $image_html];
  }
}
if (!$modal_offers) {
  return;
}
?>
<dialog class="offers-modal" aria-labelledby="offers-modal-title">
  <button class="offers-modal__close" type="button" aria-label="Закрити" autofocus>
    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="m6 6 12 12M18 6 6 18" /></svg>
  </button>
  <h2 id="offers-modal-title" class="offers-modal__title">Сьогоднішній рейтинг компаній</h2>
  <ol class="offers-modal__list">
    <?php foreach ($modal_offers as $index => $modal_offer) : ?>
      <li class="offers-modal__row">
        <span class="offers-modal__rank" aria-hidden="true"><?php echo (int) $index + 1; ?></span>
        <span class="offers-modal__image"><?php echo $modal_offer['image']; ?></span>
        <a class="offers-modal__apply btn_offer" href="<?php echo $modal_offer['url']; ?>" data-base-url="<?php echo $modal_offer['url']; ?>" data-campaign="modal" target="_blank" rel="sponsored nofollow noopener" aria-label="Перейти до пропозиції <?php echo (int) $index + 1; ?>">Перейти</a>
      </li>
    <?php endforeach; ?>
  </ol>
</dialog>
