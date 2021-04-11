<?php

namespace statikbe\videoparser\variables;


use statikbe\videoparser\models\Video;

class VideoParserVariable
{

    /**
     * @param $url
     */
    public function parse($url): ?Video
    {
        $video = new Video($url);
        if(!$video->embedSrc) {
            return null;
        }
        return $video;
    }
}