function Delete(id){
    var path_file=Routing.generate('DeleteProd');
    if (confirm('Esta seguro de Eliminar el registro?')){
        $.ajax({
            type:'POST',
            url:path_file,
            data:({id:id}),
            async:true,
            dataType:"json",
            success: function (data) {
                alert(data['answer']);
            }
        })

    }
}

function Modify(id){

    var path_file=Routing.generate('ModifyProd');
    $.ajax({
        type:'POST',
        url:path_file,
        data:({id:id}),
        async:true,
        dataType:"json",
        success: function (data) {
            console.log(data['code']);

            document.getElementById("text_code").innerHTML='<label for="code">Codigo Producto</label>&nbsp&nbsp<input id="code_product" class="form-control" type="text" value="'+data['code']+'">';
            document.getElementById("text_name").innerHTML='<label for="name">Nombre Product</label>&nbsp&nbsp<input id="name_product" class="form-control" type="text" value="'+data['name']+'">';
            document.getElementById("text_description").innerHTML='<label for="description">Descripcion Producto</label>&nbsp&nbsp<input id="description_product" class="form-control" type="text" value="'+data['description']+'">';
            document.getElementById("text_brand").innerHTML='<label for="brand">Marca</label>&nbsp&nbsp<input id="brand" class="form-control" type="text" value="'+data['brand']+'">';
            document.getElementById("text_price").innerHTML='<label for="price">Precio</label>&nbsp&nbsp<input id="price" class="form-control" type="text" value="'+data['price']+'">';
            document.getElementById("btn_modify").innerHTML='<br><a href="" class="btn btn-success" onclick="Save('+id+'); ">Modificar</a>';
        }
    })
    path_file=Routing.generate('LoadCategory');
    $.ajax({
        type:'POST',
        url:path_file,
        data:({id:id}),
        async:true,
        dataType:"json",
        success: function (data) {
            console.log(data);

            for (var clave in data){
                // Controlando que json realmente tenga esa propiedad
                if (data.hasOwnProperty(clave)) {
                    // Mostrando en pantalla la clave junto a su valor
                    if (clave=='name'){
                        alert("La clave es " + clave+ " y el valor es " + data[clave]);
                    }

                }
            }


        }
    })



}

function Save(id){
    var code =document.getElementById("code_product").value;
    var name =document.getElementById("name_product").value;
    var description =document.getElementById("description_product").value;
    var brand =document.getElementById("brand").value;
    var price =document.getElementById("price").value;

    var path_file=Routing.generate('SaveModifyProd');
    $.ajax({
        type:'POST',
        url:path_file,
        data:({id:id,code:code,name:name,description:description,brand:brand,price:price}),
        async:true,
        dataType:"json",
        success: function (data) {
            alert(data['answer']);

        }
    })

}



