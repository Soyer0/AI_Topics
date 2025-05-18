<div class="modal fade" id="topicModal" tabindex="-1" role="dialog" aria-labelledby="topicModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="topicModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="topicForm">
                    <div class="mb-3">
                        <label for="topicInput" class="form-label">Topic</label>
                        <input type="text" class="form-control" id="topicInput" name="topic" required>
                    </div>
                    <div class="mb-3">
                        <label for="groupIdInput" class="form-label">Group ID</label>
                        <input type="number" class="form-control" id="groupIdInput" name="group_id" required>
                    </div>
                    <div class="mb-3" id="processedAtWrapper">
                        <label for="processedAtInput" class="form-label">Processed At</label>
                        <input type="number" class="form-control" id="processedAtInput" name="processed_at">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveTopicBtn" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
