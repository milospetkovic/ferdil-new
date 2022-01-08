<?php

use App\Helpers\GitHelpers;

if (!function_exists('vcs_info')) {
    function vcs_info()
    {
        return GitHelpers::getApplicationVersionInfo();
    }
}