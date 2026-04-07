<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    madrid-find-your-rep
 * @license    LGPL-3.0+
 * @see        https://github.com/johnadapt/madrid-find-your-rep
 */

namespace Bcs\MadridFindRepBundle\Backend;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;

class Reps
{
    public function __construct(private readonly Connection $db)
    {
    }

    /**
     * Returns the list of US states (and territories) for the DCA options callback.
     */
    #[AsCallback(table: 'tl_rep', target: 'fields.state.options')]
    public function getStates(): array
    {
        return [
            'United States' => [
                'alabama'       => 'Alabama',
                'alaska'        => 'Alaska',
                'arizona'       => 'Arizona',
                'arkansas'      => 'Arkansas',
                'california'    => 'California',
                'colorado'      => 'Colorado',
                'connecticut'   => 'Connecticut',
                'delaware'      => 'Delaware',
                'florida'       => 'Florida',
                'georgia'       => 'Georgia',
                'hawaii'        => 'Hawaii',
                'idaho'         => 'Idaho',
                'illinois'      => 'Illinois',
                'indiana'       => 'Indiana',
                'iowa'          => 'Iowa',
                'kansas'        => 'Kansas',
                'kentucky'      => 'Kentucky',
                'louisiana'     => 'Louisiana',
                'maine'         => 'Maine',
                'maryland'      => 'Maryland',
                'massachusetts' => 'Massachusetts',
                'michigan'      => 'Michigan',
                'minnesota'     => 'Minnesota',
                'mississippi'   => 'Mississippi',
                'missouri'      => 'Missouri',
                'montana'       => 'Montana',
                'nebraska'      => 'Nebraska',
                'nevada'        => 'Nevada',
                'new_hampshire' => 'New Hampshire',
                'new_jersey'    => 'New Jersey',
                'new_mexico'    => 'New Mexico',
                'new_york'      => 'New York',
                'north_carolina'=> 'North Carolina',
                'north_dakota'  => 'North Dakota',
                'ohio'          => 'Ohio',
                'oklahoma'      => 'Oklahoma',
                'oregon'        => 'Oregon',
                'pennsylvania'  => 'Pennsylvania',
                'rhode_island'  => 'Rhode Island',
                'south_carolina'=> 'South Carolina',
                'south_dakota'  => 'South Dakota',
                'tennessee'     => 'Tennessee',
                'texas'         => 'Texas',
                'utah'          => 'Utah',
                'vermont'       => 'Vermont',
                'virginia'      => 'Virginia',
                'washington'    => 'Washington',
                'west_virginia' => 'West Virginia',
                'wisconsin'     => 'Wisconsin',
                'wyoming'       => 'Wyoming',
                'washington_dc' => 'Washington, D.C.',
                'puerto_rico'   => 'Puerto Rico',
            ],
        ];
    }
}
