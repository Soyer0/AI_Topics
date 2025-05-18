function ajaxActivateTopic(topicId, onSuccess) {
    $.ajax({
        url: 'index.php?action=activateTopic',
        type: 'POST',
        data: { id: topicId },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                showModal('customErrorModal', response.error);
            } else {
                if (typeof onSuccess === 'function') {
                    onSuccess(response);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Activation AJAX error:', error);
        }
    });
}

function ajaxDeactivateTopic(topicId, onSuccess) {
    $.ajax({
        url: 'index.php?action=deactivateTopic',
        type: 'POST',
        data: { id: topicId },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                showModal('customErrorModal', response.error);
            } else {
                if (typeof onSuccess === 'function') {
                    onSuccess(response);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Deactivation AJAX error:', error);
        }
    });
}

function ajaxDeleteTopic(topicId, onSuccess) {
    $.ajax({
        url: 'index.php?action=deleteTopic',
        type: 'POST',
        data: { id: topicId },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                showModal('customErrorModal', response.error);
            } else {
                if (typeof onSuccess === 'function') {
                    onSuccess(response);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Deletion AJAX error:', error);
        }
    });
}

function ajaxAddTopic(topic, groupId, onSuccess) {
    $.ajax({
        url: 'index.php?action=addTopic',
        type: 'POST',
        data: {
            topic: topic,
            groupId: groupId,
        },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                showModal('customErrorModal', response.error);
            } else {
                if (typeof onSuccess === 'function') {
                    onSuccess(response);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Adding AJAX error:', error);
        }
    });
}

function ajaxGetTopic(topicId, onSuccess){
    $.ajax({
        url: 'index.php?action=getTopic',
        type: 'POST',
        data: {
            id: topicId,
        },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                showModal('customErrorModal', response.error);
            } else {
                if (typeof onSuccess === 'function') {
                    onSuccess(response);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Getting AJAX error:', error);
        }
    });
}

function ajaxEditTopic(topicId, topic, groupId, processedAt, onSuccess){
    $.ajax({
        url: 'index.php?action=editTopic',
        type: 'POST',
        data: {
            id: topicId,
            topic: topic,
            groupId: groupId,
            processedAt: processedAt,
        },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                showModal('customErrorModal', response.error);
            } else {
                if (typeof onSuccess === 'function') {
                    onSuccess(response);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Editing AJAX error:', error);
        }
    });
}