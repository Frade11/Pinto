document.addEventListener('DOMContentLoaded', () => {
const exploreBtns = document.querySelectorAll('.explore');
exploreBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        window.location.href = '../pages/posts.php';
    });
});
    
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

const redirectProfile = document.getElementById('user-popup');
redirectProfile.addEventListener('click', () => {
    window.location.href='../pages/pins.php?tab=saved';
})
});

const consoleEl = document.getElementById('console');
const consoleBody = document.getElementById('consoleBody');
const openBtns = document.querySelectorAll('.openConsole');
const closeBtn = document.getElementById('closeConsole');

const messages = [
  "frade11@dev_env:~$ fetch --about-project",
  "optimizing CDN: Speed 100/100",
  "optimizing object storage: Pretty images 736/742",
  "",
  "this project was done by frade11 for practice",
  "github - https://github.com/Frade11",
  "",
  "inspired by Pinterest",
  "All rights deserved",
];

function typeLine(text, callback) {
    let i = 0;
    const lineEl = document.createElement('div');
    lineEl.className = 'line';
    consoleBody.appendChild(lineEl);

    function typeChar() {
        if (i < text.length) {
            lineEl.textContent += text[i];
            i++;
            setTimeout(typeChar, 50); 
        } else {
            const urlRegex = /(https?:\/\/[^\s]+)/g;
            lineEl.innerHTML = lineEl.textContent.replace(urlRegex, '<a href="$1" target="_blank" style="color:#0f0;">$1</a>');

            const cursor = document.createElement('span');
            cursor.className = 'cursor';
            lineEl.appendChild(cursor);
            if (callback) callback();
        }
        consoleBody.scrollTop = consoleBody.scrollHeight; 
    }
    typeChar();
}

function printMessages(index = 0) {
    if (index >= messages.length) return;
    typeLine(messages[index], () => printMessages(index + 1));
}

openBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        consoleEl.style.display = 'flex';
        consoleBody.innerHTML = ''; 
        printMessages();
    });
});
closeBtn.addEventListener('click', () => {
    consoleEl.style.display = 'none';
});
