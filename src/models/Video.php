<?php

namespace statikbe\videoparser\models;

use craft\base\Model;

class Video extends Model
{
    const TYPE_YOUTUBE = 'youtube';
    const TYPE_VIMEO = 'vimeo';
    const BASE_YOUTUBE = "https://www.youtube.com/embed/";
    const BASE_YOUTUBE_NOCOOKIES = "https://www.youtube-nocookie.com/embed/";
    const BASE_VIMEO = "https://player.vimeo.com/video/";


    public $type;
    public $id;
    public $embedSrc;
    public $noCookies = false;

    public function __construct($url)
    {
        $this->parse($url);
    }

    private function parse($url)
    {
        if (strpos($url, 'youtu')) {
            $this->type = Video::TYPE_YOUTUBE;
            if (!function_exists('str_contains')) {
                function str_contains($haystack, $needle) {
                    return $needle !== '' && mb_strpos($haystack, $needle) !== false;
                }
            }
            if(str_contains($url, 'nocookie')) {
                $this->noCookies = true;
            }
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)|shorts/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            $this->id = $match[1];
            $this->getEmbedSrc();
        } elseif (strpos($url, 'vimeo')) {
            $this->type = Video::TYPE_VIMEO;
            preg_match('(https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w:]*(?:\/videos)?)?\/([0-9]+)[^\s]*)', $url, $match);
            $this->id = $match[1];
            $this->getEmbedSrc();
        }
    }

    private function getEmbedSrc()
    {
        if ($this->type === self::TYPE_YOUTUBE) {
            if($this->noCookies) {
                $this->embedSrc = self::BASE_YOUTUBE_NOCOOKIES . $this->id;
            } else {
                $this->embedSrc = self::BASE_YOUTUBE . $this->id;
            }
        }
        if ($this->type === self::TYPE_VIMEO) {
            $this->embedSrc = self::BASE_VIMEO . $this->id;
        }
    }

}
