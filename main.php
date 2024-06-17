<?php

require 'vendor/autoload.php';
require 'src/DocumentReader.php';
require 'src/EntityExtractor.php';
require 'src/RelationshipIdentifier.php';
require 'src/SentimentAnalyzer.php';
require 'src/TemporalAnalyzer.php';
require 'src/KnowledgeGraphBuilder.php';

$filePaths = ['data/doc1.txt']; // List of your data files

// Read documents
$documents = DocumentReader::readDocuments($filePaths);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get the API key from environment variables
$apiKey = $_ENV['TEXTRAZOR_API_KEY'];

$entityExtractor = new EntityExtractor($apiKey);
$sentimentAnalyzer = new SentimentAnalyzer($apiKey);
$temporalAnalyzer = new TemporalAnalyzer($apiKey);

$entities = [];
$relationships = [];
$sentiments = [];
$temporalData = [];

foreach ($documents as $text) {
    $extractedEntities = $entityExtractor->extractEntities($text);
    $entities = array_merge($entities, $extractedEntities ?: []);

    $identifiedRelationships = RelationshipIdentifier::identifyRelationships($text, $extractedEntities);
    $relationships = array_merge($relationships, $identifiedRelationships ?: []);

    $sentiment = $sentimentAnalyzer->analyzeSentiment($text);
    if ($sentiment !== null) {
        $sentiments[] = $sentiment;
    }

    $temporal = $temporalAnalyzer->extractTemporalInformation($text);
    $temporalData = array_merge($temporalData, $temporal ?: []);
}

$knowledgeGraph = KnowledgeGraphBuilder::buildGraph($entities, $relationships, $sentiments, $temporalData);

// Save the knowledge graph to a file in JSON-LD format
file_put_contents('output/knowledge_graph.jsonld', $knowledgeGraph);

echo "Knowledge graph generated successfully and saved as knowledge_graph.jsonld in the output folder.\n";
