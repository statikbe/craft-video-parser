<?php

namespace statikbe\videoparser;

use Codeception\Test\Unit;
use statikbe\videoparser\models\Video;
use UnitTester;

class VideoUrlUnitTest extends Unit
{


    /**
     * @var UnitTester
     */
    protected $tester;

    public function _before()
    {
    }

    public function testInvalideUrls()
    {
        $model = new Video('https://www.statik.be');
        $this->assertEquals(null, $model->embedSrc);
    }

    public function testYoutubeUrls()
    {
        $url = 'https://www.youtube.com/watch?v=RD92FhbB7d4';
        $id = 'RD92FhbB7d4';
        $model = new Video($url);
        $this->assertEquals($id, $model->id);

        $url = 'https://youtu.be/RD92FhbB7d4';
        $id = 'RD92FhbB7d4';
        $model = new Video($url);
        $this->assertEquals($id, $model->id);


        $url = "https://www.youtube.com/shorts/5uQdrV-4nGI";
        $id = '5uQdrV-4nGI';
        $model = new Video($url);
        $this->assertEquals($id, $model->id);
    }

    public function testYoutubePlaylistUrl()
    {
        $url = 'https://youtube.com/playlist?list=PLqoopX-6cUn22pDS5x6qX5Pa7SFSdmQ28';
        $id = 'PLqoopX-6cUn22pDS5x6qX5Pa7SFSdmQ28';
        $model = new Video($url);
        $this->assertEquals($id, $model->id);
    }

    public function testYoutubeNoCookies()
    {
        $url = "https://www.youtube-nocookie.com/watch?v=RD92FhbB7d4";
        $id = 'RD92FhbB7d4';
        $model = new Video($url);
        $this->assertEquals($id, $model->id);
        $this->assertStringContainsString("youtube-nocookie", $model->embedSrc);
    }

    public function testVimeoUrls()
    {
        $url = 'https://vimeo.com/365607256';
        $id = '365607256';
        $model = new Video($url);
        $this->assertEquals($id, $model->id);
    }

}
