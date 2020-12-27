<?php
/**
 * TikGet - TikTok video downloader php class
 *
 * @package TikGet
 * @version 1.0.0
 * @author  Abdel Youni <abdelyouni@gmail.com>
 * @see     https://github.com/abdelyouni/TikGet
 */

require 'tikget.class.php';
$directUrl = urldecode($_GET['u']);
$title = urldecode($_GET['t']);
$format = $_GET['f'];
$tikGet  = new TikGet();
$tikGet->forceDownload($directUrl,$title,$format);
