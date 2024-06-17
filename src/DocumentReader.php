<?php
class DocumentReader {
    public static function readDocuments($filePaths) {
        $documents = [];
        foreach ($filePaths as $filePath) {
            if (file_exists($filePath)) {
                $documents[] = file_get_contents($filePath);
            } else {
                echo "File not found: $filePath\n";
            }
        }
        return $documents;
    }
}

