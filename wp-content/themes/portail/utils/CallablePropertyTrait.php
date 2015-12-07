<?php

trait CallablePropertyTrait {
    /**
     * allow to call anonymous function stored in property
    **/
    public function __call($method, $args) {
        if (!isset($this->$method)) {
            return;
        }
        $func = $this->$method;

        return call_user_func_array($func, $args);
    }
}
