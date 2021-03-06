<?php

/**
 * DetectArchives.php
 *
 * @package           WordPressURLDetector
 * @author            Leon Stafford <me@ljs.dev>
 * @license           The Unlicense
 * @link              https://unlicense.org
 */

declare(strict_types=1);

namespace WordPressURLDetector;

/**
 * Class DetectArchives
 *
 * @package WordPressURLDetector
 */
class DetectArchives
{

    /**
     * Detect Archive URLs
     *
     * Get list of archive URLs
     * ie
     *      https://foo.com/2020/04/
     *      https://foo.com/2020/05/
     *      https://foo.com/2020/
     *
     * @return array<string> list of archive URLs
     */
    public static function detect(): array
    {
        global $wpdb;

        // wp_get_archives() with echo=0 will return string
        $archiveURLsHTML = wp_get_archives(
            [
                'type' => 'yearly',
                'echo' => 0,
            ]
        ) . wp_get_archives(
            [
                'type' => 'monthly',
                'echo' => 0,
            ]
        ) . wp_get_archives(
            [
                'type' => 'daily',
                'echo' => 0,
            ]
        );

        $matchURLRegex = '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#';
        preg_match_all($matchURLRegex, $archiveURLsHTML, $matches);

        return $matches[0];
    }
}
