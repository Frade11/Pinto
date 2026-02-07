document.addEventListener('DOMContentLoaded', () => {
  const likeBtn = document.querySelector('.like-btn');
  const saveBtn = document.querySelector('.save-btn');
  const likeCount = document.getElementById('like-count');
  const saveCount = document.getElementById('save-count');

  function sendAction(action, btn, countEl) {
    const postId = btn.dataset.id;

    fetch('../api/actions.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=${action}&post_id=${postId}`
    })
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        alert(data.error);
        return;
      }

      if (action === 'like') {
        countEl.textContent = `${data.likes} likes`;
       if (data.liked) {
          btn.classList.add('active');
          btn.innerHTML = '<i class="fi fi-ss-heart"></i>'; 
        } else {
          btn.classList.remove('active');
          btn.innerHTML = '<i class="fi fi-rs-heart"></i>'; 
        }
      } else if (action === 'save') {
        countEl.textContent = `${data.saves} saves`;
        btn.classList.toggle('active', data.saved);
        if(data.saved){
            btn.innerHTML = 'Saved';
        }else{
            btn.innerHTML = "Save";
        }
      }
    });
  }

  if (likeBtn) {
    likeBtn.addEventListener('click', () => sendAction('like', likeBtn, likeCount));
  }

  if (saveBtn) {
    saveBtn.addEventListener('click', () => sendAction('save', saveBtn, saveCount));
  }
});