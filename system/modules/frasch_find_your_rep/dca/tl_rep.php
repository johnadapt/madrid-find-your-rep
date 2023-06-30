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

 
/* Table tl_rep */
$GLOBALS['TL_DCA']['tl_rep'] = array
(
 
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' 	=> 	'primary',
                'rep_name' =>  'index'
            )
        )
    ),
 
    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('rep_name'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('state', 'city', 'rep_name'),
            'format'                  => '%s - %s - %s'
        ),
        'global_operations' => array
        (
            'export' => array
            (
                'label'               => 'Export Reps CSV',
                'href'                => 'key=exportReps',
                'icon'                => 'system/modules/frasch_find_your_rep/assets/icons/file-export-icon-16.png'
            ),
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )

        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_rep']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
			
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_rep']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_rep']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
            (
              'label'               => &$GLOBALS['TL_LANG']['tl_rep']['toggle'],
              'icon'                => 'visible.gif',
              'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
              'button_callback'     => array('Bcs\Backend\Reps', 'toggleIcon')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_rep']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
 
    // Palettes
    'palettes' => array
    (
        'default'                     => '{rep_legend},rep_name,company_name,region,address,city,state,zip,phone_number,alt_phone_number,email,website;{publish_legend},published;'
    ),
 
    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     		=> "int(10) unsigned NOT NULL default '0'"
        ),
    		'sorting' => array
    		(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
    		),
    		'rep_name' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['rep_name'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'company_name' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['company_name'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'region' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['region'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'address' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['address'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'city' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['city'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'state' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['state'],
    			'inputType'               => 'select',
    			'default'				  => '',
    			'options_callback'		  => array('Bcs\Backend\Reps', 'getStates'),
    			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'zip' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['zip'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'phone_number' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['phone_number'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'alt_phone_number' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['alt_phone_number'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'email' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['email'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
        'website' => array
    		(
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['website'],
    			'inputType'               => 'text',
    			'default'                 => '',
    			'search'                  => true,
    			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    			'sql'                     => "varchar(255) NOT NULL default ''"
    		),
    		'published' => array
    		(
    			'exclude'                 => true,
    			'label'                   => &$GLOBALS['TL_LANG']['tl_rep']['published'],
    			'inputType'               => 'checkbox',
    			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
    			'sql'                     => "char(1) NOT NULL default ''"
    		)		
    )
);
