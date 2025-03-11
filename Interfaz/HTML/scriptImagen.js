const input = document.getElementById("file-input");
const image = document.getElementById("img-preview");

input.addEventListener("change", (e)=>{
    if(e.target.files.length){
        const src = URL.createObjectURL(e.target.files[0]);
        image.src = src;
    }
});

//Toast
function showToast(){
    var toast = document.getElementById("toast");
    toast.className = "show";
    setTimeout(function(){toast.className = toast.className.replace("show", "");},3000);
}