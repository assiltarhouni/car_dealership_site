let userBox = document.querySelector('.header .flex .account-box');
let navbar = document.querySelector('.header .flex .navbar');

let prevScrollPos = window.scrollY;

document.querySelector('#user-btn').onclick = () => {
    userBox.classList.toggle('active');
    navbar.classList.remove('active');
}

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    userBox.classList.remove('active');
}

window.onscroll = () => {
    let currentScrollPos = window.scrollY;

    if (prevScrollPos > currentScrollPos) {
        
        navbar.classList.add('active');
    } else {
        
        navbar.classList.remove('active');
    }

    
    prevScrollPos = currentScrollPos;

    
    userBox.classList.remove('active');
}
