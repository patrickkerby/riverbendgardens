<?php

/**
 * Shared helpers for CSA packing and delivery lists.
 *
 * Winter/late-season orders store pickup as a custom `location` attribute
 * (free-text variants). Summer orders use the `pa_pickup-location` taxonomy.
 */

if (!function_exists('csa_product_id')) {
    function csa_product_id($key)
    {
        $ids = [
            'winter' => 5484,
            'fullyear' => 103898,
            'fullseason' => 5958,
            'biwk' => 87354,
            'halfsummer' => 103905,
            'delivery' => 102902,
        ];

        return $ids[$key] ?? null;
    }
}

if (!function_exists('csa_order_date_range')) {
    function csa_order_date_range($season = 'winter')
    {
        // Both CSAs go on sale in January/February and stay processing for the
        // season. Product ID (not date) separates summer from late season.
        $year = (int) date('Y');

        return sprintf('%d-01-01...%d-12-31', $year, $year);
    }
}

if (!function_exists('csa_normalize_location')) {
    function csa_normalize_location($location)
    {
        $location = trim(html_entity_decode((string) $location, ENT_QUOTES, 'UTF-8'));
        if ($location === '') {
            return '';
        }

        static $map = null;
        if ($map === null) {
            $map = [
                'Catch of the Week!' => 'Catch of the Week',
                'Confetti Sweets (Sherwood Park)' => 'Confetti Sweets',
                "D'arcy's Meat Market (St Albert Location)" => "D'Arcy's Meats (St Albert)",
                "D'Arcy's Meat Market (St Albert Location)" => "D'Arcy's Meats (St Albert)",
                "D'arcy's Meats (St Albert)" => "D'Arcy's Meats (St Albert)",
                "D'arcy's Meat Market (Whitemud Crossing Location)" => "D'Arcy's Meats (Whitemud Crossing)",
                "D'Arcy's Meat Market (Whitemud Crossing Location)" => "D'Arcy's Meats (Whitemud Crossing)",
                "D'arcy's Meats (Whitemud Crossing)" => "D'Arcy's Meats (Whitemud Crossing)",
                'Remedy (109th St)' => 'Remedy (109St Location)',
                'Remedy (Terwillegar)' => 'Remedy (Terwillegar Location)',
                'Ribeye Butcher Shop (Manning Center)' => 'Ribeye Butcher Shop (Manning Location)',
                'Ribeye Butcher Shop (Manning) - delivered by Janelle' => 'Ribeye Butcher Shop (Manning Location)',
                'Ribeye Butcher Shop (St Albert Erin Ridge)' => 'Ribeye Butcher Shop (St Albert)',
                'Jasper Ave Location (TBD)' => 'Remedy (Jasper Ave)',
                'Obj3cts (Jasper Ave)' => 'Remedy (Jasper Ave)',
                'OBJ3CTS' => 'Remedy (Jasper Ave)',
                'Remedy (124 St Location)' => 'Remedy (Jasper Ave)',
                'Home Delivery (Edmonton & Sherwood Park only)' => 'Delivery',
                'Highlands Area Pick Up' => 'Candid Coffee Roasters',
                'Candid Coffee Highlands' => 'Candid Coffee Roasters',
                'Candid Coffee - Highlands' => 'Candid Coffee Roasters',
            ];
        }

        return $map[$location] ?? $location;
    }
}

if (!function_exists('csa_meta_string')) {
    function csa_meta_string($value)
    {
        if (is_array($value)) {
            $value = reset($value);
        }

        return is_string($value) || is_numeric($value) ? trim((string) $value) : '';
    }
}

if (!function_exists('csa_order_item_location')) {
    function csa_order_item_location($item)
    {
        $location = csa_normalize_location(csa_meta_string($item->get_meta('location')));
        if ($location !== '') {
            return $location;
        }

        $slug = csa_meta_string($item->get_meta('pa_pickup-location'));
        if ($slug === '') {
            $slug = csa_meta_string($item->get_meta('attribute_pa_pickup-location'));
        }
        if ($slug === '') {
            return csa_normalize_location(csa_meta_string($item->get_meta('attribute_location')));
        }

        static $terms = [];
        if (!array_key_exists($slug, $terms)) {
            $term = get_term_by('slug', $slug, 'pa_pickup-location');
            $terms[$slug] = ($term && !is_wp_error($term) && !empty($term->name)) ? $term->name : '';
        }

        if ($terms[$slug] !== '') {
            return csa_normalize_location($terms[$slug]);
        }

        return csa_normalize_location($slug);
    }
}

if (!function_exists('csa_acf_location_name')) {
    function csa_acf_location_name($item)
    {
        if (!empty($item['location']) && is_object($item['location'])) {
            return $item['location']->name;
        }
        if (!empty($item['custom_location_name'])) {
            return $item['custom_location_name'];
        }

        return '';
    }
}

if (!function_exists('csa_winter_extras_for_location')) {
    function csa_winter_extras_for_location($location, $acf_locations = [])
    {
        $canonical = csa_normalize_location($location);
        if ($canonical === '' || strcasecmp($canonical, 'Delivery') === 0) {
            return 0;
        }

        foreach ((array) $acf_locations as $item) {
            $name = csa_acf_location_name($item);
            if ($name !== '' && csa_normalize_location($name) === $canonical) {
                return !empty($item['extras']) ? 1 : 0;
            }
        }

        // Pickup sites pack one extra share unless ACF says otherwise.
        return 1;
    }
}

if (!function_exists('csa_hpos_enabled')) {
    function csa_hpos_enabled()
    {
        return class_exists('\Automattic\WooCommerce\Utilities\OrderUtil')
            && \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled();
    }
}

if (!function_exists('csa_list_cache_version')) {
    function csa_list_cache_version()
    {
        return (int) get_option('csa_list_cache_ver', 1);
    }
}

if (!function_exists('csa_flush_list_cache')) {
    function csa_flush_list_cache()
    {
        update_option('csa_list_cache_ver', csa_list_cache_version() + 1, false);
    }
}

if (!function_exists('csa_parse_date_range')) {
    function csa_parse_date_range($date_range)
    {
        if (!$date_range || strpos($date_range, '...') === false) {
            return [null, null];
        }

        list($start, $end) = explode('...', $date_range, 2);

        return [$start . ' 00:00:00', $end . ' 23:59:59'];
    }
}

if (!function_exists('csa_prefixed_statuses')) {
    function csa_prefixed_statuses(array $statuses)
    {
        $prefixed = [];
        foreach ($statuses as $status) {
            $status = ltrim((string) $status, 'wc-');
            if ($status === '') {
                continue;
            }
            $prefixed[] = 'wc-' . $status;
        }

        return array_values(array_unique($prefixed));
    }
}

if (!function_exists('csa_plain_statuses')) {
    function csa_plain_statuses(array $statuses)
    {
        return array_map(function ($status) {
            return ltrim((string) $status, 'wc-');
        }, $statuses);
    }
}

if (!function_exists('csa_get_orders_for_products')) {
    function csa_get_orders_for_products(array $product_ids, $date_range = null, array $statuses = ['processing', 'on-hold'])
    {
        $product_ids = array_values(array_unique(array_filter(array_map('intval', $product_ids))));
        if (empty($product_ids) || !function_exists('wc_get_order')) {
            return [];
        }

        $date_range = $date_range ?: csa_order_date_range('winter');
        $plain_statuses = csa_plain_statuses($statuses);
        $cache_key = 'csa_oids_' . csa_list_cache_version() . '_' . md5(implode(',', $product_ids) . '|' . $date_range . '|' . implode(',', $plain_statuses));

        static $runtime = [];
        if (isset($runtime[$cache_key])) {
            return $runtime[$cache_key];
        }

        $order_ids = get_transient($cache_key);
        if (!is_array($order_ids)) {
            $order_ids = csa_order_ids_for_products($product_ids, $date_range, $plain_statuses);
            if (!is_array($order_ids)) {
                $order_ids = [];
            }
            set_transient($cache_key, $order_ids, 2 * MINUTE_IN_SECONDS);
        }

        $orders = [];
        foreach ($order_ids as $order_id) {
            $order = wc_get_order((int) $order_id);
            if (!$order || !is_object($order) || !method_exists($order, 'get_status')) {
                continue;
            }
            if (!in_array($order->get_status(), $plain_statuses, true)) {
                continue;
            }
            $orders[] = $order;
        }

        $runtime[$cache_key] = $orders;

        return $orders;
    }
}

if (!function_exists('csa_order_ids_for_products')) {
    function csa_order_ids_for_products(array $product_ids, $date_range = null, array $statuses = ['processing', 'on-hold'])
    {
        $ids = csa_order_ids_from_lookup($product_ids, $date_range, $statuses);
        if ($ids !== null) {
            return $ids;
        }

        return csa_order_ids_from_itemmeta($product_ids, $date_range, $statuses) ?: [];
    }
}

if (!function_exists('csa_order_ids_from_lookup')) {
    function csa_order_ids_from_lookup(array $product_ids, $date_range = null, array $statuses = ['processing', 'on-hold'])
    {
        global $wpdb;

        $placeholders = implode(',', array_fill(0, count($product_ids), '%d'));
        $prefixed = csa_prefixed_statuses($statuses);
        if (empty($prefixed)) {
            return [];
        }
        $status_placeholders = implode(',', array_fill(0, count($prefixed), '%s'));
        $lookup_table = $wpdb->prefix . 'wc_order_product_lookup';
        $params = array_merge($product_ids, $product_ids, $prefixed);
        list($start, $end) = csa_parse_date_range($date_range);

        if (csa_hpos_enabled()) {
            $orders_table = $wpdb->prefix . 'wc_orders';
            $sql = "SELECT DISTINCT lookup.order_id
                FROM {$lookup_table} lookup
                INNER JOIN {$orders_table} orders ON orders.id = lookup.order_id
                WHERE (lookup.product_id IN ({$placeholders}) OR lookup.variation_id IN ({$placeholders}))
                  AND orders.status IN ({$status_placeholders})
                  AND orders.type = 'shop_order'";
        } else {
            $sql = "SELECT DISTINCT lookup.order_id
                FROM {$lookup_table} lookup
                INNER JOIN {$wpdb->posts} orders ON orders.ID = lookup.order_id
                WHERE (lookup.product_id IN ({$placeholders}) OR lookup.variation_id IN ({$placeholders}))
                  AND orders.post_status IN ({$status_placeholders})
                  AND orders.post_type = 'shop_order'";
        }

        if ($start && $end) {
            $sql .= ' AND lookup.date_created >= %s AND lookup.date_created <= %s';
            $params[] = $start;
            $params[] = $end;
        }

        $wpdb->last_error = '';
        $order_ids = $wpdb->get_col($wpdb->prepare($sql, $params));

        if ($wpdb->last_error) {
            return null;
        }

        return array_map('intval', (array) $order_ids);
    }
}

if (!function_exists('csa_order_ids_from_itemmeta')) {
    function csa_order_ids_from_itemmeta(array $product_ids, $date_range = null, array $statuses = ['processing', 'on-hold'])
    {
        global $wpdb;

        $placeholders = implode(',', array_fill(0, count($product_ids), '%s'));
        $prefixed = csa_prefixed_statuses($statuses);
        if (empty($prefixed)) {
            return [];
        }
        $status_placeholders = implode(',', array_fill(0, count($prefixed), '%s'));
        $params = array_merge(array_map('strval', $product_ids), $prefixed);
        list($start, $end) = csa_parse_date_range($date_range);
        $items = $wpdb->prefix . 'woocommerce_order_items';
        $itemmeta = $wpdb->prefix . 'woocommerce_order_itemmeta';

        if (csa_hpos_enabled()) {
            $orders_table = $wpdb->prefix . 'wc_orders';
            $sql = "SELECT DISTINCT oi.order_id
                FROM {$items} oi
                INNER JOIN {$itemmeta} oim ON oi.order_item_id = oim.order_item_id
                INNER JOIN {$orders_table} orders ON orders.id = oi.order_id
                WHERE oim.meta_key IN ('_product_id', '_variation_id')
                  AND oim.meta_value IN ({$placeholders})
                  AND orders.status IN ({$status_placeholders})
                  AND orders.type = 'shop_order'";
            if ($start && $end) {
                $sql .= ' AND orders.date_created_gmt >= %s AND orders.date_created_gmt <= %s';
                $params[] = gmdate('Y-m-d H:i:s', strtotime($start));
                $params[] = gmdate('Y-m-d H:i:s', strtotime($end));
            }
        } else {
            $sql = "SELECT DISTINCT oi.order_id
                FROM {$items} oi
                INNER JOIN {$itemmeta} oim ON oi.order_item_id = oim.order_item_id
                INNER JOIN {$wpdb->posts} orders ON orders.ID = oi.order_id
                WHERE oim.meta_key IN ('_product_id', '_variation_id')
                  AND oim.meta_value IN ({$placeholders})
                  AND orders.post_status IN ({$status_placeholders})
                  AND orders.post_type = 'shop_order'";
            if ($start && $end) {
                $sql .= ' AND orders.post_date >= %s AND orders.post_date <= %s';
                $params[] = $start;
                $params[] = $end;
            }
        }

        $wpdb->last_error = '';
        $order_ids = $wpdb->get_col($wpdb->prepare($sql, $params));

        if ($wpdb->last_error) {
            return [];
        }

        return array_map('intval', (array) $order_ids);
    }
}

if (!function_exists('csa_pickup_term_by_slug')) {
    function csa_pickup_term_by_slug($slug)
    {
        static $cache = [];
        $slug = csa_meta_string($slug);
        if ($slug === '') {
            return null;
        }
        if (!array_key_exists($slug, $cache)) {
            $term = get_term_by('slug', $slug, 'pa_pickup-location');
            $cache[$slug] = ($term && !is_wp_error($term)) ? $term : null;
        }

        return $cache[$slug];
    }
}

if (!function_exists('csa_summer_location_counts')) {
    function csa_summer_location_counts($orders, $display_biwk = true, $display_halfsummer = false)
    {
        $blank = [
            'biweekly' => 0,
            'full_bigger' => 0,
            'full_smaller' => 0,
            'half_bigger' => 0,
            'half_smaller' => 0,
            'fullyear' => 0,
            'fullyear_bigger' => 0,
        ];
        $counts = [];
        $full_id = (int) csa_product_id('fullseason');
        $biwk_id = (int) csa_product_id('biwk');
        $half_id = (int) csa_product_id('halfsummer');

        foreach ((array) $orders as $order) {
            if (!is_object($order) || !method_exists($order, 'get_items')) {
                continue;
            }

            foreach ($order->get_items() as $item) {
                $pid = (int) $item->get_product_id();
                $qty = (int) $item->get_quantity();
                $size = $item->get_meta('size');
                $bundle_mode = $item->get_meta('_bundle_group_mode', true);
                $location = csa_meta_string($item->get_meta('pa_pickup-location'));

                if ($location !== '' && !isset($counts[$location])) {
                    $counts[$location] = $blank;
                }

                if ($location !== '' && $pid === $biwk_id && $display_biwk) {
                    $counts[$location]['biweekly'] += $qty;
                } elseif ($location !== '' && $pid === $full_id && $bundle_mode !== 'parent') {
                    if ($size === 'Bigger') {
                        $counts[$location]['full_bigger'] += $qty;
                    } elseif ($size === 'Smaller') {
                        $counts[$location]['full_smaller'] += $qty;
                    }
                } elseif ($location !== '' && $pid === $half_id && $bundle_mode !== 'parent' && $display_halfsummer) {
                    if ($size === 'Bigger') {
                        $counts[$location]['half_bigger'] += $qty;
                    } elseif ($size === 'Smaller') {
                        $counts[$location]['half_smaller'] += $qty;
                    }
                }

                if ($bundle_mode === 'parent') {
                    $bundled = $item->get_meta('_stamp', true);
                    $summer_loc = '';
                    if (is_array($bundled)) {
                        foreach ($bundled as $value) {
                            if (!empty($value['attributes']['attribute_pa_pickup-location'])) {
                                $summer_loc = $value['attributes']['attribute_pa_pickup-location'];
                            }
                        }
                    }
                    if ($summer_loc !== '') {
                        if (!isset($counts[$summer_loc])) {
                            $counts[$summer_loc] = $blank;
                        }
                        $counts[$summer_loc]['fullyear_bigger'] += $qty;
                        $counts[$summer_loc]['fullyear']++;
                    }
                }
            }
        }

        return $counts;
    }
}

if (!function_exists('csa_winter_line_items')) {
    function csa_winter_line_items($orders)
    {
        $winter_id = (int) csa_product_id('winter');
        $rows = [];

        foreach ((array) $orders as $order) {
            if (!is_object($order) || !method_exists($order, 'get_items')) {
                continue;
            }

            foreach ($order->get_items() as $item) {
                $item_product_id = (int) $item->get_product_id();
                $item_variation_id = (int) $item->get_variation_id();
                if ($item_product_id !== $winter_id && $item_variation_id !== $winter_id) {
                    continue;
                }

                $location = csa_order_item_location($item);
                if ($location === '') {
                    continue;
                }

                $rows[] = [
                    'order' => $order,
                    'item' => $item,
                    'location' => $location,
                    'size' => $item->get_meta('size'),
                    'quantity' => (int) $item->get_quantity(),
                ];
            }
        }

        return $rows;
    }
}

if (!function_exists('csa_winter_counts_by_location')) {
    function csa_winter_counts_by_location($line_items)
    {
        $counts = [];

        foreach ((array) $line_items as $row) {
            $location = $row['location'];
            if (!isset($counts[$location])) {
                $counts[$location] = ['Bigger' => 0, 'Smaller' => 0];
            }
            if ($row['size'] === 'Bigger') {
                $counts[$location]['Bigger'] += $row['quantity'];
            } elseif ($row['size'] === 'Smaller') {
                $counts[$location]['Smaller'] += $row['quantity'];
            }
        }

        ksort($counts, SORT_NATURAL | SORT_FLAG_CASE);

        return $counts;
    }
}

if (!function_exists('csa_winter_index_rows')) {
    function csa_winter_index_rows($counts, $acf_locations = [])
    {
        $rows = [];
        $used = [];
        $has_acf = !empty($acf_locations);

        foreach ((array) $acf_locations as $item) {
            $display_name = csa_acf_location_name($item);
            if ($display_name === '') {
                continue;
            }

            $canonical = csa_normalize_location($display_name);
            if ($canonical === '' || isset($used[$canonical])) {
                continue;
            }
            $used[$canonical] = true;
            $bigger = $counts[$canonical]['Bigger'] ?? 0;
            $smaller = $counts[$canonical]['Smaller'] ?? 0;
            $extras = csa_winter_extras_for_location($canonical);

            $rows[] = [
                'name' => $canonical,
                'bigger' => $bigger,
                'smaller' => $smaller,
                'extras' => $extras,
                'total' => $bigger + $smaller + $extras,
            ];
        }

        foreach ($counts as $name => $count) {
            if (isset($used[$name])) {
                continue;
            }

            // Locations present in orders but not in ACF still appear so nothing is dropped.
            $extras = csa_winter_extras_for_location($name);

            $rows[] = [
                'name' => $name,
                'bigger' => $count['Bigger'],
                'smaller' => $count['Smaller'],
                'extras' => $extras,
                'total' => $count['Bigger'] + $count['Smaller'] + $extras,
            ];
        }

        if (!$has_acf) {
            usort($rows, function ($a, $b) {
                return strnatcasecmp($a['name'], $b['name']);
            });
        }

        return $rows;
    }
}

if (!function_exists('csa_winter_items_for_location')) {
    function csa_winter_items_for_location($line_items, $location)
    {
        $canonical = csa_normalize_location($location);
        $matches = array_values(array_filter((array) $line_items, function ($row) use ($canonical) {
            return $row['location'] === $canonical;
        }));

        usort($matches, function ($a, $b) {
            $last = strcasecmp($a['order']->get_billing_last_name(), $b['order']->get_billing_last_name());
            if ($last !== 0) {
                return $last;
            }

            return strcasecmp($a['order']->get_billing_first_name(), $b['order']->get_billing_first_name());
        });

        return $matches;
    }
}

add_action('woocommerce_order_status_changed', 'csa_flush_list_cache');
add_action('woocommerce_new_order', 'csa_flush_list_cache');
add_action('woocommerce_trash_order', 'csa_flush_list_cache');
add_action('woocommerce_delete_order', 'csa_flush_list_cache');
