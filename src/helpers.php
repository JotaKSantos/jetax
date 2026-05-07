<?php

if (! function_exists('jetax_config')) {
    function jetax_config(string $key, mixed $default = null): mixed
    {
        return config('jetax.'.$key, $default);
    }
}
