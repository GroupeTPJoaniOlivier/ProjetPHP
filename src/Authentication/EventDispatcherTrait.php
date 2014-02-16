<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 11/02/14
 * Time: 10:34
 */

namespace Authentication;

trait EventDispatcherTrait {

    private $events = [];

    public function addListener($name, $callable) {
        $this->events[$name][] = $callable;
    }

    public function dispatch($name, array $arguments = []) {
        foreach($this->events[$name] as $callable) {
            call_user_func_array($callable, $arguments);
        }
    }

}