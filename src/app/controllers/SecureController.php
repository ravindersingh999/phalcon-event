<?php

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Component;
use Phalcon\Acl\Role;


class SecureController extends Controller

{
    public function indexAction()
    {
        // $this->view->users = Users::find();
    }
    public function BuildAction()
    {
        $aclFile = APP_PATH . '/security/acl.cache';
        if (true !== is_file($aclFile)) {
            // acl does not exist build it
            $acl = new Memory();
            // print_r(json_encode($acl));

            $acl->addRole('admin');
            $acl->addRole('customer');
            $acl->addRole('guest');

            $acl->addComponent(
                'test',
                [
                    'eventtest'
                ]
            );

            $acl->allow('admin', 'test', 'eventtest');

            $acl->allow('guest', 'test', 'eventtest');

            file_put_contents(
                $aclFile,
                serialize($acl)
            );
        } else {
            $acl = unserialize(
                file_get_contents($aclFile)
            );
        }

        if (true == $acl->isAllowed('admin', 'test', 'eventtest')) {
            echo "Access Granted";
        } else {
            echo "Access Denied";
        }
    }
}
