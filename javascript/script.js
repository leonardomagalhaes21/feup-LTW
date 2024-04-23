
function validateForm() {
    let introduction = document.getElementById("introduction").value;
    let secondaryImages = document.getElementById("secondary_images").files;

    if (introduction.length > 50) {
        alert("Introduction cannot exceed 50 characters!");
        return false;
    }
    
    if (secondaryImages.length > 5) {
        alert("You can only upload 5 secondary images!");
        return false;
    }
    return true;
}


function previewMainImage(event) {
    const mainImage = document.getElementById('main_image_preview');
    mainImage.style.display = 'block';
    mainImage.src = URL.createObjectURL(event.target.files[0]);
}

function previewSecondaryImages(event) {
    const secondaryImagesDiv = document.getElementById('secondary_images_preview');
    secondaryImagesDiv.innerHTML = '';

    for (let i = 0; i < event.target.files.length; i++) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(event.target.files[i]);
        img.alt = 'Secondary Image Preview';
        img.style.width = '100px';
        img.style.height = '100px';
        img.style.objectFit = 'cover';
        img.style.borderRadius = '10px';
        img.style.marginRight = '1em';
        img.style.marginBottom = '1em';
        secondaryImagesDiv.appendChild(img);
    }
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
