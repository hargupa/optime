function Delete(id){
    var path_file=Routing.generate('Delete');
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
    var path_file=Routing.generate('Modify');
        $.ajax({
            type:'POST',
            url:path_file,
            data:({id:id}),
            async:true,
            dataType:"json",
            success: function (data) {
                console.log(data['code']);
                //var str_data_form = data['answer'];
                //var arr_str = str_data_form.
                //var resp_srv = arr_str['0'];

                document.getElementById("text_code").innerHTML='<label for="code">Codigo Categoria</label>&nbsp&nbsp<input id="code_category" class="form-control" type="text" value="'+data['code']+'">';
                document.getElementById("text_name").innerHTML='<label for="name">Nombre Categoria</label>&nbsp&nbsp<input id="name_category" class="form-control" type="text" value="'+data['name']+'">';
                document.getElementById("text_description").innerHTML='<label for="description">Descripcion Categoria</label>&nbsp&nbsp<input id="description_category" class="form-control" type="text" value="'+data['description']+'">';
                var checked = '';
                if ((data['active'])==true){
                    checked ='checked';
                }

                document.getElementById("text_active").innerHTML='<input id="active" type="checkbox" class="form-check-input" '+checked+'><label for="active">Activo&nbsp&nbsp</label>';
                document.getElementById("btn_modify").innerHTML='<br><a href="" class="btn btn-success" onclick="Save('+id+'); ">Modificar</a>';
            }
        })

}

function Save(id){
    var code =document.getElementById("code_category").value;
    var name =document.getElementById("name_category").value;
    var description =document.getElementById("description_category").value;
    var active =document.getElementById("active").checked;
    if (active==true){
        active=1;
    }else{
        active=0;
    }

    var path_file=Routing.generate('SaveModify');
    $.ajax({
        type:'POST',
        url:path_file,
        data:({id:id,code:code,name:name,description:description,active:active}),
        async:true,
        dataType:"json",
        success: function (data) {
            alert(data['answer']);

        }
    })

}