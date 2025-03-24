//? get CSRF token
const csrfToken = $('meta[name="csrf-token"]').attr("content");
console.log(csrfToken);
//? Function to Update Category Status
const updateAuthorStatus = async (event, id, status) => {

    try {
        // ? disbale button
        $(event).addClass('disabled');

        const response = await fetch(`http://localhost:8000/admin/author/statusUpdate/${id}/${status}`, {
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
            prevTd.html('<span class="badge bg-success fw-bold">active</span>');

        } else {
            target.css({ display: "none" })
                .parent().prev().children().first().css({ display: "block" });

            let prevTd = target.parents('td').prev().prev();
            prevTd.empty();
            prevTd.html('<span class="badge bg-danger fw-bold">in-actve</span>');
        }
        //? change status field

    } catch (error) {
        console.error(error.message);
        toastr.error(error.message);

        //? enable button
        $(event).removeClass('disabled');
    }
};




async function deleteUser(id) {
    //? Show confirmation alert
    const result = await swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to reverse this author!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`http://localhost:8000/admin/author/deleteAuthor/${id}`, {
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
                text: "Author deleted successfully.",
                icon: "success"
            });

            location.reload();
        } catch (error) {
            console.error("Error deleting author:", error);
            await swalWithBootstrapButtons.fire({
                title: "Error!",
                text: "Failed to delete the author.",
                icon: "error"
            });
        }
    }
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
            .attr('disabled', false)
            .val("")
            .data("DateTimePicker").minDate(e.date);
    });
});
