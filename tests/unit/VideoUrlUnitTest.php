<?php

namespace statikbe\videoparser;

use Codeception\Test\Unit;
use Craft;
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

    public  function testInvalideUrls() {
        $model = new Video('https://www.statik.be');
        $this->assertEquals(null, $model->embedSrc);
    }

    public function testYoutubeUrls()
    {
        $url = 'https://www.youtube.com/watch?v=xl0e1RDg0oY';
        $id = 'xl0e1RDg0oY';
        $model = new Video($url);
        $this->assertEquals($id, $model->id);
    }

}
