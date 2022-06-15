// const chk = document.getElementById('chk');

// chk.addEventListener('change', () => {
// 	document.body.classList.toggle('dark');
// });

// $(document).on('click', '#chk', function() {
//     $('#nav').attr('data-background-color', $('#nav').attr('data-background-color')==='dark' ? 'blue2' : 'dark');
//     $('#side').attr('data-background-color', $('#side').attr('data-background-color')==='white' ? 'dark' : 'white');
//     $('#content').attr('data-background-color', $('#content').attr('data-background-color')==='dark' ? 'bg3' : 'dark');
// })


let darkMode = localStorage.getItem('darkMode');
// set new localStorage value
localStorage.setItem('darkMode', darkMode);
   // if (localStorage.getItem('darkMode') == null) {
// //   // if the above is 'dark' then apply .dark to the body
//   console.log(darkMode)
// // } else{
// }

const enableDarkMode = () => {
        $('#nav').attr('data-background-color','dark')
        $('#side').attr('data-background-color','dark')
        $('#content').attr('data-background-color','dark')
        localStorage.setItem('darkMode','dark');
};
const disableDarkMode = () => {
        $('#nav').attr('data-background-color','blue2')
        $('#side').attr('data-background-color','white')
        $('#content').attr('data-background-color','bg3')
        localStorage.setItem('darkMode', null);

};

if(localStorage.getItem('darkMode') == 'dark'){
    $('#chk').attr('checked', true);
    $('#nav, #side, #content').attr('data-background-color','dark')
        localStorage.setItem('darkMode','dark');
}else{
     $('#nav').attr('data-background-color','blue2')
        $('#side').attr('data-background-color','white')
        $('#content').attr('data-background-color','bg3')
        localStorage.setItem('darkMode', null);
}

$(document).on('change', '#chk', function() {
    darkMode = localStorage.getItem('darkMode');
    if($(this).prop('checked')){
        //enableDarkMode();
        $('#nav, #side, #content').attr('data-background-color','dark')
        localStorage.setItem('darkMode','dark');
    }else{
        //disableDarkMode();
        $('#nav').attr('data-background-color','blue2')
        $('#side').attr('data-background-color','white')
        $('#content').attr('data-background-color','bg3')
        localStorage.setItem('darkMode', null);
    }
})