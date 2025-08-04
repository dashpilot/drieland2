<?php
// Display images from the article's img folder if it exists
if (!empty($folderName)) {
    $imgDir = __DIR__ . '/../article/' . $folderName . '/img/';
    $imgUrlPath = '/article/' . $folderName . '/img/';
    
    if (is_dir($imgDir)) {
        // Get all image files
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $images = [];
        
        foreach (scandir($imgDir) as $file) {
            if ($file !== '.' && $file !== '..') {
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($ext, $imageExtensions)) {
                    $images[] = $file;
                }
            }
        }
        
        // Display images if any were found
        if (!empty($images)) {
            echo '<div class="image-gallery">';

            echo '<div class="gallery-grid">';
            
                         foreach ($images as $index => $image) {
                 $imagePath = $imgUrlPath . $image;
                 $altText = pathinfo($image, PATHINFO_FILENAME);
                 echo '<div class="gallery-item">';
                 echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($altText) . '" onclick="openModal(' . $index . ')" />';
                 echo '</div>';
             }
             
             // Store images array in JavaScript
             echo '<script>';
             echo 'window.galleryImages = ' . json_encode(array_map(function($img) use ($imgUrlPath) {
                 return $imgUrlPath . $img;
             }, $images)) . ';';
             echo '</script>';
            
            echo '</div>';
            echo '</div>';
        }
    }
}
?>

<!-- Modal for full-size image viewing -->
<div id="imageModal" class="modal" onclick="closeModal()">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-nav prev" onclick="event.stopPropagation(); prevImage()">&lt;</div>
    <div class="modal-nav next" onclick="event.stopPropagation(); nextImage()">&gt;</div>
    <img class="modal-content" id="modalImage">
    <div class="modal-counter" id="modalCounter"></div>
</div>

<script>
let currentImageIndex = 0;

function openModal(imageIndex) {
    currentImageIndex = imageIndex;
    const modal = document.getElementById('imageModal');
    showCurrentImage();
    modal.classList.add('show');
}

function closeModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('show');
}

function showCurrentImage() {
    if (window.galleryImages && window.galleryImages.length > 0) {
        const modalImage = document.getElementById('modalImage');
        const modalCounter = document.getElementById('modalCounter');
        
        modalImage.src = window.galleryImages[currentImageIndex];
        modalCounter.textContent = `${currentImageIndex + 1} / ${window.galleryImages.length}`;
        
        // Hide/show navigation arrows based on position
        const prevArrow = document.querySelector('.modal-nav.prev');
        const nextArrow = document.querySelector('.modal-nav.next');
        
        prevArrow.style.display = currentImageIndex > 0 ? 'block' : 'none';
        nextArrow.style.display = currentImageIndex < window.galleryImages.length - 1 ? 'block' : 'none';
    }
}

function prevImage() {
    if (currentImageIndex > 0) {
        currentImageIndex--;
        showCurrentImage();
    }
}

function nextImage() {
    if (window.galleryImages && currentImageIndex < window.galleryImages.length - 1) {
        currentImageIndex++;
        showCurrentImage();
    }
}

// Handle keyboard navigation
document.addEventListener('keydown', function(event) {
    const modal = document.getElementById('imageModal');
    
    if (modal.classList.contains('show')) {
        switch(event.key) {
            case 'Escape':
                closeModal();
                break;
            case 'ArrowLeft':
                event.preventDefault();
                prevImage();
                break;
            case 'ArrowRight':
                event.preventDefault();
                nextImage();
                break;
        }
    }
});
</script>

<div class="text-center">
<a href="/" class="read-more">Terug naar Drieland</a>
</div>


</body>
</html>