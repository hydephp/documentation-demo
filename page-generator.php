<?php

$files = [
    'getting-started/welcome-to-docuvibe',
    'getting-started/system-requirements',
    'getting-started/installation-guide',
    'getting-started/quick-start',
    'admin-guide/system-configuration',
    'admin-guide/user-management',
    'admin-guide/backup-and-restore',
    'admin-guide/permissions-and-security',
    'user-guide/user-account-setup',
    'user-guide/profile-and-preferences',
    'user-guide/navigating-the-dashboard',
    'user-guide/accessing-help-and-support',
    'features/document-management',
    'features/collaboration-tools',
    'features/integration-options',
    'features/search-and-filtering',
    'features/version-control',
    'tutorials/uploading-your-first-document',
    'tutorials/creating-folders-and-categories',
    'tutorials/advanced-search-techniques',
    'tutorials/sharing-documents',
//    'api-documentation/api-overview',
//    'api-documentation/authentication',
//    'api-documentation/api-endpoints',
//    'api-documentation/examples-and-use-cases',
//    'troubleshooting/common-issues-and-solutions',
//    'troubleshooting/error-codes',
//    'troubleshooting/contacting-support',
//    'release-notes/version-history',
//    'release-notes/what-is-new-in-docuvibe',
//    'faq/frequently-asked-questions',
//    'faq/glossary-of-terms',
//    'contact-us/support-and-feedback',
//    'contact-us/contact-information',
//    'terms-and-privacy/terms-of-service',
//    'terms-and-privacy/privacy-policy',
];

$force = true;
echo "Generating pages...\n";

$sidebarPriorities = [];
foreach ($files as $file) {
    $sidebarGroup = explode('/', $file)[0];
    $sidebarPriorities[$sidebarGroup] = count($sidebarPriorities);
}

foreach ($files as $count => $file) {
    echo '.';
    $sidebarGroup = explode('/', $file)[0];
    $priority = ($sidebarPriorities[$sidebarGroup] * 100) + $count;

    $file = trim($file);
    $path = __DIR__ . '/_docs/' . $file . '.md';
    if (!file_exists($path) || $force) {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, recursive: true);
        }
        $title = str_replace('-', ' ', basename($file));
        $title = ucfirst($title);
        $title = str_replace('docuvibe', 'DocuVibe', $title);

        $markdown = file_get_contents('https://jaspervdj.be/lorem-markdownum/markdown.txt');
        // Remove first two lines
        $markdown = explode("\n", $markdown);
        unset($markdown[0]);
        unset($markdown[1]);
        $markdown = implode("\n", $markdown);
        $data = <<<YML
---
title: $title
navigation.priority: $priority
---
YML . "\n\n# $title\n\n". $markdown;
        file_put_contents($path, $data);
    }
}

echo "\nDone.\n";
