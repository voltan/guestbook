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
namespace Module\Guestbook\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Zend\Db\Sql\Predicate\Expression;

class IndexController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        $module = $this->params('module');
        // Get config
        $config = Pi::service('registry')->config->read($module);
        // Get info
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($config['show_perpage']);
        $offset = (int)($page - 1) * $config['show_perpage'];
        $where = array('status' => 1);
        $select = $this->getModel('text')->select()->where($where)->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('text')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            $list[$row->id]['text_description'] = Pi::service('markup')->render($list[$row->id]['text_description'], 'html', 'text');
            $list[$row->id]['avatar'] = Pi::service('user')->avatar($row->uid, 'large' , array(
                'alt' => $row->name,
                'class' => 'img-thumbnail'
            ));
        }
        // Set paginator
        $count = array('count' => new Expression('count(*)'));
        $select = $this->getModel('text')->select()->columns($count)->where($where);
        $count = $this->getModel('text')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router' => $this->getEvent()->getRouter(),
            'route' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array_filter(array(
                'module' => $this->getModule(),
                'controller' => 'list',
                'action' => 'index',
            )),
        ));
        // Set view
        $this->view()->setTemplate('list');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
        $this->view()->assign('config', $config);

       
    }
}