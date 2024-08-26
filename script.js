document.addEventListener("DOMContentLoaded", function () {
  loadReviews();

  document
    .getElementById("reviewForm")
    .addEventListener("submit", function (event) {
      event.preventDefault();

        let user_id = 1;// document.getElementById("user_id").value;
      let content_id = document.getElementById("content_id").value;
      let rating = document.getElementById("rating").value;
      let comment = document.getElementById("comment").value;

      let formData = new FormData();
      formData.append("user_id", user_id);
      formData.append("content_id", content_id);
      formData.append("rating", rating);
      formData.append("comment", comment);

      fetch("controller.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.message === "Review created successfully.") {
            loadReviews();
            document.getElementById("reviewForm").reset();
          } else {
            alert("Failed to submit review.");
          }
        });
    });
});





function loadReviews() {
  fetch("controller.php?content_id=1")
    .then((response) => response.json())
    .then((data) => {
      let reviewsContainer = document.getElementById("reviews");
      reviewsContainer.innerHTML = "";

      data.forEach((review) => {
        let reviewElement = document.createElement("div");
        reviewElement.classList.add("review");
        reviewElement.innerHTML = `
          <div class="card-body">
            <h5 class="card-title">
              ${review.username}
              <span class="badge bg-primary">${review.rating} Stars</span>
            </h5>
            <p class="card-text">${review.comment}</p>
            <p class="card-footer text-muted">
              Posted on: ${review.created_at}
            </p>
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary me-2" onclick="editReview(${review.id})">Edit</button>
              <button class="btn btn-danger" onclick="deleteReview(${review.id})">Delete</button>
            </div>
          </div>
        `;
        reviewsContainer.appendChild(reviewElement);
      });
    });
}

function editReview(id) {
  let rating = prompt("Enter your new rating (1-5):");
  let comment = prompt("Enter your new comment:");

  if (rating && comment) {
    let formData = new FormData();
    formData.append("id", id);
    formData.append("user_id", document.getElementById("user_id").value);
    formData.append("rating", rating);
    formData.append("comment", comment);

    fetch("controller.php", {
      method: "PUT",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.message === "Review updated successfully.") {
          loadReviews();
        } else {
          alert("Failed to update review.");
        }
      });
  }
}

function deleteReview(id) {
  if (confirm("Are you sure you want to delete this review?")) {
    let formData = new FormData();
    formData.append("id", id);
    formData.append("user_id", document.getElementById("user_id").value);

    fetch("controller.php", {
      method: "DELETE",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.message === "Review deleted successfully.") {
          loadReviews();
        } else {
          alert("Failed to delete review.");
        }
      });
  }
}

