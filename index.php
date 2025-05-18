<?php
require __DIR__ . '/config/config.php';
require __DIR__ . '/controllers/TopicController.php';

session_start();

if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'en';
}

if (!isset($_SESSION['all_languages'])) {
    $_SESSION['all_languages'] = ['en'];
}

if (!isset($GLOBALS['multilanguage_type'])) {
    $GLOBALS['multilanguage_type'] = 'main domain';
}

$topicController = new TopicController();

$action = $_GET['action'] ?? 'showTopics';

switch ($action) {
    case 'showTopics':
        $topicController->showTopics();
        break;
    case 'activateTopic':
        $topicController->activateTopic();
        break;
    case 'deactivateTopic':
        $topicController->deactivateTopic();
        break;
    case 'deleteTopic':
        $topicController->deleteTopic();
        break;
    case 'addTopic':
        $topicController->addTopic();
        break;
    case 'getTopic':
        $topicController->getTopic();
        break;
    case 'editTopic':
        $topicController->editTopic();
        break;
    default:
        echo "404 Not Found";
        break;
}

