$(document).ready(function () {
    $('#topicTableBody').on('click', '.activate-btn', function (event) {
        event.stopPropagation();

        const $row = $(this).closest('tr');
        const topicId = $row.data('topic_id');

        ajaxActivateTopic(topicId, function () {
            $row.removeClass('table-danger').addClass('table-success');
            const newBtn = `
                <button class="btn btn-sm btn-danger deactivate-btn" title="Deactivate">
                    <i class="fas fa-times text-white"></i>
                </button>
            `;
            $row.find('.activate-btn').replaceWith(newBtn);
        });
    });

    $('#topicTableBody').on('click', '.deactivate-btn', function (event) {
        event.stopPropagation();

        const $row = $(this).closest('tr');
        const topicId = $row.data('topic_id');

        ajaxDeactivateTopic(topicId, function () {
            $row.removeClass('table-success').addClass('table-danger');
            const newBtn = `
                <button class="btn btn-sm btn-success activate-btn" title="Activate">
                    <i class="fas fa-check text-white"></i>
                </button>
            `;
            $row.find('.deactivate-btn').replaceWith(newBtn);
        });
    });

    $('#topicTableBody').on('click', '.delete-btn', function (event) {
        event.stopPropagation();

        const $row = $(this).closest('tr');
        const topicId = $row.data('topic_id');

        if (!topicId || !$row.length) {
            showModal('customErrorModal', 'Topic ID or row not found');
            return;
        }

        showModal('deleteConfirmModal', `<p>Are you sure you want to delete topic with ID ${topicId}?</p>`);

        $('#confirmDeleteBtn').off('click').on('click', function () {
            ajaxDeleteTopic(topicId, function () {
                $row.remove();
            });
        });
    });

    $('#addTopicBtn').on('click', function () {
        $('#topicForm')[0].reset();
        switchToAddMode();
        showModal('topicModal');
    });

    $(document).on('click', '#saveTopicBtn', function () {
        const topic = $('#topicInput').val().trim();
        const groupId = parseInt($('#groupIdInput').val().trim(), 10);

        if (!topic || isNaN(groupId)) {
            showModal('customErrorModal', 'Please fill in both Topic and Group ID.');
            return;
        }

        ajaxAddTopic(topic, groupId, function (response){
            bootstrap.Modal.getInstance(document.getElementById('topicModal')).hide();
            const newRow = `
                <tr class="clickable-row table-success" data-topic_id="${response.topic.id}">
                    ${window.topicColumns.map(column => {
                            const value = response.topic[column];
                            const safeValue = (value !== null && value !== undefined && String(value).trim() !== '')
                                ? $('<div>').text(value).html()
                                : '-';
                            return `<td class="${column}">${safeValue}</td>`;
                        }).join('')}
                    <td>
                        <button class="btn btn-sm btn-danger deactivate-btn" title="Deactivate">
                            <i class="fas fa-times text-white"></i>
                        </button>
                        <button class="btn btn-sm btn-secondary delete-btn" title="Delete">
                            <i class="fas fa-trash text-white"></i>
                        </button>
                    </td>
                </tr>`;
            $('#topicTableBody').append(newRow);
        });
    });

    $('#topicTableBody').on('click', '.clickable-row', function () {
        const topicId = $(this).data('topic_id');
        ajaxGetTopic(topicId, function (response){
            const topic = response.topic;
            switchToEditMode();
            $('#topicInput').val(topic.topic);
            $('#groupIdInput').val(topic.group_id);
            $('#processedAtInput').val(topic.processed_at)

            $('#topicModal').attr('data-topic_id', topicId);

            showModal('topicModal');
        });
    });

    $(document).on('click', '#editTopicBtn', function () {
        const topicId = $('#topicModal').attr('data-topic_id');
        const topic = $('#topicInput').val().trim();
        const groupId = parseInt($('#groupIdInput').val().trim(), 10);
        const processedAt = parseInt($('#processedAtInput').val().trim(), 10);

        if (!topic || isNaN(groupId) || isNaN(processedAt)) {
            showModal('customErrorModal', 'Please fill in all fields correctly.');
            return;
        }

        ajaxEditTopic(topicId, topic, groupId, processedAt, function (response) {
            const editedTopic = response.topic;
            const $row = $(`#topicTableBody tr[data-topic_id="${topicId}"]`);

            if (!$row.length) {
                showModal('customErrorModal', 'Row not found for update.');
                return;
            }

            window.topicColumns.forEach(column => {
                if (column === 'id' || column === 'created_at' || column === 'created_by') return;
                const $cell = $row.find(`td.${column}`);
                const value = editedTopic[column];

                const safeValue = (value !== null && value !== undefined && String(value).trim() !== '')
                    ? $('<div>').text(value).html()
                    : '-';

                $cell.html(safeValue);
            });

            bootstrap.Modal.getInstance(document.getElementById('topicModal')).hide();
        })
    });
});
