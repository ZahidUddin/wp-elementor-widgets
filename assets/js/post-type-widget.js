document.addEventListener("DOMContentLoaded", function() {
	document.querySelectorAll(".load-more-posts").forEach(button => {
		button.addEventListener("click", function() {
			let container = this.previousElementSibling;
			let postType = container.getAttribute("data-post-type");
			let postsPerPage = container.getAttribute("data-posts-per-page");
			let columns = container.getAttribute("data-columns");
			let currentPage = parseInt(this.getAttribute("data-page"));

			let button = this;
			button.innerText = "Loading...";
			button.disabled = true;

			let data = new FormData();
			data.append("action", "load_more_posts");
			data.append("post_type", postType);
			data.append("posts_per_page", postsPerPage);
			data.append("columns", columns);
			data.append("page", currentPage + 1);

			fetch(ajaxurl, {
				method: "POST",
				body: data
			})
			.then(response => response.text())
			.then(data => {
				if (data.trim() === "") {
					button.remove();
				} else {
					container.innerHTML += data;
					button.setAttribute("data-page", currentPage + 1);
					button.innerText = "Load More";
					button.disabled = false;
				}
			});
		});
	});
});
