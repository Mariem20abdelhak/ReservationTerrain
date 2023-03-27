// constants
const body = document.querySelector("body"),
  loader = document.querySelector(".loader-wrap"),
  links = document.querySelectorAll('a[href="#"]'),
  nav = document.querySelector("header nav"),
  navToggle = document.querySelector("header nav .toggle"),
  navSpanMiddle = document.querySelector("header nav .toggle .middle"),
  navNavigationBar = document.querySelector("header nav .navigation-bar"),
  navNavigationBarLi = document.querySelectorAll(
    "header nav .navigation-bar li"
  ),
  headerText = document.querySelector("header .text"),
  headerSection = document.querySelector("header"),
  aboutSection = document.querySelector(".about-us"),
  recipeSection = document.querySelector(".recipes"),
  menuSection = document.querySelector(".menu"),
  fixedImageSection = document.querySelector(".fixed-image"),
  footerSection = document.querySelector("footer"),
  dotOne = document.querySelector(".dots .one"),
  dotTwo = document.querySelector(".dots .two"),
  dotThree = document.querySelector(".dots .three"),
  dots = document.querySelectorAll(".dots > div"),
  logoImage = document.querySelector("header nav .logo img"),
  svgDown = document.querySelector("header .arrow-down"),
  svgUp = document.querySelector(".copyright .arrow-up"),
  menuImgs = document.querySelectorAll(".menu .menu-image-container img"),
  boxModel = document.querySelector(".menu .box-model"),
  menuImageContainer = document.querySelector(".menu-image-container"),
  boxModelArrow = document.querySelector(".menu .box-model .arrow"),
  boxModelImage = document.querySelector(".menu .box-model img"),
  pageTitle = document.querySelector("title");

// prevent links click hash
links.forEach((link) =>
  link.addEventListener("click", function (e) {
    e.preventDefault();
  })
);

// toggle hamburger menu button
if (navToggle && navSpanMiddle && navNavigationBar) {
  navToggle.addEventListener("click", () => {
    navToggle.classList.toggle("active");
    navSpanMiddle.classList.toggle("hide");
    navNavigationBar.classList.toggle("show");
  });
}

// show active navigationbar li
navNavigationBarLi.forEach((li) =>
  li.addEventListener("click", () => {
    if (li.parentElement) {
      const arr = Array.from(li.parentElement.children);
      arr.forEach((li) => li.classList.remove("active"));
      li.classList.add("active");
    }
  })
);

// svg-up smooth scroll
if (svgUp) {
  svgUp.addEventListener("click", () => {
    window.scroll({
      top: 0,
      behavior: "smooth",
    });
  });
}

window.onscroll = function () {
  // make navbar fixed & change logo color
  if (headerSection) {
    if (window.pageYOffset > headerSection.offsetHeight - 75) {
      if (nav) {
        nav.classList.add("active");
      }
    } else {
      if (nav) {
        nav.classList.remove("active");
      }
    }
  }

  // home page JS
  if (pageTitle) {
    if (pageTitle.text === "ResTer") {
      //change dots background color
      if (headerSection && dotOne && dotTwo && dotThree) {
        if (window.pageYOffset < headerSection.offsetHeight * 0.5) {
          dots.forEach((dot) => dot.classList.remove("black"));
          dotTwo.classList.remove("active");
          dotOne.classList.add("active");
        } else if (
          recipeSection &&
          window.pageYOffset > headerSection.offsetHeight * 0.5 &&
          window.pageYOffset < recipeSection.offsetTop * 0.72
        ) {
          dots.forEach((dot) => dot.classList.add("black"));
        } else if (
          recipeSection &&
          menuSection &&
          window.pageYOffset > recipeSection.offsetTop * 0.75 &&
          window.pageYOffset < menuSection.offsetTop * 0.81
        ) {
          dots.forEach((dot) => dot.classList.remove("black"));
          dotOne.classList.remove("active");
          dotThree.classList.remove("active");
          dotTwo.classList.add("active");
        } else if (
          menuSection &&
          fixedImageSection &&
          window.pageYOffset > menuSection.offsetTop * 0.81 &&
          window.pageYOffset < fixedImageSection.offsetTop * 0.86
        ) {
          dots.forEach((dot) => dot.classList.add("black"));
          dotThree.classList.remove("active");
          dotTwo.classList.add("active");
        } else if (
          fixedImageSection &&
          footerSection &&
          window.pageYOffset > fixedImageSection.offsetTop * 0.86 &&
          window.pageYOffset < footerSection.offsetTop * 0.72
        ) {
          dots.forEach((dot) => dot.classList.remove("black"));
          dotTwo.classList.remove("active");
          dotThree.classList.add("active");
        } else if (
          footerSection &&
          window.pageYOffset > footerSection.offsetTop * 0.72 &&
          window.pageYOffset < footerSection.offsetTop * 0.901
        ) {
          dots.forEach((dot) => dot.classList.add("black"));
        } else if (
          footerSection &&
          window.pageYOffset > footerSection.offsetTop * 0.901
        ) {
          dots.forEach((dot) => dot.classList.remove("black"));
        }
      }
    }
  }
};

// home page JS
if (pageTitle && pageTitle.text === "Rester" && svgDown && aboutSection) {
  // svg-down smooth scroll
  svgDown.addEventListener("click", () => {
    window.scroll({
      top: aboutSection.offsetTop - 30,
      behavior: "smooth",
    });
  });

  // dots smooth scroll
  dots.forEach((dot) =>
    dot.addEventListener("click", function () {
      window.scrollTo({
        top: document.querySelector(this.dataset.x).offsetTop - 100,
        behavior: "smooth",
      });
    })
  );

  // show box model
  menuImgs.forEach((img) =>
    img.addEventListener("click", function () {
      const arr = Array.from(this.parentElement.parentElement.children);

      arr.forEach((div) => div.classList.remove("active"));

      this.parentElement.classList.add("active");
      if (boxModel) {
        boxModel.classList.add("active");
      }
      if (boxModelImage && body) {
        boxModelImage.src = this.src;
        boxModelImage.classList.add("active");
        body.classList.add("hide-scroll");
      }
    })
  );

  // box model functions
  function boxModelFun(e) {
    // close box model
    if (
      e.code === "Escape" ||
      (e.target.tagName === "DIV" && !e.target.classList.contains("arrow")) ||
      e.target.classList.contains("close")
    ) {
      if (boxModel) {
        boxModel.classList.remove("active");
      }
      if (body) {
        body.classList.remove("hide-scroll");
      }
    }

    if (boxModel && boxModel.classList.contains("active")) {
      if (
        e.code === "ArrowRight" ||
        e.code === "ArrowLeft" ||
        e.target.classList.contains("arrow-right") ||
        e.target.classList.contains("arrow-left")
      ) {
        if (menuImageContainer) {
          const arr = Array.from(menuImageContainer.children);
          const active = arr.find((div) => div.classList.contains("active"));
        }

        // change box model image
        if (
          e.target.classList.contains("arrow-right") ||
          e.code === "ArrowRight"
        ) {
          if (boxModelImage && active.nextElementSibling === null) {
            active.parentElement.firstElementChild.classList.add("active");
            boxModelImage.src =
              active.parentElement.firstElementChild.firstElementChild.src;
          } else {
            if (boxModelImage) {
              active.nextElementSibling.classList.add("active");
              boxModelImage.src =
                active.nextElementSibling.firstElementChild.src;
            }
          }
        }

        // change box model image
        else if (
          e.target.classList.contains("arrow-left") ||
          e.code === "ArrowLeft"
        ) {
          if (
            boxModelImage &&
            active.previousElementSibling === null &&
            active
          ) {
            active.parentElement.lastElementChild.classList.add("active");
            boxModelImage.src =
              active.parentElement.lastElementChild.lastElementChild.src;
          } else {
            if (boxModelImage) {
              active.previousElementSibling.classList.add("active");
              boxModelImage.src =
                active.previousElementSibling.firstElementChild.src;
            }
          }
        }
        active.classList.remove("active");
      }
    }
  }

  window.addEventListener("keydown", boxModelFun);
  window.addEventListener("click", boxModelFun);
  if (boxModelArrow) {
    boxModelArrow.addEventListener("click", boxModelFun);
  }
}
