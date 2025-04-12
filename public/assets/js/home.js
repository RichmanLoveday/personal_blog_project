
function getArticleByCategory(id) {
    // console.log(id)
    //? clear article container and attach a spinner
    $('#whatsNewContainer').empty().html(
        `<div class="text-center w-100">
            <p>Loading...</p>
        </div>`
    );
    //? send ajax request 
    $.ajax({
        url: `${BASE_URL}/home/getArticlesByCategory/${id}`,
        method: 'GET',
        contentType: 'application/json',
        dataType: 'json',
        success: function (res) {
            if (res.status == 'success') {
                const articles = res.articles;
                loadArticlesOnHtml(articles);
            } else {
                loadServerError()
            }

        },
        error: function (res) {
            loadServerError()
        }
    })
}


function loadArticlesOnHtml(articles) {
    console.log(articles);
    //? clear html
    $('#whatsNewContainer').empty();

    //? prepend left article in what new container
    // Loop through the articles and find the first one to display as the main article
    $.each(articles, function (index, article) {
        if (index === 0) {
            $('#whatsNewContainer').prepend(`
                <div class="col-xl-6 col-lg-12">
                    <div class="whats-news-single mb-40">
                        <div class="whates-img">
                            <img src="${BASE_URL}/${article.image}" alt="Main Article Image">
                        </div>
                        <div class="whates-caption">
                            <h4>
                                <a href="${BASE_URL}/blog/${article.slug}-${article.id}">
                                    ${article.title.charAt(0).toUpperCase() + article.title.slice(1)}
                                </a>
                            </h4>
                            <span>
                                by ${article.user.firstName.charAt(0).toUpperCase() + article.user.firstName.slice(1)} 
                                ${article.user.lastName.charAt(0).toUpperCase() + article.user.lastName.slice(1)} - 
                                ${new Date(article.published_at).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' })}
                            </span>
                            <p>${article.text.split(' ').slice(0, 30).join(' ')}...</p>
                        </div>
                    </div>
                </div>
            `);

            // Stop the loop after processing the first article
            return false;
        }
    });

    //? append right articles in what new container
    let html = ` <div class="col-xl-6 col-lg-12">
    <div class="row">`;

    $.each(articles, function (index, article) {
        const colors = ['colorb', 'colorb', 'colorg', 'colorr'];

        if (index !== 0) {
            html += `
                <div class="col-xl-12 col-lg-6 col-md-6 col-sm-10">
                    <div class="whats-right-single mb-20">
                        <div class="whats-right-img">
                            <img style="width: 120px; height: 100px;" src="${BASE_URL}/${article.image}" alt="Article Image">
                        </div>
                        <div class="whats-right-cap">
                            <span class="${colors[(index - 1) % colors.length]}">
                                ${article.category.name.toUpperCase()}
                            </span>
                            <h4>
                                <a href="${BASE_URL}/blog/${article.slug}-${article.id}">
                                    ${article.title.split(' ').slice(0, 10).join(' ')}...
                                </a>
                            </h4>
                            <p>${new Date(article.published_at).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' })}</p>
                        </div>
                    </div>
                </div>
            `;
        }
    });

    // Close the grid layout and append the HTML to the container
    html += `</div></div>`;
    $('#whatsNewContainer').append(html);
}

function loadServerError() {
    $('#whatsNewContainer').empty().html(
        `<div class="text-center w-100">
            <p>An Error Occured In Server</p>
        </div>`
    );
}

