<?php
declare(strict_types=1);

namespace Eightfold\Printify\Implementations;

use StdClass;

trait DecodesJson
{
    private static StdClass $decodedJson;

    private function decodedJson(): StdClass|false
    {
        if (isset(self::$decodedJson) === false) {
            $response = $this->printifyResponse();

            $json = $response->getBody()->getContents();

            $decodedJson = json_decode($json);
            if ($decodedJson === false) {
                return false;
            }
            self::$decodedJson = $decodedJson;
        }
        return self::$decodedJson;
    }
}
