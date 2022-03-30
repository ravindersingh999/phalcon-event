<?php

namespace App\Listeners;

use Phalcon\Events\Event;

class notificationListeners
{
    public function beforesend(Event $event, $data, $settings)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        echo "----------------------------------------";

        echo "<pre>";
        print_r(json_decode(json_encode($settings[0])));
        echo "</pre>";
        // die();
        if ($settings[0]->title_optimization == "with tags") {
            $data->name = $data->name . $data->tags;
        }
        if ($data->price == '') {
            $data->price = $settings[0]->default_price;
        }
        if ($data->stock == '') {
            $data->stock = $settings[0]->default_stock;
        }
        echo "after";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
      //  die();
         return $data;
    }

    public function aftersend(Event $event, $data, $settings)
    {
        if ($data->zipcode == "") {
            $data->zipcode = $settings[0]->default_zipcode;
        }
        return $data;
    }
    
    public function beforeHandleRequest(Event $event, \Phalcon\Mvc\Application $application)
    {
        $aclFile = APP_PATH . '/security/acl.cache';
        if (true == is_file($aclFile)) {
            $acl = unserialize(
                file_get_contents($aclFile)
            );

            $role = $application->request->get("role");
            if (!$role || true !== $acl->isAllowed($role, 'test', 'eventtest')) {
                echo "Access denied :(";
                die();
            } else {
                // echo "we don't find any acl list try after somtiome";
            }
        }
    }
}
