<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Util;

/**
 * Utils for swiftmailer embed image plugin.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
abstract class EmbedImageUtil
{
    /**
     * Get the local path of file.
     *
     * @param string $path        The path
     * @param string $webDir      The absolute web directory
     * @param string $hostPattern The pattern of allowed host
     *
     * @return string
     */
    public static function getLocalPath($path, $webDir, $hostPattern = '/(.*)+/')
    {
        if (false !== strpos($path, '://')) {
            $url = parse_url($path);

            if (isset($url['host'], $url['path'])
                    && preg_match($hostPattern, $url['host'], $matches)) {
                $path = static::getExistingPath($url['path'], $webDir, $path);
            }
        } else {
            $path = static::getExistingPath($path, $webDir);
        }

        return $path;
    }

    /**
     * Get the the absolute path if file exists.
     *
     * @param string      $path         The path
     * @param string      $webDir       The absolute web directory
     * @param null|string $fallbackPath The fallback if path is not in locale file system
     *
     * @return string
     */
    protected static function getExistingPath($path, $webDir, $fallbackPath = null)
    {
        return file_exists($webDir.'/'.$path)
            ? realpath($webDir.'/'.$path)
            : (null !== $fallbackPath ? $fallbackPath : $path);
    }
}
