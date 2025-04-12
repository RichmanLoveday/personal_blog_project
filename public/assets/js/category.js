function getArticleByCategory(id) {
    // console.log(id)
    //? clear article container and attach a spinner
    $('#category-articles').empty().html(
        `<div class="text-center w-100">
            <p>Loading...</p>
        </div>`
    );
    //? send ajax request 
    $.ajax({
        url: `${BASE_URL}/category/article/${id}`,
        method: 'GET',
        contentType: 'application/json',
        dataType: 'json',
        success: function (res) {
            if (res.status == 'success') {
                console.log(res.articles)
                const articles = res.articles.data;
                loadArticlesOnHtml(articles);
                renderPagination(res.articles);

            } else {
                loadServerError()
            }

        },
        error: function (xhr) {
            loadServerError(xhr.responseJSON.message);
        }
    })
}


function loadArticlesOnHtml(articles) {
    //? clear html
    $('#category-articles').empty();

    //? append right articles in what new container
    let html = '';

    $.each(articles, function (index, article) {
        html += `
             <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="whats-news-single mb-40 mb-40">
                <div class="whates-img">
                    <img src="${BASE_URL}/${article.image}" alt="${article.title}">
                </div>
                <div class="whates-caption whates-caption2">
                    <h4><a href="${BASE_URL}/blog/${article.slug}-${article.id}">${article.title}</a></h4>
                    <span>by ${article.user.firstName} ${article.user.lastName} - ${new Date(article.published_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</span>
                    <p>${article.text.split(' ').slice(0, 20).join(' ')}...</p>
                </div>
                </div>
            </div>
            `;
    });

    $('#category-articles').append(html);
}



function renderPagination(articles) {

    //? clear pagination container
    $('#pagination-container').empty();

    //? check if pagination is empty
    if (articles && articles.next_page_url) {
        const currentPage = articles.current_page;
        const lastPage = articles.last_page;

        let start = Math.max(1, currentPage - 1);
        let end = Math.min(lastPage, currentPage + 1);

        let paginationHtml = `<nav aria-label="Page navigation example"><ul class="pagination justify-content-start">`;

        //? Previous
        if (articles.prev_page_url) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="${articles.prev_page_url}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="15px">
                            <path fill="rgb(255, 11, 11)" d="M8.142,13.118 L6.973,14.135 L0.127,7.646 L0.127,6.623 L6.973,0.132 L8.087,1.153 L2.683,6.413 L23.309,6.413 L23.309,7.856 L2.683,7.856 L8.142,13.118 Z"/>
                        </svg>
                    </a>
                </li>
            `;
        } else {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="15px">
                            <path fill="rgb(221, 221, 221)" d="M8.142,13.118 L6.973,14.135 L0.127,7.646 L0.127,6.623 L6.973,0.132 L8.087,1.153 L2.683,6.413 L23.309,6.413 L23.309,7.856 L2.683,7.856 L8.142,13.118 Z"/>
                        </svg>
                    </a>
                </li>
            `;
        }

        //? Page numbers (just current -1, current, current +1)
        for (let i = start; i <= end; i++) {
            if (i === currentPage) {
                paginationHtml += `<li class="page-item active"><a class="page-link" href="#">${i}</a></li>`;
            } else {
                paginationHtml += `<li class="page-item"><a class="page-link" href="${articles.path}?page=${i}">${i}</a></li>`;
            }
        }

        //? Next
        if (articles.next_page_url) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="${articles.next_page_url}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="15px">
                            <path fill="rgb(255, 11, 11)" d="M31.112,13.118 L32.281,14.136 L39.127,7.646 L39.127,6.624 L32.281,0.132 L31.167,1.154 L36.571,6.413 L0.491,6.413 L0.491,7.857 L36.571,7.857 L31.112,13.118 Z"/>
                        </svg>
                    </a>
                </li>
            `;
        } else {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="15px">
                            <path fill="rgb(221, 221, 221)" d="M31.112,13.118 L32.281,14.136 L39.127,7.646 L39.127,6.624 L32.281,0.132 L31.167,1.154 L36.571,6.413 L0.491,6.413 L0.491,7.857 L36.571,7.857 L31.112,13.118 Z"/>
                        </svg>
                    </a>
                </li>
            `;
        }

        paginationHtml += `</ul></nav>`;

        $('#pagination-container').html(paginationHtml);
    }
}

function loadServerError(message) {
    $('#category-articles').empty().html(
        `<div class="text-center w-100">
            <p>${message}</p>
        </div>`
    );
}