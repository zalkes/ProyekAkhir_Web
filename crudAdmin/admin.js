const hamburger = document.querySelector(".hamburger-admin")
const sidebarAdmin = document.querySelector(".menu-sidebar-admin")
function sideBar(){
    sidebarAdmin.classList.toggle("active");
}

window.addEventListener("click", (event) => {
    if (!hamburger.contains(event.target) && !sidebarAdmin.contains(event.target)) {
        sidebarAdmin.classList.remove("active");
    }
});

function closeSidebar(){
    const close = document.getElementById("close")
    sidebarAdmin.classList.remove("active");
}

function limit_size(event){
    const limit = 3 * 1024 *1024;
    var file = event.target.files[0];
    var path = URL.createObjectURL(event.target.files[0]);
    var photo = document.getElementById("photo").value;
    var title = document.getElementById("title-picture");
    var image = document.getElementById("up-picture");
    var ext = file.name.split(".").pop();

    if (file.size > limit){
        alert("Maksimal File adalah 3 MB");
        event.target.value = "";
        return;
    }

    if (ext == "png" || ext == "jpg" || ext =="jpeg"){
        if (photo){
            image.style.display = "block";
            title.style.display = "none";
            image.src = path;
            console.log(ext);
            return;
        }
    }

    alert("Ekstensi File Harus png, jpg, jpeg");
}