
function onClickBtnLike(event){
    event.preventDefault();
    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const icone = this.querySelector('i');

    axios.get(url).then(function(response){
        spanCount.textContent = response.data.likes;

        if(icone.classList.contains('fas')) {
            icone.classList.replace('fas', 'far');
        }
        else{
            icone.classList.replace('far', 'fas');
        }
            
    })
    .catch(function(error){
        if(error.response.status === 403){
            window.location.href = "/projet5.4/public/connexion";
        }
        else{
            window.location.href = "/projet5.4/public/connexion";
        }
    })
};


document.querySelectorAll('a.js-like').forEach(function(link){
    link.addEventListener('click', onClickBtnLike);
});


