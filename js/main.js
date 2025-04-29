function openAddBookmarkModal(groupId = null) {
    if (groupId !== null) {
        document.getElementById('modalGroupId').value = groupId;
    }
    document.getElementById('addBookmarkModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('addBookmarkModal').style.display = 'none';
}
