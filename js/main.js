
//function to open Add Favorite Bookmark to Bookmark Section Form 
function openAddFavoriteBookmarkForm(){
    const form = document.getElementById('FavoriteBookmarkForm');
    form.style.display = 'block';
}

//Funtion opens in-line 'modal' to add bookmarks. 
function openAddBookmarkModal(groupId = null) {
 
    // document.getElementById('addBookmarkModal').style.display = 'block';

    const li =document.createElement('li');
    const groupList = document.getElementById('group-list-' + groupId);
    li.id='inlineBookmarkForm';
    li.innerHTML = `
        
        <form method="POST" action="handlers/add_bookmark.php" class="add-bookmark-form w3-auto">
            <button type="button" class="cancel-btn" onclick="closeBookmarkForm()" aria-label="Close">&#10006;</button>
            <h3 class="w3-center" style="margin-top: 0px;">Add Bookmark</h3>

            <input type="hidden" name="group_id" value="${groupId}">

            <label for="title">Title:</label>
            <input type="text" name="title" id="modalTitle" required><br>
    
            
            <label for="url">URL:</label>
            <input type="text" name="url" id="modalUrl" required placeholder="https://example.com"><br>
            
            <label>
                <input type="checkbox" name="favorite" value="1"> Add to Favorites
            </label>

            <button type="submit" class="add-btn">Add Bookmark</button>
            


        </form>
    `;
    groupList.appendChild(li);
    console.log(groupList);

}

//Function closes the in-line 'modal' if user chooses to cancel. 
function closeBookmarkForm() {
    document.getElementById('inlineBookmarkForm').style.display = 'none';
}

function closeFavoriteBookmarkForm() {
    document.getElementById('FavoriteBookmarkForm').style.display = 'none';
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

function editSection(groupId=null){

    const groupList = document.getElementById('group-list-' + groupId);

}



//Function to Edit a Section 

function editSection(groupId = null, btnElement) {
    const isEditing = btnElement.dataset.editing === "true";

    // Update button label and state
    btnElement.textContent = isEditing ? "EDIT" : "CANCEL";
    btnElement.dataset.editing = isEditing ? "false" : "true";

    // Determine the section we’re editing
    let targetSection;
    if (groupId === null) {
        // Favorites section
        targetSection = document.getElementById("FavoriteSection");
    } else {
        targetSection = document.querySelector(`.group-section[data-group-id="${groupId}"]`);
    }

    if (!targetSection) return;

    // Toggle pencil icons within the section
    const pencils = targetSection.querySelectorAll(".edit-pencil");

    pencils.forEach((icon) => {
        if (isEditing) {
            icon.style.display = "none";
            icon.disabled = true;
        } else {
            icon.style.display = "inline-block";
            icon.disabled = false;
        }
    });

    // Special handling for group title pencil if custom group
    if (groupId !== null) {
        const titlePencil = targetSection.querySelector(".group-title + .edit-pencil");
        if (titlePencil) {
            titlePencil.style.display = isEditing ? "none" : "inline-block";
            titlePencil.disabled = isEditing;
        }
    }
}


// Function to Generate Editing modal 
function openEditModal(type, id, triggerBtn) {
    const modalContainer = document.getElementById('editModalContainer');
    const modalContent = document.getElementById('editModalContent');

    const existingTitle = triggerBtn.dataset.title || '';
    const existingUrl = triggerBtn.dataset.url || '';

    modalContent.innerHTML = '';

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'handlers/edit_modal_handler.php';

    form.innerHTML += `
        <input type="hidden" name="type" value="${type}">
        <input type="hidden" name="id" value="${id}">
    `;

    if (type === 'favorite' || type === 'bookmark') {
        form.innerHTML += `
            <label>Title:</label>
            <input type="text" name="title" placeholder="${existingTitle}" required><br>

            <label>URL:</label>
            <input type="text" name="url" placeholder="${existingUrl}" required><br>

            <label>
                <input type="checkbox" name="delete" value="1">
                ${type === 'favorite' ? 'Remove from Favorites' : 'Remove from Group'}
            </label><br>
        `;
    }

    if (type === 'group') {
        form.innerHTML += `
            <label>Group Title:</label>
            <input type="text" name="group_title" placeholder="${existingTitle}" required><br>

            <label>
                <input type="checkbox" name="delete_group" value="1">
                Delete group and all bookmarks
            </label><br>
        `;
    }

    form.innerHTML += `
        <button type="submit" class="w3-button w3-green" style="margin-top: 1rem;">Save Changes</button>
        <button type="button" class="w3-button w3-red" onclick="closeEditModal()">Cancel</button>
    `;

    modalContent.appendChild(form);
    modalContainer.style.display = 'block';
}

//Closes Editing Modal 
function closeEditModal() {
    const modal = document.getElementById('editModalContainer');
    modal.style.display = 'none';
}
