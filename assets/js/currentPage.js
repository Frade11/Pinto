const currentPage = window.location.pathname;
const pageName = currentPage.split('/').pop();

const homeBtn = document.getElementById('home');
const postsBtn = document.getElementById('posts');
const trendsBtn = document.getElementById('trends');
const pinsBtn = document.getElementById('pins');
const createBtn = document.getElementById('create');

const homeMobile = document.getElementById('homeMobile');
const postsMobile = document.getElementById('postsMobile');
const pinsMobile = document.getElementById('pinsMobile');
const createMobile = document.getElementById('createMobile');
const logoImg = document.querySelector('.logoImg');
const logoMobile = document.querySelector('.logoImgMobile');

logoImg.addEventListener("click", () =>{
    window.location.href = "../pages/home.php"
});
logoMobile.addEventListener("click", () =>{
    window.location.href = "../pages/home.php"
});


function setActive(btnDesktop, btnMobile) {
    if (btnDesktop) btnDesktop.classList.add("active");
    if (btnMobile) btnMobile.classList.add("active");
}


switch (pageName) {
    case 'home.php': setActive(homeBtn, homeMobile); break;
    case 'posts.php': setActive(postsBtn, postsMobile); break;
    case 'trends.php': setActive(null, null); break; 
    case 'pins.php': setActive(pinsBtn, pinsMobile); break;
    case 'create.php': setActive(createBtn, createMobile); break;
}