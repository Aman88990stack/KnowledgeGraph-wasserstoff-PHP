<?php

class KnowledgeGraphBuilder {
    public static function buildGraph($entities, $relationships, $sentiments, $temporalData) {
        $graph = [
            '@context' => [
                'entity' => 'http://example.org/entity',
                'type' => 'http://example.org/type',
                'relationship' => 'http://example.org/relationship',
                'sentiment' => 'http://example.org/sentiment',
                'temporal' => 'http://example.org/temporal',
            ],
            '@graph' => []
        ];

        foreach ($entities as $entity) {
            $graph['@graph'][] = [
                '@id' => 'entity:' . $entity['entityId'],
                'type' => $entity['type'] ?? [],
                'confidenceScore' => $entity['confidenceScore'] ?? null,
            ];
        }

        foreach ($relationships as $relationship) {
            $graph['@graph'][] = [
                '@id' => 'relationship:' . uniqid(),
                'entity' => $relationship['entity'],
                'type' => $relationship['type'],
            ];
        }

        foreach ($sentiments as $sentiment) {
            $graph['@graph'][] = [
                '@id' => 'sentiment:' . uniqid(),
                'sentiment' => $sentiment,
            ];
        }

        foreach ($temporalData as $temporal) {
            $graph['@graph'][] = [
                '@id' => 'temporal:' . uniqid(),
                'temporal' => $temporal,
            ];
        }

        return json_encode($graph, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
