let likes = document.querySelectorAll('button.like');
let unlikes = document.querySelectorAll('button.unlike');

function handelLike(e) {


    this.disabled=true
let icon = this.querySelector('i');
let likeCount = this.querySelector('#likeCount');
this.parentElement.setAttribute('disabled', true);

// let a=e.target.closest('a');
let url = this.dataset.href;
console.log(url)
axios.get(url).then((response) => {
  this.disabled=false
console.log(response.data)

likeCount.innerText = response.data.likes;
icon.innerText = response.data.message == 'added' ? 'favorite ' : 'favorite_border';

}).catch((err) => {
console.log(err)
})

e.preventDefault();
}
likes.forEach((el) => {
el.addEventListener('click', handelLike);

})
unlikes.forEach((el) => {
el.addEventListener('click', handelLike)
})