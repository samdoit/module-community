<?php
/**
 * Copyright © Samdoit (support@samdoit.com). All rights reserved.
 * Please visit Samdoit.com for license details (http://www.samdoit.com/end-user-license-agreement).
 */

namespace Samdoit\Community\Model;

/*
 * Class with static methods to check URL
 */
class UrlChecker
{
    /**
     * @return bool
     */
    final public static function showUrl($url)
    {
        $url = (string)$url;
        $info = parse_url($url);
        $part = '';
        if (isset($info['host'])) {
            $part = explode('.', $info['host']);
            $part = $part[0];
        }

        if (!$part) {
            $part = 0;
        }

        return (false === strpos($url, 'mag' . 'ento'))
            && !is_numeric($part);
    }
}
