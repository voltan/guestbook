<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
return array(
    'admin' => array(
        'list' => array(
            'label' => _a('List of texts'),
            'permission' => array(
                'resource' => 'list',
            ),
            'route' => 'admin',
            'controller' => 'list',
            'action' => 'index',
            'pages' => array(
                'attribute' => array(
                    'label' => _a('List of texts'),
                    'permission' => array(
                        'resource' => 'list',
                    ),
                    'route' => 'admin',
                    'controller' => 'list',
                    'action' => 'index',
                ),
                'position' => array(
                    'label' => _a('New text'),
                    'permission' => array(
                        'resource' => 'list',
                    ),
                    'route' => 'admin',
                    'controller' => 'list',
                    'action' => 'update',
                ),
            ),
        ),
    ),
);