<?php

namespace statikbe\videoparser\models;

use craft\base\Model;

class Video extends Model
{
    const TYPE_YOUTUBE = 'youtube';
    const TYPE_VIMEO = 'vimeo';

    public $type;
    public $id;
    public $embedSrc;

    public function __construct($url)
    {
        $this->parse($url);
    }

    private function parse($url)
    {
        if (strpos($url, 'youtu')) {
            $this->type = Video::TYPE_YOUTUBE;
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
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
            $this->embedSrc = "https://www.youtube.com/embed/{$this->id}";
        }
        if ($this->type === self::TYPE_VIMEO) {
            $this->embedSrc = "https://player.vimeo.com/video/{$this->id}";
        }
    }

}
