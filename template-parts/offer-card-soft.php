<?php
/**
 * Soft offer card variation.
 *
 * @package Cash-custom
 */

if (!defined('ABSPATH')) {
  exit;
}

$card_args            = is_array($args) ? $args : [];
$card_args['variant'] = 'soft';

get_template_part('template-parts/offer-card', null, $card_args);
