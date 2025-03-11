/*---------------------DROPDOWN JS FOR DASHBOARD----------------------*/
const optionMenu = document.querySelector(".select-menu"),
       selectBtn = optionMenu.querySelector(".select-btn"),
       options = optionMenu.querySelectorAll(".option"),
       sBtn_text = optionMenu.querySelector(".sBtn-text");

selectBtn.addEventListener("click", () => optionMenu.classList.toggle("active"));       

options.forEach(option =>{
    option.addEventListener("click", ()=>{
        let selectedOption = option.querySelector(".option-text").innerText;
        sBtn_text.innerText = selectedOption;

        optionMenu.classList.remove("active");
    });
});

const sidenavoptionMenu = document.querySelector(".sidenav-menu"),
       sidenavBtn = sidenavoptionMenu.querySelector(".sidenav-btn"),
       sidenavoptions = sidenavoptionMenu.querySelectorAll(".sidenavoption"),
       snavtntext = sidenavoptionMenu.querySelector(".snavtn-text");
sidenavBtn.addEventListener("click", () => sidenavoptionMenu.classList.toggle("active"));       
sidenavoptions.forEach(sidenavoption =>{
    sidenavoption.addEventListener("click", ()=>{
        let selectedOption = option.querySelector(".snavoption-text").innerText;
        snavtntext.innerText = selectedOption;
        sidenavoptionMenu.classList.remove("active");
    });
});
