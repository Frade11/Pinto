const exploreBtns = document.querySelectorAll('.explore');
exploreBtns.forEach(btn => {
    btn.addEventListener('click',()=>{
    window.location.href = 'posts.php'
})})

const userIcon = document.getElementById('userIcon');
const userOverlay = document.getElementById('userOverlay');

userIcon.addEventListener('click', function(){
    if(userOverlay.style.display === 'block'){
        userOverlay.style.display = 'none';
    }else{
         userOverlay.style.display = 'block';
    }
});

const logOutBtn = document.getElementById('logOut');
logOutBtn.addEventListener('click', () => {
    window.location.href='../login/logout.php';
})


