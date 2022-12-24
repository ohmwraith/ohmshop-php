class Catalog {
    constructor() {
        this.parentEl = document.querySelector('.catalog');
    }
    static renderBasketIcon(){
        let amountItemsInBasket = new XMLHttpRequest();
        amountItemsInBasket.open('GET', '/handlers/itemsInBasket.php');
        amountItemsInBasket.send();
        document.querySelector('.countItems').innerHTML='';
        this.preloaderOn(document.querySelector('.countItems'));
        amountItemsInBasket.addEventListener('load', ()=>{
            this.preloaderOff(document.querySelector('.countItems'));
            document.querySelector('.countItems').innerText=amountItemsInBasket.responseText;
        });
    }
    static editThisProduct(title, picture, price, description, categoryID, subCategoryID, itemID){
        let productInfo = document.querySelector('.product-info');

        productInfo.innerHTML=`
        <form class='editForm' method="POST">
            <input class='product-title-edit' type='text' name='newTitle' value='${title}'>
            <input class='product-price-edit' type='text' name='newPrice' value='${price}'><br>
            <textarea class='product-description-edit' name='newDescription' type='text'>${description}</textarea>
            <select class='changeCategories' name='newCategory'>
                <option value='0'>Все</option>
                <option value='1'>Мужчинам</option>
                <option value='2'>Женщинам</option>
                <option value='3'>Детям</option>
            </select>
            <select class='changeCategories' name='newSubCategory'>
                <option value='0'>Все</option>
                <option value='1'>Обувь</option>
                <option value='2'>Куртки</option>
                <option value='3'>Джинсы</option>
                <option value='4'>Костюмы</option>
                <option value='5'>Рюкзаки</option>
            </select>
            <div class="product-buttons">
                <span class="addToCart" onclick="document.querySelector('.editForm').submit();">готово</span>
                <span class="addToCart" onclick="Catalog.removeThisProduct(${itemID})">удалить товар</span>
            </div>
        </form>`;
        document.querySelectorAll('.changeCategories')[0].value=categoryID;
        document.querySelectorAll('.changeCategories')[1].value=subCategoryID;
    }
    static removeThisProduct(itemID){
        let removeRequest = new XMLHttpRequest;
        removeRequest.open('GET', `/handlers/deleteFromCatalog.php?id=${itemID}`);
        removeRequest.send();
        removeRequest.addEventListener('load', ()=>{
            alert(JSON.parse(removeRequest.responseText));
            location.href=location.href;
            // header('location: /catalog/');
        });
    }
    static preloaderOn(insertEl) {
        let preloader = document.createElement('div');
        preloader.classList.add('preloader');
        preloader.innerHTML = '<img src="/images/preloader.svg" />';
        insertEl.appendChild(preloader);
    }
    static preloaderOff(insertEl) {
        let preloader = insertEl.querySelector('.preloader');
        preloader.remove();
    }
    static renderBasket(){
        let basketData = new XMLHttpRequest();
        basketData.open('POST', `/catalog/basket.php?i=1`);
        basketData.send();
        // Catalog.preloaderOn(document);
        basketData.addEventListener('load', ()=>{
            let basketDataDecode = JSON.parse(basketData.responseText);
            console.log(basketDataDecode);
            
        });
    }
    cleanCatalog() {
        this.parentEl.innerHTML = '';
    }
    renderPagination(pagination, CatID, subCatID) {
        document.getElementById('selectPage').innerHTML='';
        for (let index = 1 ; index <= pagination['allPages']; index++) {
            let pageButton = document.createElement('div');
            pageButton.classList.add('pageButton');
            pageButton.innerHTML=index;
            pageButton.addEventListener('click', ()=>{
                this.renderCatalog(CatID, subCatID, index)
            });
            document.getElementById('selectPage').appendChild(pageButton);
        }
        
    }
    renderCatalog(catID = 0, subCatID=0, pageID = 1) {
        this.cleanCatalog();
        let xhr = new XMLHttpRequest();
        let category = catID;
        let subCategory = subCatID;
        xhr.open('GET', `/handlers/catalog.php?category=${category}&subCategory=${subCategory}&page=${pageID}`);
        xhr.send();

        Catalog.preloaderOn(document.querySelector('.catalog'));

        xhr.addEventListener('load', ()=> {
            Catalog.preloaderOff(document.querySelector('.catalog')); 
            let data = JSON.parse(xhr.responseText);

            console.log(xhr);
            console.log(data);

            data['products'].forEach((value)=> {
                let product = new Product(value.itemPic, value.itemName, value.itemPrice, value.id);
                product.renderProduct();
            });
            this.renderPagination(data['pagination'], category, subCatID);
            document.getElementsByClassName('pageButton')[data['pagination']['currentPage']-1].classList.add('currentPage');
        });  
    }

}
Catalog.renderBasketIcon();

class Product {
    constructor(pic, title, price, id) {
        this.pic = pic;
        this.title = title;
        this.price = price;
        this.id = id;
        this.parentEl = document.querySelector('.catalog');
    }
    static addToCart(id){
        // Делаем AJAX запрос к Bascket и даем id, получаем ответ и выводим через alert
        let cartButton = document.querySelector('.addToCart');
        cartButton.innerText='';
        Catalog.preloaderOn(cartButton);
        let toCart = new XMLHttpRequest();
        toCart.open('GET', `/handlers/addToBasket.php?id=${id}`);
        toCart.send();
        toCart.addEventListener('load', ()=> {
            console.log(toCart);
            Catalog.preloaderOff(cartButton);
            cartButton.innerText=toCart.responseText;
        });
        
    }
    renderProduct() {
        let el = document.createElement('div');
        el.classList.add('catalog-item');
        el.innerHTML = `
            <div class="catalog-item-pic" style="background-image: url(/images/catalog/${this.pic})"></div>
            <div class="catalog-item-title">${this.title}</div>
            <div class="catalog-item-price">${this.price} руб.</div>
            <a href="/catalog/product.php?id=${this.id}">подробнее</a>
        `;
        this.parentEl.appendChild(el);
    }
}

let product = new Product();

let catalog = new Catalog();
catalog.renderCatalog();

let form = document.getElementById('categoryFilter');
let categorySelect = form.querySelector('[name=category]');
let subCategorySelect = form.querySelector('[name=subCategory]');

subCategorySelect.addEventListener('change', function() {
    let catalog = new Catalog();
    catalog.renderCatalog(document.querySelector('[name=category]').value, this.value);
});

categorySelect.addEventListener('change', function() {
    let catalog = new Catalog();
    catalog.renderCatalog(this.value, document.querySelector('[name=subCategory]').value);
});
