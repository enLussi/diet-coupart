// const ingredientSelector = document.getElementById('recipe_form_ingredients');

// let ingredients = [];

// ingredientSelector.onchange = () => {
//   addIngredientInList(ingredientSelector.value);
// }

// function addIngredientContainer(HTMLtext, value) {

//   let list_element = document.createElement('li');
//   let parent = document.getElementById('ingredients_list');

//   list_element.innerHTML = 
//   "<p>" + HTMLtext + "</p>" +
//   "<button class='btn btn-danger' type='button' onclick=removeIngredientsFromList("+ value +") style='--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;'>-</button>";

//   list_element.setAttribute('class', 'ingredient_list');

//   list_element.dataset.value = value;

//   parent.appendChild(list_element);

// }

// function addIngredientInList (value) {
//   if(!ingredients.includes(value)){
//     ingredients.push(value);
//     addIngredientContainer(ingredientSelector.children[value - 1].innerHTML, value)
//   }
//   console.log(ingredients);
// }

// function removeIngredientsFromList (value) {
//   console.log(ingredients);

//   if(ingredients.includes(value.toString())){
//     console.log(value.toString());
//     let index = ingredients.indexOf(value.toString());
//     if(index > -1 ){
//       ingredients.splice(index, 1);
//       document.querySelector("[data-value='"+ value +"']").remove();
//     }
//   }
// }