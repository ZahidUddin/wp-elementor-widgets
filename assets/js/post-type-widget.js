document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector(".post-search-input");
    if (!searchInput) return;

    searchInput.addEventListener("keyup", function () {
        let searchQuery = this.value.trim();
        let postType = this.getAttribute("data-post-type");
        let postsPerPage = this.getAttribute("data-posts-per-page");
        let loopTemplate = this.getAttribute("data-loop-template");
        let postGrid = document.getElementById("post-grid");

        // Fetch all posts when the input is empty
        if (searchQuery.length === 0) {
            searchQuery = ""; // Ensure it's an empty string
        }

        // Create FormData
        let data = new FormData();
        data.append("action", "search_posts");
        data.append("post_type", postType);
        data.append("posts_per_page", postsPerPage);
        data.append("search_query", searchQuery);
        data.append("loop_template", loopTemplate); // Pass template ID

        // Make AJAX Request
        fetch(wp_search_params.ajaxurl, {
            method: "POST",
            body: data
        })
            .then(response => response.text())
            .then(data => {
                postGrid.innerHTML = data;
            })
            .catch(error => console.error("Search Error: ", error));
    });
});
