<?php

/**
 * Bright Cloud Studio's Find Your Rep
 *
 * Copyright (C) 2024 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/madrid-find-your-rep
 * @link       https://www.brightcloudstudio.com/
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

namespace Bcs\MadridFindRepBundle\Backend;

use Contao\Backend;
use Contao\DataContainer;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;

class Reps extends Backend
{
    /**
     * Returns available item templates for the rep module.
     */
    public function getItemTemplates(): array
    {
        return $this->getTemplateGroup('item_rep');
    }

    /**
     * Toggles the published state of a rep record.
     * Called via button_callback in the DCA.
     */
    public function toggleIcon(array $row, ?string $href, string $label, string $title, string $icon, string $attributes): string
    {
        if (Input::get('tid') !== null && Input::get('tid') !== '') {
            $this->toggleVisibility((int) Input::get('tid'), Input::get('state') == 1);
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

        if (!$row['published']) {
            $icon = 'invisible.svg';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label) . '</a> ';
    }

    /**
     * Toggles visibility in the database.
     */
    public function toggleVisibility(int $intId, bool $blnVisible, DataContainer $dc = null): void
    {
        // Trigger any save_callbacks registered on the published field
        if (isset($GLOBALS['TL_DCA']['tl_rep']['fields']['published']['save_callback'])
            && \is_array($GLOBALS['TL_DCA']['tl_rep']['fields']['published']['save_callback'])
        ) {
            foreach ($GLOBALS['TL_DCA']['tl_rep']['fields']['published']['save_callback'] as $callback) {
                if (\is_array($callback)) {
                    $obj = System::importStatic($callback[0]);
                    $blnVisible = $obj->{$callback[1]}($blnVisible, $dc ?? $this);
                } elseif (\is_callable($callback)) {
                    $blnVisible = $callback($blnVisible, $dc ?? $this);
                }
            }
        }

        // Update the database via Doctrine (Contao 5 way)
        $db = System::getContainer()->get('database_connection');
        $db->update('tl_rep', ['tstamp' => time(), 'published' => ($blnVisible ? '1' : '')], ['id' => $intId]);
    }

    /**
     * Returns the list of US states and territories for the DCA options callback.
     */
    public function getStates(): array
    {
        return [
            'United States' => [
                'alabama'        => 'Alabama',
                'alaska'         => 'Alaska',
                'arizona'        => 'Arizona',
                'arkansas'       => 'Arkansas',
                'california'     => 'California',
                'colorado'       => 'Colorado',
                'connecticut'    => 'Connecticut',
                'delaware'       => 'Delaware',
                'florida'        => 'Florida',
                'georgia'        => 'Georgia',
                'hawaii'         => 'Hawaii',
                'idaho'          => 'Idaho',
                'illinois'       => 'Illinois',
                'indiana'        => 'Indiana',
                'iowa'           => 'Iowa',
                'kansas'         => 'Kansas',
                'kentucky'       => 'Kentucky',
                'louisiana'      => 'Louisiana',
                'maine'          => 'Maine',
                'maryland'       => 'Maryland',
                'massachusetts'  => 'Massachusetts',
                'michigan'       => 'Michigan',
                'minnesota'      => 'Minnesota',
                'mississippi'    => 'Mississippi',
                'missouri'       => 'Missouri',
                'montana'        => 'Montana',
                'nebraska'       => 'Nebraska',
                'nevada'         => 'Nevada',
                'new_hampshire'  => 'New Hampshire',
                'new_jersey'     => 'New Jersey',
                'new_mexico'     => 'New Mexico',
                'new_york'       => 'New York',
                'north_carolina' => 'North Carolina',
                'north_dakota'   => 'North Dakota',
                'ohio'           => 'Ohio',
                'oklahoma'       => 'Oklahoma',
                'oregon'         => 'Oregon',
                'pennsylvania'   => 'Pennsylvania',
                'rhode_island'   => 'Rhode Island',
                'south_carolina' => 'South Carolina',
                'south_dakota'   => 'South Dakota',
                'tennessee'      => 'Tennessee',
                'texas'          => 'Texas',
                'utah'           => 'Utah',
                'vermont'        => 'Vermont',
                'virginia'       => 'Virginia',
                'washington'     => 'Washington',
                'west_virginia'  => 'West Virginia',
                'wisconsin'      => 'Wisconsin',
                'wyoming'        => 'Wyoming',
                'washington_dc'  => 'Washington, D.C.',
                'puerto_rico'    => 'Puerto Rico',
            ],
        ];
    }
}
