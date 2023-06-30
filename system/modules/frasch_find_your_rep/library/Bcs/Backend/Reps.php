<?php

/**
 * Bright Cloud Studio's Find Your Rep
 *
 * Copyright (C) 2023 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/frasch-find-your-rep
 * @link       https://www.brightcloudstudio.com/
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

 
namespace Bcs\Backend;

use Contao\DataContainer;
use Bcs\Model\Rep;

class Reps extends \Backend
{

	public function getItemTemplates()
	{
      return $this->getTemplateGroup('item_rep');
	}

	
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(\Input::get('tid')))
		{
			$this->toggleVisibility(\Input::get('tid'), (\Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.\Image::getHtml($icon, $label).'</a> ';
	}	
	

	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_rep']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_rep']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_rep SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$this->log('A new version of record "tl_rep.id='.$intId.'" has been created'.$this->getParentEntries('tl_location', $intId), __METHOD__, TL_GENERAL);
	}

	function getStates()
    	{		
        	return array(
			'United States' => array(
				'alabama' => 'Alabama',
				'alaska' => 'Alaska',
				'arizona' => 'Arizona',
				'arkansas' => 'Arkansas',
				'california' => 'California',
				'colorado' => 'Colorado',
				'connecticut' => 'Connecticut',
				'delaware' => 'Delaware',
				'florida' => 'Florida',
				'georgia' => 'Georgia',
				'hawaii' => 'Hawaii',
				'idaho' => 'Idaho',
				'illinois' => 'Illinois',
				'indiana' => 'Indiana',
				'iowa' => 'Iowa',
				'kansas' => 'Kansas',
				'kentucky' => 'Kentucky',
				'louisiana' => 'Louisiana',
				'maine' => 'Maine',
				'maryland' => 'Maryland',
				'massachusetts' => 'Massachusetts',
				'michigan' => 'Michigan',
				'minnesota' => 'Minnesota',
				'mississippi' => 'Mississippi',
				'missouri' => 'Missouri',
				'montana' => 'Montana',
				'nebraska' => 'Nebraska',
				'nevada' => 'Nevada',
				'new_hampshire' => 'New Hampshire',
				'new_jersey' => 'New Jersey',
				'new_mexico' => 'New Mexico',
				'new_york' => 'New York',
				'north_carolina' => 'North Carolina',
				'north_dakota' => 'North Dakota',
				'ohio' => 'Ohio',
				'oklahoma' => 'Oklahoma',
				'oregon' => 'Oregon',
				'pennsylvania' => 'Pennsylvania',
				'rhode_island' => 'Rhode Island',
				'south_carolina' => 'South Carolina',
				'south_dakota' => 'South Dakota',
				'tennessee' => 'Tennessee',
				'texas' => 'Texas',
				'utah' => 'Utah',
				'vermont' => 'Vermont',
				'virginia' => 'Virginia',
				'washington' => 'Washington',
				'west_virginia' => 'West Virginia',
				'wisconsin' => 'Wisconsin',
				'wyoming' => 'Wyoming',
				'puerto_rico' => 'Puerto Rico'),
			'Canada' => array(
				'alberta' => 'Alberta',
				'british_columbia' => 'British Columbia',
                'manitoba' => 'Manitoba',
				'new_brunswick' => 'New Brunswick',
                'newfoundland' => 'Newfoundland',
				'nova_scotia' => 'Nova Scotia',
                'ontario' => 'Ontario',
				'quebec' => 'Quebec',
				'saskatchewan' => 'Saskatchewan'),
		);
	}
}
