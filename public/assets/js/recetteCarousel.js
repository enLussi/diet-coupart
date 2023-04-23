const listRecettes = document.getElementById('list-recettes');
const carouselElement = document.getElementById('carousel-element');

const previousButton = document.getElementById('previous');
const nextButton = document.getElementById('next');

let position = 1;
let startPosition = 1;
let increment = 1;

if(listRecettes.length > 0) {
  var maxElement = listRecettes.children.length;
  var cardWidth = listRecettes.children[0].clientWidth;
  var containerWidth = carouselElement.clientWidth;
}


previousButton.onclick = () => {
  position -= increment;
  if(position < startPosition) position = startPosition;
  turnCarousel();
}

nextButton.onclick = () => {
  position += increment;
  let realPosition = position + parseInt(containerWidth / cardWidth - 1);
  console.log(realPosition)
  if(realPosition > maxElement) position -= increment;
  turnCarousel();
}

function turnCarousel() {
  listRecettes.style.left = - cardWidth * (position - 1) + "px";
}

