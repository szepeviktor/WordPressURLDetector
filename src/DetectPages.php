<?php

declare(strict_types=1);

namespace WordPressURLDetector;

class DetectPages
{

    /**
     * Detect Page URLs
     *
     * @return array<string> list of URLs
     */
    public static function detect(): array
    {
        global $wpdb;

        $page_urls = [];

        $page_ids = $wpdb->get_col(
            "SELECT ID
            FROM {$wpdb->posts}
            WHERE post_status = 'publish'
            AND post_type = 'page'"
        );

        foreach ($page_ids as $page_id) {
            $permalink = get_page_link($page_id);

            if (strpos($permalink, '?post_type') !== false) {
                continue;
            }

            $page_urls[] = $permalink;
        }

        return $page_urls;
    }
}
