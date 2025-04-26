const csrf = $('meta[name="csrf-token"]').attr("content");

let placement = 0;
let pages = {
    top_banner: ['home', 'about', 'category', 'contact', 'blogs'],
    footer_banner: ['home', 'about', 'category', 'contact', 'blogs'],
    whats_new_banner: ['home', 'category'],
    most_popular_banner: ['home'],
    featured_banner: ['home'],
};

function getPagesForBanner(ele) {
    const wrapper = $(ele).closest('#placement-group');
    const pageSelect = wrapper.find('.page-select');
    const selectedPosition = $(ele).val();
    const selectImage = wrapper.find('.image');

    console.log(selectImage)

    //? check if selectedPosition is empty and add default option
    if (!selectedPosition) {
        pageSelect.empty();
        selectImage.next().empty();
        pageSelect.html('<option value="">Choose Page</option>');
        return;
    }

    //? search fror page based on selceted banner
    let selectedPagesValues = pages[selectedPosition];

    //? clear page select
    pageSelect.empty();

    //? update field based on selected banner
    let pageValues = `<option value="">Choose Page</option>`;
    $.each(selectedPagesValues, function (_, val) {
        pageValues += ` <option value="${val}">${val.charAt(0).toUpperCase() + val.slice(1)}</option>`
    });

    //console.log(pageValues);
    pageSelect.append(pageValues);

    //? show the size of image to be uploaded
    // console.log(selectedPosition)
    if (selectedPosition == 'top_banner') {
        selectImage.attr('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        selectImage.next().text(`Image dimensions should be 690 x 85 pixels`);
    }

    if (selectedPosition === 'footer_banner') {
        selectImage.attr('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        selectImage.next().text(`Image dimensions should be 210 x 268 px`);
    }

    if (selectedPosition === 'whats_new_banner') {
        selectImage.attr('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        selectImage.next().text(`Image dimensions should be 610 x 90 px`);
    }

    if (selectedPosition === 'most_popular_banner') {
        selectImage.attr('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        selectImage.next().text(`Image dimensions should be 210 x 282 px`);
    }

    if (selectedPosition === 'featured_banner') {
        selectImage.attr('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        selectImage.next().text(`Image dimensions should be 770 x 124 px`);
    }

    return;
}


function addMorePlacement(event) {
    event.preventDefault();

    placement++;
    let placementHtml = `
         <div id="placement-group" class="col-12 row mt-3">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group">
                    <label>Select Position</label>
                    <select onchange="getPagesForBanner(this)" id="placements.${placement}.position" name="placements[${placement}][position]" class="select form-select position-select"
                        name="position">
                        <option value="">Choose Position</option>
                        <option value="top_banner">Top Banner</option>
                        <option value="footer_banner">Footer Banner</option>
                        <option value="whats_new_banner">Whats New Banner</option>
                        <option value="most_popular_banner">Most Popular Banner</option>
                        <option value="featured_banner">Featured Banner</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group">
                    <label>Select Page</label>
                    <select class="select form-select page-select" id="placements.${placement}.page" name="placements[${placement}][page]">
                        <option value="">Choose Page</option>
                        <option value="draft">Draft</option>
                        <option value="published">Publish</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group">
                    <label>Add Placement Image</label>
                    <input type="file" id="placements.${placement}.image" name="placements[${placement}][image]" onchange="previewImage(this)"
                        class="form-control image">
                    <small class="text-muted mt-2 d-block"></small>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-between mx-3">
                <img id="preview_image" style=" width:50px;height:50px;" accept="image/*"
                    src="${BASE_URL}/admin/assets/img/icons/empty-image.png" alt="preview_image">
                <button type="button" class="btn btn-danger rounded-circle p-1"
                    onclick="removePlacement(this)" id="remove_placement_btn"><img
                        src="${BASE_URL}/admin/assets/img/icons/remove.png" alt=""
                        style="width:20px; height:20px;"></button>
            </div>
        </div>`;

    $('#placements').append(placementHtml);
}


function removePlacement(ele) {
    $(ele).closest('#placement-group').remove();
}


function previewImage(ele) {
    const wrapper = $(ele).closest('#placement-group');
    const preview_image = wrapper.find('#preview_image');

    let reader = new FileReader();
    reader.onload = (e) => {
        preview_image.attr('src', e.target.result);
    };
    reader.readAsDataURL($(ele)[0].files[0]);
}


function validateForm() {
    let isValid = true;
    let positionPagePairs = new Set();

    const advertTittle = $('#title');
    const advertUrl = $('#url');
    const startDate = $('#start_date');
    const endDate = $('#end_date');

    if (!advertTittle.val()) {
        advertTittle.addClass('is-invalid');
        advertTittle.next('.invalid-feedback').text('Advert title is required.');
        isValid = false;
    } else {
        advertTittle.removeClass('is-invalid');
        advertTittle.next('.invalid-feedback').text('');
    }

    if (!advertUrl.val()) {
        advertUrl.addClass('is-invalid');
        advertUrl.next('.invalid-feedback').text('Advert url is required.');
        isValid = false;
    } else {
        advertUrl.removeClass('is-invalid');
        advertUrl.next('.invalid-feedback').text('');
    }


    if (!startDate.val()) {
        startDate.addClass('is-invalid');
        startDate.next('.invalid-feedback').text('Start date is required.');
        isValid = false;
    } else {
        startDate.removeClass('is-invalid');
        startDate.next('.invalid-feedback').text('');
    }

    if (!endDate.val()) {
        endDate.addClass('is-invalid');
        endDate.next('.invalid-feedback').text('End date is required.');
        isValid = false;
    } else {
        endDate.removeClass('is-invalid');
        endDate.next('.invalid-feedback').text('');
    }



    $('#placements #placement-group').each(function () {
        const positionSelect = $(this).find('.position-select');
        const pageSelect = $(this).find('.page-select');
        const imageInput = $(this).find('.image');
        const position = positionSelect.val();
        const page = pageSelect.val();
        const imageFile = imageInput[0].files[0];

        //? Validate position
        if (!position) {
            isValid = false;
            positionSelect.addClass('is-invalid');
            positionSelect.next('.invalid-feedback').text('Position is required.');
        } else {
            positionSelect.removeClass('is-invalid');
            positionSelect.next('.invalid-feedback').text('');
        }

        //? Validate page
        if (!page) {
            isValid = false;
            pageSelect.addClass('is-invalid');
            pageSelect.next('.invalid-feedback').text('Page is required.');
        } else {
            pageSelect.removeClass('is-invalid');
            pageSelect.next('.invalid-feedback').text('');
        }

        //? Check for duplicate position and page pair
        if (position && page) {
            const pair = `${position}-${page}`;
            if (positionPagePairs.has(pair)) {
                isValid = false;
                pageSelect.addClass('is-invalid');
                pageSelect.next('.invalid-feedback').text('This position and page combination already exists.');
            } else {
                positionPagePairs.add(pair);
                pageSelect.removeClass('is-invalid');
                pageSelect.next('.invalid-feedback').text('');
            }
        }

        //? Validate image
        if (!imageFile) {
            isValid = false;
            imageInput.addClass('is-invalid');
            imageInput.next('.invalid-feedback').text('Advert image is required.');
        } else {
            const dimensions = {
                top_banner: { width: 690, height: 85 },
                footer_banner: { width: 210, height: 268 },
                whats_new_banner: { width: 610, height: 90 },
                most_popular_banner: { width: 210, height: 282 },
                featured_banner: { width: 770, height: 124 },
            };

            const requiredDimensions = dimensions[position];
            if (requiredDimensions) {

                const img = new Image();
                img.onload = function () {
                    if (this.width !== requiredDimensions.width || this.height !== requiredDimensions.height) {
                        isValid = false;

                        imageInput.addClass('is-invalid');
                        imageInput.next().next().text(
                            `Image dimensions must be ${requiredDimensions.width} x ${requiredDimensions.height} pixels, but you provided ${this.width} x ${this.height} pixels.`
                        );
                    } else {
                        imageInput.removeClass('is-invalid').next().next().removeClass('is-invalid');
                        imageInput.next().next().text('');
                    }
                };
                img.src = URL.createObjectURL(imageFile);
            }
        }
    });

    return isValid;
}

function submitForm(event) {
    event.preventDefault();

    if (!validateForm()) {
        console.error('Validation failed.');
        return;
    }

    let form = $('#advertForm')[0];
    let formData = new FormData(form);

    $.ajax({
        url: form.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        beforeSend: function () {
            $('#submit').prop('disabled', true).text('Submitting...');
            //? disable placement remove buttons
            $('#remove_placement_btn').prop('disabled', true);
        },
        success: function (response) {
            $('#remove_placement_btn').prop('disabled', true);
            console.log(response);
            // Handle success response
        },
        error: function (xhr, status, error) {
            console.log(status);
            console.log(xhr);
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    const ele = $(`[id="${key}"]`);
                    ele.addClass('is-invalid');
                    ele.next('.invalid-feedback').text(value[0]);
                });
            } else if (status === 500) {
                toastr.error('An error occured while creating advert');
            }

            $('#remove_placement_btn').prop('disabled', false);
        },
        complete: function () {
            $('#submit').prop('disabled', false).text('Submit');
        }

    })
}


$(document).ready(function () {
    // Initialize datetimepickers
    $('#start_date').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: false, // Important to prevent auto-selecting current date
        ignoreReadonly: true,
        minDate: moment(), // Disable previous days
    });

    $('#end_date').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: false,
        ignoreReadonly: true,
    });

    //? When start date is selected, update end date's minDate
    $("#start_date").on("dp.change", function (e) {
        $('#end_date')
            .prop('disabled', false)
            .val("")
            .data("DateTimePicker").minDate(e.date);
    });
});
