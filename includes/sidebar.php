   <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-chubby/css/uicons-solid-chubby.css'>
  <div class="sidebar">
        <div class="top-links">
            <img src="/assets/images/logo.jpg" alt="logo">
            <a href="home.php" id = "home" >Home</a>
            <a href="posts.php" id = "posts">Posts</a>
            <a href="trends.php" id = "trends">Trends</a>
            <a href="pins.php" id = "pins">Pins</a>
            <a href="create.php" id = "create">Create</a>
        </div>

        <div class="bottom-links">
            <i class="fi fi-sc-settings"></i>
        </div>
    </div>

    <script>
        const currentPage = window.location.pathname;
        const pageName = currentPage.split('/').pop();
        

        const homeBtn = document.getElementById('home');
        const postsBtn = document.getElementById('posts');
        const trendsBtn = document.getElementById('trends');
        const pinsBtn = document.getElementById('pins');
        const createBtn = document.getElementById('create');
        console.log(homeBtn);

        switch(pageName){
            case 'home.php': homeBtn.classList.add("active"); break;
            case 'posts.php': postsBtn.classList.add("active"); break;
            case 'trends.php': trendsBtn.classList.add("active"); break;
            case 'pins.php': pinbsBtn.classList.add("active"); break;
            case 'create.php': createBtn.classList.add("active"); break;
            default:homeBtn.classList.add("active");
        }
    </script>