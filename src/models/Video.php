<?php

namespace statikbe\videoparser\models;

use craft\base\Model;

class Video extends Model
{
    const TYPE_YOUTUBE = 'youtube';
    const TYPE_NOT_FOUND = 'not-found';
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

    private function parse($url): void
    {
        try {
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
                } else {
                    preg_match('/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(?:-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|shorts\/|live\/|v\/)?)([\w\-]+)(\S+)?$/', $url, $match);
                    $this->id = $match[5];
                }

                if (str_contains($url, '&')) {
                    $parts = explode('&', $url);
                    array_shift($parts);
                    $parts = preg_replace('/^t=(.*)s$/', "start=$1", $parts);
                    $this->extraParts = implode("&", $parts);
                }

                $this->getEmbedSrc();
            } elseif (strpos($url, 'vimeo')) {
                $this->type = Video::TYPE_VIMEO;
                preg_match('/https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w:]*?(?:\/videos)?)\/([\d]+(?:\/[\w\d]+)?)[^\s]*/i', $url, $match);
                $this->id = $match[1];

                if (str_contains($this->id, '/')) {
                    $parts = explode('/', $this->id);
                    $this->id = array_shift($parts);
                    $this->extraParts = 'h=' . array_shift($parts);
                }

                $this->getEmbedSrc();
            }
        } catch (\Throwable $th) {
            $this->type = self::TYPE_NOT_FOUND;
            $this->id = '';
            $this->embedSrc = '';
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
