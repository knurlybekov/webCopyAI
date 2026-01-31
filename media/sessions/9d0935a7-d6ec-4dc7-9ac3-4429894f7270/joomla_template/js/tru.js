
/*===========================
----- TABLE OF CONTENTS -----
-----------------------------

1. PRIMARY NAVIGATION JS
2. MODAL JS

===========================*/

// ==================================== //
// ----- 1. PRIMARY NAVIGATION JS ----- //
// ==================================== //

function globalRemoveClass(elements, removal) {
  while(elements.length > 0){
      elements[0].classList.remove(removal);
  }
}

// ==============================================================
// OPEN MOBILE NAV FUNCTION
// ==============================================================

function mobileNavOpen(target) {
  if (!target.classList.contains('toggled')) {
    target.classList.add('toggled');
    document.querySelector('.nav-items-wrapper').classList.add('toggled');
    document.getElementsByTagName('body')[0].style.overflowY = 'hidden';

    setTimeout(() => {
      document.getElementsByTagName('main')[0].style.visibility = 'hidden';
    }, 250);
  } else {
    target.classList.remove('toggled');
    document.querySelector('.nav-items-wrapper').classList.remove('toggled');
    document.getElementsByTagName('body')[0].style.overflowY = 'auto';
    document.getElementsByTagName('main')[0].style.visibility = 'visible';
  }
}

// ==============================================================
// OPEN NAV SUBMENUS FUNCTION
// ==============================================================

function submenuOpen(target) {          
  var dataToggle = target.getAttribute('data-toggle');
  var submenuToggled = document.querySelector('.menu-item-submenu.toggled');
  var navItemActive = document.querySelector('.submenu-toggle.active');

  if (target.classList.contains('active') == false) {            
    if (submenuToggled != null) {
      document.querySelector('.menu-item-submenu.toggled').classList.remove('toggled');
    }

    document.getElementById(dataToggle).classList.add('toggled');

    if (window.innerWidth >= 1024) {
      document.querySelector('.menu-item-submenu.toggled .submenu-close').setAttribute('tabindex', '0');
    }

    if (navItemActive == null && window.innerWidth >= 1024) {
      setTimeout(() => {                
        target.classList.add('active');                  
      }, 250);                
    } else {
      if (navItemActive != null) {              
        document.querySelector('.submenu-toggle.active').classList.remove('active');
      }

      target.classList.add('active');
    }
  } else {
    target.classList.remove('active');
    document.querySelector('.menu-item-submenu.toggled .submenu-close').setAttribute('tabindex', '-1');
    document.querySelector('.menu-item-submenu.toggled').classList.remove('toggled');
  }
}

// ==============================================================
// CLOSE SUBMENU FUNCTIONS
// ==============================================================

function submenuClose(target) {
  if (target.parentElement.parentElement.classList.contains('toggled') == true) {
    target.parentElement.parentElement.classList.remove('toggled');
    target.setAttribute('tabindex', '-1');
    document.querySelector('.submenu-toggle.active').classList.remove('active');            
  }
}      

// ==============================================================
// ON CLICK EVENT
// ==============================================================

document.addEventListener('click', function(event) {
  const _target = event.target;

  if (document.getElementById('mobileNavToggle').contains(_target) == true) {
    mobileNavOpen(_target);
  }        

  if (_target.classList.contains('submenu-close') == true) {
    submenuClose(_target);
  }

  if (_target.classList.contains('submenu-toggle') == true) {
    submenuOpen(_target);
  }

  var isSubmenuInside = document.querySelector('.menu-item-submenu').contains(_target);
  var isMainNav = document.querySelector('.nav-menu-items').contains(_target);                     
  if (!isSubmenuInside && !isMainNav) {
    if (document.querySelector('.menu-item-submenu.toggled') != null) {
      if (window.innerWidth < 1024) {
        document.querySelector('.menu-item-submenu.toggled .submenu-close').setAttribute('tabindex', '-1');
      }

      document.querySelector('.menu-item-submenu.toggled').classList.remove('toggled');
      document.querySelector('.submenu-toggle.active').classList.remove('active');
    }            
  }
});

document.addEventListener('keypress', function(event) {
  const _target = event.target;

  if (event.key === 'Enter') {
    if (document.getElementById('mobileNavToggle').contains(_target) == true) {
      mobileNavOpen(_target);
    }        

    if (_target.classList.contains('submenu-close') == true) {
      submenuClose(_target);
    }

    if (_target.classList.contains('submenu-toggle') == true) {
      submenuOpen(_target);
    }

    var isSubmenuInside = document.querySelector('.menu-item-submenu').contains(_target);
    var isMainNav = document.querySelector('.nav-menu-items').contains(_target);                     
    if (!isSubmenuInside && !isMainNav) {
      if (document.querySelector('.menu-item-submenu.toggled') != null) {
        if (window.innerWidth < 1024) {
          document.querySelector('.menu-item-submenu.toggled .submenu-close').setAttribute('tabindex', '-1');
        }

        document.querySelector('.menu-item-submenu.toggled').classList.remove('toggled');
        document.querySelector('.submenu-toggle.active').classList.remove('active');
      }            
    }
  }
});

// ==============================================================
// ON SCROLL EVENTS
// ==============================================================

var position = window.scrollY;

document.addEventListener("scroll", (event) => {
    var scroll = window.scrollY;
    if (scroll > position) {
      if (scroll >= 150 && document.querySelector('.nav-wrapper') != null) {                  
        document.querySelector('.nav-wrapper').classList.add('scrolled');                  
      }            
    } else {
      if (scroll < 150 && document.querySelector('.nav-wrapper') != null) {
        document.querySelector('.nav-wrapper').classList.remove('scrolled');
      }
    }
    position = scroll;
});

// ======================= //
// ----- 2. MODAL JS ----- //
// ======================= //

document.addEventListener("DOMContentLoaded", function(event) {

  // ==============================================================  
  // If there is a gallery do some initial set up
  // ============================================================== 

  // Array for all the images
  const arrGalleryImages = [];

  // Object with important attributes
  function GalleryImage(){
    this.url = "";
    this.caption = "";
    this.alt = "";
  }

  const galleryItems = document.querySelectorAll(".gallery-item");

  // if there is a gallery, loop through each grid item and set up the necessary items for the gallery modal
  if (galleryItems && galleryItems.length) {
    for(let i=0; i < galleryItems.length; i++){
        
      const currentItem = new GalleryImage();

      // if there is a caption
      if(galleryItems[i].parentElement.dataset.caption){
          
        // get it for modal later
        currentItem.caption = galleryItems[i].parentElement.dataset.caption

        // add the figcaption tag to the figure
        const galleryFigure = document.createElement("figcaption");
        galleryFigure.classList.add("photo-caption");

        const caption = document.createTextNode(galleryItems[i].parentElement.dataset.caption);
        galleryFigure.appendChild(caption);
        galleryItems[i].parentElement.appendChild(galleryFigure);
      }

      // if there is an alt tag (which there should be!)
      if(galleryItems[i].alt){
        currentItem.alt = galleryItems[i].alt;
      }

      // assign id to grid item to help with modal later
      galleryItems[i].id = "galleryImage-" + i;

      // get current item src
      currentItem.url = galleryItems[i].src;

      // Add the item to the images array
      arrGalleryImages.push(currentItem);
    }
  }
  
  
  // ==============================================================  
  // Open modal
  // ==============================================================  
  
  const openButtons = document.querySelectorAll(".openModal");
  for(let i=0; i < openButtons.length; i++){

    const openButton = openButtons[i];
    
    openButton.addEventListener("click", (event) => { doOpenModal(openButton); });
    openButton.addEventListener("keydown", (event) => { 
        
      const KEY = event.code; 
      if (KEY === "Enter"){
        event.preventDefault();
        doOpenModal(openButton);
      }  
    });  
  }

  function doOpenModal(button){
      
    // Open modal
    const modal = document.querySelector(`#${button.dataset.modal}`);   
    modal.showModal();
    modal.classList.add("open");
    document.body.style.overflowY = "hidden";

    // check if this open modal button is associated with a gallery and doesn't have special overrides
    if(button.classList.contains("gallery-item-container")){

      const triggeredModal = button.querySelector(".gallery-item").id;
      const imgNum = triggeredModal.replace("galleryImage-", "");
      const modalImg = document.querySelector(".modal-image");
          
      modalImg.src = arrGalleryImages[imgNum].url;  
      modalImg.alt = arrGalleryImages[imgNum].alt; 

      // if caption exists 
      if(arrGalleryImages[imgNum].caption != ""){
        const modalFigcaption = document.querySelector("#galleryModalcaption");
        modalFigcaption.textContent = arrGalleryImages[imgNum].caption;
        modalFigcaption.style.display = "block";
      }
    }
  }

  // ==============================================================  
  // Close modal 
  // ==============================================================  

  const closeButtons = document.querySelectorAll(".closeModal");
  for(let i=0; i < closeButtons.length; i++){

    const closeButton = closeButtons[i];
    
    closeButton.addEventListener("click", (event) => { doCloseModal(event); });
    // keydown not needed since there is a real button element that works
  }

  function doCloseModal(event){
      
    // Close modal 
    const modal = event.target.closest("dialog");

    if (modal) {       
      const isClickInModal = modal.querySelector(".modal-content").contains(event.target);

      if (!isClickInModal) {
        // if this is the gallery modal and has caption remove the current caption and hide
        if(modal.querySelector("#galleryModalcaption")){
          const modalFigcaption = document.querySelector("#galleryModalcaption");
          modalFigcaption.textContent = "";
          modalFigcaption.style.display = "none";
        }

        modal.classList.remove("open");
        document.body.style.overflowY = "auto";
        setTimeout(function() {
             modal.close();
        }, 250);
      } 
    }
  }
});