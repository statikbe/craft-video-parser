<?php

namespace statikbe\videoparser;

use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use modules\statik\variables\StatikVariable;
use statikbe\videoparser\variables\VideoParserVariable;
use yii\base\Event;

class VideoParser extends Plugin
{
	 public function init()
    {
        parent::init();
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('videoparser', VideoParserVariable::class);
            }
        );

    }
}
