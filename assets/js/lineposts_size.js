function adjustPosts(){
    const posts = document.querySelectorAll('.line_post');
    const posts1 = document.querySelectorAll('.line_post1');
    let showNumber = 10;

    if(window.innerWidth < 1400) showNumber = 8; 
    if(window.innerWidth < 1200) showNumber = 6; 
    if(window.innerWidth < 900) showNumber = 4; 
    if(window.innerWidth < 768) showNumber = 4; 
    if(window.innerWidth < 600) showNumber = 3; 
    if(window.innerWidth < 400) showNumber = 2; 

    posts.forEach((post, index) =>{
        post.style.display = index < showNumber ? '' : 'none';
    })
     posts1.forEach((post, index) =>{
        post.style.display = index < showNumber ? '' : 'none';
    })
}
window.addEventListener("load",adjustPosts);
window.addEventListener("resize",adjustPosts);