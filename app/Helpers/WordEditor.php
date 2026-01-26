<?php

if (! function_exists('wordEditorUrl')) {
    function wordEditorUrlOneDrive(string $tenant, string $driveId, string $itemId): string
    {
        return sprintf(
            'https://%s.sharepoint.com/_layouts/15/WopiFrame.aspx?resid=%s!%s&action=edit',
            $tenant,
            $driveId,
            $itemId
        );
    }
}


