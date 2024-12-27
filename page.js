const link = document.querySelector("a");

link.addEventListener("click", (e)=>{
    e.preventDefault();
    console.log("로그인!")
});
