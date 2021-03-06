<?php

declare(strict_types=1);

namespace WordPressURLDetector;

class DetectPosts
{

    /**
     * Detect Post URLs
     *
     * @return array<string> list of URLs
     */
    public static function detect(): array
    {
        global $wpdb;

        $post_urls = [];

        $post_ids = $wpdb->get_col(
            "SELECT ID
            FROM {$wpdb->posts}
            WHERE post_status = 'publish'
            AND post_type = 'post'"
        );

        foreach ($post_ids as $post_id) {
            $permalink = get_permalink($post_id);

            if (! $permalink) {
                continue;
            }

            if (strpos($permalink, '?post_type') !== false) {
                continue;
            }

            $post_urls[] = $permalink;
        }

        return $post_urls;
    }
}
