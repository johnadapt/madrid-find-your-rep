<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    madrid-find-your-rep
 * @license    LGPL-3.0+
 * @see        https://github.com/johnadapt/madrid-find-your-rep
 */

namespace Bcs\MadridFindRepBundle;

use Bcs\MadridFindRepBundle\DependencyInjection\BcsMadridFindRepExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BcsMadridFindRepBundle extends Bundle
{
    /**
     * Tell Symfony where the bundle root is.
     * Resources/ lives inside src/, so getPath() returns __DIR__ (= src/).
     */
    public function getPath(): string
    {
        return __DIR__;
    }

    /**
     * Return our custom Extension so Symfony loads services.yaml automatically.
     */
    public function getContainerExtension(): ExtensionInterface
    {
        return new BcsMadridFindRepExtension();
    }
}
