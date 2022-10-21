console.log('file called')

function DeleteBusiness(element) {
    var rowid = element.parentNode.parentNode.id;

    var businessid = parseInt(rowid);
    var csrf_token = $("[name=_token]").val();

    $.ajax({
        type: "DELETE",
        url: "/deletebusiness",
        data: {
            id: businessid,
            _token: csrf_token,
        },
        cache: false,
        error: function () {
            console.log("Error Found");
        },
    });

    setTimeout(function () {
        window.location.reload();
    }, 500);
}

function Deletelocation(element) {
    var rowid = element.parentNode.parentNode.id;

    var locationid = parseInt(rowid);
    var csrf_token = $("[name=_token]").val();

    $.ajax({
        type: "DELETE",
        url: "/location/delete",
        data: {
            id: locationid,
            _token: csrf_token,
        },
        cache: false,
        error: function () {
            console.log("Error Found");
        },
    });

    setTimeout(function () {
        window.location.reload();
    }, 500);
}



function deleteuser(id) {

    var userid = id;
    var csrf_token = $("[name=_token]").val();

    if(confirm("Are you sure to Delete User?")){
    $.ajax({
        type: "DELETE",
        url: "/user/delete",
        data: {
            id: userid,
            _token: csrf_token,
        },
        cache: false,
        error: function () {
            console.log("Error Found");
        },
    });

     setTimeout(function () {
         window.location.reload();
     }, 500);
  }
}
