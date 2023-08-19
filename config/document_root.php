<?php
function getDocumentRoot() {
    $documentRoot = '';

    if (isset($_SERVER['DOCUMENT_ROOT'])) {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
    }
    return $documentRoot;
    
}
?>
