<?php
require_once 'Model.php';
class TopicModel extends Model {
    public function getColumns()
    {
        $columns =  $this->db->getTableFields('ai_topics');
        $columns = array_map(fn($field) => $field->Field, $columns);
        $columns = array_filter($columns, fn($col) => $col !== 'active');
        $columns[] = 'group_name';
        return $columns;
    }

    public function getAllTopics()
    {
        return $this->db->select("ai_topics")
            ->join("ai_topics_group", 'name as group_name', '#group_id')
            ->get();
    }

    public function addTopic(string $topic, int $groupId)
    {
        $groupIds = array_column($this->db->getAllData('ai_topics_group'), 'id');
        $created_at = time();
        if (!in_array($groupId, $groupIds)) {
            return ['error' => 'Invalid group ID: no such group found.'];
        }

        $newId = $this->db->insertRow('ai_topics', [
            'topic' => $topic,
            'group_id' => $groupId,
            'created_at' => $created_at,
            'created_by' => 0,
            'processed_at' => 0,
            'active' => 1,
        ]);

        $groupName = $this->db->getAllDataById("ai_topics_group", $groupId);
        return ['id' => $newId,
            'topic' => $topic,
            'group_id' => $groupId,
            'created_at' => $created_at,
            'created_by' => 0,
            'processed_at' => 0,
            'group_name' => $groupName->name
        ];
    }

    public function updateActiveStatus(int $id, int $status)
    {
        $topic = $this->db->getAllDataById("ai_topics", $id);
        if (!empty($topic->processed_at)) {
            return ['error' => 'Cannot update topic active status because processed_at is not empty.'];
        }

        return $this->db->updateRow('ai_topics',
            ['active' => $status],
            $id);
    }

    public function deleteTopic(int $id)
    {
        $topic = $this->db->getAllDataById("ai_topics", $id);
        if (!empty($topic->processed_at)) {
            return ['error' => 'Cannot update topic because it is still active (processed_at is not empty).'];
        }

        return $this->db->deleteRow('ai_topics', $id);
    }

    public function getTopic(int $id)
    {
        $topic = $this->db->getAllDataById("ai_topics", $id);

        if(!$topic){
            return ['error' => 'Cannot get topic'];
        }

        return $topic;
    }

    public function editTopic(int $id, string $topic, int $groupId, int $processedAt)
    {
        $isUpdated = $this->db->updateRow('ai_topics',
        ['topic' => $topic,
        'group_id' => $groupId,
        'processed_at' => $processedAt],
        $id);

        if (!$isUpdated) {
            return ['error' => 'Cannot edit topic'];
        }

        $groupName = $this->db->getAllDataById("ai_topics_group", $groupId);

        return ['id' => $id,
            'topic' => $topic,
            'group_id' => $groupId,
            'processed_at' => $processedAt,
            'group_name' => $groupName->name];
    }
}