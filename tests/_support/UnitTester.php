<?php

use Codeception\Actor;
use Codeception\Lib\Friend;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 *
 */
class UnitTester extends Actor
{
    use _generated\UnitTesterActions;

    public function parseRegex($expressions, $string, $pos = 2)
    {
        $translator = new \statikbe\translate\services\Translate();
        foreach ($expressions as $regex) {
            $matches = $translator->parseString($regex, $string);
            if (!$matches) {
                return false;
            }
            if (array_filter($matches)) {
                foreach ($matches[$pos] as $original) {
                    $str = $original;
                }
                return $str;
            }
        }
        return false;
    }
}
