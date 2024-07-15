// check for saved 'darkMode' in localStorage
let darkMode = localStorage.getItem('darkMode'); 

const darkModeToggle = document.querySelector('#dark-mode-toggle');

const enableDarkMode = () => {
  // 1. Add the class to the body
  document.body.classList.add("dark-mode");
  document.querySelector('.wrapper').classList.add('dark-mode');
  //   dark mode header
  document.querySelector('.main-header').classList.remove('navbar-white');
  document.querySelector('.main-header').classList.add('navbar-dark');
  //   dark mode sidebar
  document.querySelector('.main-sidebar').classList.remove('sidebar-light-blue');
  document.querySelector('.main-sidebar').classList.add('sidebar-dark-orange');
  //   dark mode icon
  document.querySelector('.darkicon').classList.remove('fa-sun');
  document.querySelector('.darkicon').classList.add('fa-moon');
  //   dark mode text
  document.querySelector('.darktext').innerHTML= 'Dark';
  
  // 2. Update darkMode in localStorage
  localStorage.setItem('darkMode', 'enabled');
}

const disableDarkMode = () => {
    // 1. Remove the class from the body
    document.body.classList.remove("dark-mode");
    document.querySelector('.wrapper').classList.remove('dark-mode');
    //   remove dark mode header
    document.querySelector('.main-header').classList.remove('navbar-dark');
  document.querySelector('.main-header').classList.add('navbar-white');
  //   dark mode sidebar
  document.querySelector('.main-sidebar').classList.remove('sidebar-dark-orange');
  document.querySelector('.main-sidebar').classList.add('sidebar-light-blue');
  //   dark mode icon
  document.querySelector('.darkicon').classList.remove('fa-moon');
  document.querySelector('.darkicon').classList.add('fa-sun');
  //   dark mode text
  document.querySelector('.darktext').innerHTML= 'Light';
  // 2. Update darkMode in localStorage 
  localStorage.setItem('darkMode', null);
}
 
// If the user already visited and enabled darkMode
// start things off with it on
if (darkMode === 'enabled') {
  enableDarkMode();
}

// When someone clicks the button
darkModeToggle.addEventListener('click', () => {
  // get their darkMode setting
  darkMode = localStorage.getItem('darkMode'); 
  
  // if it not current enabled, enable it
  if (darkMode !== 'enabled') {
    enableDarkMode();
  // if it has been enabled, turn it off  
  } else {  
    disableDarkMode(); 
  }
});