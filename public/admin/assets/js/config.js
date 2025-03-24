const BASE_URL = "http://localhost:8000";

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
});


function formatDate(dateString) {
    const date = new Date(dateString);
    const day = date.getUTCDate();
    const month = date.toLocaleString('en-US', { month: 'short' });
    const year = date.getUTCFullYear();

    //? Function to get ordinal suffix
    const getOrdinalSuffix = (num) => {
        if (num > 3 && num < 21) return 'th';
        switch (num % 10) {
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
            default: return 'th';
        }
    };

    return `${day}${getOrdinalSuffix(day)} ${month}, ${year}`;
}

