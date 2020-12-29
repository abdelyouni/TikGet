# TikGet - TikTok video downloader php class
You can use this php class to download any tiktok video or music & get all relative video meta infos.

## Supported links :
- www.tiktok.com/username/video/.....
- m.tiktok.com/v/.....
- vm.tiktok.com/.....

## Example
###### Basic usage :
```php
require 'tikget.class.php';

$video = new TikGet('https://www.tiktok.com/...');

$datas = $video->get();

print_r($videoDatas);
```
#### Force Download

###### Force Download Video :
the generated download link will be found in :  
 
 `$datas->video->download_url`
###### Force Download Music :
the generated download link will be found in :  

`$datas->music->download_url`

## Properties
#### Video Infos
| Name  | Property   |
| ------------ | ------------ |
| Video ID  | $datas->video->id  |
| Video Title  | $datas->video->title  |
|  Video Keywords | $datas->video->keywords  |
| Video Description  | $datas->video->Description  |
|  Video Height | $datas->video->height  |
| Video Duration (in secondes)  | $datas->video->duration  |
|  Video Resolution | $datas->video->sizeFormat  |
| Video Cover  | $datas->video->cover  |
|  Video Animated Cover | $datas->video->animatedCover  |
| Video Likes Count  | $datas->video->likes  |
|  Video Shares Count | $datas->video->shares  |
| Video Comments Count  | $datas->video->comments  |
|  Video Views Count | $datas->video->views  |
|  Video Original Url | $datas->video->original_url  |
|  Video Download Url | $datas->video->download_url  |

#### Music Infos
| Name  | Parametre  |
| ------------ | ------------ |
| Music ID  | $datas->music->id  |
| music Title  | $datas->music->title  |
|  Large size Cover | $datas->music->cover_large  |
| Medium size Cover  | $datas->music->cover_medium  |
|  Small size Cover | $datas->music->cover_small  |
| Singer (Artist)  | $datas->music->artist  |
|  Album name | $datas->music->album  |
| Duration  | $datas->music->duration  |
|  Stream URL | $datas->music->url  |
| Download URL | $datas->music->download_url  |

#### Author Infos
| Name  | Parametre  |
| ------------ | ------------ |
| Author ID  | $datas->author->id  |
| Unique ID  | $datas->author->uniqueId  |
| Username  | $datas->author->username  |
| Large size Avatar  | $datas->author->avatar_large  |
| Medium size Avatar  | $datas->author->avatar_medium  |
| Small size Avatar  | $datas->author->avatar_small  |
| Signature  | $datas->author->signature  |
| SignUp date  | $datas->author->createDate  |
| Is the profile verified ?  | $datas->author->isVerified  |
| Followers Count  | $datas->author->followers|
| Followings Count  | $datas->author->followings  |
| Likes recieved Count  | $datas->author->hearts  |
| Likes given Count  | $datas->author->diggCount  |
| Total Videos  | $datas->author->totalVideos  |

## License
(The MIT License)

Copyright (c) 2020 Abdel Youni

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the 'Software'), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
