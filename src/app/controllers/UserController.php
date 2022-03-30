<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        
    }
    public function signupAction()
    {
        if ($this->request->getPost()) {
            // print_r($this->request->getPost());
            // die();
            $user = new Users();
            $user->assign(
                $this->request->getPost(),
                [
    
                    'name',
                    'email'
                ]
            );
            $success = $user->save();

            $this->view->success = $success;

            if ($success) {
                $this->view->message = "Register succesfully";
            } else {
                $this->view->message = "Not Register succesfully";
            }
        }

    }
}
    // public function registerAction()
    // {
        // if ($this->request->getPost()) {
        //     // print_r($this->request->getPost());
        //     // die();
        //     $user = new Users();
        //     $user->assign(
        //         $this->request->getPost(),
        //         [
    
        //             'name',
        //             'email'
        //         ]
        //     );
        //     $user->save();
        // }
    // }

