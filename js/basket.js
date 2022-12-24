class Basket{
    static renderBasket(){
        let isBasketEmpty=1;
        let basketData = new XMLHttpRequest();
        basketData.open('GET', `/handlers/basket.php?i=1`);
        basketData.send();
        // Catalog.preloaderOn(document);
        basketData.addEventListener('load', ()=>{
            let basketDataDecode = JSON.parse(basketData.responseText);
            
            // console.log(basketData.responseText);
            console.log(basketDataDecode);
            
            basketDataDecode.forEach((value) => {
                if (value.amount!="0"){
                    isBasketEmpty=0;
                    let product = document.createElement('div');
                    product.classList.add('product');
                    product.innerHTML=`
                    <div class="product">
                    <div class="product-image">
                        <img style="" src="/images/catalog/${value.itemPic}" alt="${value.itemName}">
                    </div>
                    <div class="product-info">
                        <h1 class="product-title">${value.itemName}</h1>
                        <div class="product-pna">
                        <div class="product-price">${value.itemPrice}р</div>
                        <div class="product-amount"><p>${value.amount} шт.</p></div>
                        <div class="product-del"><span class="addToCart" onclick="Basket.removeItem(${value.id});">X</span></div>
                        </div>
                        <div class="product-description">${value.itemDescription}</div>
            
                    `;
                    document.querySelector('.basket').appendChild(product);
                }
            });
            if(isBasketEmpty==1){
                let product = document.createElement('div');
                product.classList.add('.product-info');
                product.innerHTML=`
                    <p class="product-description" style="text-align:center;">Пусто</p>
                `;
                document.querySelector('.basket').appendChild(product);
            } else{
                let checkout = document.createElement('div');
                checkout.classList.add('basket-checkout');
                checkout.innerHTML=`
                    <span class="addToCart" onclick="alert('Как бы все');">Купить</span>
                `;
                document.querySelector('.basket').appendChild(checkout);
            }
        });
    }
    static removeItem(itemID){
        let removeRequest = new XMLHttpRequest;
        removeRequest.open('GET', `/handlers/delFromBasket.php?id=${itemID}`);
        removeRequest.send();
        removeRequest.addEventListener("load", ()=>{
            console.log(removeRequest.responseText);
            if (removeRequest.responseText == '200'){
                console.log('gg');
                location.href=location.href;
            }
        });
    }
}

Basket.renderBasket();