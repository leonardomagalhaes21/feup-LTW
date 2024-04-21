
function validateForm() {
    let secondaryImages = document.getElementById("secondary_images").files;
    
    if (secondaryImages.length > 5) {
        alert("You can only upload 5 secondary images!");
        return false;
    }
    return true;
}


function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    let slides = document.getElementsByClassName("image-slide");

    if (n > slides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides.length}
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    slides[slideIndex-1].style.display = "block";  
}

let slideIndex = 1;
showSlides(slideIndex);
