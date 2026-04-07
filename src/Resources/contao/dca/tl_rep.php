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

use Bcs\MadridFindRepBundle\Backend\Reps;

$GLOBALS['TL_DCA']['tl_rep'] = [

    // Config
    'config' => [
        'dataContainer'  => \Contao\DC_Table::class,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id'       => 'primary',
                'rep_name' => 'index',
            ],
        ],
    ],

    // List
    'list' => [
        'sorting' => [
            'mode'        => 1,
            'fields'      => ['rep_name'],
            'flag'        => 1,
            'panelLayout' => 'filter;search,limit',
        ],
        'label' => [
            'fields' => ['state', 'city', 'rep_name'],
            'format' => '%s - %s - %s',
        ],
        'global_operations' => [
            'all' => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations' => [
            'edit' => [
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'copy' => [
                'href' => 'act=copy',
                'icon' => 'copy.svg',
            ],
            'delete' => [
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? 'Are you sure?') . '\'))return false;Backend.getScrollOffset()"',
            ],
            'toggle' => [
                'href'                  => null,
                'icon'                  => 'visible.svg',
                'showInHeader'          => false,
                // Contao 5 toggleField — no custom button_callback needed
                'toggleField'           => 'published',
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.svg',
            ],
        ],
    ],

    // Palettes
    'palettes' => [
        'default' => '{rep_legend},rep_name,company_name,region,product_line,address,city,address_state,zip,phone_number,alt_phone_number,email,website;{state_legend},state;{publish_legend},published;',
    ],

    // Fields
    'fields' => [
        'id' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'autoincrement' => true],
        ],
        'tstamp' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],
        'sorting' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],
        'rep_name' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['rep_name'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'company_name' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['company_name'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'region' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['region'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'product_line' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['product_line'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'address' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['address'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'city' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['city'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'address_state' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['address_state'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'state' => [
            'label'            => &$GLOBALS['TL_LANG']['tl_rep']['state'],
            'inputType'        => 'checkbox',
            'options_callback' => [Reps::class, 'getStates'],
            'eval'             => ['multiple' => true, 'chosen' => true, 'tl_class' => 'w50'],
            'sql'              => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'zip' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['zip'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'phone_number' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['phone_number'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'alt_phone_number' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['alt_phone_number'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'email' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['email'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'website' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['website'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'published' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_rep']['published'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'toggle'    => true,
            'eval'      => ['submitOnChange' => true, 'doNotCopy' => true],
            'sql'       => ['type' => 'string', 'fixed' => true, 'length' => 1, 'default' => ''],
        ],
    ],
];
