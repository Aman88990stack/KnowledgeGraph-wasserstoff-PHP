<?php

class RelationshipIdentifier {
    public static function identifyRelationships($text, $entities) {
        $relationships = [];
        
        foreach ($entities as $entity) {
            if (isset($entity['type']) && is_array($entity['type'])) {
                foreach ($entity['type'] as $type) {
                    if (strpos($text, $type) !== false) {
                        $relationships[] = [
                            'entity' => $entity['entityId'],
                            'type' => $type,
                        ];
                    }
                }
            }
        }

        return $relationships;
    }
}
