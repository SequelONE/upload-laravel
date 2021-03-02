<?php

function upload_display_link($savedPath)
{
    return \Upload\Util::getDisplayLink($savedPath);
}

function upload_download_link($savedPath, $newName)
{
    return \Upload\Util::getDownloadLink($savedPath, $newName);
}

if ( ! function_exists('storage_host_field') ) {
    function storage_host_field()
    {
        return \Upload\Util::getStorageHostField();
    }
}


