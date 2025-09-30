document.addEventListener('DOMContentLoaded', function () {
  // Navbar Dropdown
  const initDropdowns = () => {
    const toggleDropdown = (event, dropdown) => {
      event.stopPropagation();
      dropdown.classList.toggle('show');
      dropdown.classList.toggle('hide');
    };

    const closeAllDropdownsExcept = (exceptDropdown) => {
      dropdowns.forEach((dropdown) => {
        if (dropdown && dropdown !== exceptDropdown) {
          dropdown.classList.remove('show');
          dropdown.classList.add('hide');
        }
      });
    };

    const closeAllDropdowns = () => {
      dropdowns.forEach((dropdown) => {
        if (dropdown) {
          dropdown.classList.remove('show');
          dropdown.classList.add('hide');
        }
      });
    };

    const linkDropdownPairs = [
      { linkId: 'brand-dropdown', dropdownClass: 'navbar-menu--brand' },
      { linkId: 'watch-dropdown', dropdownClass: 'navbar-menu--watch' },
      { linkId: 'user-dropdown', dropdownClass: 'navbar-menu--user' },
      { linkId: 'cart-sidebar', dropdownClass: 'navbar-menu--cart' },
      // Add more pairs as needed
    ];

    const dropdowns = linkDropdownPairs.map((pair) => document.querySelector(`.${pair.dropdownClass}`));

    linkDropdownPairs.forEach(({ linkId, dropdownClass }) => {
      const link = document.getElementById(linkId);
      const dropdown = document.querySelector(`.${dropdownClass}`);

      // Check if the link and dropdown elements exist before adding event listeners
      if (link && dropdown) {
        link.addEventListener('click', (event) => {
          toggleDropdown(event, dropdown);
          closeAllDropdownsExcept(dropdown);
          // console.log(closeAllDropdownsExcept(dropdown));
        });
      }
    });

    // Add event listener to the cart icon to close the cart modal
    const closeButton = document.getElementById('cart-button');
    const cartModal = document.querySelector('.navbar-menu--cart');
    if (closeButton && cartModal) {
      closeButton.addEventListener('click', (event) => {
        event.stopPropagation();
        cartModal.classList.remove('show');
        cartModal.classList.add('hide');
      });
    }

    document.addEventListener('click', closeAllDropdowns);

    dropdowns.forEach((dropdown) => {
      if (dropdown) {
        dropdown.addEventListener('click', (event) => event.stopPropagation());
      }
    });
  };

  // Navbar Menu
  const initMenu = () => {
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    const menuItems = document.querySelector('.navbar-menu--items');

    if (menuIcon && closeIcon && menuItems) {
      const openMenu = () => {
        menuItems.classList.toggle('show');
        menuItems.classList.remove('hide');
      };

      const closeMenu = () => {
        menuItems.classList.remove('show');
        menuItems.classList.add('hide');
      };

      menuIcon.addEventListener('click', (event) => {
        event.stopPropagation();
        openMenu();
      });

      closeIcon.addEventListener('click', (event) => {
        event.stopPropagation();
        closeMenu();
      });
    }
  };

  // Accordion
  const initAccordion = () => {
    const accordions = document.querySelectorAll('.product-details--dropdown');

    const openAccordion = (accordion) => {
      const content = accordion.querySelector('.product-details--dropdown--content');
      accordion.classList.add('active');
    };
    const closeAccordion = (accordion) => {
      const content = accordion.querySelector('.product-details--dropdown--content');
      accordion.classList.remove('active');
    };

    accordions.forEach((accordion) => {
      const header = accordion.querySelector('.product-details--dropdown--header');
      const content = accordion.querySelector('.product-details--dropdown--content');

      header.onclick = () => {
        accordion.classList.toggle('active');
        if (accordion.classList.contains('active')) {
          openAccordion(accordion);
        } else {
          closeAccordion(accordion);
        }
      };
    });
  };

  // Quantity Controls
  const cartpage = document.getElementById('shoppingcartBody');
  if(cartpage) {
    document.querySelector('.cart-modal').remove();
    document.querySelector('#cart-sidebar').setAttribute('onclick', "window.location='/zencart-210-watxh/index.php?main_page=shopping_cart'");
  }
  const updateValue = (valueInputElem, adjustment) => {
    let inputValue = parseInt(valueInputElem.value) || 0;
    inputValue = Math.max(1, inputValue + adjustment);
    valueInputElem.setAttribute('value', inputValue);

    let count = 0;
    qtys = document.querySelectorAll('input[type="number"].quantity-value');
    Array.from(qtys).forEach(function(qty) {
      count += parseInt(qty.value);
    })
    document.querySelector('#cart-sidebar .badge label').textContent = ` ${count} `;
  };

  const initProductQuantity = () => {
      const decreaseButtons = document.querySelectorAll('.quantity-decrease');
      const valueInputElems = document.querySelectorAll('input[type="number"].quantity-value');
      const increaseButtons = document.querySelectorAll('.quantity-increase');

      // Iterate over each set of elements and attach event listeners
      decreaseButtons.forEach((decreaseButton, index) => {
          const valueInputElem = valueInputElems[index];
          const increaseButton = increaseButtons[index];

          decreaseButton.addEventListener('click', () => {
              updateValue(valueInputElem, -1);
          });

          increaseButton.addEventListener('click', () => {
              updateValue(valueInputElem, 1);
          });
      });
  };

  // Select Product Type
  function initSelectProductType() {
    const productType = document.querySelectorAll('.product-details--type--image');
    const productName = document.querySelector('.product-details--type--name');

    const options = ['Gold', 'Black', 'Blue', 'Black Leather', 'Copper', 'Steel', 'Rose Gold', 'Nickel'];

    productType.forEach((div, index) => {
      div.addEventListener('click', function () {
        // Remove border from all divs
        productType.forEach((typeDiv) => {
          typeDiv.style.border = 'none';
        });

        // Add border to the clicked div
        div.style.border = '.1rem solid black';

        // Update the content of the paragraph with a specific option based on the index
        productName.textContent = `Color: ${options[index]}`;
      });
    });
  }

  // Input Group
  function applyFocusLabelBehavior() {
    var inputGroups = document.querySelectorAll('.input-group');

    inputGroups.forEach(function (group) {
      var input = group.querySelector('input');
      var label = group.querySelector('label');

      // Check if both input and label are found
      if (input && label) {
        input.addEventListener('focus', function () {
          // Show the label associated with the current input group
          // label.style.opacity = '1';
          label.style.top = '0px';
          label.style.fontSize = '12px';
          label.style.color = 'rgba(0, 0, 0, 1)';
        });

        input.addEventListener('blur', function () {
          // Hide the label if the input has no value
          if (this.value === '') {
            // label.style.opacity = '1';
            label.style.top = '24px';
            label.style.fontSize = '18px';
            label.style.color = 'rgba(129, 129, 129, 1)';
          }
        });
      }
    });
  }

  // Modal
  function initModal() {
    // Get the modal element
    var modal = document.getElementById('modal');

    // Get the button that opens the modal
    var openModalBtn = document.getElementById('openModal');

    // Get the <span> element that closes the modal
    var modalCloseBtn = document.getElementById('modal-close');

    // Function to open the modal
    function openModal() {
      modal.style.display = 'flex';
    }

    // Function to close the modal
    function closeModal() {
      modal.style.display = 'none';
    }

    if (openModalBtn) {
      // Event listener for opening the modal
      openModalBtn.addEventListener('click', openModal);
    }

    if (modalCloseBtn) {
      // Event listener for closing the modal using the close button
      modalCloseBtn.addEventListener('click', closeModal);
    }

    // Event listener for closing the modal when clicking outside of it
    window.addEventListener('click', function (event) {
      if (event.target === modal) {
        closeModal();
      }
    });
  }

  function initStarRating() {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(function (star) {
      star.addEventListener('click', function () {
        const rating = parseInt(star.getAttribute('data-rating'));
        ratingInput.value = rating;

        // Remove star-filled class from all stars
        stars.forEach(function (s) {
          s.classList.remove('star-filled');
          s.classList.add('star-stroke');
        });

        // Add star-filled class to stars up to the clicked star
        for (let i = 0; i < rating; i++) {
          stars[i].classList.add('star-filled');
          stars[i].classList.remove('star-stroke');
        }
      });
    });
  }

  //Carousel
  function initCarousel() {
    // Get the button that opens the modal
    var reviewCarousel = document.querySelectorAll('.review-carousel');

    if (reviewCarousel.length > 0) {
      console.log(reviewCarousel);
      
      jQuery('.review-carousel').owlCarousel({
        loop: true,
        center: true,
        margin: 40,
        nav: true,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 1,
          },
          1024: {
            items: 3,
          },
        },
      });
    }
  }

  // Handle alerts
  function handleAlerts() {
    // Define an array of alert types
    const alertTypes = ['success', 'error', 'warning', 'caution'];

    alertTypes.forEach((type) => {
      // Select all elements for the current alert type
      const alerts = document.querySelectorAll(`.message-${type}`);

      alerts.forEach((alert) => {
        alert.classList.add('show');

        setTimeout(() => {
          alert.classList.remove('show');
          alert.classList.add('hide');
        }, 3000); // 30 seconds
      });
    });
  }

  // Call the menu initialization function
  initMenu();
  initModal();
  initStarRating();
  initCarousel();
  initDropdowns();
  initAccordion();
  initProductQuantity();
  initSelectProductType();
  applyFocusLabelBehavior();
  handleAlerts();
  //Carousel


  // Product listing grid/list
  const filterBtn = document.querySelectorAll('.product-filter-btn');
  Array.from(filterBtn).forEach(function(item) {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      var type = this.dataset.type;
      if(type === 'list') {
        document.querySelector('.product-item-listing').classList.add('list-view');
      } else {
        document.querySelector('.product-item-listing').classList.remove('list-view');
      }

      Array.from(filterBtn).forEach(function(btn) {
        btn.classList.remove('active');
      });
      item.classList.add('active');
    });
  });

  // Product listing sidebar
  const sidebarHeaders = document.querySelectorAll('.product-sidebar--section > header');
  Array.from(sidebarHeaders).forEach(function(header) {
    header.addEventListener('click', function(e) {
      e.stopPropagation();
      this.parentElement.classList.toggle('inactive');
    });
  });

  const resetButton = document.getElementById("reset-btn");
  if(resetButton) {
    resetButton.addEventListener('click', function() {
      const checkboxes = document.querySelectorAll(".product-sidebar input[type='checkbox']");
      Array.from(checkboxes).forEach(checkbox => {
          checkbox.checked = false;
      });
    });
  }

  /**
   * Start: Product listing pagination
   */
  const pagination = document.querySelectorAll(".listing-pagination a");
  const totalPages = pagination.length - 2; // Exclude Prev/Next buttons
  const dotsClass = "dots";

  const createDots = (parent, beforeIndex) => {
      const span = document.createElement("span");
      span.className = dotsClass;
      span.innerText = "...";
      parent.insertBefore(span, pagination[beforeIndex]);
  };

  const updatePagination = (currentPageIndex) => {
    // Reset all links
    pagination.forEach((item) => item.classList.remove("hidden", "active"));

    // Highlight active page
    pagination[currentPageIndex].classList.add("active");

    // Hide irrelevant pages and remove existing dots
    document.querySelectorAll(".dots").forEach((dot) => dot.remove());

    let startPage, endPage;

    if (currentPageIndex <= 3) {
        // Near the beginning: Show 1, 2, 3, 4, 5, ..., last
        startPage = 1;
        endPage = Math.min(5, totalPages - 1);
    } else if (currentPageIndex >= totalPages - 3) {
        // Near the end: Show first, ..., last 5 pages
        startPage = Math.max(totalPages - 4, 2);
        endPage = totalPages - 1;
    } else {
        // Middle section: Show first, ..., current group of 5, ..., last
        startPage = currentPageIndex - 2;
        endPage = currentPageIndex + 2;
    }

    // Show calculated pages
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= startPage && i <= endPage)) {
            pagination[i].classList.remove("hidden");
        } else {
            pagination[i].classList.add("hidden");
        }
    }

    // Add dots after the first page if needed
    if (startPage > 2) {
        createDots(pagination[0].parentElement, 2); // Add dots after '1'
    }

    // Add dots before the last page if needed
    if (endPage < totalPages - 1) {
        createDots(pagination[totalPages].parentElement, pagination.length - 2); // Add dots before 'last'
    }
  };






  // Handle clicks on Prev and Next buttons
  if(document.querySelector(".listing-pagination")) {
    document.querySelector(".listing-pagination").addEventListener("click", (e) => {
        if (e.target.classList.contains("prev") || e.target.classList.contains("next")) {
            e.preventDefault();
            const currentPage = document.querySelector(".listing-pagination a.active");
            const currentPageIndex = Array.from(pagination).indexOf(currentPage);
            const step = parseInt(e.target.getAttribute("data-step"), 10);
            const newPageIndex = currentPageIndex + step;

            if (newPageIndex > 0 && newPageIndex < pagination.length - 1) {
                window.location.href = pagination[newPageIndex].getAttribute("href");
            }
        }
    });
  }

  // Run initially to handle default pagination
  const currentPage = document.querySelector(".listing-pagination a.active");
  if (currentPage) {
      const currentIndex = Array.from(pagination).indexOf(currentPage);
      updatePagination(currentIndex);
  }
  /**
   * End: Product listing pagination
   */

  // Product listing filter mobile
  const dropdownItems = document.querySelectorAll('.sorting-dropdown-item');
  const selectElement = document.querySelector('select[name="sortby"]');
  const sortDropdownMb = document.getElementById('sorting-dropdown-mb');
  const filterIconClose = document.getElementById('sidebar-filter-mb-icon');
  const productSidebar = document.querySelector('.product-sidebar');
  const filterBtnMb = document.getElementById('filter-button-mb');

  Array.from(dropdownItems).forEach(item => {
      item.addEventListener('click', function () {
          const selectedId = this.getAttribute('data-id');
          selectElement.value = selectedId;
          selectElement.dispatchEvent(new Event('change'));
      });
  });

  if(sortDropdownMb) {
    sortDropdownMb.addEventListener('click', function() {
      sortDropdownMb.classList.toggle('active');
    });
  }

  if(filterBtnMb) {
    filterBtnMb.addEventListener('click', function() {
      productSidebar.classList.add('active');
    });
  }

  if(filterIconClose) {
    filterIconClose.addEventListener('click', function() {
      productSidebar.classList.remove('active');
    });
  }

  const navbarSearch = document.querySelector('.navbar-menu--search');
  const navbar = document.querySelector('.navbar');
  const btnNavbarSearchClose = document.querySelectorAll('.navbar-close-icon');
  navbarSearch.addEventListener('click', function() {
    navbar.classList.add('search-active');
  });
  Array.from(btnNavbarSearchClose).forEach(function(btn) {
    btn.addEventListener('click', function() {
      navbar.classList.remove('search-active');
    });
  });

  /**
   * Address page
   */
  const deleteBtns = document.querySelectorAll('.js-delete-modal-open');
  const modal = document.getElementById('js-address-delete-modal-container');
  Array.from(deleteBtns).forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const btnID = btn.dataset.id;
      const inputDelete = document.querySelector('input[name="delete"]');
      inputDelete.setAttribute('value', btnID);
      modal.classList.add('active');
    });
  });

  const closeBtns = document.querySelectorAll('.js-delete-modal-close');
  Array.from(closeBtns).forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      modal.classList.remove('active');
    });
  });
  
  jQuery('.watch-card--image') && 
  jQuery('.watch-card--image').hover(
    function() {
      var altPic = jQuery(this).data('altpic');
      if (altPic) {
        jQuery(this).find('.card--image').attr('src', altPic);
      }
    },
    function() {
      var original = jQuery(this).data('original');
      if (original) {
        jQuery(this).find('.card--image').attr('src', original);
      }
    }
  );

  $(document).on('click', '.watch-card--like', function(e) {
    e.preventDefault();
    $(this).toggleClass('active');
  });

  if (localStorage.getItem('showAddToCartSuccess') === '1') {
    localStorage.removeItem('showAddToCartSuccess');
    const toast = document.getElementById('addToCartToast');
    if (toast) {
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 3000);
    }
  }

});


const addToCartBtn = document.querySelector('button[name="add_to_cart"]');
const productForm = addToCartBtn ? addToCartBtn.closest('form') : null;

if (addToCartBtn && productForm) {
  addToCartBtn.addEventListener('click', function(e) {
    e.preventDefault();
    const formData = new FormData(productForm);
    formData.append('ajax', '1');
    fetch(productForm.action, {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.text())
    .then(data => {
      localStorage.setItem('showAddToCartSuccess', '1');
      window.location.reload();
    })
    .catch(error => {
      alert('There was a problem adding the product to cart.');
      console.error(error);
    });
  });
}