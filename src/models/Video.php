<?php

namespace statikbe\videoparser\models;

use craft\base\Model;

class Video extends Model
{
    const TYPE_YOUTUBE = 'youtube';
    const TYPE_YOUTUBE_PLAYLIST = 'youtube_playlist';
    const TYPE_VIMEO = 'vimeo';
    const BASE_YOUTUBE = "https://www.youtube.com/embed/";
    const BASE_YOUTUBE_PLAYLIST = "https://www.youtube.com/embed/videoseries?list=";
    const BASE_YOUTUBE_NOCOOKIES = "https://www.youtube-nocookie.com/embed/";
    const BASE_VIMEO = "https://player.vimeo.com/video/";


    public $type;
    public $id;
    public $embedSrc;
    public $extraParts = '';
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
                function str_contains($haystack, $needle)
                {
                    return $needle !== '' && mb_strpos($haystack, $needle) !== false;
                }
            }
            if (str_contains($url, 'nocookie')) {
                $this->noCookies = true;
            }

            if (str_contains($url, 'playlist')) {
                $this->type = self::TYPE_YOUTUBE_PLAYLIST;
                preg_match("/[&?]list=([^&]+)/i", $url, $match);
                $this->id = $match[1];
                $this->getEmbedSrc();

            } else {
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)|shorts/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                $this->id = $match[1];
                $this->getEmbedSrc();
            }
        } elseif (strpos($url, 'vimeo')) {
            $this->type = Video::TYPE_VIMEO;
            preg_match('/https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w:]*?(?:\/videos)?)\/([\d]+(?:\/[\w\d]+))[^\s]*/i', $url, $match);
            $this->id = $match[1];

            if (str_contains($this->id, '/')) {
                $parts = explode('/', $this->id);
                $this->id = array_shift($parts);
                $this->extraParts = 'h=' . array_shift($parts);
            }

            $this->getEmbedSrc();
        }
    }

    private function getEmbedSrc()
    {
        if ($this->type === self::TYPE_YOUTUBE || $this->type === self::TYPE_YOUTUBE_PLAYLIST) {
            if ($this->noCookies) {
                $this->embedSrc = self::BASE_YOUTUBE_NOCOOKIES . $this->id;
            } elseif ($this->type === self::TYPE_YOUTUBE_PLAYLIST) {
                $this->embedSrc = self::BASE_YOUTUBE_PLAYLIST . $this->id;
            } else {
                $this->embedSrc = self::BASE_YOUTUBE . $this->id;
            }
        }
        if ($this->type === self::TYPE_VIMEO) {
            $this->embedSrc = self::BASE_VIMEO . $this->id;
        }
    }
}
