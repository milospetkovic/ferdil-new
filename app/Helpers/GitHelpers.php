<?php
/**
 * Created by PhpStorm.
 * User: milos
 * Date: 08.1.22.
 * Time: 18.24
 */

namespace App\Helpers;

class GitHelpers
{
    /**
     * Return application version and latest commit hash from git repo.
     * Return empty string if user is not logged in.
     *
     * @author Miloš Petković <ElitaSoft>
     * @return string
     */
    public static function getApplicationVersionInfo()
    {
        $ret = "";
        if (auth()->id()) {
            $gitBasePath = base_path().'/.git';
            $gitStr = file_get_contents($gitBasePath.'/HEAD');
            $gitBranchName = rtrim(preg_replace("/(.*?\/){2}/", '', $gitStr));
            $gitPathBranch = $gitBasePath.'/refs/heads/'.$gitBranchName;
            $gitHash = file_get_contents($gitPathBranch);
            $ret .= " - Application Version: ".$gitBranchName."; Commit hash: ".$gitHash;
        }
        return $ret;
    }

}
