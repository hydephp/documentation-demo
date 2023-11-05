<?php

$files = <<<'TXT'
getting-started/welcome-to-docuvibe
getting-started/installation-guide
getting-started/quick-start
getting-started/system-requirements
user-guide/user-account-setup
user-guide/navigating-the-dashboard
user-guide/profile-and-preferences
user-guide/accessing-help-and-support
features/document-management
features/version-control
features/collaboration-tools
features/search-and-filtering
features/integration-options
tutorials/uploading-your-first-document
tutorials/creating-folders-and-categories
tutorials/sharing-documents
tutorials/advanced-search-techniques
admin-guide/user-management
admin-guide/permissions-and-security
admin-guide/system-configuration
admin-guide/backup-and-restore
api-documentation/api-overview
api-documentation/authentication
api-documentation/api-endpoints
api-documentation/examples-and-use-cases
troubleshooting/common-issues-and-solutions
troubleshooting/error-codes
troubleshooting/contacting-support
release-notes/version-history
release-notes/what-is-new-in-docuvibe
faq/frequently-asked-questions
faq/glossary-of-terms
contact-us/support-and-feedback
contact-us/contact-information
terms-and-privacy/terms-of-service
terms-and-privacy/privacy-policy
TXT;
echo "Generating pages...\n";
$files = explode("\n", $files);
foreach ($files as $file) {
    echo '.';
    $file = trim($file);
    $path = __DIR__ . '/_docs/' . $file . '.md';
    if (!file_exists($path)) {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, recursive: true);
        }
        $title = str_replace('-', ' ', $file);
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
---
YML . "\n\n". $markdown;
        file_put_contents($path, $data);
    }
}

echo "\nDone.\n";
