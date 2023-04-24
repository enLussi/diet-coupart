const form = document.querySelector('[name="comment_form"]');
const commentaires = document.getElementById('commentaires');

const stars = document.querySelectorAll('.star');
const inputs = document.querySelectorAll('.star>input[type="radio"]');
const message = document.getElementById('comment_form_message');

inputs.forEach(input => {
  console.log(input);

  input.onclick = () => {
    console.log(input.value);
    if (input.checked) {
      for ( let i = 0; i < 5; i++) {
        stars[i].classList.remove('checked');
      }
      stars[input.value - 1].classList.add('checked');
      for ( let i = 0; i < input.value - 1; i++) {
        stars[i].classList.add('checked');
      }
    }
  }

});

stars.forEach((star, index) => {
  star.onmouseover = () => {
    star.classList.add('hover');
    for ( let i = 0; i < index; i++) {
      stars[i].classList.add('hover');
    }
  }

  star.onmouseout = () => {
    star.classList.remove('hover');
    for ( let i = 0; i < 5; i++) {
      stars[i].classList.remove('hover');
    }
  }




});

if (form !== null) {
  form.onsubmit = (e) => {

    e.preventDefault();
  
    const formData = new FormData(form);
  
    fetch(window.location.href, {
      method: "POST",
      body: formData
    }).then(response => response.json())
    .then(data => {
      addComment(data);
      resetForm();
    })
  
  };
}


function addComment (data) {
  let newComment = document.createElement('div');
  newComment.classList.add('commentaire');
  newComment.innerHTML = 
  '<p class="signature">'+ data.author +'</p>' +
  '<div class="note-commentaire">' + 
  '<p class="star-comment"><i class="fas fa-star"></i></p>' +
  '<p class="star-comment"><i class="fas fa-star"></i></p>' +
  '<p class="star-comment"><i class="fas fa-star"></i></p>' +
  '<p class="star-comment"><i class="fas fa-star"></i></p>' +
  '<p class="star-comment"><i class="fas fa-star"></i></p>' +
  '</div>' +
  '<p class="message-commentaire">'+ data.message +'</p>' +
  '<p class="date-commentaire">'+ formatDate(new Date(Date.parse(data.date.date))) +'</p>';

  commentaires.prepend(newComment);

  for(let i = 0; i < data.mark; i++){
    newComment.children[1].children[i].classList.add('hover');
  }
}

function resetForm() {
  inputs.forEach(input => {
    input.checked = false;
    message.value = "";
  })
}

function formatDate(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');
  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');

  return `${day}/${month}/${year} ${hours}:${minutes}`;
}
