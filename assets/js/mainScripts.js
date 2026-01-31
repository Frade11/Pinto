const exploreBtns = document.querySelectorAll('.explore');
exploreBtns.forEach(btn => {
    btn.addEventListener('click',()=>{
    window.location.href = 'posts.php'
})})
