//? get CSRF token
const csrfToken = $('meta[name="csrf-token"]').attr("content");

//? Function to Update Category Status
const updateTagStatus = async (ele, id, status) => {

    $.ajax({
        url: `${BASE_URL}/admin/tag/statusUpdate`,
        method: "PUT",
        contentType: "application/json",
        data: JSON.stringify({ id, status }),
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Accept": "application/json",
        },
        beforeSend: function () {
            //    $(ele)
        },
        success: function (res) {
            console.log(res);
            if (res.status == 'success') {
                let target = $(ele);

                if (target.hasClass('enable')) {
                    target.css({ display: "none" })
                        .parent().next().children().first().css({ display: "block" });

                    let prevTd = target.parents('td').prev().prev();
                    prevTd.empty();
                    prevTd.html('<span class="badge bg-success">active</span>');

                } else {
                    target.css({ display: "none" })
                        .parent().prev().children().first().css({ display: "block" });

                    let prevTd = target.parents('td').prev().prev();
                    prevTd.empty();
                    prevTd.html('<span class="badge bg-danger">in-active</span>');
                }

                toastr.success(res.message);
            }
        },
        error: function (xhr) {
            toastr.error("Something went wrong!");
            console.log(xhr);
        }
    });
};


function deleteTag(ele, id) {
    console.log('Reached');

    //? Show confirmation alert
    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to reverse this tag!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $(ele).prop('disabled', true); //? Disable button

            $.ajax({
                url: `${BASE_URL}/admin/tag/delete/${id}`,
                method: 'DELETE',
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
                success: function (res) {
                    console.log(res);
                    if (res.status === 'success') {
                        // Show success message
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


async function deleteCategory(id) {
    //? Show confirmation alert
    const result = await swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to reverse this category!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`${BASE_URL}/admin/category/delete/${id}`, {
                method: 'DELETE',
                credentials: "include",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                },
            });

            if (!response.ok) {
                let data = await response.json();
                throw new Error(data.message);
            }

            //? Show success message
            await swalWithBootstrapButtons.fire({
                title: "Deleted!",
                text: "Category deleted successfully.",
                icon: "success"
            });

            location.reload();
        } catch (error) {
            console.error("Error deleting category:", error);
            await swalWithBootstrapButtons.fire({
                title: "Error!",
                text: "Failed to delete the category.",
                icon: "error"
            });
        }
    }
}
