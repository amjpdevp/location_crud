function DeleteBusiness (element){
        var rowid = element.parentNode.parentNode.id;
        
        var businessid = parseInt(rowid);
        var csrf_token = $('[name=_token]').val();

   
    $.ajax({
        type: "DELETE",
        url: "/deletebusiness",
        data: {
          id : businessid,
        "_token": csrf_token
        },
        cache: false,
        error: function () {
            console.log("Error Found")
        }
    });
    
    setTimeout(function(){
        window.location.reload();
     }, 500);

    }

    function Deletelocation(element){
        var rowid = element.parentNode.parentNode.id;
        
        var locationid = parseInt(rowid);
        var csrf_token = $('[name=_token]').val();
     
   
    $.ajax({
        type: "DELETE",
        url: "/location/delete",
        data: {
          id : locationid,
        "_token": csrf_token
        },
        cache: false,
        error: function () {
            console.log("Error Found")
        }
    });
    
    setTimeout(function(){
        window.location.reload();
     },500);

     

    }

    