function showPopup(){
    document.getElementById('popupOverlay').classList.add('show');
}

function closePopup(){
     document.getElementById('popupOverlay').classList.remove('show');
}
function showNotification(message, success = true){
    const notif = document.getElementById('notification');
    notif.textContent = message;
    notif.style.background = success 
        ? 'linear-gradient(135deg, #5b5bff, #9b6bff)'
        : 'linear-gradient(135deg, #d93025, #ff5757)';

    notif.style.opacity = '1';
    notif.style.transform = 'translateY(0)';

    setTimeout(()=>{
        notif.style.opacity = '0';
        notif.style.transform = 'translateY(-20px)';
    }, 3000);
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
                 showNotification('Username successfully changed to: ' + nickname, true);
            }
            closePopup();
        } else {
              showNotification('Error: ' + result.message, false);
        }
    })
    .catch(err => {
        console.error(err);
         showNotification('An error occurred while saving the profile', false);
    });
}