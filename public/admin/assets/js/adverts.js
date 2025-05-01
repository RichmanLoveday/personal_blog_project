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
        selectImage.next().next().text(`Image dimensions should be 690 x 85 pixels`);
    }

    if (selectedPosition === 'footer_banner') {
        selectImage.attr('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        selectImage.next().next().text(`Image dimensions should be 210 x 268 px`);
    }

    if (selectedPosition === 'whats_new_banner') {
        selectImage.attr('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        selectImage.next().next().text(`Image dimensions should be 610 x 90 px`);
    }

    if (selectedPosition === 'most_popular_banner') {
        selectImage.attr('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        selectImage.next().next().text(`Image dimensions should be 210 x 282 px`);
    }

    if (selectedPosition === 'featured_banner') {
        selectImage.attr('accept', 'image/png, image/jpeg, image/jpg, image/webp');
        selectImage.next().next().text(`Image dimensions should be 770 x 124 px`);
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
                         <div class="invalid-feedback"></div>
                                    <small class="text-muted mt-2 d-block"></small>
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


function removePlacement(ele, type = 'new') {
    if (type === 'edit') {
        const placementId = $(ele).data('placement-id');

        //? remeve placement from db
        $.ajax({
            url: `${BASE_URL}/admin/advert/placement/delete/${placementId}`,
            type: 'DELETE',
            method: 'DELETE',
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": csrf,
                "Accept": "application/json",
            },
            beforeSend: function () {
                $(ele).prop('disabled', true);
            },
            success: function (res) {
                console.log(res);
                if (res.status === 'success') {
                    //? Show success message
                    toastr.success(res.message);

                    //? remove the placement group
                    $(ele).closest('#placement-group').remove();
                }
            },
            error: function (xhr) {
                if (xhr.status === 500) {
                    toastr.error('An error occurred while deleting placement');
                    $(ele).prop('disabled', false);
                }
            }

        })
        return;
    }

    //? remove the placement group
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


async function validateForm(type = 'new') {
    let isValid = true;
    let positionPagePairs = new Set();
    const dimensionChecks = [];

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
        const isNewPlacement = !$(this).data('placement-id'); // Check if it's a new placement

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

        //? Validate image for new placements or when editing an existing placement with a new image
        if (isNewPlacement || imageFile) {
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
                    const p = new Promise((resolve) => {
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

                            //? resolve the promise to continue the loop
                            resolve();
                        };
                        img.src = URL.createObjectURL(imageFile);
                    });
                    dimensionChecks.push(p);
                }
            }
        }
    });

    // WAIT for *all* of the onload handlers before returning
    await Promise.all(dimensionChecks);
    return isValid;
}


async function submitForm(event) {
    event.preventDefault();

    if (! await validateForm()) {
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
            $('#btn-submit').prop('disabled', true);
            //? disable cloz
        },
        success: function (response) {
            if (response.status === 'success') {
                window.location.href = response.redirect_url;
            } else if (response.status === 'error') {
                toastr.error('An error occurred while creating advert!');
                $('#btn-submit').prop('disabled', false);
            }
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

            //? undisable button
            $('#btn-submit').prop('disabled', false);
        },
        complete: function () {
            $('#submit').prop('disabled', false).text('Submit');
            //? undisable button
            $('#btn-submit').prop('disabled', false);
        }

    })
}


async function updateAdvert(event) {
    event.preventDefault();

    if (! await validateForm('edit')) {
        console.error('Validation failed.');
        return;
    }

    let form = $('#advertForm')[0];
    let formData = new FormData(form);

    $.ajax({
        url: form.action,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        beforeSend: function () {
            $('#submit').prop('disabled', true).text('Submitting...');
            $('#btn-submit').prop('disabled', true);
            //? disable cloz
        },
        success: function (response) {
            if (response.status === 'success') {
                window.location.href = response.redirect_url;
            } else if (response.status === 'error') {
                toastr.error('An error occurred while creating advert!');
                $('#btn-submit').prop('disabled', false);
            }
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

            //? undisable button
            $('#btn-submit').prop('disabled', false);
        },
        complete: function () {
            $('#submit').prop('disabled', false).text('Submit');
            //? undisable button
            $('#btn-submit').prop('disabled', false);
        }

    })
}


$(document).ready(function () {
    // Initialize datetimepickers
    $('#start_date').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: false, // Important to prevent auto-selecting current date
        ignoreReadonly: true,
        minDate: $('#start_date').val() ? moment($('#start_date').val(), 'DD-MM-YYYY') : moment(), // Set minDate based on existing value or current date
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

    //? loop through all the placement groups and add event listener to each select element
    $('#placements #placement-group').each(function () {
        const positionSelect = $(this).find('.position-select');
        const pageSelect = $(this).find('.page-select');

        //? select page when position is selected
        selectPageWhenPageLoads(positionSelect, pageSelect);
    });
});


function selectPageWhenPageLoads(positionEle, pageEle) {

    //? check if selectedPosition is empty and add default option
    if (!positionEle) {
        pageEle.empty();
        pageEle.html('<option value="">Choose Page</option>');
        return;
    }

    //? search fror page based on selceted banner
    let selectedPagesValues = pages[positionEle.val()];

    //? update field based on selected banner
    let pageValues = `<option value="">Choose Page</option>`;
    $.each(selectedPagesValues, function (_, val) {
        console.log(val, pageEle.val())
        const isSelected = pageEle.val() === val ? 'selected' : '';
        pageValues += ` <option value="${val}" ${isSelected}>${val.charAt(0).toUpperCase() + val.slice(1)}</option>`;
    });

    //? clear page select
    pageEle.empty();
    pageEle.append(pageValues);
}

function updateStatus(ele, id, status) {
    $.ajax({
        url: `${BASE_URL}/admin/advert/updateStatus`,
        type: 'PUT',
        data: JSON.stringify({ id, status }),
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        beforeSend: function () {
            $(ele).prop('disabled', true);
        },
        success: function (res) {
            if (res.status === 'success') {
                toastr.success(res.message);
                updateStatusDom(ele, id, status);
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            if (xhr.status === 500) {
                toastr.error('An error occurred while updating status');
            }
        },
        complete: function () {
            $(ele).prop('disabled', false);
        }
    });
}


function updateStatusDom(ele, id, status) {
    //? get the status element and the status button element
    const wrapper = $(ele).closest('tr');
    const statusEle = wrapper.find('.status');
    const statusBtn = wrapper.find('.status-btn');

    //? declare the status text and background color based on the status
    const statusText = status === 'active' ? 'Active' : 'Inactive';
    const statusBg = status === 'active' ? 'bg-success' : 'bg-danger';
    const statusBtnText = status === 'active' ? 'Deactivate' : 'Activate';
    const statusBtnValue = status === 'active' ? 'in-active' : 'active';

    const html = `
        <span class="badge status ${statusBg}">${statusText}</span>
    `;

    //? remove the old status and add the new one
    statusEle.parent().empty().html(html);

    //? remove the old status button and add the new one
    statusBtn.parent().parent().empty().html(`
        <button onclick="updateStatus(this, ${id}, '${statusBtnValue}')" class="dropdown-item"><img
        src="${BASE_URL}/admin/assets/img/icons/eye1.svg"
        class="me-2 status-btn" alt="img">${statusBtnText} Advert</button>
    `);
}


function deleteAdvert(ele, id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `${BASE_URL}/admin/advert/delete/${id}`,
                type: 'DELETE',
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "Accept": "application/json",
                },
                beforeSend: function () {
                    $(ele).prop('disabled', true);
                },
                success: function (res) {
                    if (res.status === 'success') {
                        //? Show success message
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: res.message,
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 500) {
                        toastr.error('An error occurred while deleting advert');
                    }
                },
                complete: function () {
                    $(ele).prop('disabled', false);
                }
            });
        }
    })
}