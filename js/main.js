

//Funtion opens in-line 'modal' to add bookmarks. 
function openAddBookmarkModal(groupId = null) {
    if (groupId !== null) {
        document.getElementById('modalGroupId').value = groupId;
    }
    document.getElementById('addBookmarkModal').style.display = 'block';
}

//Function closes the in-line 'modal' if user chooses to cancel. 
function closeBookmarkForm() {
    document.getElementById('addBookmarkModal').style.display = 'none';
}


function openAddGroupForm(groupId = null) {
    if (groupId !== null) {
        document.getElementById('modalGroupId').value = groupId;
    }
    document.getElementById('addGroupForm').style.display = 'block';
}

//Function closes the in-line 'modal' if user chooses to cancel. 
function closeGroupForm() {
    document.getElementById('addGroupForm').style.display = 'none';
}