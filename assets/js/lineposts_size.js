function adjustPosts(){
    const posts = document.querySelectorAll('.line_post');
    let showNumber = 10;

    if(window.innerWidth < 1400) showNumber = 8; 
    if(window.innerWidth < 1200) showNumber = 8; 
    if(window.innerWidth < 900) showNumber = 5; 
    if(window.innerWidth < 768) showNumber = 4; 
    if(window.innerWidth < 500) showNumber = 3; 

    posts.forEach((post, index) =>{
        post.style.display = index < showNumber ? '' : 'none';
    })
}
window.addEventListener("load",adjustPosts);
window.addEventListener("resize",adjustPosts);