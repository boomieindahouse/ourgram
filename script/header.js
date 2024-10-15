const noti_tg = document.querySelector('.noti_tg');
const dropdown_noti = document.querySelector('.dropdown_noti');
noti_tg.addEventListener('click', function(){
    console.log("click");
    dropdown_noti.classList.toggle('noti-active');
});