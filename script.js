function myFunction(x) {
    x.classList.toggle("change");
}

function toggleSideNav() {
    const sideNav = document.getElementById("mySidenav");
    const menuBtn = document.querySelector(".menu");
  
    // Check if the side nav is open (width equals "250px")
    if (sideNav.style.width === "250px") {
      // Close side nav and remove the transformation class
      sideNav.style.width = "0";
      menuBtn.classList.remove("change");
    } else {
      // Open side nav and add the transformation class
      sideNav.style.width = "250px";
      menuBtn.classList.add("change");
    }
  }
  



document.addEventListener("DOMContentLoaded", () => {
    const faqButton = document.getElementById("faqButton");
    const faqContent = document.getElementById("faqContent");

    faqButton.addEventListener("click", () => {
        // Toggle the 'expand' class to show/hide the dropdown content
        faqContent.classList.toggle("expand");
    });

    // Optional: Close other dropdowns if one is opened
    document.addEventListener("click", (event) => {
        if (!faqButton.contains(event.target) && !faqContent.contains(event.target)) {
            faqContent.classList.remove("expand");
        }
    });
});



function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "white";
}



