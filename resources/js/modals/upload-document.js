document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("uploadDocumentModal");
    if (!modal) return;

    const openButtons = document.querySelectorAll(
        "[data-open-upload-document-modal]"
    );
    const closeButtons = modal.querySelectorAll(
        "[data-close-upload-document-modal]"
    );

    openButtons.forEach((button) => {
        button.addEventListener("click", () => {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        });
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    });
});

function updateFileName(input) {
    const display = document.getElementById("fileNameDisplay");
    if (input.files && input.files[0]) {
        display.textContent = input.files[0].name;
    } else {
        display.textContent = "or drag and drop";
    }
}

// Toggle site selection based on storage type
const uploadStorage = document.getElementById("uploadStorage");
const siteSelection = document.getElementById("siteSelection");

if (uploadStorage && siteSelection) {
    uploadStorage.addEventListener("change", function () {
        if (this.value === "sharepoint") {
            siteSelection.style.display = "block";
        } else {
            siteSelection.style.display = "none";
        }
    });
}
