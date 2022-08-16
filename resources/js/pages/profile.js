let profileLinks = document.querySelectorAll('.profilePage nav ul li');
let linksArry = Array.from(profileLinks);

if (typeof(profileLinks) != 'undefined' && profileLinks != null) {

    linksArry.forEach((ele) => {

        ele.addEventListener('click', function(e) {
            linksArry.forEach((ele) => {
                ele.classList.remove('active');
            });
            e.currentTarget.classList.add('active');

            Livewire.emit('tabs', e.currentTarget.dataset.targget);
        });

    });
}



let get_input = document.querySelector('input.slug');
if (typeof(get_input) != 'undefined' && get_input != null) {
    get_input.addEventListener('keyup', function (e) {
        this.value = this.value.replace(/[^\x00-\x7F]+/ig, '');
        this.value =this.value.replace(/ /g,"-");

    });
}
let wight_input = document.querySelector('input.wight');
if (typeof(wight_input) != 'undefined' && wight_input != null) {
    wight_input.addEventListener('keyup', function (e) {
        let  charCode = (e.which) ? e.which : e.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            this.value = this.value.replace(/[^\x00-\x7F]+/ig, '');

        }
    });
}


