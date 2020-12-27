<?php

/**
 * TikGet - TikTok video downloader mini library
 *
 * @package TikGet
 * @version 1.0.0
 * @author  Abdel Youni <abdelyouni@gmail.com>
 * @see     https://github.com/abdelyouni/TikGet
 */

class TikGet
{
    public $url;
    private $FORCE_DOWNLOAD_FILE = 'getFile.php'; 
    private $userAgent = 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Mobile Safari/537.36';
    private $patterns = ['<link data-react-helmet="true" rel="canonical" href="','"/>','>','</','id="__NEXT_DATA__"'];

    public function __construct($url = null)
    {
        $this->url = $url;
    }

    private function curlTikTok($tiktokUrl){
        $tiktokUrl = trim($tiktokUrl);   
        $ch = curl_init();
        $options = array(
            CURLOPT_URL            => $tiktokUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => $this->userAgent,
            CURLOPT_ENCODING       => "utf-8",
            CURLOPT_AUTOREFERER    => false,
            CURLOPT_COOKIEJAR      => 'cookie.txt',
            CURLOPT_COOKIEFILE     => 'cookie.txt',
            CURLOPT_REFERER        => 'https://www.tiktok.com/',
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_MAXREDIRS      => 10,
        );
        curl_setopt_array( $ch, $options );
        if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }
        $resp = curl_exec($ch);
        curl_close($ch);
        return $resp;
    }

    public function get(){
        if ($this->url == null || strpos($this->url, 'tiktok.com/') === false) {
            return false;
        }

        $protocole = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != '' && $_SERVER['SERVER_PORT']  == 443 )?'https://':'http://';
        
        $tiktokUrl = trim($this->url);
        
        $resp = $this->curlTikTok($tiktokUrl);
        
        if(strpos($resp, $this->patterns[0]) !== false){
            $tiktokUrl = explode($this->patterns[1],explode($this->patterns[0],$resp)[1])[0];
            $resp = $this->curlTikTok($tiktokUrl);
        }
    
        $json = explode($this->patterns[2],explode($this->patterns[3],explode($this->patterns[4],$resp)[1])[0])[1];
        $json = json_decode($json);
        if($json == null){
            return false;
        }
        $video = new stdClass();
        $video->id = $json->props->pageProps->itemInfo->itemStruct->video->id;
        $video->height = $json->props->pageProps->itemInfo->itemStruct->video->height;
        $video->duration = $json->props->pageProps->itemInfo->itemStruct->video->duration;
        $video->sizeFormat = $json->props->pageProps->itemInfo->itemStruct->video->ratio;
        $video->cover = $json->props->pageProps->itemInfo->itemStruct->video->cover;
        $video->animatedCover = $json->props->pageProps->itemInfo->itemStruct->video->dynamicCover;
        $video->likes = $json->props->pageProps->itemInfo->itemStruct->stats->diggCount;
        $video->shares = $json->props->pageProps->itemInfo->itemStruct->stats->shareCount;
        $video->comments = $json->props->pageProps->itemInfo->itemStruct->stats->commentCount;
        $video->vues = $json->props->pageProps->itemInfo->itemStruct->stats->playCount;
        $video->title = $json->props->pageProps->metaParams->title;
        $video->keywords = $json->props->pageProps->metaParams->keywords;
        $video->description = $json->props->pageProps->metaParams->description;
        $video->original_url = $json->props->pageProps->metaParams->canonicalHref;
        $video->download_url = $protocole.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])
                            .'/'.$this->FORCE_DOWNLOAD_FILE
                            .'?u='. urlencode($json->props->pageProps->itemInfo->itemStruct->video->downloadAddr)
                            .'&t='.$video->id.'&f=v';
    
        $music = new stdClass();
        $music->id = $json->props->pageProps->itemInfo->itemStruct->music->id;
        $music->title = $json->props->pageProps->itemInfo->itemStruct->music->title;
        $music->cover_large = $json->props->pageProps->itemInfo->itemStruct->music->coverLarge;
        $music->cover_medium = $json->props->pageProps->itemInfo->itemStruct->music->coverMedium;
        $music->cover_small = $json->props->pageProps->itemInfo->itemStruct->music->coverThumb;
        $music->artist = $json->props->pageProps->itemInfo->itemStruct->music->authorName;
        $music->album = $json->props->pageProps->itemInfo->itemStruct->music->album;
        $music->duration = $json->props->pageProps->itemInfo->itemStruct->music->duration;
        $music->url = $json->props->pageProps->itemInfo->itemStruct->music->playUrl;
        $music->download_url = $protocole.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])
                            .'/'.$this->FORCE_DOWNLOAD_FILE
                            .'?u='. urlencode($music->url)
                            .'&t='.$music->id.'&f=a';
    
        $author = new stdClass();
        $author->id = $json->props->pageProps->itemInfo->itemStruct->author->id;
        $author->uniqueId = $json->props->pageProps->itemInfo->itemStruct->author->uniqueId;
        $author->username = $json->props->pageProps->itemInfo->itemStruct->author->nickname;
        $author->avatar_large = $json->props->pageProps->itemInfo->itemStruct->author->avatarLarger;
        $author->avatar_medium = $json->props->pageProps->itemInfo->itemStruct->author->avatarMedium;
        $author->avatar_small = $json->props->pageProps->itemInfo->itemStruct->author->avatarThumb;
        $author->signature = $json->props->pageProps->itemInfo->itemStruct->author->signature;
        $author->createDate = $json->props->pageProps->itemInfo->itemStruct->author->createTime;
        $author->isVerified = $json->props->pageProps->itemInfo->itemStruct->author->verified;
        $author->followers = $json->props->pageProps->itemInfo->itemStruct->authorStats->followerCount;
        $author->followings = $json->props->pageProps->itemInfo->itemStruct->authorStats->followingCount;
        $author->hearts = $json->props->pageProps->itemInfo->itemStruct->authorStats->heart;
        $author->totalVideos = $json->props->pageProps->itemInfo->itemStruct->authorStats->videoCount;
        $author->diggCount = $json->props->pageProps->itemInfo->itemStruct->authorStats->diggCount;
    
    
        $datas = new stdClass();
        $datas->video = $video;
        $datas->music = $music;
        $datas->author = $author;
    
        return $datas;
    }

    public function forceDownload($directUrl,$title,$format){
        if($format != "a" && $format != "v")
        {
            die('File Format Error !');
        }
        $format = ($format == 'v')?'.mp4':'.mp3';
        $ch = curl_init();
        $headers = array(
            'Range: bytes=0-',
        );
        $options = array(
            CURLOPT_URL            => $directUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_FOLLOWLOCATION => true,
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_USERAGENT      => 'okhttp',
            CURLOPT_ENCODING       => "utf-8",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_COOKIEJAR      => 'cookie.txt',
            CURLOPT_COOKIEFILE     => 'cookie.txt',
            CURLOPT_REFERER        => 'https://www.tiktok.com/',
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_MAXREDIRS      => 10,
        );
        curl_setopt_array( $ch, $options );
    
        if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }
        
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        header('Cache-Control: private', false);
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename="' . basename($title) . $format);
        header('Content-Transfer-Encoding: binary');
        
        $video = curl_exec($ch);    
        curl_close($ch);

        echo $video;
    }

}
