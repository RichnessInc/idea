let els = document.querySelectorAll(".clients-counter .num");
if (typeof(els) != 'undefined' && els != null) {
    els.forEach(num => startCoumter(num))
}

let top_sealing_products = document.querySelector("#top-sealing-products .products-container");
if (typeof(top_sealing_products) != 'undefined' && top_sealing_products != null) {
    if (top_sealing_products.dataset.status == 0) {
        let maxNum = document.querySelector("#top-sealing-products .products-container:last-child").dataset.num;
        let topSlider = setInterval(function () {
            let current = document.querySelector("#top-sealing-products .products-container.show");
            let currentNum = parseInt(current.dataset.num) +1;
            if (currentNum <= maxNum) {
                current.classList.remove('show');
                move();
                document.getElementById("top-num-"+currentNum).classList.add('show');
            } else {
                current.classList.remove('show');
                document.getElementById("top-num-1").classList.add('show');
                currentNum=1;
                move()
            }
        }, 8000);
        function move() {
            let i = 0;
            if (i === 0) {
                i = 1;
                let elem = document.querySelector(".top-sale-con .progressbar");
                let width = 1;
                let id = setInterval(frame, 80);
                function frame() {
                    if (width >= 100) {
                        clearInterval(id);
                        i = 0;
                    } else {
                        width++;
                        elem.style.width = width + "%";
                    }
                }
            }
        }
    }
}

let down_products = document.querySelector("#down-products .products-container");
if (typeof(down_products) != 'undefined' && down_products != null) {

    if (down_products.dataset.status == 0) {
        let maxNum = document.querySelector("#down-products .products-container:last-child").dataset.num;
        let topSlider2 = setInterval(function () {
            let current = document.querySelector("#down-products .products-container.show");
            let currentNum = parseInt(current.dataset.num) +1;
            if (currentNum <= maxNum) {
                current.classList.remove('show');
                move2();
                document.getElementById("down-num-"+currentNum).classList.add('show');
            } else {
                current.classList.remove('show');
                document.getElementById("down-num-1").classList.add('show');
                currentNum=1;
                move2()
            }
        }, 8000);


        function move2() {
            let i = 0;
            if (i === 0) {
                i = 1;
                let elem = document.querySelector(".down-products .progressbar");
                let width = 1;
                let id = setInterval(frame, 80);
                function frame() {
                    if (width >= 100) {
                        clearInterval(id);
                        i = 0;
                    } else {
                        width++;
                        elem.style.width = width + "%";
                    }
                }
            }
        }
    }
}




let top_price_products = document.querySelector("#top-price-products .products-container");
if (typeof(top_price_products) != 'undefined' && top_price_products != null) {
    if (top_price_products.dataset.status == 0) {
        let maxNum = document.querySelector("#top-price-products .products-container:last-child").dataset.num;
        let topSlider3 = setInterval(function () {
            let current = document.querySelector("#top-price-products .products-container.show");
            let currentNum = parseInt(current.dataset.num) +1;
            if (currentNum <= maxNum) {
                current.classList.remove('show');
                move3();
                document.getElementById("price-num-"+currentNum).classList.add('show');
            } else {
                current.classList.remove('show');
                document.getElementById("price-num-1").classList.add('show');
                currentNum=1;
                move3()
            }
        }, 8000);


        function move3() {
            let i = 0;
            if (i === 0) {
                i = 1;
                let elem = document.querySelector(".pricetop .progressbar");
                let width = 1;
                let id = setInterval(frame, 80);
                function frame() {
                    if (width >= 100) {
                        clearInterval(id);
                        i = 0;
                    } else {
                        width++;
                        elem.style.width = width + "%";
                    }
                }
            }
        }
    }
}




let single_product_page = document.querySelector(".single-product-container");
if (typeof(single_product_page) != 'undefined' && single_product_page != null) {
    let images = Array.from(document.querySelectorAll('.single-product-container .imgs img'));

    const imgs = document.querySelectorAll('.single-product-container .imgs img');
    for (const img of imgs) {
        img.addEventListener('click', function(e) {
            console.log('a');
            images.forEach(node => {
                node.classList.remove('active');
            });
            e.target.classList.add('active');
            let get_image = e.target.getAttribute('src');
            let main_image_box = document.querySelector('.main-image-box')
            main_image_box.innerHTML = "";
            let newImage = document.createElement('img');
            newImage.src=get_image;
            newImage.className = "shadow rounded";
            main_image_box.appendChild(newImage);
        });
    }
}
let single_card_page = document.querySelector(".cardPage");
if (typeof(single_card_page) != 'undefined' && single_card_page != null) {
    if (single_card_page.dataset.background != '') {
        single_card_page.style.backgroundImage = "url('../uploads/"+single_card_page.dataset.background+"')";

    }
}
let wave_holder = document.querySelectorAll(".audio-holder");
if (typeof(wave_holder) != 'undefined' && wave_holder != null) {
    wave_holder.forEach((el) => {
        let controls = el.querySelectorAll('.controls i');
        controls.forEach((ele) => {
            ele.addEventListener('click', function (e) {
                e.preventDefault();
                if(e.target.classList.contains('fa-play')) {
                    el.querySelector('.myAudio').play();
                    e.target.classList.add('status');
                    e.target.nextElementSibling.classList.remove('status');
                    el.querySelectorAll('.sound-container>div').forEach((wav) => {
                        wav.classList.add('running');
                    });
                } else {
                    el.querySelector('.myAudio').pause();
                    el.querySelectorAll('.sound-container>div').forEach((wav) => {
                        wav.classList.remove('running');
                    });
                    e.target.classList.add('status');
                    e.target.previousElementSibling.classList.remove('status');
                }
            });
        });
    });
}

let myVideo = document.querySelectorAll(".video-holder");
if (typeof(myVideo) != 'undefined' && myVideo != null) {
    myVideo.forEach((el) => {
        let controls = el.querySelectorAll('.controls i');
        controls.forEach((ele) => {
            ele.addEventListener('click', function (e) {
                e.preventDefault();
                if(e.target.classList.contains('fa-play')) {
                    el.querySelector('.myVideo').play();
                    e.target.classList.add('status');
                    e.target.nextElementSibling.classList.remove('status');
                } else {
                    el.querySelector('.myVideo').pause();
                    e.target.classList.add('status');
                    e.target.previousElementSibling.classList.remove('status');
                }
            });
        });
    });
}
