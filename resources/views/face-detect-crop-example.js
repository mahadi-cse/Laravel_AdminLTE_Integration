// Face detection and cropping logic using face-api.js and Cropper.js
// Requirements: face-api.js, cropperjs, Bootstrap modal, and an <img> for cropping

// DOM elements
const fileInput = document.getElementById('profile-photo');
const cropperImage = document.getElementById('cropper-image');
const previewWrapper = document.getElementById('photo-preview-wrapper');
const previewImage = document.getElementById('photo-preview');
const cropConfirmBtn = document.getElementById('cropConfirmBtn');
const croppedImageInput = document.getElementById('cropped-image');
let cropper = null;

// Load face-api.js model from local weights directory
Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('/face-api/weights'),
]).then(function () {
    // Ready for face detection
});

// Handle file input change
fileInput.addEventListener('change', async function (e) {
    const file = e.target.files[0];
    if (file && file.type.startsWith('image/')) {
        // Remove previous error if any
        let errorDiv = document.getElementById('photo-face-error');
        if (errorDiv) errorDiv.remove();
        fileInput.classList.remove('is-invalid');
        // Read image as data URL
        const reader = new FileReader();
        reader.onload = async function (event) {
            // Resize image to 300x300 before face detection and cropping
            const img = new window.Image();
            img.onload = async function () {
                // Create a canvas to resize
                const canvas = document.createElement('canvas');
                canvas.width = 300;
                canvas.height = 300;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, 300, 300);
                const resizedDataUrl = canvas.toDataURL('image/png');
                cropperImage.src = resizedDataUrl;
                cropperImage.onload = async function () {
                    // Wait for face-api.js to be ready
                    if (typeof faceapi === 'undefined' || !faceapi.nets.tinyFaceDetector.params) {
                        setTimeout(() => cropperImage.onload(), 200);
                        return;
                    }
                    // Detect face
                    const detections = await faceapi.detectAllFaces(cropperImage, new faceapi.TinyFaceDetectorOptions());
                    if (!detections || detections.length === 0) {
                        fileInput.value = '';
                        fileInput.classList.add('is-invalid');
                        const error = document.createElement('div');
                        error.id = 'photo-face-error';
                        error.className = 'invalid-feedback d-block';
                        error.innerText = 'Face not found in the selected image.';
                        fileInput.parentNode.appendChild(error);
                        return;
                    }
                    // Show Bootstrap modal for cropping
                    const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
                    modal.show();
                    modal._element.addEventListener('shown.bs.modal', () => {
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 1,        // Square crop
                            viewMode: 1,
                            autoCropArea: 1
                        });
                    }, { once: true });
                };
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Handle crop confirmation
cropConfirmBtn.addEventListener('click', () => {
    if (cropper) {
        // Get cropped image as a 200x200 PNG data URL
        const canvas = cropper.getCroppedCanvas({ width: 200, height: 200 });
        const dataUrl = canvas.toDataURL('image/png');
        previewImage.src = dataUrl;
        previewWrapper.style.display = 'block'; // Show preview only after cropping
        croppedImageInput.value = dataUrl;

        // Hide modal
        const modalElement = document.getElementById('cropperModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        modal.hide();
    }
});
