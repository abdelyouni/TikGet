<?php

/**
 * TikGet - TikTok video downloader mini library
 *
 * @package TikGet
 * @version 1.0.0
 * @author  Abdel Youni <abdelyouni@gmail.com>
 * @see     https://github.com/abdelyouni/TikGet
 */

require 'tiktok.class.php';

$video = new TikGet('https://www.tiktok.com/@billieeilish/video/6894081763379924229');
echo(json_encode($video->get()));
