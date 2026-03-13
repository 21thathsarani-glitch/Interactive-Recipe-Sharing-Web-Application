document.addEventListener("DOMContentLoaded", function () {

  // 1. Smooth Scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      if (this.getAttribute('href') !== '#') {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({ behavior: 'smooth' });
        }
      }
    });
  });

  // 2. Interactive Image Slider (Home Page)
  const sliderImages = document.querySelectorAll('.slider-image');
  if (sliderImages.length > 0) {
    let currentSlide = 0;

    window.nextSlide = function () {
      sliderImages[currentSlide].classList.remove('active');
      currentSlide = (currentSlide + 1) % sliderImages.length;
      sliderImages[currentSlide].classList.add('active');
    };

    window.prevSlide = function () {
      sliderImages[currentSlide].classList.remove('active');
      currentSlide = (currentSlide - 1 + sliderImages.length) % sliderImages.length;
      sliderImages[currentSlide].classList.add('active');
    };

    // Auto-advance
    setInterval(window.nextSlide, 5000);
  }

  // 3. Form Validation (Contact Form)
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      if (!contactForm.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      } else {
        e.preventDefault();
        alert("Thank you! Your message has been sent.");
        contactForm.reset();
        contactForm.classList.remove('was-validated');
        return;
      }
      contactForm.classList.add('was-validated');
    }, false);
  }

  // 4. Form Validation & LocalStorage (Submit Recipe Form)
  const submitForm = document.getElementById('submitRecipeForm');
  if (submitForm) {
    submitForm.addEventListener('submit', function (e) {
      if (!submitForm.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      } else {
        e.preventDefault();
        const name = document.getElementById("recipeName").value;
        const desc = document.getElementById("recipeDesc").value;
        const ingredients = document.getElementById("recipeIngredients").value;
        const steps = document.getElementById("recipeSteps").value;
        const imageInput = document.getElementById("recipeImage");
        const file = imageInput.files[0];

        const reader = new FileReader();
        reader.onload = function (event) {
          const recipe = {
            name,
            desc,
            ingredients,
            steps,
            image: event.target.result
          };
          let recipes = JSON.parse(localStorage.getItem("userRecipes")) || [];
          recipes.push(recipe);
          localStorage.setItem("userRecipes", JSON.stringify(recipes));

          alert("Recipe submitted successfully!");
          submitForm.reset();
          submitForm.classList.remove('was-validated');
        };
        if (file) reader.readAsDataURL(file);
        return;
      }
      submitForm.classList.add('was-validated');
    }, false);
  }

  // 5. Dynamic Content Filtering (Recipes Page)
  const searchInput = document.getElementById("search");
  if (searchInput) {
    searchInput.addEventListener("keyup", function () {
      const filter = searchInput.value.toLowerCase();
      const cols = document.querySelectorAll(".recipe-col");

      cols.forEach(col => {
        const name = col.getAttribute("data-name");
        if (name && name.toLowerCase().includes(filter)) {
          col.style.display = "block";
        } else {
          col.style.display = "none";
        }
      });
    });
  }

  // 6. Load Submitted Recipes dynamically
  const container = document.getElementById("recipeContainer");
  if (container) {
    let recipes = JSON.parse(localStorage.getItem("userRecipes")) || [];
    recipes.forEach(recipe => {
      const col = document.createElement("div");
      col.classList.add("col-md-4", "mb-4", "recipe-col");
      col.setAttribute("data-name", recipe.name.toLowerCase());

      col.innerHTML = `
        <div class="card h-100 shadow-sm border-0">
          <img src="${recipe.image}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="${recipe.name}">
          <div class="card-body d-flex flex-column">
            <h3 class="card-title h5">${recipe.name}</h3>
            <p class="card-text">${recipe.desc}</p>
            <button class="btn btn-primary w-100 mt-auto" style="background:#f39c12; border:none;" onclick="openModal('${recipe.name}', 'Ingredients: ${recipe.ingredients}\nHow to Cook: ${recipe.steps}')">
              View
            </button>
          </div>
        </div>
      `;
      container.appendChild(col);
    });
  }

  // 7. Rating Logic
  const ratingStars = document.querySelectorAll('.rating-star');
  const ratingFeedback = document.getElementById('ratingFeedback');
  let currentRating = 0;

  if (ratingStars.length > 0) {
    ratingStars.forEach(star => {
      star.addEventListener('mouseover', function () {
        const rating = this.getAttribute('data-rating');
        highlightStars(rating);
      });

      star.addEventListener('mouseout', function () {
        highlightStars(currentRating);
      });

      star.addEventListener('click', function () {
        currentRating = this.getAttribute('data-rating');
        highlightStars(currentRating);
        if (ratingFeedback) {
          ratingFeedback.classList.remove('d-none');
        }
      });
    });

    function highlightStars(rating) {
      ratingStars.forEach(star => {
        if (star.getAttribute('data-rating') <= rating) {
          star.classList.remove('bi-star');
          star.classList.add('bi-star-fill');
        } else {
          star.classList.remove('bi-star-fill');
          star.classList.add('bi-star');
        }
      });
    }
  }

  // 8. Authentication Logic
  const currentUser = localStorage.getItem("currentUser");
  const guestOnlyElems = document.querySelectorAll(".guest-only");
  const userOnlyElems = document.querySelectorAll(".user-only");

  if (currentUser) {
    guestOnlyElems.forEach(el => el.style.display = 'none');
    userOnlyElems.forEach(el => el.style.display = 'block');
  } else {
    guestOnlyElems.forEach(el => el.style.display = 'block');
    userOnlyElems.forEach(el => el.style.display = 'none');
  }

  const logoutBtn = document.getElementById("logoutBtn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", function (e) {
      e.preventDefault();
      localStorage.removeItem("currentUser");
      window.location.href = "index.html";
    });
  }

  const registerForm = document.getElementById("registerForm");
  if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const pwd = document.getElementById("registerPassword").value;
      const confirmPwd = document.getElementById("registerConfirmPassword").value;
      const errorDiv = document.getElementById("confirmPasswordError");

      if (pwd !== confirmPwd) {
        document.getElementById("registerConfirmPassword").setCustomValidity("Passwords do not match");
        errorDiv.style.display = "block";
        registerForm.classList.add("was-validated");
        return;
      } else {
        document.getElementById("registerConfirmPassword").setCustomValidity("");
        errorDiv.style.display = "none";
      }

      if (registerForm.checkValidity()) {
        const email = document.getElementById("registerEmail").value;
        const fullName = document.getElementById("registerName").value;
        const userName = document.getElementById("registerUserName").value;

        let users = JSON.parse(localStorage.getItem("users")) || {};
        if (users[email]) {
          alert("Email already registered. Please login.");
          return;
        }

        // We save the 'User Name' as 'name' since the login form checks against users[email].name
        users[email] = { name: userName, fullName: fullName, password: pwd };
        localStorage.setItem("users", JSON.stringify(users));
        alert("Registration successful! Please login.");
        window.location.href = "login.html";
      } else {
        registerForm.classList.add("was-validated");
      }
    });
  }

  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();

      if (loginForm.checkValidity()) {
        const username = document.getElementById("loginName").value;
        const email = document.getElementById("loginEmail").value;
        const pwd = document.getElementById("loginPassword").value;

        let users = JSON.parse(localStorage.getItem("users")) || {};
        if (users[email] && users[email].name === username && users[email].password === pwd) {
          localStorage.setItem("currentUser", JSON.stringify({ email: email, name: users[email].name }));
          alert("Login successful!");
          window.location.href = "index.html";
        } else {
          alert("Invalid username, email, or password.");
        }
      } else {
        loginForm.classList.add("was-validated");
      }
    });
  }

  // 9. Route Guards
  const currentPath = window.location.pathname;

  // Page access guards
  if (!currentUser && (currentPath.includes("submit.html") || currentPath.includes("contact.html"))) {
    alert("Please login to access this page.");
    window.location.href = "login.html";
  }

  // Intercept navigation links
  const protectedLinks = document.querySelectorAll('a[href="submit.html"], a[href="contact.html"], a[href="recipes.html"]');
  protectedLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      if (!currentUser) {
        e.preventDefault();
        alert("Please login to access this feature.");
        window.location.href = "login.html";
      }
    });
  });

});

// Modal Logic
window.openModal = function (title, text) {
  const currentUser = localStorage.getItem("currentUser");
  if (!currentUser) {
    alert("Please login to view recipe details.");
    window.location.href = "login.html";
    return;
  }
  document.getElementById("modalTitle").innerText = title;
  document.getElementById("modalText").innerText = text;
  document.getElementById("recipeModal").style.display = "flex";
};

window.closeModal = function () {
  document.getElementById("recipeModal").style.display = "none";
};

