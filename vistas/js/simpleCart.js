var $valorAcumulado=0;

function cart(A){
    this.totalItems=0;
    this.totalPrice=0;
    this.items=new Array();
    this.userEmail=A;
    //    this.ItemColumns=["Name","Price","Options","Quantity","Total","Ruta"];
    this.ItemColumns=["Name","Price","Quantity","Total"];
    this.initialize=function(){
        if(!readCookie("simpleCart")){
            this.totalItems=0;
            this.totalPrice=0
        }else{
            data=readCookie("simpleCart").split("&");
            this.totalItems=data[0]*1;
            this.totalPrice=data[1]*1;
            for(x=2;x<(data.length);x++){
                newItem=new item();
                itemData=data[x].split(",");
                i=0;
                for(i=0;i<itemData.length;i++){
                    pair=itemData[i].split("=");
                    newItem.addValue(pair[0],pair[1])
                }
                if(!newItem.getValue("name")||!newItem.getValue("price")||!newItem.getValue("quantity")){
                    alert("item must have price, name, and quantity!");
                    return false
                }
                this.items[x-2]=newItem
            }
        }
        this.setUpEvents();
        this.updateCookie();
        this.updatePageElements();
        return
    };

    this.checkOutEvent=function(){
        simpleCart.checkOut();
        return false
    };
    
    this.emptyEvent=function(){
        simpleCart.empty();
        return false
    };
    
    this.setUpEvents=function(){
        var B=0,C,D=getElementsByClassName("simpleCart_total");
        B=0;
        D=getElementsByClassName("simpleCart_checkout");
        for(B=0;B<D.length;B++){
            C=D[B];
            if(C.addEventListener){
                C.addEventListener("click",this.checkOutEvent,false)
            }else{
                if(C.attachEvent){
                    C.attachEvent("onclick",this.checkOutEvent)
                }
            }
        }
        B=0;
        D=getElementsByClassName("simpleCart_empty");
        for(B=0;B<D.length;B++){
            C=D[B];
            if(C.addEventListener){
                
                C.addEventListener("click",this.emptyEvent,false)
            }else{
                if(C.attachEvent){
                   
                    C.attachEvent("onclick",this.emptyEvent)
                }
            }
        }
        return
    };

    this.add=function(){
        

        newItem=new item();
        var B=0;
        for(B=0;B<arguments.length;B++){
            temp=arguments[B];
            data=temp.split("=");
            newItem.addValue(data[0],data[1]);
//            jAlert(newItem.getValue("identificador"));
        }
        if(!newItem.getValue("name")||!newItem.getValue("price")){
            alert("Item must have name and price to be added to the cart!");
            return false
        }
        isnew=true;
        if(!newItem.getValue("quantity")){
            newItem.addValue("quantity",1)
        }
        this.totalItems=this.totalItems+newItem.getValue("quantity");
        B=0;
        for(B=0;B<this.items.length;B++){
            tempItem=this.items[B];
            if(tempItem.equalTo(newItem)){
                jAlert('La cancion ya esta en el carrito');
                //                tempItem.addValue("quantity",(parseInt(tempItem.getValue("quantity"))+parseInt(newItem.getValue("quantity"))));
                //                this.totalPrice=this.totalPrice+parseFloat(tempItem.getValue("price"));
                //                $valorAcumulado=this.totalPrice;
                //                alert('No es nuevo '+ $valorAcumulado +' y la cantidad es ' +tempItem.getValue("quantity")+' y el id de la cacnion es '+tempItem.getValue("Options")+' y la ruta es '+tempItem.getValue("Ruta"));
                isnew=false
            }
        }
        if(isnew){
            this.items[this.items.length]=newItem;
            this.totalPrice=this.totalPrice+parseFloat(newItem.getValue("price"))
            $valorAcumulado=this.totalPrice;
        //            alert('es nuevo '+ $valorAcumulado+' y la cantidad es ' +tempItem.getValue("quantity"));
        }
        this.updateCookie();
        this.updatePageElements();
        return
    };

    this.addItem=function(C){
        var B=0;
        for(B=0;B<this.items.length;B++){
            var D=this.items[B];
            if(D.equalTo(C)){
                
                D.addValue("quantity",parseInt(C.getValue("quantity"))+parseInt(D.getValue("quantity")));
                this.totalItems=this.totalItems+parseInt(C.getValue("quantity"));
                this.totalPrice=this.totalPrice+parseInt(C.getValue("quantity"))*parseFloat(C.getValue("price"));
            
                return
            }
        }
        this.items[this.items.length]=C;
        this.totalItems=this.totalItems+parseInt(C.getValue("quantity"));
        this.totalPrice=this.totalPrice+parseInt(C.getValue("quantity"))*parseFloat(C.getValue("price"));
        return
    };

    this.updateCookie=function(){
        cookieString=String(this.totalItems)+"&"+String(this.totalPrice);
        x=0;
        for(x=0;x<this.items.length;x++){
            tempItem=this.items[x];
            cookieString=cookieString+"&"+tempItem.cookieString()
        }
        createCookie("simpleCart",cookieString,30)
    };
    
    this.empty=function(){
        this.items=new Array();
        this.totalItems=0;
        this.totalPrice=0;
        this.updateCookie();
        this.updatePageElements();
        return false
    };
    
    this.deleteItem=function(C){
        found=false;
        var B=new Array();
        for(x=0;x<this.items.length;x++){
            tempItem=this.items[x];
            if(tempItem.equalTo(C)){
                found=true;
                this.totalItems=this.totalItems-parseFloat(tempItem.getValue("quantity"));
                this.totalPrice=this.totalPrice-parseFloat(tempItem.getValue("price"))
            }
            if(found){
                if(x<(this.items.length-1)){
                    B[x]=this.items[x+1]
                }
            }else{
                B[x]=this.items[x]
            }
        }
        this.items=B;
        this.updateCookie();
        this.updatePageElements();
        return false
    };

    this.options=function(){
        var B=0;
        for(B=0;B<this.items.length;B++){
            var C=this.items[B];
            if(C.optionList()){
                return true
            }
        }
        return false
    };

    this.updatePageElements=function(){
        var B=0,D,E=getElementsByClassName("simpleCart_total");
        for(B=0;B<E.length;B++){
            D=E[B];
            D.innerHTML=this.returnTotalPrice()
        }
        B=0;
        E=getElementsByClassName("simpleCart_quantity");
        for(B=0;B<E.length;B++){
            D=E[B];
            D.innerHTML=String(this.totalItems)
        }
        E=getElementsByClassName("simpleCart_items");
        for(B=0;B<E.length;B++){
            cartTable=E[B];
            newRow=document.createElement("div");
            var B=0,C=0;
            while(cartTable.childNodes[0]){
                cartTable.removeChild(cartTable.childNodes[0])
            }
            for(B=0;B<this.ItemColumns.length;B++){
                if(this.ItemColumns[B]!="Options"||this.options()){
                    tempCell=document.createElement("div");
                    tempCell.innerHTML=this.ItemColumns[B];
                    tempCell.className="item"+this.ItemColumns[B];
                    newRow.appendChild(tempCell)
                }
            }
            newRow.className="cartHeaders";
            cartTable.appendChild(newRow);
            B=0;
            for(B=0;B<this.items.length;B++){
                tempItem=this.items[B];
                newRow=document.createElement("div");
                C=0;
                for(C=0;C<this.ItemColumns.length;C++){
                    tempCell=document.createElement("div");
                    tempCell.className="item"+this.ItemColumns[C];
                    if(this.ItemColumns[C]=="Image"){
                        if(tempItem.getValue("image")){
                            tempCell.innerHTML='<img src="'+tempItem.getValue("image")+'" />'
                        }
                    }
                    if(this.ItemColumns[C]=="Name"){
                        tempCell.innerHTML=tempItem.getValue("name")
                    }else{
                        if(this.ItemColumns[C]=="Price"){
                            tempCell.innerHTML=this.returnFormattedPrice(tempItem.getValue("price"))
                        }else{
                            if(this.ItemColumns[C]=="Options"&&this.options()){
                                tempCell.innerHTML=tempItem.optionList()
                            }else{
                                if(this.ItemColumns[C]=="Quantity"){
                                    cadena='<input type="text" onblur="simpleCart.updateQuantity('+tempItem.functionString()+",'new_quantity=' + this.value);return false;\"value=\""+tempItem.getValue("quantity")+'" />'
                                 
                                    //                                   cadena+='<input type="button" onclick="simpleCart.updateQuantity()" value="Eliminar del carrito"/>'
                                    //                                    jAlert(cadena);
                                    tempCell.innerHTML=cadena;
                                //                                    tempCell.innerHTML='<input type="text" onblur="simpleCart.updateQuantity('+tempItem.functionString()+",'new_quantity=' + this.value);return false;\"'/>";
                                //                                    tempCell.innerHTML='<input type="text" onblur="simpleCart.updateQuantity('+tempItem.functionString()+",'new_quantity=' + this.value);return false;\"value=\""+tempItem.getValue("quantity")+'" />'
                                //tempCell.innerHTML='<input type="text" onblur="simpleCart.updateQuantity('+tempItem.functionString()+",'new_quantity=' + this.value);return false;\"value=\""+tempItem.getValue("quantity")+'" />'
                                }else{
                                    if(this.ItemColumns[C]=="Total"){
                                        tempCell.innerHTML=this.returnFormattedPrice(tempItem.getValue("quantity")*tempItem.getValue("price"))
                                    }
                                }
                            }
                        }
                    }
                    newRow.appendChild(tempCell)
                }
                newRow.className="itemContainer";
                cartTable.appendChild(newRow)
            }
            newRow=document.createElement("div");
            tempCell=document.createElement("div");
            tempCell.innerHTML=String(this.totalItems);
            tempCell.className="totalItems";
            //            newRow.appendChild(tempCell);
            tempCell=document.createElement("div");
            tempCell.innerHTML=this.returnTotalPrice();
            tempCell.className="totalPrice";
            newRow.appendChild(tempCell);
            newRow.className="totalRow";
            cartTable.appendChild(newRow)
        }
        return false
    };

    this.returnTotalPrice=function(){
        return this.returnFormattedPrice(this.totalPrice)
    };
    
    this.returnFormattedPrice=function(B){
        temp=Math.round(B*100);
        change=String(temp%100);
        if(change.length==0){
            change="00"
        }else{
            if(change.length==1){
                change="0"+change
            }
        }
        temp=String(Math.floor(temp/100));
        return"$"+temp+"."+change
    };

    this.updateQuantity=function(){
        
        newItem=new item();
        x=0;
        for(x=0;x<arguments.length;x++)
        {
            temp=arguments[x];
            data=temp.split("=");
            if(data[0]=="new_quantity")
            {
                var B=data[1]
            }
            if(B>0)
            {
                jAlert("No esta permitido comprar la cancion mas de una vez");
                return
               
            }
            if(B<1){
            
                this.deleteItem(newItem);
                return
            }
            else
            {
                
                newItem.addValue(data[0],data[1])
                
            }
        }
        //        if(B<1){
        //            jAlert("313 se va a eliminar"+B);
        //            this.deleteItem(newItem);
        //            return
        //        }
        newQuan=B-newItem.getValue("quantity");
        newItem.addValue("quantity",newQuan);
        this.addItem(newItem);
        this.updateCookie();
        this.updatePageElements();
        return false
    };

    this.checkOut=function(){
        if(this.totalItems==0){
            jAlert("su carro esta vacio!");
            return false
        }
        
        
        //         jAlert("pagando via paypal para usuario " +$usuario);
        var D="scrollbars,location,resizable,status";
        var F,E=0,G,C;
        var B="https://www.paypal.com/cgi-bin/webscr?cmd=_cart&upload=1&business="+this.userEmail+"&currency_code=USD&lc=US";
        C=0;
       
        for(C=0;C<this.items.length;C++){
            
            tempItem=this.items[C];
            registrarCancionesCompradas(tempItem.getValue("identificador"));
           
           
            E=C+1;
            B=B+"&item_name_"+E+"="+tempItem.getValue("name")+"&item_number_"+E+"="+E+"&quantity_"+E+"="+tempItem.getValue("quantity")+"&amount_"+E+"="+this.returnFormattedPrice(tempItem.getValue("price"))+"&no_shipping_"+E+"=0&no_note_"+E+"=1";
            if(tempItem.optionList()){
                B=B+"&on0_"+E+"=Options&os0_"+E+"="+tempItem.optionList()
            }
        }
        //         jAlert(mia);
        window.open(B,"paypal",D);
        return false
    }
}
function item(){
    this.names=new Array();
    this.values=new Array();
    this.addValue=function(B,C){
        if(this.names.length!=this.values.length){
            alert("name and value array lengths do not match for this item!");
            return false
        }
        found=false;
        var A=0;
        for(A=0;A<this.names.length;A++){
            if(this.names[A]==B){
                this.values[A]=C;
                return
            }
        }
        if(!found){
            this.names[this.names.length]=B;
            this.values[this.values.length]=C
        }
        return
    };

    this.getValue=function(A){
        var B=0;
        for(B=0;B<this.names.length;B++){
            if(A==this.names[B]){
                return this.values[B]
            }
        }
        return null
    };

    this.equalTo=function(A){
        if(this.getSize()!=A.getSize()){
            return false
        }
        var B=0;
        for(B=0;B<this.names.length;B++){
            if(this.names[B]!="quantity"&&(A.getValue(this.names[B])!=this.values[B])){
                return false
            }
        }
        return true
    };

    this.getSize=function(){
        return this.names.length
    };
    
    this.cookieString=function(){
        returnString="";
        var A=0;
        returnString=this.names[A]+"="+this.values[A];
        A=1;
        for(A=1;A<this.names.length;A++){
            returnString=returnString+","+this.names[A]+"="+this.values[A]
        }
        return returnString
    };
    
    this.functionString=function(){
        returnString="'";
        var A=0;
        returnString="'"+this.names[A]+"="+this.values[A];
        A=1;
        for(A=1;A<this.names.length;A++){
            returnString=returnString+"','"+this.names[A]+"="+this.values[A]
        }
        returnString=returnString+"'";
        return returnString
    };
    
    this.optionList=function(){
        returnString="";
        if(this.getSize()<4){
            return null
        }
        var A=0;
        for(A=0;A<this.names.length;A++){
            if(this.names[A]!="quantity"&&this.names[A]!="price"&&this.names[A]!="name"&&this.names[A]!="image"){
                returnString=returnString+this.names[A]+":"+this.values[A]+", "
            }
        }while(returnString.charAt(returnString.length-1)==","||returnString.charAt(returnString.length-1)==" "||returnString.charAt(returnString.length)==":"){
            returnString=returnString.substring(0,returnString.length-1)
        }
        return returnString
    }
}
function createCookie(C,D,E){
    if(E){
        var B=new Date();
        B.setTime(B.getTime()+(E*24*60*60*1000));
        var A="; expires="+B.toGMTString()
    }else{
        var A=""
    }
    document.cookie=C+"="+D+A+"; path=/"
}
function readCookie(B){
    var D=B+"=";
    var A=document.cookie.split(";");
    for(var C=0;C<A.length;C++){
        var E=A[C];
        while(E.charAt(0)==" "){
            E=E.substring(1,E.length)
        }
        if(E.indexOf(D)==0){
            return E.substring(D.length,E.length)
        }
    }
    return null
}
function eraseCookie(A){
    createCookie(A,"",-1)
}
var getElementsByClassName=function(B,A,C){
    if(document.getElementsByClassName){
        getElementsByClassName=function(I,L,H){
            H=H||document;
            var D=H.getElementsByClassName(I),K=(L)?new RegExp("\\b"+L+"\\b","i"):null,E=[],G;
            for(var F=0,J=D.length;F<J;F+=1){
                G=D[F];
                if(!K||K.test(G.nodeName)){
                    E.push(G)
                }
            }
            return E
        }
    }else{
        if(document.evaluate){
            getElementsByClassName=function(M,P,L){
                P=P||"*";
                L=L||document;
                var F=M.split(" "),N="",J="http://www.w3.org/1999/xhtml",O=(document.documentElement.namespaceURI===J)?J:null,G=[],D,E;
                for(var H=0,I=F.length;H<I;H+=1){
                    N+="[contains(concat(' ', @class, ' '), ' "+F[H]+" ')]"
                }
                try{
                    D=document.evaluate(".//"+P+N,L,O,0,null)
                }catch(K){
                    D=document.evaluate(".//"+P+N,L,null,0,null)
                }while((E=D.iterateNext())){
                    G.push(E)
                }
                return G
            }
        }else{
            getElementsByClassName=function(O,R,N){
                R=R||"*";
                N=N||document;
                var H=O.split(" "),Q=[],D=(R==="*"&&N.all)?N.all:N.getElementsByTagName(R),M,J=[],L;
                for(var I=0,E=H.length;I<E;I+=1){
                    Q.push(new RegExp("(^|\\s)"+H[I]+"(\\s|$)"))
                }
                for(var G=0,P=D.length;G<P;G+=1){
                    M=D[G];
                    L=false;
                    for(var F=0,K=Q.length;F<K;F+=1){
                        L=Q[F].test(M.className);
                        if(!L){
                            break
                        }
                    }
                    if(L){
                        J.push(M)
                    }
                }
                return J
            }
        }
    }
    return getElementsByClassName(B,A,C)
};

function createCart(){
    simpleCart.initialize();
    return
}
var ElementCheckInterval=setInterval("simpleCart.updatePageElements()",2000);
window.onload=createCart;