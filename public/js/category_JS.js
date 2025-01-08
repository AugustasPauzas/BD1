
// Filter for Price
document.addEventListener('DOMContentLoaded', function() {
    var category_price_filter_slider = document.getElementById('category_price_filter_slider');

    if (!category_price_filter_slider) {
        console.error('Slider element not found');
        return;
    }

    var minPrice = parseFloat(category_price_filter_slider.getAttribute('data-min-price'));
    var maxPrice = parseFloat(category_price_filter_slider.getAttribute('data-max-price'));
    var set_minPrice = parseFloat(category_price_filter_slider.getAttribute('data-set-min-price'));
    var set_maxPrice = parseFloat(category_price_filter_slider.getAttribute('data-set-max-price'));

    noUiSlider.create(category_price_filter_slider, {
        start: [set_minPrice, set_maxPrice], 
        connect: true,
        range: {
            'min': minPrice,
            'max': maxPrice
        },
        step: 0.01,
        format: {
            to: function(value) {
                return value.toFixed(2);
            },
            from: function(value) {
                return parseFloat(value);
            }
        }
    });

    var category_price_filter_minPriceValue = document.getElementById('category_price_filter_minPriceValue');
    var category_price_filter_maxPriceValue = document.getElementById('category_price_filter_maxPriceValue');
    var categoryIdentifier = document.getElementById('category_identifier').value; 

    category_price_filter_minPriceValue.innerHTML = set_minPrice.toFixed(2);
    category_price_filter_maxPriceValue.innerHTML = set_maxPrice.toFixed(2);

    category_price_filter_slider.noUiSlider.on('update', function (values, handle) {
        if (handle === 0) {
            category_price_filter_minPriceValue.innerHTML = values[0];
        } else {
            category_price_filter_maxPriceValue.innerHTML = values[1];
        }
    });

    category_price_filter_slider.noUiSlider.on('change', function (values) {
        const minPrice = values[0];
        const maxPrice = values[1];
        let currentUrl = window.location.href;
        let baseUrl = currentUrl.split('?')[0];
        let existingFilters = currentUrl.split('?')[1] ? currentUrl.split('?')[1].split('&').filter(param => !param.startsWith('minPrice') && !param.startsWith('maxPrice') && !param.startsWith('page')).join('&') : '';
        if (existingFilters) {
            window.location.href = `${baseUrl}?${existingFilters}&minPrice=${minPrice}&maxPrice=${maxPrice}&page=1`;
        } else {
            window.location.href = `${baseUrl}?minPrice=${minPrice}&maxPrice=${maxPrice}&page=1`;
        }
    });
});



// FILTER the PARAMETERS values
function updateFilterUrl() {
    let currentUrl = window.location.href;

    let baseUrl = currentUrl.split('?')[0];

    let filters = [];

    document.querySelectorAll('.update_filter_button_url').forEach(function(checkbox) {
        if (checkbox.checked) {
            let parameterId = checkbox.getAttribute('data-parameter-id');
            let valueId = checkbox.getAttribute('data-value-id');
            filters.push(`fa[]=${parameterId}:${valueId}`);
        }
    });

    let filterString = filters.join('&');
    let priceFilters = currentUrl.split('?')[1] ? currentUrl.split('?')[1].split('&').filter(param => param.startsWith('minPrice') || param.startsWith('maxPrice')).join('&') : '';

    if (priceFilters) {
        if (filterString) {
            document.getElementById('apply_filter').href = `${baseUrl}?${priceFilters}&${filterString}`;
        } else {
            document.getElementById('apply_filter').href = `${baseUrl}?${priceFilters}`;
        }
    } else {
        if (filterString) {
            document.getElementById('apply_filter').href = `${baseUrl}?${filterString}`;
        } else {
            document.getElementById('apply_filter').href = baseUrl; 
        }
    }
    //console.log(filters);
}
