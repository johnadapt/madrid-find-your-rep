<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    madrid-find-your-rep
 * @license    LGPL-3.0+
 * @see        https://github.com/johnadapt/madrid-find-your-rep
 */

namespace Bcs\MadridFindRepBundle\Controller\FrontendModule;

use Bcs\MadridFindRepBundle\Model\RepModel;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(
    type: 'mod_find_your_rep',
    category: 'madrid_find_your_rep',
    template: 'mod_find_your_rep'
)]
class FindYourRepController extends AbstractFrontendModuleController
{
    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        $reps = RepModel::findBy('published', '1');

        $template->empty = '';

        if (null === $reps) {
            $template->empty = 'No Locations Found';
            $template->reps = [];

            return $template->getResponse();
        }

        $arrReps = [];

        foreach ($reps as $rep) {
            $arrReps[] = [
                'rep_name'        => $rep->rep_name,
                'company_name'    => $rep->company_name,
                'region'          => $rep->region,
                'address'         => $rep->address,
                'city'            => $rep->city,
                'address_state'   => $rep->address_state,
                'zip'             => $rep->zip,
                'phone_number'    => $rep->phone_number,
                'alt_phone_number'=> $rep->alt_phone_number,
                'email'           => $rep->email,
                'website'         => $rep->website,
                'product_line'    => StringUtil::deserialize($rep->product_line, true),
                'state'           => StringUtil::deserialize($rep->state, true),
            ];
        }

        $template->reps = $arrReps;

        return $template->getResponse();
    }

    /**
     * Returns the US states array for use in templates or other contexts.
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

    /**
     * Generates a <select> option string for US states.
     */
    public function generateSelectOptions(bool $blank = true): string
    {
        $states = $this->getStates();
        $html = $blank ? '<option value="">Select Location...</option>' : '';
        $html .= '<optgroup label="United States">';

        foreach ($states['United States'] as $abbr => $name) {
            $html .= sprintf('<option value="%s">%s</option>', htmlspecialchars($abbr), htmlspecialchars($name));
        }

        $html .= '</optgroup>';

        return $html;
    }
}
