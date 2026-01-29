        const currentPage = window.location.pathname;
        const pageName = currentPage.split('/').pop();
        
        const homeBtn = document.getElementById('home');
        const postsBtn = document.getElementById('posts');
        const trendsBtn = document.getElementById('trends');
        const pinsBtn = document.getElementById('pins');
        const createBtn = document.getElementById('create');

        const logoImg = document.querySelector('.logoImg')
        logoImg.addEventListener("click", () =>{
            window.location.href = "/"
        })
        

        switch(pageName){
            case 'home.php': homeBtn.classList.add("active"); break;
            case 'posts.php': postsBtn.classList.add("active"); break;
            case 'trends.php': trendsBtn.classList.add("active"); break;
            case 'pins.php': pinbsBtn.classList.add("active"); break;
            case 'create.php': createBtn.classList.add("active"); break;
            default:homeBtn.classList.add("active");
        }