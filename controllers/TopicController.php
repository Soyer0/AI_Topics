<?php
require_once __DIR__ . '/../models/TopicModel.php';
require_once(__DIR__ . '/../lib/data.php');

class TopicController
{
    private TopicModel $topicModel;
    private Data $data;

    public function __construct()
    {
        $this->topicModel = new TopicModel();
        $this->data = new Data();
    }

    public function showTopics(): void
    {
        $topics = $this->topicModel->getAllTopics();
        if (is_null($topics)) {
            $topics = [];
        } elseif (!is_array($topics)) {
            $topics = [$topics];
        }
        $columns = $this->topicModel->getColumns();
        if (is_null($columns)) {
            $columns = [];
        } elseif (!is_array($columns)) {
            $columns = [$columns];
        }
        $content = $this->render('topics/index', [
            'topics' => $topics,
            'columns' => $columns,
        ]);

        echo $this->render('layout', ['content' => $content]);
    }

    public function activateTopic(): void
    {
        header('Content-Type: application/json');

        $id = $this->data->post('id');
        if (!$id) {
            echo json_encode(['error' => 'Topic ID is missing']);
            return;
        }

        $updated = $this->topicModel->updateActiveStatus($id, 1);

        if (is_array($updated) && isset($updated['error'])) {
            echo json_encode(['error' => $updated['error']]);
            return;
        }

        if ($updated) {
            echo json_encode([
                'success' => true,
            ]);
        } else {
            echo json_encode(['error' => 'Failed to activate topic']);
        }
    }

    public function deactivateTopic(): void
    {
        header('Content-Type: application/json');

        $id = $this->data->post('id');
        if (!$id) {
            echo json_encode(['error' => 'Topic ID is missing']);
            return;
        }

        $updated = $this->topicModel->updateActiveStatus($id, 0);

        if (is_array($updated) && isset($updated['error'])) {
            echo json_encode(['error' => $updated['error']]);
            return;
        }

        if ($updated) {
            echo json_encode([
                'success' => true,
            ]);
        } else {
            echo json_encode(['error' => 'Failed to deactivate topic']);
        }
    }

    public function deleteTopic(): void
    {
        header('Content-Type: application/json');
        $id = $this->data->post('id');

        if (!$id) {
            echo json_encode(['error' => 'Topic ID is missing']);
            return;
        }

        $isDeleted = $this->topicModel->deleteTopic($id);

        if (is_array($isDeleted) && isset($isDeleted['error'])) {
            echo json_encode(['error' => $isDeleted['error']]);
            return;
        }

        if ($isDeleted) {
            echo json_encode([
                'success' => true,
            ]);
        } else {
            echo json_encode(['error' => 'Something went wrong']);
        }

    }

    function addTopic(): void
    {
        header('Content-Type: application/json');
        $topic = $this->data->post('topic');
        if ($topic === '' || $topic === null) {
            echo json_encode(['error' => 'Topic is missing']);
        }

        $groupId = $this->data->post('groupId');
        if (empty($groupId)) {
            echo json_encode(['error' => 'Group ID is missing']);
        }

        $topic = $this->topicModel->addTopic($topic, $groupId);

        if (is_array($topic) && isset($topic['error'])) {
            echo json_encode(['error' => $topic['error']]);
            return;
        }

        if($topic){
            echo json_encode([
                'success' => true,
                'topic' =>  $topic,
            ]);
        }
        else {
            echo json_encode(['error' => 'Failed to add topic']);
        }
    }

    public function getTopic(): void
    {
        header('Content-Type: application/json');
        $id = $this->data->post('id');

        if (!$id) {
            echo json_encode(['error' => 'Topic ID is missing']);
            return;
        }

        $topic = $this->topicModel->getTopic($id);

        if (is_array($topic) && isset($topic['error'])) {
            echo json_encode(['error' => $topic['error']]);
            return;
        }

        if($topic){
            echo json_encode([
                'success' => true,
                'topic' =>  $topic,
            ]);
        }
        else {
            echo json_encode(['error' => 'Failed to get topic']);
        }
    }

    public function editTopic(): void
    {
        header('Content-Type: application/json');
        $id = $this->data->post('id');

        if (!$id) {
            echo json_encode(['error' => 'Topic ID is missing']);
            return;
        }

        $topic = $this->data->post('topic');
        if ($topic === '' || $topic === null) {
            echo json_encode(['error' => 'Topic is missing']);
        }

        $groupId = $this->data->post('groupId');
        if (empty($groupId)) {
            echo json_encode(['error' => 'Group ID is missing']);
        }

        $processedAt = $this->data->post('processedAt') ?? 0;

        $newTopic = $this->topicModel->editTopic($id, $topic, $groupId, $processedAt);

        if (is_array($newTopic) && isset($newTopic['error'])) {
            echo json_encode(['error' => $newTopic['error']]);
            return;
        }

        if($newTopic){
            echo json_encode([
                'success' => true,
                'topic' =>  $newTopic,
            ]);
        }
        else {
            echo json_encode(['error' => 'Failed to edit topic']);
        }


    }

    private function render($view, $data = []): bool|string
    {
        extract($data);
        ob_start();
        include "views/$view.php";
        return ob_get_clean();
    }
}