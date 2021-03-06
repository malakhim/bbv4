<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

$schema['controllers']['news'] = array (
    'modes' => array (
        'delete' => array (
            'permissions' => 'manage_news'
        )
    ),
    'permissions' => array ('GET' => 'view_news', 'POST' => 'manage_news')
);
$schema['addons']['news_and_emails']['permission'] = true;
$schema['import']['sections']['subscribers']['permission'] = false;
$schema['export']['sections']['subscribers']['permission'] = false;

return $schema;
