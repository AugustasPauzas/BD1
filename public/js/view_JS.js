


// VIEW ITEM

document.querySelectorAll('#click_too_replace_main').forEach(image => {
    image.addEventListener('click', function() {
        let targetImage = document.getElementById('replace_image_item_view');

        if (targetImage) {
            targetImage.src = this.src;
        }
    });
});

$(document).ready(function () {
    
    document.querySelectorAll('#click_too_replace_main').forEach(image => {
        image.addEventListener('click', function() {

            let targetImage = document.getElementById('replace_image_item_view');

            if (targetImage) {
                targetImage.src = this.src;
            }
        });
    });
});

// F. View Item 
function view_item_image_menu_scroll_left() {
    const container = document.getElementById('imageContainer');
    const scrollAmount = container.clientWidth * 0.65; // 
    container.scrollBy({
        left: -scrollAmount,
        behavior: 'smooth'
    });
}

function view_item_image_menu_scroll_right() {
    const container = document.getElementById('imageContainer');
    const scrollAmount = container.clientWidth * 0.65; // 
    container.scrollBy({
        left: scrollAmount,
        behavior: 'smooth'
    });
}

// Item Quantity in item view
document.addEventListener('DOMContentLoaded', function() {
    const maxQuantity = document.getElementById('view_item_add_quantity').max;
    const inputField = document.getElementById('view_item_add_quantity');
    const increaseButton = document.getElementById('view_item_add_quantity_increaseButton');
    const decreaseButton = document.getElementById('view_item_add_quantity_decreaseButton');

    increaseButton.addEventListener('click', function() {
        let currentValue = parseInt(inputField.value);
        if (currentValue < maxQuantity) {
            inputField.value = currentValue + 1;
        }
    });

    decreaseButton.addEventListener('click', function() {
        let currentValue = parseInt(inputField.value);
        if (currentValue > 1) {
            inputField.value = currentValue - 1;
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {

    setTimeout(adjustHeight, 10);
    function adjustHeight() {
        const screenWidth = window.innerWidth;

        const sourceDiv = document.getElementById('sourceDiv');
        const targetDiv = document.getElementById('targetDiv');

        if (!sourceDiv || !targetDiv) {
            console.warn('sourceDiv or targetDiv not found. Stopping function.');
            window.removeEventListener('resize', adjustHeight); 
            return;
        }
        if (screenWidth >= 1200) {
            const sourceHeight = sourceDiv.getBoundingClientRect().height;
            targetDiv.style.height = sourceHeight + 'px';
        } else {
            targetDiv.style.height = 'auto';
        }
    }
    adjustHeight();
    setTimeout(adjustHeight, 10);
    setTimeout(adjustHeight, 100);
    setTimeout(adjustHeight, 320);
    setTimeout(adjustHeight, 500);
    window.addEventListener('resize', adjustHeight);
    });