<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    madrid-find-your-rep
 * @license    LGPL-3.0+
 * @see        https://github.com/johnadapt/madrid-find-your-rep
 */

namespace Bcs\MadridFindRepBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BcsMadridFindRepBundle extends Bundle
{
    public function getPath(): string
    {
        // Resources/ lives inside src/, which is __DIR__
        return __DIR__;
    }
}
