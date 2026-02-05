function showPopup(){
    document.getElementById('popupOverlay').classList.add('show');
}

function closePopup(){
     document.getElementById('popupOverlay').classList.remove('show');
}
function saveProfile() {
    const avatarUrl = document.getElementById('avatarUrl').value;
    const nickname = document.getElementById('nickname').value;
    const avatarPreview = document.getElementById('avatarPreview');

    const formData = new FormData();
    formData.append('nickname', nickname);
    formData.append('avatar', avatarUrl);

    fetch('../api/update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(result => {
        if(result.success){
            if(avatarUrl){
                avatarPreview.src = avatarUrl;
                avatarPreview.classList.add('updated');
                setTimeout(()=>avatarPreview.classList.remove('updated'),300);
            }
            if(nickname){
                alert('Username successfully changed to: ' + nickname);
            }
            closePopup();
        } else {
            alert('Error: ' + result.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred while saving the profile');
    });
}