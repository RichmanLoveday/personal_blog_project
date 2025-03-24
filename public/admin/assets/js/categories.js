//? get CSRF token
const csrfToken = $('meta[name="csrf-token"]').attr("content");

//? Function to Update Category Status
const updateCategoryStatus = async (event, id, status) => {

    try {
        // ? disbale button
        $(event).addClass('disabled');

        const response = await fetch(`http://localhost:8000/admin/category/statusUpdate/${id}/${status}`, {
            method: "PUT",
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

        const data = await response.json();
        toastr.success(data.message);

        //? enable button
        $(event).removeClass('disabled');

        //? hide enable button and show disabled button
        let target = $(event);

        if (target.hasClass('enable')) {
            target.css({ display: "none" })
                .parent().next().children().first().css({ display: "block" });

            let prevTd = target.parents('td').prev().prev();
            prevTd.empty();
            prevTd.html('<span class="badges bg-lightgreen">Enabled</span>');

        } else {
            target.css({ display: "none" })
                .parent().prev().children().first().css({ display: "block" });

            let prevTd = target.parents('td').prev().prev();
            prevTd.empty();
            prevTd.html('<span class="badges bg-lightred">Disabled</span>');
        }
        //? change status field

    } catch (error) {
        console.error(error.message);
        toastr.error(error.message);

        //? enable button
        $(event).removeClass('disabled');
    }
};




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
            const response = await fetch(`http://localhost:8000/admin/category/delete/${id}`, {
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
