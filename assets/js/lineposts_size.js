function adjustPosts(){
    const posts = document.querySelectorAll('.line_post');
    let showNumber = 6;

    if(window.innerWidth < 1400) showNumber = 5; 
    if(window.innerWidth < 1200) showNumber = 4; 
    if(window.innerWidth < 900) showNumber = 3; 
    if(window.innerWidth < 768) showNumber = 3; 
    if(window.innerWidth < 500) showNumber = 2; 

    posts.forEach((post, index) =>{
        post.style.display = index < showNumber ? '' : 'none';
    })
}
window.addEventListener("load",adjustPosts);
window.addEventListener("resize",adjustPosts);