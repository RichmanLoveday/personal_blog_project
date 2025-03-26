CKEDITOR.replace('description1');
const csrf = $('meta[name="csrf-token"]').attr("content");

//? add tags
let tags = [];

function addTag(ele) {
    let tagInput = $('#tagInput');
    let tagValue = tagInput.val().trim();

    if (!tagValue) {
        toastr.error('Please select a tag');
        return;
    }

    //? check if tag is added already
    if (tags.includes(tagValue)) {
        toastr.error('Tag already added');
        return;
    }

    //? Check if tag already exists in UI
    let tagExists = $('#tags-container span').filter(function () {
        return $(this).text().trim().toLowerCase() === tagValue.toLowerCase();
    }).length > 0;

    console.log(tagExists)
    if (tagExists) {
        toastr.error('Tag already added');
        return;
    }

    //? add tag id to array
    tags.push(tagValue);

    //? add tag UI
    $('#tags-container').append(`
         <div class="d-flex badge align-items-center bg-light bg-success justify-content-center rounded-full text-dark fw-bold gap-2">
            <span>${tagValue}</span>
            <span style="width:20px; height:20px; cursor:pointer" onclick="removeTag(this, '${tagValue}')">
                <img src="${BASE_URL}/admin/assets/img/icons/multiply.png" />
            </span>
        </div>
    `);

    //? clear input
    tagInput.val('');
}


function searchTag(ele) {
    const input = $(ele).val();
    const role = $(ele).data('role');
    let url = `${BASE_URL}/admin/tags/search/${input}`;

    if (role == 'author') {
        url = `${BASE_URL}/author/tags/search/${input}`;
    }

    $.ajax({
        url: url,
        type: 'GET',
        contentType: 'application/json',
        success: function (res) {
            if (res.status == 'success') {
                let tags = res.tags;
                console.log(tags);
                $('#tagSuggestions')
                    .html(
                        tags.map(tag => `<option value="${tag.name}">${tag.name}</option>`).join('')
                    );
            }
        },
        error: function (res) { }
    })
}


function removeTag(ele, value) {
    removeIndex(value, tags);
    $(ele).closest('div').remove();
}


function removeIndex(value, array) {
    const index = array.indexOf(value);
    if (index > -1) {
        array.splice(index, 1);
    }
    return;
}


function addNewArticle(e) {
    e.preventDefault();

    // console.log($(e));
    let articleContent = CKEDITOR.instances['description1'].getData().trim();
    let image = $('#image')[0].files;
    let error = false;

    //? validate ck editor
    if (articleContent == '') {
        toastr.error('Article content is required');
        error = true;
    }

    //? article image
    if (image.length == 0) {
        toastr.error('Please select an image');
        error = true;
    }

    //? validate article title
    if (!$('#title').val()) {
        toastr.error('Please enter article title');
        error = true;
    }

    //? validate category
    if (!$('#category').val()) {
        toastr.error('Please select category');
        error = true;
    }

    //? validate aricle status
    if (!$('#status').val()) {
        toastr.error('Please select status');
        error = true;
    }


    if (!error) {
        let form = $('#articleForm')[0];
        let formData = new FormData(form);
        formData.append('tags', tags);

        $.ajax({
            url: $('#articleForm').attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": csrf,
                "Accept": "application/json",
            },
            beforeSend: function (res) {
                $('#btn-submit').prop('disabled', true).html(`<span class="spinner-border text-white" role="status"></span>`);
                toastr.info('Uploading article. Please wait....');
            },
            success: function (res) {
                console.log(res);
                if (res.status == 'success') {
                    toastr.success(res.message);
                    $('#articleForm')[0].reset();
                    $('#btn-submit').prop('disabled', false).text('Submit');

                    //? empty tag array and ui
                    tags = [];
                    $('#tags-container').empty();
                    CKEDITOR.instances['description1'].setData('');
                }
            },
            error: function (xhr) {
                console.log(xhr);
                if (xhr.status == 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, messages) {
                        //? loop through messages
                        messages.forEach(message => {
                            toastr.error(message);
                        });
                    });

                } else {
                    toastr.error('An error occured while uploading article');
                }

                $('#btn-submit').prop('disabled', false).text('Submit');
            }
        });
    }
}


function updatePublishment(ele, id, status, role) {
    const url = role == 'author' ? `${BASE_URL}/author/article/publishment` : `${BASE_URL}/admin/article/publishment`;

    $.ajax({
        url: url,
        method: "PUT",
        contentType: "application/json",
        data: JSON.stringify({ id, status }),
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        success: function (res) {
            console.log(res);
            if (res.status == 'success') {
                status = status == 'publish' ? 'unpublish' : 'publish';
                role = role == 'author' ? 'author' : 'admin';

                //?update the publish at column
                $(ele).closest('tr')
                    .children('#published_date')
                    .empty()
                    .text(res.article.published_at ? formatDate(res.article.published_at) : 'Not Published')

                let html = `<a onclick="updatePublishment(this, '${id}', '${status}', '${role}')"
                            class="dropdown-item"><img src="${BASE_URL}/admin/assets/img/icons/eye1.svg" class="me-2" alt="img">${status} Article</a>`;

                $(ele).parent().empty().html(html);
                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
        },
        error: function (res) {
            console.log(res);
        }
    });
}


function deleteArtcile(ele, id, role) {
    const url = role == 'author' ? `${BASE_URL}/author/article/delete/${id}` : `${BASE_URL}/admin/article/delete/${id}`;

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to reverse this article!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $(ele).prop('disabled', true); //? Disable button

            $.ajax({
                url: url,
                method: 'DELETE',
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "Accept": "application/json",
                },
                success: function (res) {
                    console.log(res);
                    if (res.status === 'success') {
                        //? Show success message
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: res.message,
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function (xhr) {
                    console.error(xhr);
                    swalWithBootstrapButtons.fire({
                        title: "Oops...",
                        text: "Something went wrong!",
                        icon: "error"
                    });
                    $(ele).prop('disabled', false);
                }
            });
        }
    });
}


function updateNewsType(ele, id, newsType, role) {
    const url = role == 'author' ? `${BASE_URL}/author/article/updateNewsType` : `${BASE_URL}/admin/article/updateNewsType`;
    const value = $(ele).attr('value');

    $.ajax({
        url: url,
        method: "PUT",
        contentType: "application/json",
        data: JSON.stringify({ id, newsType, value }),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Accept": "application/json",
        },
        success: function (res) {
            console.log(res);
            if (res.status == 'success') {
                let article = res.article;
                console.log(article)
                if (newsType == 'is_trending') $(ele).attr('value', +article.is_trending ? 0 : 1);
                if (newsType == 'is_featured') $(ele).attr('value', +article.is_featured ? 0 : 1);

                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
        },
        error: function (res) {
            console.log(res);
        }
    });
}

function deleteTag(ele, id, articleId, role) {
    const url = role == 'author' ? `${BASE_URL}/author/tag/delete/${id}/${articleId}` : `${BASE_URL}/admin/article/tag/delete/${id}/${articleId}`;

    $.ajax({
        url: url,
        method: 'DELETE',
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        success: function (res) {
            if (res.status == 'success') {
                $(ele).closest('div').remove();
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            toastr.error('An error occured while removing tag');
        }
    });
}


function updateArticle(e) {
    e.preventDefault();

    // console.log($(e));
    let articleContent = CKEDITOR.instances['description1'].getData().trim();
    let error = false;

    //? validate ck editor
    if (articleContent == '') {
        toastr.error('Article content is required');
        error = true;
    }


    //? validate article title
    if (!$('#title').val()) {
        toastr.error('Please enter article title');
        error = true;
    }

    //? validate category
    if (!$('#category').val()) {
        toastr.error('Please select category');
        error = true;
    }

    //? validate aricle status
    if (!$('#status').val()) {
        toastr.error('Please select status');
        error = true;
    }


    if (!error) {
        let form = $('#articleForm')[0];
        let formData = new FormData(form);
        formData.append('tags', tags);
        //form.append('_method', 'PUT');

        $.ajax({
            url: $('#articleForm').attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": csrf,
                "Accept": "application/json",
            },
            beforeSend: function (res) {
                $('#btn-submit').prop('disabled', true).html(`<span class="spinner-border text-white" role="status"></span>`);
                toastr.info('Updating article. Please wait....');
            },
            success: function (res) {
                console.log(res);
                if (res.status == 'success') {
                    toastr.success(res.message);
                    $('#btn-submit').prop('disabled', false).text('Submit');
                }
            },
            error: function (xhr) {
                console.log(xhr);
                if (xhr.status == 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, messages) {
                        //? loop through messages
                        messages.forEach(message => {
                            toastr.error(message);
                        });
                    });

                } else {
                    toastr.error('An error occured while uploading article');
                }

                $('#btn-submit').prop('disabled', false).text('Submit');
            }
        });
    }
}


function updateSlider(ele, id) {
    const value = $(ele).attr('value');

    $.ajax({
        url: `${BASE_URL}/admin/article/slider`,
        method: "PUT",
        contentType: "application/json",
        data: JSON.stringify({ id, value }),
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        success: function (res) {
            if (res.status == 'success') {
                $(ele).closest('tr')
                    .children('#slider')
                    .find('input')
                    .attr('value', +res.article.is_slider ? 0 : 1);

                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            console.log(xhr);
            if (xhr.status == 500) {
                toastr.error(xhr.responseJSON.message);

                //? uncheck button
                $(ele).prop('checked', false);
            }
        }
    });
}


function updateStatus(ele, id, status) {
    $.ajax({
        url: `${BASE_URL}/admin/article/updateStatus`,
        method: "PUT",
        contentType: "application/json",
        data: JSON.stringify({ id, status }),
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        success: function (res) {
            if (res.status == 'success') {
                let value = status == 'active' ? 'in-active' : 'active';
                let display = status == 'active' ? 'Disable' : 'Enable';

                $(ele).closest('tr')
                    .children('#status')
                    .empty()
                    .html(status == 'active' ? `<span class="badge bg-success fw-bold">active</span>` : `<span class="badge bg-danger fw-bold">in-active</span>`);

                let html = `<a onclick="updateStatus(this, '${id}', '${value}')"
                    class="dropdown-item"><img src="${BASE_URL}/admin/assets/img/icons/eye1.svg" class="me-2" alt="img">${display}</a>`;

                $(ele).parent().empty().html(html);

                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            console.log(xhr);
            if (xhr.status == 500) {
                toastr.error(xhr.responseJSON.message);

                //? uncheck button
                $(ele).prop('checked', false);
            }
        }
    });
}

function updateBannerTop(ele, id) {
    const value = $(ele).attr('value');

    $.ajax({
        url: `${BASE_URL}/admin/article/updateBannerTop`,
        method: "PUT",
        contentType: "application/json",
        data: JSON.stringify({ id, value }),
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        success: function (res) {
            if (res.status == 'success') {
                $(ele).closest('tr')
                    .children('#banner_right_top')
                    .find('input')
                    .attr('value', +res.article.is_banner_right_top ? 0 : 1);

                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            console.log(xhr);
            if (xhr.status == 500) {
                toastr.error(xhr.responseJSON.message);

                //? uncheck button
                $(ele).prop('checked', false);
            }
        }
    });
}

function updateBannerBottom(ele, id) {
    const value = $(ele).attr('value');

    $.ajax({
        url: `${BASE_URL}/admin/article/updateBannerBottom`,
        method: "PUT",
        contentType: "application/json",
        data: JSON.stringify({ id, value }),
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        success: function (res) {
            if (res.status == 'success') {
                $(ele).closest('tr')
                    .children('#banner_right_bottom')
                    .find('input')
                    .attr('value', +res.article.is_banner_right_bottom ? 0 : 1);

                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
        },
        error: function (xhr) {
            console.log(xhr);
            if (xhr.status == 500) {
                toastr.error(xhr.responseJSON.message);

                //? uncheck button
                $(ele).prop('checked', false);
            }
        }
    });
}

function previewImage(ele) {
    let reader = new FileReader();
    reader.onload = (e) => {
        $('#preview_image').attr('src', e.target.result);
    };
    reader.readAsDataURL($(ele)[0].files[0]);
}



$(document).ready(function () {
    // Initialize datetimepickers
    $('#startDate').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: false, // Important to prevent auto-selecting current date
        ignoreReadonly: true,
    });

    $('#endDate').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: false,
        ignoreReadonly: true,
    });

    //? When start date is selected, update end date's minDate
    $("#startDate").on("dp.change", function (e) {
        $('#endDate')
            .prop('disabled', false)
            .val("")
            .data("DateTimePicker").minDate(e.date);
    });
});


