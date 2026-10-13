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

if (!function_exists('csa_get_orders_for_products')) {
    function csa_get_orders_for_products(array $product_ids, $date_range = null)
    {
        $product_ids = array_values(array_unique(array_filter(array_map('intval', $product_ids))));
        if (empty($product_ids) || !function_exists('wc_get_order')) {
            return [];
        }

        $date_range = $date_range ?: csa_order_date_range('winter');
        $order_ids = csa_order_ids_for_products($product_ids, $date_range);

        if ($order_ids === null) {
            $orders = wc_get_orders([
                'status' => ['processing', 'on-hold'],
                'limit' => -1,
                'type' => 'shop_order',
                'return' => 'objects',
                'orderby' => 'date',
                'order' => 'DESC',
                'date_created' => $date_range,
            ]);

            return is_array($orders) ? $orders : [];
        }

        $allowed_statuses = ['processing', 'on-hold'];
        $orders = [];
        foreach ($order_ids as $order_id) {
            $order = wc_get_order($order_id);
            if (!$order || !is_object($order) || !method_exists($order, 'get_status')) {
                continue;
            }
            if (!in_array($order->get_status(), $allowed_statuses, true)) {
                continue;
            }
            $orders[] = $order;
        }

        return $orders;
    }
}

if (!function_exists('csa_order_ids_for_products')) {
    function csa_order_ids_for_products(array $product_ids, $date_range = null)
    {
        global $wpdb;

        $placeholders = implode(',', array_fill(0, count($product_ids), '%d'));
        $lookup_table = $wpdb->prefix . 'wc_order_product_lookup';
        $params = $product_ids;
        $sql = "SELECT DISTINCT order_id FROM {$lookup_table} WHERE product_id IN ({$placeholders})";

        if ($date_range && strpos($date_range, '...') !== false) {
            list($start, $end) = explode('...', $date_range, 2);
            $sql .= ' AND date_created >= %s AND date_created <= %s';
            $params[] = $start . ' 00:00:00';
            $params[] = $end . ' 23:59:59';
        }

        $wpdb->last_error = '';
        $order_ids = $wpdb->get_col($wpdb->prepare($sql, $params));

        if ($wpdb->last_error) {
            return null;
        }

        return array_map('intval', (array) $order_ids);
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
                if ((int) $item->get_product_id() !== $winter_id) {
                    continue;
                }

                $location = csa_normalize_location($item->get_meta('location'));
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
