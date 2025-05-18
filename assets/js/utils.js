function showModal(modalId, message = '') {
    const modalElement = document.getElementById(modalId);
    if (!modalElement) return;
    if (message) {
        const body = modalElement.querySelector('.modal-body');
        if (body) body.innerHTML = message;
    }
    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
    modal.show();
}

function switchToEditMode() {
    $('#topicModalLabel').text('Edit Topic');
    $('#processedAtWrapper').removeClass('d-none');
    $('#saveTopicBtn').replaceWith(`
        <button type="button" id="editTopicBtn" class="btn btn-primary">Edit</button>
    `);
}

function switchToAddMode() {
    $('#topicModalLabel').text('Add Topic');
    $('#processedAtWrapper').addClass('d-none');
    $('#editTopicBtn').replaceWith(`
        <button type="button" id="saveTopicBtn" class="btn btn-primary">Save</button>
    `);
}
